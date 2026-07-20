<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Admin_controller.php';
require_once 'Common_controller.php';

class Merchant_controller extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        $this->load->model(array('Admin_model' => 'am2'));

        //common controller
        $this->common_controller = new Common_controller();
        $this->admin_controller = new Admin_controller();

        //current date
        $this->current_date = gmdate("Y-m-d H:i:s");

        $this->ci = get_instance();
        $this->ci->load->library('form_validation');

        //get categories
        $categoriesHavingProduct = $this->am2->getCategoriesHavingProduct();
        $this->categories['result'] = $categoriesHavingProduct;

        //get categories in tree format
        $parent_categories = $this->am2->selectRecords(array('has_parent' => 0), 'product_category', '*');
        $categories = $parent_categories ? $parent_categories['result'] : [];

        $i = 0;
        foreach ($categories as $category) 
        {
            $where = array('has_parent' => 1, 'parent_category_id' => $category['category_id']);
            $child_categories = $this->am2->selectRecords($where, 'product_category', '*');

            if ($child_categories) 
                $categories[$i]['child_category'] = $child_categories['result'];
            else
                $categories[$i]['child_category'] = false;

            $i++;
        }
            
        $this->tree_list = $categories;

        //get brands
        $brandHavingProduct = $this->am2->getBrandHavingProduct();
        $this->brands['result'] = $brandHavingProduct;
    }

    public function loginSignupPage()
    {
        $data = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        $data['meta_data']['title'] = 'Seller Login';
        $data['meta_data']['keywords'] = '';
        $data['meta_data']['description'] = 'ROPOshop Seller login';
        $data['meta_data']['image'] = 'ROPOshop';

        //load user register view
        // $this->load->view('user/include/header', $data);
        // $this->load->view('merchant/login_signup');
        // $this->load->view('user/include/footer');

        //load user register view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/merchant_login');
        $this->load->view('user/design/include/footer');
    }

    public function insertSeller()
    {
        if ($this->ci->form_validation->run('UC_step1_registration') == FALSE)
        {
            $this->loginSignupPage();
            die;
        }

        //user data
        $user_data = array();
        $user_data['status'] = 1;
        $user_data['first_name'] = $this->input->post('first_name');
        $user_data['email'] = $this->input->post('email');
        $user_data['password'] = $this->input->post('password');
        $user_contact = $this->input->post('contact_number');
        $user_data['create_date'] = $this->current_date;
        $user_data['update_date'] = $this->current_date;
        // $confirm_password = $this->input->post('confirm_password');
        
        //insert user detail
        $user_id = $this->am2->insertData('user', $user_data);
        if ($user_id)
        {
            //insert seller role
            $type_data['usr_id'] = $user_id;
            $type_data['type_name'] = "SELLER";

            $type_id = $this->am2->insertData('user_type', $type_data);
            if (!$type_id)
               redirectWithMessage('Error: unable to add you as seller', 'merchantLoginSignup');
            else
            {
                //insert seller data
                $seller_data = array();

                //seller data
                $seller_data['userId'] = $user_id;
                $seller_data['contact'] = $this->input->post('contact_number');
                $seller_data['establishment_name'] = $this->input->post('shop_name');
                $seller_data['is_verified'] = 0;
                $seller_data['status'] = 1;
                $seller_data['create_date'] = $this->current_date;
                $seller_data['update_date'] = $this->current_date;

                //insert data in db
                $seller_id = $this->am2->insertData('merchant', $seller_data);

                if (!$seller_id)
                   redirectWithMessage('Error: unable to add you as seller', 'merchantLoginSignup');
                else
                {
                    //send mail to company
                    $mail_data = array();
                    $mail_data['first_name'] = $user_data['first_name'];
                    $mail_data['seller_id'] = $seller_id;
                    $mail_data['email'] = $user_data['email'];
                    $mail_data['contact_number'] = $user_contact;
                    $mail_data['code'] = MAIL_CODE_SELLER_SIGNUP;
                    $mail_data['url'] = str_replace("seller", "admin", base_url()).'seller/'.$seller_id.'/view';
                    $this->common_controller->sendMail($mail_data);

                    //step 1 send mail to inform user to fill step 2 detail
                    $mail_data = array();
                    $mail_data['email'] = $user_data['email'];
                    $mail_data['shop_name'] = $seller_data['establishment_name'];
                    $mail_data['merchant_name'] = $user_data['first_name'];
                    $mail_data['code'] = MAIL_CODE_STEP_1_REGISTRATION;
                    $this->common_controller->sendMail($mail_data);
                    
                    redirect('merchantSignupStep2/'.$user_id.'/'.$seller_id, 'refresh');
                }
            }
        }           
        else
            redirectWithMessage('Error: unable to add you', 'login');
    }

    public function merchantSignupStep2($user_id, $merchant_id)
    {
        if (isset($_COOKIE['user_detail'])) 
            redirect('', 'refresh');
        else
        {
            $data = array();
            $data['categories'] = $this->categories['result']; //get categories
            $data['tree_list'] = $this->tree_list; //get categories in tree format

            //get countries
            $countries = $this->am2->selectRecords('', 'country', '*', array('name' => 'ASC'));
            if ($countries)
                $data['countries'] = $countries['result'];
            else
                $data['countries'] = false;

            //get user detail
            $user = $this->am2->sellers($merchant_id);
            if ($user)
                $data['user'] = $user[0];
            else
                redirectWithMessage('Error: No Such User Found!', 'merchantLoginSignup');

            //get user address
            $address_res = $this->admin_controller->getUserAddress(array('address.userId' => $user_id, 'is_default_address' => 1));
            if (isset($address_res['db_error'])) 
                redirectWithMessage('Error: '.$address_res['msg'], 'merchantLoginSignup');
            else if ($address_res) 
                $data['user']['address'] = $address_res['result'][0];

            //get seller(shop) images
            $seller_imgs = $this->admin_controller->attatchments($merchant_id, "SELLER");
            $data['user']['shop_image'] = ($seller_imgs) ? $seller_imgs : false;

            $data['meta_data']['title'] = 'Seller signup';
            $data['meta_data']['keywords'] = '';
            $data['meta_data']['description'] = 'ROPOshop signup step 2';
            $data['seller_images_dir'] = $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant_id.'/';

            //load user register view
            // $this->load->view('user/include/header', $data);
            // $this->load->view('merchant/signupStep2', $data);
            // $this->load->view('user/include/footer');

            //echo "<pre>"; print_r($data); die;
            //load user register view
            $this->load->view('user/design/include/header', $data);
            $this->load->view('user/design/merchant_signupStep2', $data);
            $this->load->view('user/design/include/footer');
        }
    }

    public function updateMerchant()
    {
        $user_id = $this->input->post('user_id');
        $email = $this->input->post('email');
        $merchant_id = $this->input->post('merchant_id');
        $isVerified = $this->input->post('is_verified');
        $controller = 'merchantSignupStep2/'.$user_id.'/'.$merchant_id;

        if ($user_id && $merchant_id) 
        {
            //seller data
            $seller_data = array();
            $seller_data['establishment_name'] = $this->input->post('comp_name');
            $seller_data['description'] = $this->input->post('description');
            //$seller_data['contact'] = $this->input->post('shop_contact');
            $seller_data['contact'] = $this->input->post('own_contact');
            $seller_data['is_verified'] = 1;
            $seller_data['status'] = 1;
            $seller_data['is_completed'] = 1;
            $seller_data['update_date'] = $this->current_date;
            $seller_data['establishment_name'] = $this->input->post('comp_name');
            $seller_data['description'] = $this->input->post('description');
            $seller_data['business_days'] = $this->input->post('global_business_days');
            $seller_data['business_hours'] = $this->input->post('global_business_hours');

            //user data
            $user_data = array();
            $user_data['first_name'] = $this->input->post('first_name');
            $user_data['update_date'] = $this->current_date;

            //merchant attachments path
            $merchant_folder = SELLER_ATTATCHMENTS_PATH.$merchant_id;
            
            //insert user profile picture
            if (isset($_FILES['file7']) && $_FILES['file7']['name'] != '')
            {
                $profile_pic = $this->common_controller->single_upload(PROFILE_PIC_PATH, '', 'file7');
                if (!$profile_pic)
                    redirectWithMessage('Error: Unable to upload profile picture!', $controller);
                else
                    $user_data['picture'] = $profile_pic;
            }

            //update user data
            $isUpdated = $this->am2->updateData('user', $user_data, array('userId' => $user_id));
            if (isset($isUpdated['db_error'])) 
                redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

            //insert shop logo
            if (isset($_FILES['file9']) && $_FILES['file9']['name'] != '')
            {
                $merchant_logo = $this->common_controller->single_upload($merchant_folder, '', 'file9');
                if (!$merchant_logo)
                    redirectWithMessage('Error: Unable to upload merchant logo!', $controller);
                else
                    $seller_data['merchant_logo'] = $merchant_logo;
            }
            
            //insert seller proof
            if (isset($_FILES['file8']) && $_FILES['file8']['name'] != '')
            {
                $business_proof = $this->common_controller->single_upload($merchant_folder, '', 'file8');
                if (!$business_proof)
                    $msg = "Error: Unable to upload merchant business proof!";
                else
                    $seller_data['business_proof'] = $business_proof;
            }
            
            //update seller detail
            $isUpdated = $this->am2->updateData('merchant', $seller_data, array('merchant_id' => $merchant_id));
            if (isset($isUpdated['db_error'])) 
                redirectWithMessage('Error: '.$isUpdated['msg'], $controller);

            //atatchment data
            $img_data['link_id'] = $merchant_id;
            $img_data['atch_type'] = "IMAGE";
            $img_data['atch_for'] = "SELLER";

            //insert seller images
            $isUploaded = $this->admin_controller->upload_image($merchant_folder, $img_data);
            if (isset($isUploaded['db_error'])) 
                redirectWithMessage('Error: '.$isUploaded['msg'], $controller);
            else
            {
                //insert merchant address
                $address_id = $this->admin_controller->insertAddress($user_id, 1);
                if (!$address_id) 
                    redirectWithMessage('Error: lat, long are not in correct format.', $controller);
                else
                {
                    //get user detail
                    $usr_details = $this->am2->getUser($user_id, 1);
                    if (isset($usr_details['db_error'])) 
                        redirectWithMessage('Error: '.$usr_details['msg'], $controller);
                    else
                    {
                        // send mail to user for step 2 completion if already not done
                        if(!$isVerified) {
                            
                            $mail_data = array();
                            $mail_data['merchant_name'] = $user_data['first_name'];
                            $mail_data['shop_name'] = $seller_data['establishment_name'];
                            $mail_data['email'] = $email;
                            $mail_data['code'] = MAIL_CODE_STEP_2_REGISTRATION;
                            $this->common_controller->sendMail($mail_data);
                        }

                        //merchant cookie setup and redirect to seller dashboard
                        $usr_details['merchant_id'] = $merchant_id;
                        $this->admin_controller->cookieSetupForLogin($usr_details);
                    }
                }
            }
        }
        else
            redirectWithMessage('Error: User id or merchant id not found!', $controller);
    }

    public function merchantLoginWithoutStep2Completion($user_id, $merchant_id) {

        $usr_details = $this->am2->getUser($user_id, 1);
        if (isset($usr_details['db_error'])) 
            redirectWithMessage('Error: '.$usr_details['msg'], $controller);
        else
        {
            //merchant cookie setup and redirect to seller dashboard
            $usr_details['merchant_id'] = $merchant_id;
            $this->admin_controller->cookieSetupForLogin($usr_details);
        }
    }

    //login method
    public function login()
    {
        if (!isset($_COOKIE['site_code'])) {
            
            redirect('', 'refresh');
            die;
        }
        
        //get controller
        $controller = 'merchantLoginSignup';
        $usr_roles = array();
        $usr_details = array();
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        if (!$username && !$password) {
            $this->loginSignupPage();
            die;
        }
        
        $usr_id = $this->am2->doLogin($username, $password);
        if (isset($usr_id['db_error'])) {
            redirectWithMessage('Error: '.$usr_id['msg'], $controller);
        } elseif ($usr_id) {

            $usr_id = $usr_id['userId'];
            $usr_details = $this->am2->getUser($usr_id, 1);
            
            if (isset($usr_details['db_error'])) {
                redirectWithMessage('Error: '.$usr_details['msg'], $controller);
            } else {
                $usr_roles = $this->am2->selectRecords(array('usr_id' => $usr_id), 'user_type', '*');
                if (isset($usr_roles['db_error'])) {
                    redirectWithMessage('Error: '.$usr_roles['msg'], $controller);
                } elseif ($usr_details) {
                    
                    $usr_roles = array_column($usr_roles['result'], 'type_name');

                    if (in_array('SELLER', $usr_roles)) {

                        $merchant = $this->am2->selectRecords(array('userId' => $usr_id), 'merchant', 'merchant_id, is_verified');
                        if (isset($merchant['db_error'])) {
                            redirectWithMessage('Error: '.$merchant['msg'], $controller);
                        } elseif ($merchant) {
                            $usr_details['is_verified'] = $merchant['result'][0]['is_verified'];
                            $usr_details['merchant_id'] = $merchant['result'][0]['merchant_id'];
                        }
                        
                        $this->admin_controller->cookieSetupForLogin($usr_details);

                    } else {

                        //insert seller role
                        $type_data['usr_id'] = $usr_id;
                        $type_data['type_name'] = "SELLER";

                        $type_id = $this->am2->insertData('user_type', $type_data);
                        if (!$type_id)
                           redirectWithMessage('Error: unable to add you as seller', 'merchantLoginSignup');
                        else //insert seller data
                        {
                            //seller data
                            $seller_data = array();
                            $seller_data['userId'] = $usr_id;
                            $seller_data['is_verified'] = 0;
                            $seller_data['status'] = 1;
                            $seller_data['create_date'] = $this->current_date;
                            $seller_data['update_date'] = $this->current_date;

                            $seller_id = $this->am2->insertData('merchant', $seller_data);
                            if (!$seller_id)
                               redirectWithMessage('Error: unable to add you as seller', 'merchantLoginSignup');
                            else
                                redirect('merchantSignupStep2/'.$usr_id.'/'.$seller_id, 'refresh');
                        }
                    }
                }
                else
                    redirectWithMessage('Error: You are not a varified user, please contact to system administrator!', $controller);
            }
        }
        else
            redirectWithMessage('Error: Wrong credential!', 'merchantLoginSignup');
    }

    public function resetPasswordPage($user_id) {
		
        $this->load->view('merchant/resetPassword', array('user_id' => $user_id));
    }
	
	public function resetPassword() {

        $otp = $this->input->post('otp');
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');
        $user_id = $this->input->post('user_id');

        if ($password != $cpassword) {

			$this->session->set_flashdata('errors', 'Password and Confirm Password are not same.');
			$this->resetPasswordPage($user_id);
			die;

        } else {

			$res = $this->common_controller->resetPassword($user_id, $otp, $password);

            if ($res['status']) {
            				
				echo "<script>window.alert('".$res['msg']."');</script>";
				$this->loginSignupPage();
                die;

			} else {
				
				$this->session->set_flashdata('errors', $res['msg']);
				$this->resetPasswordPage($user_id);
				die;
			}
        }
    }
}