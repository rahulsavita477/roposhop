<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_controller extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Admin_model', 'am5');
    }

    public function upload_image($path, $img_data)
    {
        //insert category images
        for ($i = 1; $i < 7; $i++) 
        { 
            $obj_name = 'file'.$i;
            if ($_FILES[$obj_name]['name'] != '')
            {
                $img_data['atch_url'] = $this->single_upload($path, '', $obj_name);

                //insert images
                if ($img_data['atch_url']) 
                {
                    $isInserted = $this->am5->insertData('attatchments', $img_data);
                    if (isset($isInserted['db_error'])) 
                        return $isInserted;

                    $remove_img = $this->input->post('remove_img'.$i);

                    if ($remove_img) 
                    {
                        //delete from the folder
                        $isDeleted = $this->am5->deleteRecord('attatchments', array('atch_url' => $remove_img));
                        if (isset($isDeleted['db_error'])) 
                            return $isDeleted;

                        //delete from the folder
                        unlink($path.'/'.$remove_img);
                    }
                }
            }
        }

        return true;
    }
    
    public function sendMail($mail_data="")
    {
        $code = (isset($mail_data['code'])) ? $mail_data['code'] : $this->input->post('mail_code');
        $atch = '';
        //$reciever_email = 'rahulsavita477@gmail.com';
        $reciever_email = EMAIL_ID;

        $template = $this->am5->selectRecords(array('tmp_code' => $code), 'mail_template', 'tmp_html, mail_subject');

        if (!$template)
            echo "<script>window.alert('Error: Template not found!');</script>";
        else
        {
            $body = $template['result'][0]['tmp_html'];
            $subject = $template['result'][0]['mail_subject'];

            switch ($code) 
            {
                case MAIL_CODE_RESET_PASSWORD:
                {
                    $body = str_replace("[link_to_reset_password]", base_url('account/resetPassword/'.$mail_data['userId']), $body);
                    $body = str_replace("[NAME]", $mail_data['name'], $body);
                    $body = str_replace("[ROPO_SHOP_BRAND_NAME]", ROPO_SHOP_BRAND_NAME, $body);
                    $body = str_replace("[OTP]", $mail_data['otp'], $body);

                    $reciever_email = $mail_data['email'];

                    break;
                }

                case MAIL_CODE_CLAIM_BUSINESS:
                {
                    $merchant_id = $mail_data['clmd_merchant_id'];
                    $establishment_name = $mail_data['establishment_name'];
                    
                    //mail subject
                    $subject = str_replace("[SHOP_NAME]", $establishment_name, $subject);
                    $subject = str_replace("[SELLER_ID]", $merchant_id, $subject);

                    //mail body
                    $body = str_replace("[SELLER_ID]", $merchant_id, $body);
                    $body = str_replace("[SHOP_NAME]", $establishment_name, $body);
                    $body = str_replace("[CONTACT]", $mail_data['clmd_contact'], $body);
                    $body = str_replace("[NAME]", $mail_data['clmd_name'], $body);
                    $body = str_replace("[EMAIL]", $mail_data['clmd_email'], $body);
                    $body = str_replace("[REQUEST_ID]", $mail_data['request_id'], $body);
                    $body = str_replace("[LINK_TO_VIEW_REQUESTED_CLAIM]", $mail_data['request_url'], $body);
                    $body = str_replace("[MESSAGE]", $mail_data['clmd_message'], $body);

                    if ($mail_data['atch']) 
                        $atch = $mail_data['atch'];

                    break;   
                }
                
                case MAIL_CODE_SELLER_SIGNUP:
                {
                    $name = $mail_data['first_name'];
                    $merchant_id = $mail_data['seller_id'];
                    
                    //mail subject
                    $subject = str_replace("[NAME]", $name, $subject);
                    $subject = str_replace("[SELLER_ID]", $merchant_id, $subject);

                    //mail body
                    $body = str_replace("[NAME]", $name, $body);
                    $body = str_replace("[SELLER_ID]", $merchant_id, $body);
                    $body = str_replace("[LINK_TO_VIEW_SELLER_DETAIL]", $mail_data['url'], $body);
                    $body = str_replace("[EMAIL]", $mail_data['email'], $body);
                    $body = str_replace("[CONTACT]", $mail_data['contact_number'], $body);

                    break;
                }

                case MAIL_CODE_HELP_AND_SUPPORT:
                {
                    $name = $this->input->post('name');
                    $contact = $this->input->post('contact');
                    $message = $this->input->post('message');
                    $email = $this->input->post('email');

                    //mail subject
                    $subject = str_replace("[ROPO_SHOP_BRAND_NAME]", ROPO_SHOP_BRAND_NAME, $subject);
                    $subject = str_replace("[NAME]", $name, $subject);

                    //mail body
                    $body = str_replace("[NAME]", $name, $body);
                    $body = str_replace("[CONTACT]", $contact, $body);
                    $body = str_replace("[MESSAGE]", $message, $body);
                    $body = str_replace("[EMAIL]", $email, $body);

                    break;
                }

                case MAIL_CODE_STEP_1_REGISTRATION:
                {
                    $reciever_email = $mail_data['email'];
                    
                    //mail subject
                    $subject = str_replace("[ROPO_SHOP_BRAND_NAME]", ROPO_SHOP_BRAND_NAME, $subject);

                    //mail body
                    $body = str_replace("[MERCHANT_NAME]", $mail_data['merchant_name'], $body);
                    $body = str_replace("[SHOP_NAME]", $mail_data['shop_name'], $body);
                    $body = str_replace("[SUPPORT_MAIL]", SUPPORT_MAIL, $body);
                    $body = str_replace("[SUPPORT_NUMBER]", SUPPORT_NUMBER, $body);
                    $body .= EMAIL_SIGNATURE;
                    $body = nl2br($body);

                    break;
                }

                case MAIL_CODE_STEP_2_REGISTRATION: 
                {
                    $reciever_email = $mail_data['email'];
                    
                    //mail subject
                    $subject = str_replace("[ROPO_SHOP_BRAND_NAME]", ROPO_SHOP_BRAND_NAME, $subject);
                    
                    //mail body
                    $body = str_replace("[MERCHANT_NAME]", $mail_data['merchant_name'], $body);
                    $body = str_replace("[SHOP_NAME]", $mail_data['shop_name'], $body);
                    $body = str_replace("[ROPO_SHOP_BRAND_NAME]", ROPO_SHOP_BRAND_NAME, $body);
                    $body = str_replace("[SUPPORT_MAIL]", SUPPORT_MAIL, $body);
                    $body = str_replace("[SUPPORT_NUMBER]", SUPPORT_NUMBER, $body);
                    $body .= EMAIL_SIGNATURE;
                    $body = nl2br($body);

                    break;   
                }

                case MAIL_CODE_CLAIM_BUSINESS_APPROVED: 
                {
                    $reciever_email = $mail_data['email'];
                    
                    //mail subject
                    $subject = str_replace("[ROPO_SHOP_BRAND_NAME]", ROPO_SHOP_BRAND_NAME, $subject);

                    //mail body
                    $body = str_replace("[MERCHANT_NAME]", $mail_data['merchant_name'], $body);
                    $body = str_replace("[SHOP_NAME]", $mail_data['shop_name'], $body);
                    $body = str_replace("[USER_EMAIL]", $mail_data['email'], $body);
                    $body = str_replace("[USER_PASSWORD]", $mail_data['password'], $body);
                    $body = str_replace("[SUPPORT_MAIL]", SUPPORT_MAIL, $body);
                    $body = str_replace("[SUPPORT_NUMBER]", SUPPORT_NUMBER, $body);
                    $body .= EMAIL_SIGNATURE;
                    $body = nl2br($body);

                    break;
                }

                default: return false;
            }

            $mail_response = sendEmail($reciever_email, $subject, $body, $atch);
            if ($code == MAIL_CODE_HELP_AND_SUPPORT)
            {
                echo "<script>window.alert('Mail has been sent!');</script>";
                redirect($_SERVER['HTTP_REFERER']);
            }
            else {
                echo "<script>window.alert('Unable to send mail!');</script>";
                return $mail_response;
            }
        }
    }

    public function getMinimumOffOnProduct($product_id, $mrp_price)
    {
        $data = array('offer_price' => 0, 'discount_price' => 0, 'off' => 0);
    
        //get product listings
        $sold_by_merchants = $this->am5->getProductListings(array('product_listing.product_id' => $product_id));

        if($sold_by_merchants) {
            $data['offer_price'] = ($sold_by_merchants && is_array($sold_by_merchants['result'])) ? (round(abs(min(array_column($sold_by_merchants['result'], 'sell_price'))), 2)) : 0;
            // echo "<pre>"; print_r($sold_by_merchants); die;
            $data['discount_price'] = (int) trim($mrp_price)- (int) trim($data['offer_price']);
            $data['off'] = calculatePercentage((int) trim($mrp_price), (int) trim($data['offer_price']));
        }

        return $data;
    }

    //-- function for image upload 
    public function single_upload($path, $name="", $obj_name='file')
    {
        $this->createFolder($path);
        
        $allowed_types = array('jpg', 'png', 'jpeg', 'pdf');
        $file_type = $_FILES[$obj_name]['type'];
        $extension = explode("/", $file_type);

        if (!in_array($extension[1], $allowed_types)) 
        {
            echo "Error: allowed file types are => jpg, png, pdf";
            die;
        }

        $_FILES['attatchment']['name'] = ($name) ? $name.'.'.$extension[1] : time().".".$extension[1];
        $_FILES['attatchment']['type'] = $file_type;
        $_FILES['attatchment']['tmp_name'] = $_FILES[$obj_name]['tmp_name'];
        $_FILES['attatchment']['error'] = $_FILES[$obj_name]['error'];
        $_FILES['attatchment']['size'] = $_FILES[$obj_name]['size'];

        $config['upload_path'] = $path;
        $config['allowed_types'] = '*';
        
        //$this->load->library('upload');
        $this->upload->initialize($config);

        if($this->upload->do_upload('attatchment'))
        {
            $fileData = $this->upload->data();
            
            if ($fileData['file_name']) 
                return $fileData['file_name'];
            else
                return FALSE;
        }
        else
        {
            print_r($this->upload->display_errors());
            die;
        }
    }

    public function multiple_upload($path)
    {
        $this->isLoggedIn();

        $filesCount = count($_FILES['files']['name']);
        
        for($i = 0; $i < $filesCount; $i++)
        {
            $file_type = $_FILES['files']['type'][$i];
            $extension = explode("/", $file_type);

            $_FILES['attatchment']['name'] = time().".".$extension[1];
            $_FILES['attatchment']['type'] = $file_type;
            $_FILES['attatchment']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
            $_FILES['attatchment']['error'] = $_FILES['files']['error'][$i];
            $_FILES['attatchment']['size'] = $_FILES['files']['size'][$i];

            if (!is_dir($path))
            {
                if (!mkdir($path, 0777, true)) 
                {
                    echo 'Error: Unable to create folder!';
                    die;
                }
                else
                    chmod($path, 0777);
            }

            $config['upload_path'] = $path;
            $config['allowed_types'] = '*';
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('attatchment'))
            {
                $fileData = $this->upload->data();
                $uploadData[$i]['file_name'] = $fileData['file_name'];
            }
            else
            {
                print_r($this->upload->display_errors());
                die;
            }
        }

        if ($uploadData) 
            return $uploadData;
        else
            return FALSE;
    }

    //copy data from one folder to another folder
    public function cloneData($from, $to, $specificFiles = [])
    {
        $this->createFolder($to);

        // Agar specific files diye gaye hain
        if (!empty($specificFiles)) {
            $files = [];
            foreach ($specificFiles as $fileName) {
                $filePath = $from . '/' . $fileName;
                if (file_exists($filePath)) {
                    $files[] = $filePath;
                }
            }
        } else {
            // Default: copy all files
            $files = glob($from.'/*.*');
        }

        foreach ($files as $file) {
            $file_to_go = str_replace($from, "", $file);
            $isCopied = copy($file, $to.$file_to_go);

            if (!$isCopied) return false;
        }

        return $files;
    }

    //create folder
    public function createFolder($path)
    {
        if (!is_dir($path))
        {
            if (!mkdir($path, 0777, true)) 
            {
                echo 'Error: Unable to create folder!';
                die;
            }
            else
                chmod($path, 0777);
        }

        return true;
    }
}