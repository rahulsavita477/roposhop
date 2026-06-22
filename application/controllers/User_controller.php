<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Admin_controller.php';
require_once 'Common_controller.php';

class User_controller extends CI_Controller 
{
	function __construct()
    {
        parent::__construct();

        $this->load->model(array('Admin_model' => 'am1'));

        //get categories
        // $this->categories = $this->am1->selectRecords('', 'product_category', '*', array('category_name' => 'asc'));
        // echo "<pre>"; print_r($this->categories['result']);

        $categoriesHavingProduct = $this->am1->getCategoriesHavingProduct();
        $this->categories['result'] = $categoriesHavingProduct;
        // echo "<pre>"; print_r($categoriesHavingProduct); die;

        //get categories in tree format
        $parent_categories = $this->am1->selectRecords(array('has_parent' => 0), 'product_category', '*');
        $categories = $parent_categories ? $parent_categories['result'] : [];

        $i = 0;
        foreach ($categories as $category) 
        {
            $where = array('has_parent' => 1, 'parent_category_id' => $category['category_id']);
            $child_categories = $this->am1->selectRecords($where, 'product_category', '*');

            if ($child_categories) 
                $categories[$i]['child_category'] = $child_categories['result'];
            else
                $categories[$i]['child_category'] = false;

            $i++;
        }
            
        $this->tree_list = $categories;

        //get brands
        // $this->brands = $this->am1->selectRecords('', 'brand', '*', array('name' => 'asc'));
        // echo "<pre>"; print_r($this->brands); die;
        $brandHavingProduct = $this->am1->getBrandHavingProduct();
        $this->brands['result'] = $brandHavingProduct;

        //pagination
        $this->limit = 9;
        $this->start = 0;
        $this->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        
        if (isset($_GET['limit'])) 
        {
            if ($_GET['limit'] != "") 
            {
                $this->limit = $_GET['limit'];
                $this->start = 0;

                if (isset($_GET['page']) && $_GET['page'] != "") 
                    $this->start = ($this->limit*$_GET['page']) - $this->limit;
            }
        }

        //common controller
        $this->common_controller = new Common_controller();

        //admin controller
        $this->admin_controller = new Admin_controller();

        //site settings
        $this->site_settings = $this->admin_controller->site_settings();
    }
    
    //load 404 error page
    public function Error404()
    {
        $this->output->set_status_header('404');
        $this->load->view('error404');
    }

    public function privacypolicy()
    {
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/privacypolicy');
        $this->load->view('user/design/include/footer');
    }

    public function aboutus()
    {
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/aboutus');
        $this->load->view('user/design/include/footer');
    }

    //load home page
    public function index()
    {
        $data = array();
        $where['current_status'] = 1;
        $where['start_date <= '] = date("Y-m-d h:i:s");
        $where['end_date >= '] = date("Y-m-d h:i:s");
        $data = $this->getOffers($where); //get offers
        
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $this->limit = '';
        // echo "<pre>"; print_r($data); die;
        
        for ($i=0; $i < sizeof($data['categories']) ; $i++) 
        { 
            if ($data['categories'][$i]['has_parent'] == 0)
            {
                $data['categories'][$i]['products'] = array();
                continue;
            } 

            $cat_id = $data['categories'][$i]['category_id'];

            //get latest products
            $products = $this->getProducts(array('category_id' => $cat_id));
            $products = $products ? sortArray($products['result'], 'offer_price', 'DESC') : array();
            
            $data['categories'][$i]['products'] = $products;
        }

        //get brands
        $data['brands'] = $this->am1->selectRecords('', 'brand', 'brand_id, name, brand_logo');

        //get sellers
        $data['merchants'] = $this->am1->selectRecords(array('status' => 1, 'establishment_name != ' =>''), 'merchant', 'merchant_id, establishment_name, merchant_logo');
        
        $metaData = $this->admin_controller->getMetaData('HOME');

        //meta data
        $data['meta_data']['title'] = $metaData['metaTitle'];
        $data['meta_data']['keywords'] = $metaData['metaKeyword'];
        $data['meta_data']['description'] = $metaData['metaDescription'];
        $data['meta_data']['image'] = base_url('assets/ropo-promo.jpg');

        //load view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/index', $data);
        $this->load->view('ajaxFunctions');
        $this->load->view('user/design/include/footer');
    }

    public function resetPasswordPage($user_id)
    {
        $this->load->view('user/include/header', array());
        $this->load->view('resetPassword', array('user_id' => $user_id));
        $this->load->view('user/include/footer');
    }

    public function resetPassword()
    {
        $otp = $this->input->post('otp');
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');
        $user_id = $this->input->post('user_id');

        if ($password != $cpassword) 
        {
            echo "<script>window.alert('password and confirm password are not same!');</script>";
            $this->resetPasswordPage($user_id);
        }
        else
        {
            $record = $this->am1->selectRecords(array('userId' => $user_id, 'passwordOtp' => $otp), 'user', 'otpCreatetime');
            if (!$record) 
            {
                echo "<script>window.alert('otp is not valid, Please reset your password again!');</script>";
                $this->resetPasswordPage($user_id);
                die;   
            }

            //get time differance between current and db time
            $time1 = new DateTime($record['result'][0]['otpCreatetime']);
            $time2 = new DateTime(date("Y-m-d H:i:s"));
            $since_start = $time1->diff($time2);
            $minutes = $since_start->days * 24 * 60;
            $minutes += $since_start->h * 60;
            $minutes += $since_start->i;
            
            if ($minutes <= 1440) 
            {
                $data = array();
                $data['passwordOtp'] = '';
                $data['otpCreatetime'] = '';
                $data['password'] = $password;
                $condition = array('userId' => $user_id);
                $this->am1->updateData('user', $data, $condition);

                echo "<script>window.alert('Password updated, Please go for signin!');</script>";
                $this->login_page();
            }
            else
            {
                echo "<script>window.alert('Expired link, Please reset your password again!');</script>";
                $this->resetPasswordPage($user_id);
            }
        }
    }

    //load products page
    public function product()
    {
        $data = array();
        $product_ids = array();
        $search_val = $this->input->post('search_val');
        $category_id = isset($_GET['category']) ? $_GET['category'] : $this->input->post('selected_category');
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        
        if (isset($_GET['merchant_id'])) //get perticular merchant products
        {
            //get products id
            $where = array('merchant_id' => $_GET['merchant_id']);
            $prd_ids = $this->am1->selectRecords($where, 'product_listing', 'product_id');

            if ($prd_ids) 
            {
                foreach ($prd_ids['result'] as $prd_id) 
                {
                    if ($prd_id['product_id'])
                        array_push($product_ids, $prd_id['product_id']);
                }

                //get products
                // $where_in['where_column_name'] = 'product_id';
                // $where_in['ids'] = $product_ids;
                $where_in['product_id'] = $product_ids;
                $data['products'] = $this->getProducts('', $where_in);   

                //get merchant meta data
                $metaData = $this->admin_controller->getMetaData('MERCHANT', $_GET['merchant_id']); 
            }
            else
                $data['products'] = false;
        }
        else if (isset($_GET['brand_id'])) //get perticular brand based product 
        {
            $data['products'] = $this->getProducts(array('brand_id' => $_GET['brand_id']));

            //get brand meta data
            $metaData = $this->admin_controller->getMetaData('BRAND', $_GET['brand_id']);
        }
        else if (!$search_val && $category_id == '') 
        {
            $this->categories();
            die;
            // $data['products'] = $this->getProducts();

            //get product meta data
            // $metaData = $this->admin_controller->getMetaData('PRODUCT');
        }
        else //get search based products
        {
            //get category ids in tree format
            $cat_ids = $this->am1->fetchCategoryIdList($category_id);
            array_push($cat_ids, $category_id);
            
            //get products
            // $where_in['where_column_name'] = 'category_id';
            // $where_in['ids'] = $cat_ids;
            $where_in['category_id'] = $cat_ids;
            $data['products'] = $this->getProducts('', $where_in);

            $category_meta_data = $this->am1->selectRecords(array('category_id' => $category_id), 'product_category', 'meta_keyword, meta_description, category_name');
            
            //get category meta data
            $metaData = $this->admin_controller->getMetaData('CATEGORY', $category_id);
        }

        //meta data
        $data['meta_data']['title'] = $metaData['metaTitle'];
        $data['meta_data']['keywords'] = $metaData['metaKeyword'];
        $data['meta_data']['description'] = $metaData['metaDescription'];
        $data['meta_data']['image'] = $metaData['metaImage'];

        //load products view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/products');
        $this->load->view('user/include/footer');
    }

    public function location_setting()
    {
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['states'] = $this->am1->selectRecords(array('status' => 1), 'state', 'state_id, name'); //get all states
        $data['city'] = $this->am1->selectRecords('', 'city', 'name, latitude, longitude'); //get all cities
        $data['area'] = $this->am1->selectRecords('', 'area', 'area_name, latitude, longitude'); //get all areas

        // echo "<pre>"; print_r($data); die;

        //load products view
        // $this->load->view('user/include/header', $data);
        // $this->load->view('user/include/sidebar', $data);
        // $this->load->view('user/location_setting');
        // $this->load->view('user/include/footer');

        // if lat, long not available in cookies then set them using ip address
        $latitude = $this->input->cookie('latitude', true);
        $longitiude = $this->input->cookie('longitude', true);

        if(!$latitude || !$longitiude) {
            $response = file_get_contents("https://ipinfo.io/json");
            $location = json_decode($response, true);

            $this->load->helper('cookie');
        
            // echo "IP: " . $location['ip'] . "<br>";
            // echo "City: " . $location['city'] . "<br>";
            // echo "State Region: " . $location['region'] . "<br>";
            // echo "Country: " . $location['country'] . "<br>";
            // echo $location['loc']; // "lat,long"
            $parts = explode(',', $location['loc']);

            set_cookie('latitude', $parts[0], 3600);
            set_cookie('longitude', $parts[1], 3600);
            
        }

        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/location_setting');
        $this->load->view('ajaxFunctions');
        $this->load->view('user/design/include/footer');
    }

    public function help_support()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        $body = "Name: ".$name."<br />
                Email: ".$email."<br />
                Message: ".$message;
        $isSend = $this->common_controller->sendEmail('', $subject, $body);

        if ($isSend) 
            echo "<script>window.alert('Mail has been sent');</script>";
        else
            echo "<script>window.alert('Unable to send mail');</script>";

        redirect(base_url(), 'refresh');
    } 

    //get prodyct rating
    private function getProductRating($product_id)
    {
        //average rating information
        $rating_info = $this->am1->selectRecords(array('product_id' => $product_id), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
        return $rating_info['result'][0];
    }

    //get products
    public function getProducts($where='', $where_in=array(), $like=array())
    {
        $data = false;
        $discardDisabledProduct = ['isEnabled' => 1];
        if(is_array($where)) {
            $where = $where + $discardDisabledProduct;
        } else {
            $where = $discardDisabledProduct;
        }

        $products = $this->am1->selectRecords($where, 'product', 'SQL_CALC_FOUND_ROWS product_id, product_name, mrp_price, description', array(), $this->limit, $this->start, $like, false, $where_in);
        
        if ($products) 
        {
            $data = $products;

            $i = 0;
            //echo "<pre>"; print_r($products['result']); die;
            foreach ($products['result'] as $product) 
            {
                $attatchments = array();

                //get product images
                $product_id = $product['product_id'];
                $product_imgs = $this->attatchments($product_id, "PRODUCT");

                if ($product_imgs && $product_imgs['result']) 
                {
                    foreach ($product_imgs['result'] as $atch_value) 
                        array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']);
                    
                    if ($attatchments)
                        $data['result'][$i]['products_images'] = $attatchments;
                }
                else
                    $data['result'][$i]['products_images'] = array($this->config->item('site_url').'assets/user/download (1).jpeg');

                //get product rating
                $data['result'][$i]['rating'] = $this->getProductRating($product_id);

                //get minimum off on product by merchant
                $prd_off = $this->common_controller->getMinimumOffOnProduct($product_id, $data['result'][$i]['mrp_price']);
                $data['result'][$i]['offer_price'] = $prd_off['offer_price'];
                $data['result'][$i]['discount_price'] = $prd_off['discount_price'];
                $data['result'][$i]['off'] = $prd_off['off'];

                $i++;
            }

            if (isset($products['count']))
                $data['paging'] = $this->createPagingArray($products['count']);
        }

        return $data;
    }

    public function product_detail()
    {
        if (isset($_GET['category']) && !isset($_GET['prd_id']))
        {
            $this->product();
            die;
        }
        
        $data = array();
        $attatchments = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['product'] = false;
        $key_features = array();

        if (isset($_GET['prd_id']))
        {
            $product_id = $_GET['prd_id']; // product id

            //get product detail
            $where = array('product_id' => $product_id, 'isEnabled' => 1);
            $product_detail = $this->am1->selectRecords($where, 'product', 'category_id, product_id, product_name, mrp_price, description, brand_id, in_the_box, meta_keyword, meta_description');

            //product detail
            $data['product'] = $product_detail ? $product_detail['result'][0] : [];

            //get product meta data
            $metaData = $this->admin_controller->getMetaData('PRODUCT', $product_id);
            //meta data
            $data['meta_data']['title'] = $metaData['metaTitle'];
            $data['meta_data']['keywords'] = $metaData['metaKeyword'];
            $data['meta_data']['description'] = $metaData['metaDescription'];
            $data['meta_data']['image'] = $metaData['metaImage'];

            //get brand name
            if($product_detail) {
                
                $where = array('brand_id' => $product_detail['result'][0]['brand_id']);
                $brand = $this->am1->selectRecords($where, 'brand', 'name, brand_logo');
                $data['product']['brand_name'] = $brand ? $brand['result'][0]['name']: "";
                $data['product']['brand_logo'] = $brand ? base_url(BRAND_ATTATCHMENTS_PATH.$product_detail['result'][0]['brand_id'].'/'.$brand['result'][0]['brand_logo']) : "";
            }

            //get product attributes
            $prd_att_res = $this->am1->productAttributes($product_id);
            if ($prd_att_res && $data['product']) 
                $data['product']['specifications'] = $prd_att_res;
            else
                $data['product']['specifications'] = false;

            //get product varients
            $prd_att_res = $this->am1->productVarients($product_id);
            if ($prd_att_res) 
            {
                //create grouped array for varients
                $newArray = array();
                foreach($prd_att_res as $val){
                    $newKey = $val['att_name'];
                    $newArray[$newKey][] = $val['att_value'];
                }

                $data['product']['varients'] = $newArray;
            }
            else
                $data['product']['varients'] = false;

            //get product key features
            $prd_feature = $this->am1->selectRecords(array('product_id' => $product_id), 'product_key_features', 'feature');
            if ($prd_feature) 
            {
                foreach ($prd_feature['result'] as $feature_value) 
                    array_push($key_features, $feature_value['feature']);
            }

            $data['product']['key_features'] = $key_features;

            //get product images
            $product_imgs = $this->attatchments($product_id, "PRODUCT");
            if ($product_imgs && $product_imgs['result']) 
            {
                foreach ($product_imgs['result'] as $atch_value) 
                    array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']);
                
                if ($attatchments)
                    $data['product']['images'] = $attatchments;
            }
            else
                $data['product']['images'] = array($this->config->item('site_url').'assets/user/download (1).jpeg');

            //get product reviews
            $product_reviews = $this->am1->productReviews(array('product_review.product_id' => $product_id), 0, 3);
            if ($product_reviews)
                $data['product']['reviews'] = $product_reviews;
            else
                $data['product']['reviews'] = false;

            //average rating information
            $rating_info = $this->am1->selectRecords(array('product_id' => $product_id), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
            $data['product']['rating_info'] = $rating_info['result'][0];

            //get product listing information
            $sold_by_merchants = $this->am1->getProductListings(array('product_listing.product_id' => $product_id));
            $data['product']['sold_by_merchants'] = $sold_by_merchants['result'];

            if ($sold_by_merchants) 
            {
                $address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';

                $i = 0;
                foreach ($sold_by_merchants['result'] as $merchant) 
                {
                    if (isset($_COOKIE['latitude']) && isset($_COOKIE['longitude'])) 
                    {
                        $getNearestAddressId = $this->am1->getNearestAddress('Where userId = '.$merchant['userId']);
                        $getAddress = $this->am1->getUserAddress(array('address_id' => $getNearestAddressId[0]['address_id']), $address_columns);
                    }
                    else
                        $getAddress = $this->am1->getUserAddress(array('address.userId' => $merchant['userId']), $address_columns);

                    $data['product']['sold_by_merchants'][$i]['nearest_address'] = $getAddress ? $getAddress['result'][0] : false;
                }
            }

            //get similar product
            if(isset($data['product']['category_id'])) $where = array('product_id !=' => $product_id, 'category_id' => $data['product']['category_id']);
            $similar_products = $this->am1->selectRecords($where, 'product', 'product_id, product_name');
            
            if ($similar_products) 
            {
                $data['product']['similar_products'] = $similar_products['result'];

                //get product images
                $i = 0;
                foreach ($similar_products['result'] as $product) 
                {
                    $attatchments = array();
                    $product_id = $product['product_id'];

                    $product_imgs = $this->attatchments($product_id, "PRODUCT");
                    if ($product_imgs && $product_imgs['result']) 
                    {
                        foreach ($product_imgs['result'] as $atch_value) 
                            array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']);
                        
                        if ($attatchments)
                            $data['product']['similar_products'][$i]['images'] = $attatchments;
                    }
                    else
                        $data['product']['similar_products'][$i] = false;

                    $i++;
                }
            }
        }


        //load product detail view
        /*$this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/product_details');
        $this->load->view('user/include/footer');*/
        
        //load view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/product_detail', $data);
        $this->load->view('user/design/include/footer');
    }

    public function productRatingPage($product_id)
    {
        $data = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['product'] = false;

        //get product rating and review detail

        //get product detail
        $product_detail = $this->am1->selectRecords(array('product_id' => $product_id), 'product', 'product_id, product_name, mrp_price');
        $data['product'] = $product_detail['result'][0];
        $prd_off = $this->common_controller->getMinimumOffOnProduct($product_id, $data['product']['mrp_price']);
        $data['product']['offer_price'] = $prd_off['offer_price'];
        $data['product']['discount_price'] = $prd_off['discount_price'];
        $data['product']['off'] = $prd_off['off'];

        //get product image
        $product_imgs = $this->attatchments($product_id, "PRODUCT");
        if ($product_imgs['result']) 
            $data['product']['image'] = base_url(PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$product_imgs['result'][0]['atch_url']);
        else
            $data['product']['image'] = base_url('assets/user/download (1).jpeg');

        //get product reviews order by selected filter
        if (!isset($_GET['orderby'])) 
            $_GET['orderby'] = '';

        switch ($_GET['orderby']) 
        {
            case 'update_date_desc':
                $order_by = array('product_review.update_date' => 'DESC');
                break;
            
            case 'create_date_asc':
                $order_by = array('product_review.create_date' => 'ASC');
                break;

            case 'rating_desc':
                $order_by = array('product_review.rating' => 'DESC');
                break;

            case 'rating_asc':
                $order_by = array('product_review.rating' => 'ASC');
                break;

            default:
                $order_by = array('product_review.update_date' => 'DESC');
                break;
        }

        $product_reviews = $this->am1->productReviews(array('product_review.product_id' => $product_id), '', '', $order_by);
        if ($product_reviews)
            $data['product']['reviews'] = $product_reviews['result'];
        else
            $data['product']['reviews'] = false;

        //get login user review
        $data['product']['login_user_review'] = false;
        if (isset($_COOKIE['consumer_id'])) 
        {
            $prd_usr_review = $this->am1->productReviews(array('product_review.product_id' => $product_id, 'product_review.consumer_id' => $_COOKIE['consumer_id'], 'product_review.status' => 0));
            if ($prd_usr_review)
                $data['product']['login_user_review'] = $prd_usr_review['result'][0];
        }

        //average rating information
        $rating_info = $this->am1->selectRecords(array('product_id' => $product_id, 'status' => 0), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
        $data['product']['rating_info'] = $rating_info['result'][0];

        //echo "<pre>"; print_r($data); die;

        //load view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/product_rating', $data);
        $this->load->view('user/design/include/footer');
    }

    public function merchantRatingPage($merchant_id)
    {
        $data = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['merchant'] = false;

        //get merchant detail
        $merchant_detail = $this->am1->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'merchant_id, merchant_logo, establishment_name');
        $data['merchant'] = $merchant_detail['result'][0];

        //get product reviews order by selected filter
        if (!isset($_GET['orderby'])) 
            $_GET['orderby'] = '';

        switch ($_GET['orderby']) 
        {
            case 'update_date_desc':
                $order_by = array('merchant_review.update_date' => 'DESC');
                break;
            
            case 'create_date_asc':
                $order_by = array('merchant_review.create_date' => 'ASC');
                break;

            case 'rating_desc':
                $order_by = array('merchant_review.rating' => 'DESC');
                break;

            case 'rating_asc':
                $order_by = array('merchant_review.rating' => 'ASC');
                break;

            default:
                $order_by = array('merchant_review.update_date' => 'DESC');
                break;
        }
        
        $merchant_reviews = $this->am1->merchantReviews(array('merchant_review.merchant_id' => $merchant_id), '', '', $order_by);
        if ($merchant_reviews)
            $data['merchant']['reviews'] = $merchant_reviews['result'];
        else
            $data['merchant']['reviews'] = false;

        //get login user review
        $data['merchant']['login_user_review'] = false;
        if (isset($_COOKIE['consumer_id'])) 
        {
            $prd_usr_review = $this->am1->merchantReviews(array('merchant_review.merchant_id' => $merchant_id, 'merchant_review.consumer_id' => $_COOKIE['consumer_id'], 'merchant_review.status' => 0));
            if ($prd_usr_review)
                $data['merchant']['login_user_review'] = $prd_usr_review['result'][0];
        }

        //average rating information
        $rating_info = $this->am1->selectRecords(array('merchant_id' => $merchant_id, 'status' => 0), 'merchant_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
        $data['merchant']['rating_info'] = $rating_info['result'][0];

        //echo "<pre>"; print_r($data); die;

        //load view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/merchant_rating', $data);
        $this->load->view('user/design/include/footer');
    }

    public function listing_detail()
    {
        $data = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        if (isset($_GET['list_id']) && $_GET['list_id'] != 'undefined')
        {
            // $address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';

            $listing_id = $_GET['list_id']; // listing id
            $product_id = $_GET['prd_id']; // product id

            //get product listing information
            $listing_result = $this->am1->getProductListings(array('listing_id' => $listing_id));
            $data['listing'] = $listing_result['result'][0];

            //get listing's offers
            $data['listing']['offers'] = $this->am1->getListingOffers(array('lst_id' => $listing_id));

            //get merchant detail
            $merchant_id = $listing_result['result'][0]['merchant_id'];
            $where = array('merchant_id' => $merchant_id);
            $merchant_detail = $this->am1->selectRecords($where, 'merchant', '*');
            $data['merchant'] = $merchant_detail['result'][0];
            $attatchments = array();
            
            //merchant logo
            if ($merchant_detail['result'][0]['merchant_logo'])
                array_push($attatchments, $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$merchant_detail['result'][0]['merchant_logo']);

            //get merchant shop images
            $product_imgs = $this->attatchments($merchant_id, "SELLER");
            if ($product_imgs && $product_imgs['result']) 
            {
                foreach ($product_imgs['result'] as $atch_value) 
                    array_push($attatchments, $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$atch_value['atch_url']);
            }

            if (count($attatchments)>0)
                $data['merchant']['images'] = $attatchments;
            else
                $data['merchant']['images'] = array($this->config->item('site_url').'assets/user/download (1).jpeg');

            //get seller heighlights
            $data['merchant']['heighlights'] = $this->am1->selectRecords(array('merchant_id' => $merchant_id), 'merchant_offering', '*');

            //merchant nearest address
            $address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';
            if (isset($_COOKIE['latitude']) && isset($_COOKIE['longitude'])) 
            {
                $getNearestAddressId = $this->am1->getNearestAddress('Where userId = '.$merchant_detail['result'][0]['userId']);
                $getAddress = $this->am1->getUserAddress(array('address_id' => $getNearestAddressId[0]['address_id']), $address_columns);
            }
            else
                $getAddress = $this->am1->getUserAddress(array('address.userId' => $merchant_detail['result'][0]['userId']), $address_columns);

            $data['merchant']['address']['nearest_address'] = $getAddress ? $getAddress['result'][0] : null;
            $data['merchant']['address']['total_address'] = $getAddress ? $getAddress['count'] : 0;

            //average rating information
            $rating_info = $this->am1->selectRecords(array('merchant_id' => $merchant_id), 'merchant_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
            $data['merchant']['rating_info'] = $rating_info['result'][0];

            //get product detail
            $where = array('product_id' => $product_id);
            $product_detail = $this->am1->selectRecords($where, 'product', 'category_id, product_id, product_name, mrp_price, description, brand_id, in_the_box, meta_keyword, meta_description');

            //product detail
            $data['product'] = $product_detail['result'][0];

            //get brand name
            $where = array('brand_id' => $product_detail['result'][0]['brand_id']);
            $brand = $this->am1->selectRecords($where, 'brand', 'name, brand_logo');
            $data['product']['brand_name'] = $brand['result'][0]['name'];
            $data['product']['brand_logo'] = base_url(BRAND_ATTATCHMENTS_PATH.$product_detail['result'][0]['brand_id'].'/'.$brand['result'][0]['brand_logo']);

            //get product key features
            $prd_feature = $this->am1->selectRecords(array('product_id' => $product_id), 'product_key_features', 'feature');
            $key_features = array();
            if ($prd_feature) 
            {
                foreach ($prd_feature['result'] as $feature_value) 
                    array_push($key_features, $feature_value['feature']);
            }

            $data['product']['key_features'] = $key_features;

            //get product images
            $product_imgs = $this->attatchments($product_id, "PRODUCT");
            $attatchments = array();
            if ($product_imgs && $product_imgs['result']) 
            {
                foreach ($product_imgs['result'] as $atch_value) 
                    array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']);
                
                if ($attatchments)
                    $data['product']['images'] = $attatchments;
            }
            else
                $data['product']['images'] = array($this->config->item('site_url').'assets/user/download (1).jpeg');

            //average rating information
            $rating_info = $this->am1->selectRecords(array('product_id' => $product_id), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
            $data['product']['rating_info'] = $rating_info['result'][0];

            //get merchant meta data
            $metaData = $this->admin_controller->getMetaData('MERCHANT', $data['listing']['merchant_id']);
            //meta data
            $data['meta_data']['title'] = $metaData['metaTitle'];
            $data['meta_data']['keywords'] = $metaData['metaKeyword'];
            $data['meta_data']['description'] = $metaData['metaDescription'];
            $data['meta_data']['image'] = $metaData['metaImage'];
        }

        //load product detail view
        // $this->load->view('user/include/header', $data);
        // $this->load->view('user/include/sidebar', $data);
        // $this->load->view('user/listing_details');
        // $this->load->view('user/include/footer');

        // echo "<pre>"; print_r($data); die;
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/listing_detail', $data);
        $this->load->view('user/design/include/footer');
    }

    public function login_page()
    {
        if (isset($_COOKIE['user_id'])) 
            redirect('', 'refresh');
        else
        {
            $data['categories'] = $this->categories['result']; //get categories
            $data['tree_list'] = $this->tree_list; //get categories in tree format

            //meta data
            $data['meta_data']['title'] = 'user login | RopoShop';
            $data['meta_data']['keywords'] = 'RopoShop';
            $data['meta_data']['description'] = 'RopoShop';
            $data['meta_data']['image'] = 'RopoShop';

            //load user register view
            $this->load->view('user/design/include/header', $data);
            $this->load->view('user/design/user_login');
            $this->load->view('user/design/include/footer');

            // $this->load->view('user/include/header', $data);
            // $this->load->view('user/include/sidebar', $data);
            // $this->load->view('user/login');
            // $this->load->view('user/include/footer');
        }
    }

    //get seller offers
    public function getOffers($where='')
    {
        $columns = 'offer_id, offer_title, description, start_date, end_date, meta_keyword, meta_description';
        $mer_offers = $this->am1->selectRecords($where, 'product_listing_offer', $columns);

        if ($mer_offers)
        {
            $res['offers'] = $mer_offers['result'];

            $i = 0;
            foreach ($mer_offers['result'] as $mer_offer) 
            {
                $attatchments = array();

                //get offer images
                $offer_id = $mer_offer['offer_id'];
                $offer_imgs = $this->attatchments($offer_id, "OFFER");

                if ($offer_imgs && $offer_imgs['result']) 
                {
                    foreach ($offer_imgs['result'] as $atch_value) 
                        array_push($attatchments, $this->config->item('site_url').OFFER_ATTATCHMENTS_PATH.$offer_id.'/'.$atch_value['atch_url']);
                    
                    if ($attatchments)
                        $res['offers'][$i]['offer_images'] = $attatchments;
                }
                else
                    $res['offers'][$i]['offer_images'] = false;

                $i++;
            }
        }
        else
            $res['offers'] = false;

        return $res;
    }

    //get attatchments
    public function attatchments($link_id, $atch_for)
    {
        $where = array('link_id' => $link_id, 'atch_for' => $atch_for);
        $atch_res = $this->am1->selectRecords($where, 'attatchments', 'atch_url');

        if ($atch_res) 
            return $atch_res;
        else
            return FALSE;
    }
    
    public function insertUser()
    {
        $user_id = $this->input->post('user_id');
        
        $user_data = array();
        $consumer_data = array();

        //user data
        $consumer_data['gender'] = $this->input->post('gender');
        $dob = $this->input->post('dob');
        $consumer_data['phone'] = $this->input->post('phone');

        if ($dob) 
            $consumer_data['birthday'] = date("d-m-Y", strtotime($dob));

        $user_data['status'] = 1;
        $user_data['first_name'] = $this->input->post('full_name');    

        if ($user_id) 
        {
            if ($_FILES['file']['name'] != '')
                $user_data['picture'] = $this->common_controller->single_upload(PROFILE_PIC_PATH);

            $condition = array('userId' => $user_id);
            $this->am1->updateData('user', $user_data, $condition);

            //check consumer detail is already exist or not
            $isConsumerExist = $this->am1->selectRecords(array('userId' => $user_id), 'consumer', 'userId');
            if ($isConsumerExist) 
                $this->am1->updateData('consumer', $consumer_data, $condition);
            else
            {
                $consumer_data['userId'] = $user_id;
                $this->am1->insertData('consumer', $consumer_data);
            }

            //get user detail
            $usr_details = $this->am1->getUser($user_id, 1);

            $this->redirect('Profile updated successfully', 'userProfile?profile=view');
        }
        else
        {
            $user_data['email'] = $this->input->post('email');
            $user_data['password'] = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            
            if ($confirm_password != $user_data['password']) 
                $this->redirect('Error: password and confirm password should be same', 'login');
            
            //check email is already exist or not
            $isEmailExist = $this->am1->selectRecords(array('email' => $user_data['email']), 'user', 'userId');

            if ($isEmailExist) 
                $this->redirect('Error: email already exist!', 'login');
            else
            {
                $user_id = $this->am1->insertData('user', $user_data);

                if ($user_id)
                {
                    //insert user role
                    $type_data['usr_id'] = $user_id;
                    $type_data['type_name'] = 'BUYER';

                    $type_id = $this->am1->insertData('user_type', $type_data);

                    if (!$type_id)
                       $this->redirect('Error: unable to add you as a consumer', 'login');
                   else
                   {
                        $usr_details = $this->am1->getUser($user_id, 1);
            
                        if (isset($usr_details['db_error'])) 
                            $this->redirect('Error: '.$usr_details['msg'], 'login');

                        $usr_roles = $this->am1->selectRecords(array('usr_id' => $user_id), 'user_type', 'type_name');
                        if (isset($usr_roles['db_error'])) 
                            $this->redirect('Error: '.$usr_roles['msg'], 'login');

                        if ($usr_details) 
                        {
                            $isValidUser = false;
                            foreach ($usr_roles['result'] as $role) 
                            {
                                if ($role['type_name'] == 'BUYER') 
                                {
                                    $isValidUser = true;
                                    break;
                                }
                            }

                            if ($isValidUser) 
                            {                                
                                $consumer = $this->am1->selectRecords(array('userId' => $user_id), 'consumer', 'consumer_id');
                                if (isset($consumer['db_error'])) 
                                    $this->redirect('Error: '.$consumer['msg'], $controller);

                                $_COOKIE['consumer_id'] = $consumer['result'][0]['consumer_id'];
                                redirect('userProfile?profile=view', 'refresh');
                            }
                            else
                                $this->redirect('Error: Not authorised for login!', $controller);
                        }
                        else
                            $this->redirect('Error: You are not a varified user, please contact to system administrator!', $controller);
                   }
                }           
                else
                    $this->redirect('Error: unable to add you', 'login');
            }
        }
    }

    //login method
    public function userLogin()
    {
        $usr_roles = array(); 
        $usr_details = array();
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        $controller = 'login';

        if (!$username && !$password) 
        {
            $this->login_page();
            die;
        }

        $usr_id = $this->am1->doLogin($username, $password);
        if (isset($usr_id['db_error'])) 
            $this->redirect('Error: '.$usr_id['msg'], $controller);
        
        if ($usr_id) 
        {
            $usr_id = $usr_id['userId'];
            $usr_details = $this->am1->getUser($usr_id, 1);
            
            if (isset($usr_details['db_error'])) 
                $this->redirect('Error: '.$usr_details['msg'], $controller);

            $usr_roles = $this->am1->selectRecords(array('usr_id' => $usr_id), 'user_type', 'type_name');

            if (isset($usr_roles['db_error'])) 
                $this->redirect('Error: '.$usr_roles['msg'], $controller);

            if ($usr_details) 
            {
                $isValidUser = false;
                foreach ($usr_roles['result'] as $role) 
                {
                    if ($role['type_name'] == 'BUYER') 
                    {
                        $isValidUser = true;
                        break;
                    }
                }

                if (!$isValidUser) 
                {
                    $this->am1->insertData('consumer', array('userId' => $usr_id));
                    $this->am1->insertData('user_type', array('usr_id' => $usr_id, 'type_name' => 'BUYER'));   
                }
                    
                $consumer = $this->am1->selectRecords(array('userId' => $usr_id), 'consumer', 'consumer_id');
                if (isset($consumer['db_error'])) 
                    $this->redirect('Error: '.$consumer['msg'], $controller);

                setcookie('consumer_id', $consumer['result'][0]['consumer_id'], null, "/");

                goBack();
                //redirect('', 'refresh');
            }
            else
                $this->redirect('Error: You are not a varified user, please contact to system administrator!', $controller);
        }
        else
            $this->redirect('Error: Wrong credential!', $controller);
    }

    public function userLogout()
    {
        //unset all cookies
        setcookie('email', '', null, "/");
        setcookie('image', '', null, "/");
        setcookie('name', '', null, "/");
        setcookie('status', '', null, "/");
        setcookie('token', '', null, "/");
        setcookie('user_id', '', null, "/");
        setcookie('merchant_id', '', null, "/");
        setcookie('consumer_id', '', null, "/");

        redirect(base_url(), 'refresh');
    }

    public function userProfile()
    {
        if (!isset($_COOKIE['consumer_id'])) 
        {   
            $this->login_page();
            die;
        }

        $user = false;
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        $user = $this->am1->getConsumer($_COOKIE['consumer_id']);

        //load view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/userProfile', $user);
        $this->load->view('user/include/footer');
    }

    public function merchants()
    {
        $merchants = false;
        $attatchments = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['brands'] = $this->brands; //get brands

        if (isset($_GET['merchant_id'])) 
        {
            $merchants = array();
            $merchant_id = $_GET['merchant_id'];

            //merchant detail
            $where = array('merchant_id' => $merchant_id);
            $merchant_detail = $this->am1->selectRecords($where, 'merchant', '*');
            $merchants['merchant_detail'] = $merchant_detail['result'][0];
            
            $data['establishment_name'] = $merchant_detail['result'][0]['establishment_name'];
            
            //merchant logo
            if ($merchant_detail['result'][0]['merchant_logo'])
                array_push($attatchments, $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$merchant_detail['result'][0]['merchant_logo']);

            // get merchant's user detail
            $userDetails = $this->am1->selectRecords(['userId' => $merchant_detail['result'][0]['userId']], 'user', '*');
            $data['userDetail'] = $userDetails['result'][0];

            //get merchant shop images
            $product_imgs = $this->attatchments($merchant_id, "SELLER");
            if ($product_imgs && $product_imgs['result']) 
            {
                foreach ($product_imgs['result'] as $atch_value) 
                    array_push($attatchments, $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$atch_value['atch_url']);
            }

            if (count($attatchments)>0)
                $merchants['shop_images'] = $attatchments;
            else
                $merchants['shop_images'] = array($this->config->item('site_url').'assets/user/download (1).jpeg');

            //get seller heighlights
            $merchants['merchant_heighlights'] = $this->am1->selectRecords(array('merchant_id' => $merchant_id), 'merchant_offering', '*');

            //merchant nearest address
            $address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';
            if (isset($_COOKIE['latitude']) && isset($_COOKIE['longitude'])) 
            {
                $getNearestAddressId = $this->am1->getNearestAddress('Where userId = '.$merchant_detail['result'][0]['userId']);
                if($getNearestAddressId) {
                    $getAddress = $this->am1->getUserAddress(array('address_id' => $getNearestAddressId[0]['address_id']), $address_columns);
                }
            }
            else
                $getAddress = $this->am1->getUserAddress(array('address.userId' => $merchant_detail['result'][0]['userId']), $address_columns);

            $merchants['address']['nearest_address'] = isset($getAddress) ? $getAddress['result'][0] : null;
            $merchants['address']['total_address'] = isset($getAddress) ? $getAddress['count'] : 0;

            //get product reviews
            $merchant_reviews = $this->am1->merchantReviews(array('merchant_review.merchant_id' => $merchant_id), 3, 0);
            if ($merchant_reviews)
                $merchants['reviews'] = $merchant_reviews;
            else
                $merchants['reviews'] = false;

            //average rating information
            $rating_info = $this->am1->selectRecords(array('merchant_id' => $merchant_id), 'merchant_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star");
            $merchants['rating_info'] = $rating_info['result'][0];

            //listing product counts
            $merchantProductCnt = $this->am1->selectRecords(array('merchant_id' => $_GET['merchant_id']), 'product_listing', 'COUNT(listing_id) AS listingCnt');
            $merchants['totalProduct'] = $merchantProductCnt['result'][0]['listingCnt'];

            //get merchant listing products categories
            $data['listing_product_categories'] = $this->am1->getCategoriesHavingProduct($_GET['merchant_id']);
            
            //get merchant's listing products categories
            $data['listing_product_brands'] = $this->am1->getBrandHavingProduct($_GET['merchant_id']);
            
            //get merchant meta data
            $metaData = $this->admin_controller->getMetaData('MERCHANT', $_GET['merchant_id']);

            $page = 'merchant_detail';
        }
        else //get all merchants
        {
            $search = (isset($_GET['search_tearm'])) ? array('establishment_name', $_GET['search_tearm']) : array();

            $merchants = $this->am1->selectRecords(array('status' => 1), 'merchant', '*', array(), '', '', $search);

            //get merchant meta data
            $metaData = $this->admin_controller->getMetaData('MERCHANT');

            $page = 'merchants';
        }

        //meta data
        $data['meta_data']['title'] = $metaData['metaTitle'];
        $data['meta_data']['keywords'] = $metaData['metaKeyword'];
        $data['meta_data']['description'] = $metaData['metaDescription'];
        $data['meta_data']['image'] = $metaData['metaImage'];

        // echo "<pre>"; print_r($merchants);die;
        // echo "<pre>"; print_r($data);die;
        // echo $page; die;

        //load view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/'.$page, $merchants);
        
        if ($page == 'merchant_detail')
        {
            // echo "<pre>"; print_r($data); die;

            $this->load->view('user/design/include/merchant_products_with_filter', $data);
            $this->load->view('ajaxFunctions');  
        }
                
        $this->load->view('user/design/include/footer');
    }

    public function categories()
    {
        $data = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['brands'] = $this->brands; //get brands

        //product counts
        $productCnt = $this->am1->selectRecords('', 'product', 'COUNT(product_id) AS productCnt');
        $data['totalProduct'] = $productCnt['result'][0]['productCnt'];

        //get merchant meta data
        $metaData = $this->admin_controller->getMetaData('CATEGORY');

        //meta data
        $data['meta_data']['title'] = $metaData['metaTitle'];
        $data['meta_data']['keywords'] = $metaData['metaKeyword'];
        $data['meta_data']['description'] = $metaData['metaDescription'];
        $data['meta_data']['image'] = $metaData['metaImage'];

        // echo "<pre>"; print_r($data);die;

        //load view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/categories', $data);   
        $this->load->view('ajaxFunctions');
        $this->load->view('user/design/include/footer');
    }

    public function category()
    {
        $data = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['brands'] = $this->brands; //get brands
        $data['parent_category_id'] = $_GET['category']; //get brands
        $category_name = $this->am1->selectRecords(array('category_id' => $_GET['category']), 'product_category', 'category_name');
        $data['category_name'] = $category_name['result'][0]['category_name'];

        //product counts
        $productCnt = $this->am1->selectRecords('', 'product', 'COUNT(product_id) AS productCnt');
        $data['totalProduct'] = $productCnt['result'][0]['productCnt'];

        //get child categories ids
        $a_child_category = $this->am1->selectRecords(array('parent_category_id' => $_GET['category']), 'product_category', 'category_id');
        $data['a_child_category'] = $a_child_category ? array_column($a_child_category['result'], 'category_id') : array($_GET['category']);

        //get merchant meta data
        $metaData = $this->admin_controller->getMetaData('CATEGORY');

        //meta data
        $data['meta_data']['title'] = $metaData['metaTitle'];
        $data['meta_data']['keywords'] = $metaData['metaKeyword'];
        $data['meta_data']['description'] = $metaData['metaDescription'];
        $data['meta_data']['image'] = $metaData['metaImage'];

        // echo "<pre>"; print_r($data);die;

        //load view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/category', $data);
        $this->load->view('ajaxFunctions', $data);
        $this->load->view('user/design/include/footer');
    }

    public function merchantAddress($merchant_id)
    {
        $data = array();
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['merchant_id'] = $merchant_id;

        //get all states
        $states = $this->am1->selectRecords('', 'state', 'state_id, name');
        $data['states'] = $states['result'];

        //get establishment name
        $merchant_establishment_name = $this->am1->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'establishment_name');
        $data['establishment_name'] = $merchant_establishment_name['result'][0]['establishment_name'];

        //get merchant user id
        $merchant_user_id = $this->am1->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
        $user_id = $merchant_user_id['result'][0]['userId'];
        $mer_reviews = $this->am1->getUserAddress(array('address.userId' => $user_id), 'COUNT(address_id) AS addressCnt');
        $data['totalAddress'] = $mer_reviews['result'][0]['addressCnt'];

        // echo "<pre>"; prin        $this->l        $this->load->view('user/design/category', $data);   
        
        $this->load->view('user/design/include/header', $data);
        $this->load->view('ajaxFunctions', $data);             
        $this->load->view('user/design/merchant_addresses', $data);
        $this->load->view('ajaxFunctions', $data);             
        $this->load->view('user/design/include/footer');
    }

    public function brands()
    {
        $brands = false;
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        if (isset($_GET['brand_id'])) 
        {
            $brand = $this->am1->selectRecords(array('brand_id' => $_GET['brand_id']), 'brand', 'brand_id, name, brand_logo, brand_desc, meta_keyword, meta_description');
            $brands['brand'] = $brand['result'][0];

            $attatchments = array();
            array_push($attatchments, $this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$_GET['brand_id'].'/'.$brand['result'][0]['brand_logo']);

            //get product images
            $brand_id = $brand['result'][0]['brand_id'];
            $brand_imgs = $this->attatchments($brand_id, "BRAND");

            if ($brand_imgs && $brand_imgs['result']) 
            {
                foreach ($brand_imgs['result'] as $atch_value) 
                    array_push($attatchments, $this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$brand_id.'/'.$atch_value['atch_url']);
            }

            $brands['brand_images'] = $attatchments;

            //get brand products
            $brands['products'] = $this->getProducts(array('brand_id' => $brand_id));
            
            //get brand products
            $brands['categories'] = $this->am1->getCategoriesHavingProduct('', $brand_id);

            //brand product counts
            $brandProductCnt = $this->am1->selectRecords(array('brand_id' => $_GET['brand_id']), 'product', 'COUNT(product_id) AS productCnt');
            $brands['totalProduct'] = $brandProductCnt['result'][0]['productCnt'];

            //get merchant meta data
            $metaData = $this->admin_controller->getMetaData('MERCHANT', $_GET['brand_id']);

            //meta data
            $data['meta_data']['title'] = $metaData['metaTitle'];
            $data['meta_data']['keywords'] = $metaData['metaKeyword'];
            $data['meta_data']['description'] = $metaData['metaDescription'];
            $data['meta_data']['image'] = $metaData['metaImage'];

            //load view
            // $this->load->view('user/include/header', $data);
            // $this->load->view('user/include/sidebar', $data);
            // $this->load->view('user/brand', $brands);
            // $this->load->view('user/include/footer');

            //load view
            $this->load->view('user/design/include/header', $data);
            $this->load->view('user/design/brand_detail', $brands);
            $this->load->view('ajaxFunctions');
            $this->load->view('user/design/include/footer');
        }
        else //get all brands
        {
            $search = (isset($_GET['search_tearm'])) ? array('name', $_GET['search_tearm']) : array();

            $brands = $this->am1->selectRecords('', 'brand', 'brand_id, name, brand_logo, brand_desc', array(), '', '', $search);
            
            //get merchant meta data
            $metaData = $this->admin_controller->getMetaData('BRAND');

            //meta data
            $data['meta_data']['title'] = $metaData['metaTitle'];
            $data['meta_data']['keywords'] = $metaData['metaKeyword'];
            $data['meta_data']['description'] = $metaData['metaDescription'];
            $data['meta_data']['image'] = $metaData['metaImage'];

            //load view
            $this->load->view('user/design/include/header', $data);
            $this->load->view('user/design/brands', $brands);
            $this->load->view('user/design/include/footer');
        }
    }

    public function insertReview()
    {
        if (!isset($_COOKIE['consumer_id'])) 
        {
            $this->login_page();
            die;
        }

        $review_for = $this->input->post('review_for');
        $merchant_id = $this->input->post('merchant_id');
        $product_id = $this->input->post('product_id');

        $review_data = array();
        $review_data['review'] = $this->input->post('review');
        $review_data['rating'] = $this->input->post('rating');
        $review_data['status'] = 0;
        $review_data['consumer_id'] = $_COOKIE['consumer_id'];
        $review_data['update_date'] = date("Y-m-d H:i:s");

        $msg = 'Your rating update successfully';

        if ($review_for == "merchant") 
        {
            $review_data['merchant_id'] = $merchant_id;
            $condition = array('consumer_id' => $_COOKIE['consumer_id'], 'merchant_id' => $merchant_id);
            $isExistMerchantReview = $this->am1->selectRecords($condition, 'merchant_review', 'review_id');
            if ($isExistMerchantReview) 
            {
                $review_id = $isExistMerchantReview['result'][0]['review_id'];
                $condition = array('review_id' => $review_id);
                $this->am1->updateData('merchant_review', $review_data, $condition);
            }
            else
            {
                $review_data['create_date'] = date("Y-m-d H:i:s");
                $this->am1->insertData('merchant_review', $review_data);
            }

            $controller = 'merchant/rating/'.$merchant_id;
        }
        else if ($review_for == "product") 
        {
            $review_data['product_id'] = $product_id;

            //set null for blank fields
            setNULLToBlank($review_data);

            $condition = array('consumer_id' => $_COOKIE['consumer_id'], 'product_id' => $product_id);
            $isExistProductReview = $this->am1->selectRecords($condition, 'product_review', 'review_id');
            if ($isExistProductReview) 
            {
                $review_id = $isExistProductReview['result'][0]['review_id'];
                $condition = array('review_id' => $review_id);
                $this->am1->updateData('product_review', $review_data, $condition);
            }
            else
            {
                $review_data['create_date'] = date("Y-m-d H:i:s");
                $this->am1->insertData('product_review', $review_data);
            }

            $controller = 'product/rating/'.$product_id;
        }

        $this->redirect($msg, $controller);
    }

    public function offer()
    {
        $offer_id = $_GET['offer_id'];

        //get offer
        $data = $this->getOffers(array('offer_id' => $offer_id, 'current_status' => 1));

        //get offer listing products
        $data['offer_listing_products'] = $this->am1->getListingOffers(array('ofr_id' => $offer_id));
        if ($data['offer_listing_products']) 
        {
            $i = 0;
            foreach ($data['offer_listing_products'] as $product) 
            {
                $attatchments = array();

                //get product images
                $product_id = $product['product_id'];
                $product_imgs = $this->attatchments($product_id, "PRODUCT");

                if ($product_imgs['result']) 
                {
                    foreach ($product_imgs['result'] as $atch_value) 
                        array_push($attatchments, base_url(PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$atch_value['atch_url']));
                    
                    if ($attatchments)
                        $data['offer_listing_products'][$i]['products_images'] = $attatchments;
                }
                else
                    $data['offer_listing_products'][$i]['products_images'] = false;

                $i++;
            }
        }

        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format

        //need to work here
        //$metaData = $this->admin_controller->getMetaData('OFFER');

        //meta data
        $data['meta_data']['title'] = '';
        $data['meta_data']['keywords'] = '';
        $data['meta_data']['description'] = '';

        //load view
        $this->load->view('user/include/header', $data);
        $this->load->view('user/include/sidebar', $data);
        $this->load->view('user/offer');
        $this->load->view('user/include/footer');
    }

    public function search()
    {
        $data['categories'] = $this->categories['result']; //get categories
        $data['tree_list'] = $this->tree_list; //get categories in tree format
        $data['brands'] = $this->brands; //get brands

        if (isset($_GET['str'])) 
        {
            $string = $_GET['str'];
            $data['search_term'] = $string;
            $data['search_result'] = array();

            //search categories
            $columns = 'SQL_CALC_FOUND_ROWS category_id';
            $cat_result = $this->am1->selectRecords('', 'product_category', $columns, array(), $this->limit, $this->start, array('category_name', $string), true);
            if ($cat_result)
                $data['search_result']['categories'] = $cat_result;
            else
                $data['search_result']['categories'] = array();

            //search products
            $like=array('product_name', $string);
            $prd_result = $this->getProducts('', array(), $like);
            if ($prd_result)
            {
                foreach ($prd_result['result'] as $key => $value) 
                {
                    $key_features = array();

                    //get product key features
                    $prd_feature = $this->am1->selectRecords(array('product_id' => $value['product_id']), 'product_key_features', 'feature');
                    if ($prd_feature) 
                    {
                        foreach ($prd_feature['result'] as $feature_value) 
                            array_push($key_features, $feature_value['feature']);
                    }

                    $prd_result['result'][$key]['key_features'] = $key_features;
                }

                $data['search_result']['products'] = $prd_result;
            }
            else
                $data['search_result']['products'] = array();

            //search brand
            $columns = 'SQL_CALC_FOUND_ROWS brand_id, name, CONCAT("'.base_url(BRAND_ATTATCHMENTS_PATH).'", brand_id, "/", brand_logo) AS logo, brand_desc';
            $brands = $this->am1->selectRecords('', 'brand', $columns, array(), '', '', array('name', $string));
            if ($brands)
                $data['search_result']['brands'] = $brands;
            else
                $data['search_result']['brands'] = array();

            //search merchants
            $columns = 'SQL_CALC_FOUND_ROWS merchant_id, establishment_name, userId, CONCAT("'.base_url(SELLER_ATTATCHMENTS_PATH).'", merchant_id, "/", merchant_logo) AS logo';
            $merchants = $this->am1->selectRecords('', 'merchant', $columns, array(), '', '', array('establishment_name', $string));
            if ($merchants)
            {
                $address_columns = 'address.*, country.name as country_name, state.name as state_name, city.name as city_name';

                $i = 0;
                foreach ($merchants['result'] as $merchant) 
                {
                    if (isset($_COOKIE['latitude']) && isset($_COOKIE['longitude'])) 
                    {
                        $getNearestAddressId = $this->am1->getNearestAddress('Where userId = '.$merchant['userId']);
                        $getAddress = $this->am1->getUserAddress(array('address_id' => $getNearestAddressId[0]['address_id']), $address_columns);
                    }
                    else
                        $getAddress = $this->am1->getUserAddress(array('address.userId' => $merchant['userId']), $address_columns);

                    $merchants['result'][$i]['nearest_address'] = $getAddress['result'][0];
                }

                $data['search_result']['merchants'] = $merchants;
            }
            else
                $data['search_result']['merchants'] = array();
        }

        //load view
        // $this->load->view('user/include/header', $data);
        // $this->load->view('user/include/sidebar', $data);
        // $this->load->view('user/search', $res);
        // $this->load->view('user/include/footer');

        // echo "<pre>"; print_r($data); die;

        //load view
        $this->load->view('user/design/include/header', $data);
        $this->load->view('user/design/search_result', $data);   
        $this->load->view('ajaxFunctions', $data);
        $this->load->view('user/design/include/footer');
    }

    public function claimBusiness($value='')
    {
        $claimed_data = array();
        $controller = 'merchants/'.url_title($this->input->post('establishment_name'), '-', true).'?merchant_id='.$this->input->post('merchant_id');
        $claimed_data['clmd_email'] = $this->input->post('email');
        $claimed_data['clmd_name'] = $this->input->post('name');
        $claimed_data['clmd_contact'] = $this->input->post('contact_number');
        $claimed_data['clmd_merchant_id'] = $this->input->post('merchant_id');
        $claimed_data['clmd_message'] = ($this->input->post('message')) ? $this->input->post('message') : "";

        if ($_FILES['file']['name'] != '')
            $claimed_data['clmd_business_proof'] = $this->common_controller->single_upload(TEMP_FOLDER_PATH);

        $clmd_id = $this->am1->insertData('claimed_requests', $claimed_data);
        if ($clmd_id) 
        {
            $claimed_data['establishment_name'] = $this->input->post('establishment_name');
            $claimed_data['request_id'] = $clmd_id;
            $claimed_data['request_url'] = "<a href='".base_url('merchants/'.$claimed_data['establishment_name'].'?merchant_id='.$claimed_data['clmd_merchant_id'])."'>Shop Detail</a>";
            $claimed_data['code'] = MAIL_CODE_CLAIM_BUSINESS;
            $claimed_data['atch'] = base_url().TEMP_FOLDER_PATH.$claimed_data['clmd_business_proof'];

            $isSend = $this->common_controller->sendMail($claimed_data);
        }

        if ($isSend) 
            $this->redirect('Mail has been sent! We will review your request.', $controller);
        else
            $this->redirect('Error: Unable to send mail!', $controller);
    }

    public function redirect($msg, $controller)
    {
        echo "<script>window.alert('".$msg."');</script>";
        redirect($controller, 'refresh');
    }

    //add paging array
    public function createPagingArray($count = "")
    {
        $paging = array();
        $paging['total_results'] = $count;
        $paging['total_pages'] = ceil($count/$this->limit);
        $paging['page'] = $this->current_page;
        $paging['limit'] = $this->limit;

        return $paging;
    }
}
