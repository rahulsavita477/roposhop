<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Admin_controller.php';
require_once 'Common_controller.php';

class V1_api_controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
        
        //allow header
        header("Access-Control-Allow-Headers: Content-Type");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		header("Access-Control-Allow-Origin: *");

		$this->load->model(array('Admin_model' => 'am3'));

		//common controller
		$this->common_controller = new Common_controller();
		$this->admin_controller = new Admin_controller();

		//get request data
		$this->requestData = (object)$_POST;
     	$file_data = json_decode(file_get_contents("php://input"));
     	if($file_data && is_object($file_data))
     		$this->requestData = $file_data;

     	$this->limit = '';
		$this->start = '';
		$this->current_page = isset($_GET['page']) ? $_GET['page'] : "";
		
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

		//current date
		$this->current_date = date("Y-m-d H:i:s");
	}

	//get consumer app version
	public function ConsumerAppversion()
	{
		$res = array();
		$res['version_info']['current_version_code'] = 7;
		$res['version_info']['current_version_name'] = "1.0.6";
		$res['version_info']['min_supported_version_code'] = 7;
		$res['version_info']['min_supported_version_name'] = "1.0.6";

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	//get seller app version
	public function SellerAppversion()
	{
		$res = array();
		$res['version_info']['current_version_code'] = 1;
		$res['version_info']['current_version_name'] = "1.0.0";
		$res['version_info']['min_supported_version_code'] = 1;
		$res['version_info']['min_supported_version_name'] = "1.0.0";

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	//get brand(s)
	public function brands($brand_id='', $brands_for='')
	{
		$res = array();
		$where = "";
		
		if ($brand_id && $brands_for == 'products')
			$res = $this->getProducts(array('brand_id' => $brand_id));
		else
		{
			if ($brand_id) 
				$where = array('brand_id' => $brand_id);

			$res = $this->getBrands($where);
		}
			
		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function getBrands($where = '', $like = array())
	{
		//get brand result
		$columns = 'SQL_CALC_FOUND_ROWS brand_id, name as brand_name, brand_desc as description, IF(brand_logo, CONCAT("'.$this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.'", "/", brand_id, "/", brand_logo), "") as brand_logo, update_date as last_updated, isEnabled AS enabled';
		$brands_result = $this->am3->selectRecords($where, 'brand', $columns, array(), $this->limit, $this->start, $like, true);
		$res['brands'] = array();
		
		if ($brands_result) 
		{
			if ($where) 
			{
				$brands_result = $brands_result['result'][0];
				$brand_id = $brands_result['brand_id'];
				$res['brands'] = $brands_result;

				//get brand images
				$attatchments = array();
				$brand_imgs = $this->attatchments($brand_id, "BRAND");
				if ($brand_imgs['result']) 
				{
					foreach ($brand_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$brand_id.'/'.$atch_value['atch_url']);
				}

				$res['brands']['brand_images'] = $attatchments;
				$res['brands']['brand_htmls'] = $this->getWebLinks($brand_id, 'BRAND');
			}
			else
			{
				$res['brands'] = $brands_result['result'];
				$i = 0;

				//get brand images
				foreach ($brands_result['result'] as $brand_value) 
				{
					$attatchments = array();
					$brand_id = $brand_value['brand_id'];
					$brand_imgs = $this->attatchments($brand_id, "BRAND");
					if ($brand_imgs['result']) 
					{
						foreach ( $brand_imgs['result'] as $atch_value ) 
							array_push($attatchments, $this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$brand_id.'/'.$atch_value['atch_url']);

						$res['brands'][$i]['brand_images'] = $attatchments;
					}
					else
						$res['brands'][$i]['brand_images'] = array();

					//get brand web links
					$res['brands'][$i]['brand_htmls'] = $this->getWebLinks($brand_id, 'BRAND');

					$i++;
				}

				//pagination array
				if (isset($brands_result['count'])) 
					$res['paging'] = $this->createPagingArray($brands_result['count']);
			}
		}
		else if ($this->current_page && !isset($res['paging'])) 
			$this->createPagingArray();

		if (!$where) 
			$res['deleted_brand_ids'] = $this->getDeletedItems('BRAND');

		return $res;	
	}

	public function getWebLinks($link_id, $type)
	{
		//get brand web links
		$web_links = array();
		$where = array(
					'link_id' => $link_id,
					'linked_type' => $type
				);
		$links = $this->am3->selectRecords($where, 'html_files', 'html_file');

		if ( $links ) 
		{
			foreach ( $links['result'] as $html_file_value ) 
				array_push($web_links, $this->config->item('site_url').HTML_FILES_PATH.'/'.$html_file_value['html_file']);
		}

		return $web_links;
	}

	//get category/categories
	public function categories($cat_id = '', $cat_for = '')
	{
		$res = array();
		$where = "";
		
		if ($cat_id && $cat_for == 'products')
			$res = $this->getProducts(array('category_id' => $cat_id));
		else
		{
			if ($cat_id == 'no-parent')
				$where = array('has_parent' => 0);
			else if ($cat_id && $cat_for == 'categories')
				$where = array('has_parent' => 1, 'parent_category_id' => $cat_id);
			else if ($cat_id) 
				$where = array('category_id' => $cat_id);

			$res = $this->getCategories($where);

			if (!$where) 
				$res['deleted_category_ids'] = $this->getDeletedItems('CATEGORY');
		}

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function getCategories($where = '', $like = array())
	{
		$columns = 'SQL_CALC_FOUND_ROWS category_id, category_name, has_parent, parent_category_id, update_date as last_updated, isEnabled AS enabled';

		$cat_result = $this->am3->selectRecords($where, 'product_category', $columns, array(), $this->limit, $this->start, $like, true);	

		if ($cat_result) 
		{
			$i = 0;
			$res['categories'] = $cat_result['result'];

			foreach ($cat_result['result'] as $cat_value) 
			{
				//get category images
				$attatchments = array();
				$cat_id = $cat_value['category_id'];
				$cat_imgs = $this->attatchments($cat_id, "CATEGORY");

				if ( $cat_imgs ) 
				{
					foreach ($cat_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').CATEGORY_ATTACHMENT_PATH.$cat_id.'/'.$atch_value['atch_url']);

					$res['categories'][$i]['category_images'] = $attatchments;
				}
				else
					$res['categories'][$i]['category_images'] = array();

				//get category web links
				$res['categories'][$i]['category_htmls'] = $this->getWebLinks( $cat_id, 'CATEGORY' );

				$i++;
			}

			//pagination array
			if (isset($cat_result['count'])) 
				$res['paging'] = $this->createPagingArray( $cat_result['count'] );

			return $res;
		}
		else if ($this->current_page && !isset($res['paging'])) 
			$this->createPagingArray();

		return array();
	}

	//get product listing(s)
	public function listings($listing_id = '', $listing_for = '')
	{
		$res = array();
		$where = "";

		if ($listing_id && $listing_for == 'merchants') 
		{
			$listing_result = $this->am3->listingMerchants($listing_id);

			if ($listing_result)
				$res['merchants'] = $listing_result[0];
		}
		else if ($listing_id && $listing_for == 'products') 
		{
			$listing_result = $this->am3->listingProducts(array('listing_id' => $listing_id));

			if ($listing_result)
			{
				$res['products'] = $listing_result[0];

				//get brand images
				$attatchments = array();
				$prd_id = $listing_result[0]['product_id'];
				$prd_imgs = $this->attatchments($prd_id, "PRODUCT");
				if ($prd_imgs) 
				{
					foreach ($prd_imgs['result'] as $atch_value) 
						array_push($attatchments, base_url(PRODUCT_ATTATCHMENTS_PATH.$prd_id.'/'.$atch_value['atch_url']));

					$res['products']['product_images'] = $attatchments;
				}
				else
					$res['products']['product_images'] = array();
			}
		}
		else
		{
			if ($listing_id)
				$where = array('listing_id' => $listing_id);

			$listing_result = $this->getListings($where);

			if ($listing_result)
			{
				$res['listings'] = $listing_result['result'];

				//pagination array
				if (isset($listing_result['count'])) 
					$res['paging'] = $this->createPagingArray($listing_result['count']);
			}
			else if ($this->current_page && !isset($res['paging'])) 
				$this->createPagingArray();
			else
				$res['listings'] = array();

			if (!$where)
				$res['deleted_listing_ids'] = $this->getDeletedItems('LISTING');
		}

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function getListings($where='')
	{
		$columns = 'SQL_CALC_FOUND_ROWS listing_id, product_id, merchant_id, sell_price as price, finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, in_stock, will_back_in_stock_on, replacement_available, replacement_terms, return_available, return_policy, seller_offering, isVerified, update_date as last_updated, isEnabled AS enabled';
		
		$listing_result = $this->am3->selectRecords($where, 'product_listing', $columns, array(), $this->limit, $this->start, array(), true);		

		return $listing_result;
	}

	//get products on the basis of conition(i.e. brand id, category id)
	public function getProducts($where='', $like = array(), $a_brand_id=array(), $s_order_by='', $a_category_id=array())
	{
		$res = array();
		$where_in = array();

		if (count($a_brand_id)>0) 
			$where_in['brand_id'] = $a_brand_id;

		if (count($a_category_id)>0) 
			$where_in['category_id'] = $a_category_id;

		switch ($s_order_by) 
        {
        	case 'name_desc':
                $orderby = array('product_name' => 'desc');
                $hasUpdateDateField = false;
                break;

            case 'name_asc':
                $orderby = array('product_name' => 'asc');
                $hasUpdateDateField = false;
                break;

            case 'sell_price_asc':
                $orderby = array('mrp_price' => 'asc');
                $hasUpdateDateField = false;
                break;

            case 'sell_price_desc':
                $orderby = array('mrp_price' => 'desc');
                $hasUpdateDateField = false;
                break;
            
            default:
            	$orderby = array();
                $hasUpdateDateField = true;
                break;
        }

		$columns = 'SQL_CALC_FOUND_ROWS product_id, product_name, amazon_prd_id, flipkart_prd_id, description, mrp_price, category_id, brand_id, update_date as last_updated, in_the_box, isEnabled AS enabled';
		$result = $this->am3->selectRecords(
			$where, 
			'product', 
			$columns, 
			$orderby, 
			$this->limit, 
			$this->start, 
			$like, 
			$hasUpdateDateField, 
			$where_in
		);

		if ($result) 
		{
			$prd_result = $result['result'];
			$res['products'] = $prd_result;
			
			$i = 0;

			foreach ($prd_result as $prd_value) 
			{
				//get brand images
				$attatchments = array();
				$prd_id = $prd_value['product_id'];
				$prd_imgs = $this->attatchments($prd_id, "PRODUCT");

				if ($prd_imgs['result']) 
				{
					foreach ($prd_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$prd_id.'/'.$atch_value['atch_url']);

					$res['products'][$i]['product_images'] = $attatchments;
				}
				else
					$res['products'][$i]['product_images'] = array();

				//get product attributes
				$prd_att_res = $this->am3->productAttributes($prd_id);
				if ($prd_att_res) 
					$res['products'][$i]['specifications'] = $prd_att_res;
				else
					$res['products'][$i]['specifications'] = array();

				//get product varients
				$prd_att_res = $this->am3->productVarients($prd_id);
				if ($prd_att_res) 
					$res['products'][$i]['varients'] = $prd_att_res;
				else
					$res['products'][$i]['varients'] = array();

				//get product key features
				$key_features = array();
				$prd_feature = $this->am3->selectRecords(array('product_id' => $prd_id), 'product_key_features', 'feature');
				if ($prd_feature) 
				{
					foreach ($prd_feature['result'] as $feature_value) 
						array_push($key_features, $feature_value['feature']);
				}

				$res['products'][$i]['key_features'] = $key_features;

				//get product web links
				$res['products'][$i]['product_htmls'] = $this->getWebLinks( $prd_id, 'PRODUCT' );

				$i++;
			}

			//pagination array
			if (isset($result['count'])) 
				$res['paging'] = $this->createPagingArray($result['count']);
		}
		else if ($this->current_page && !isset($res['paging'])) 
			$this->createPagingArray();

		if (!$where) 
			$res['deleted_product_ids'] = $this->getDeletedItems('PRODUCT');

		return $res;
	}

	//get cities from db
	public function cityAJAX($city_id)
	{
		$res = $this->am3->selectRecords(array('city_id' => $city_id), 'city', '*');

		//echo "<pre>"; print_r($data); die;
        $this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function getMerchantProductsAJAX($merchant_id)
	{
		$listings = array();
		
		$search = isset($this->requestData->search) && !empty($this->requestData->search) ? array('product_name', $this->requestData->search) : array();
		$orderby = $this->requestData->orderby;
		$a_category_id = json_decode($this->requestData->categoryIds);
		$a_brand_id = json_decode($this->requestData->brandIds);

		$where = array();
		$where['product_listing.merchant_id'] = $merchant_id;
		$result = $this->am3->getProductListings($where, $search, $this->limit, $this->start, $orderby, $a_brand_id, $a_category_id);
		
		if($result) {
			$listings['listings'] = $result['result'];
			$listings['paging'] = $this->createPagingArray($result['count']);
		} else {
			$listings['listings'] = [];
			$listings['paging'] = $this->createPagingArray(0);
		}		

		//echo "<pre>"; print_r($data); die;
        $this->getJsonData(CODE_SUCCESS, 'ok', $listings);
	}

	//get product
    public function getProductAJAX($product_id)
    {
        $data = array();
        $products = $this->am3->selectRecords(array('product_id' => $product_id), 'product', 'product_id, product_name, mrp_price', array(), $this->limit, $this->start);
        
        if ($products) 
        {
            $data['product'] = $products['result'][0];
            
            //get product average rating
            $rating_info = $this->am3->selectRecords(array('product_id' => $product_id), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating", array(), '', '', array(), true);
            $data['product']['rating'] = $rating_info['result'][0];

            //get product images
            $product_imgs = $this->attatchments($product_id, "PRODUCT");
            if ($product_imgs['result']) 
            {
                $data['product']['image'] = $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id.'/'.$product_imgs['result'][0]['atch_url'];
            }
            else
                $data['product']['image'] = array($this->config->item('site_url').'assets/user/download (1).jpeg');

            $merchant_id = isset($_GET['merchant_id']) ? $_GET['merchant_id'] : '';

            //get minimum off on product by merchant
            $prd_off = $this->getMinimumOffOnProduct($product_id, $products['result'][0]['mrp_price'], $merchant_id);
            $data['product']['offer_price'] = $prd_off['offer_price'];
            $data['product']['discount_price'] = $prd_off['discount_price'];
            $data['product']['off'] = $prd_off['off'];
        }

        //echo "<pre>"; print_r($data); die;
        $this->getJsonData(CODE_SUCCESS, 'ok', $data);
    }

    //need to remove that function (exist in user controller)
    private function getMinimumOffOnProduct($product_id, $mrp_price, $merchant_id)
    {
        $data = array();
        $where = array();

        if ($merchant_id)
        	$where['product_listing.merchant_id'] = $merchant_id;

        $where['product_listing.product_id'] = $product_id;

        //get product listings
        $sold_by_merchants = $this->am3->getProductListings($where);

        $data['offer_price'] = (is_array($sold_by_merchants['result'])) ? (round(abs(min(array_column($sold_by_merchants['result'], 'sell_price'))), 2)) : 0;
        $data['discount_price'] = (int) trim($mrp_price)- (int) trim($data['offer_price']);        
        $data['off'] = calculatePercentage((int) trim($mrp_price), (int) trim($data['offer_price']));

        return $data;
    }

	//get product rating
	public function getProductRating($prd_id = '')
	{
		if ($prd_id) 
		{
			$rating_info = $this->am3->selectRecords(array('product_id' => $prd_id), 'product_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star", array(), '', '', array(), true);

			return $rating_info['result'][0];
		}

		return false;
	}

	//get product rating
	public function getMerchantRating($merchant_id = '')
	{
		if ($merchant_id) 
		{
			$rating_info = $this->am3->selectRecords(array('merchant_id' => $merchant_id), 'merchant_review', "COUNT(review_id) as rating_count, ROUND(AVG(CAST(rating AS DECIMAL(10,1))), 1) as avg_rating, coalesce(sum(rating = '1'), 0) as rating_count_1_star, coalesce(sum(rating = '2'), 0) as rating_count_2_star, coalesce(sum(rating = '3'), 0) as rating_count_3_star, coalesce(sum(rating = '4'), 0) as rating_count_4_star, coalesce(sum(rating = '5'), 0) as rating_count_5_star", array(), '', '', array(), true);

			return $rating_info['result'][0];
		}

		return false;
	}

	public function products($prd_id = '', $product_for = '')
	{
		$where = '';
		$res = array();

		if ($prd_id == 'reviews')
		{
			$mer_reviews = $this->am3->productReviews(array(), $this->limit, $this->start);
			if ($mer_reviews)
				$res['product_reviews'] = $mer_reviews['result'];
			else
				$res['product_reviews'] = array();

			$res['deleted_product_review_ids'] = $this->getDeletedItems('PRODUCT_REVIEW');
		}
		else if ($prd_id && $product_for == 'reviews') 
		{
			$product_reviews = $this->am3->productReviews(array('product_review.product_id' => $prd_id), $this->limit, $this->start);
			if ($product_reviews)
				$res['product_reviews'] = $product_reviews['result'];
			else
				$res['product_reviews'] = array();
		}
		else if ($prd_id && $product_for == 'listings') 
		{
			$where = array('product_id' => $prd_id);
			$listing_result = $this->getListings($where);

			if ($listing_result)
				$res['listings'] = $listing_result['result'];
			else
				$res['listings'] = array();
		}
		else
		{
			if ($prd_id)
				$where = array('product_id' => $prd_id);

			//requestData is for user controller not for mobile services 
			$a_brand_id = isset($this->requestData->brandIds) ? json_decode($this->requestData->brandIds) : array();
			$a_category_id = isset($this->requestData->categoryIds) ? json_decode($this->requestData->categoryIds) : array();
			$s_order_by = isset($this->requestData->orderby) ? $this->requestData->orderby : '';
			$s_search = (isset($this->requestData->search) && !empty($this->requestData->search)) ? array('product_name', $this->requestData->search) : array();

			$res = $this->getProducts($where, $s_search, $a_brand_id, $s_order_by, $a_category_id);
		}

		//pagination array
		if (isset($mer_reviews['count'])) 
			$res['paging'] = $this->createPagingArray($mer_reviews['count']);
		else if (isset($listing_result['count'])) 
			$res['paging'] = $this->createPagingArray($listing_result['count']);
		else if ($this->current_page && !isset($res['paging']))
			$this->createPagingArray();

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function merchants($merchant_id = '', $merchant_for = '')
	{
		$res = array();
		$where = "";

		if ($merchant_id == 'reviews') 
		{
			$mer_reviews = $this->am3->merchantReviews(array(), $this->limit, $this->start);
			if ($mer_reviews['result'])
				$res['merchant_reviews'] = $mer_reviews['result'];
			else
				$res['merchant_reviews'] = array();
		}
		else if ($merchant_id == 'address') 
		{
			$columns = 'SQL_CALC_FOUND_ROWS address_id, address.userId as user_id, merchant_id, address.business_days, address.business_hours, address_line_1, address_line_2, landmark, locality, pin, address.state_id, address.country_id, address.city_id, is_default_address, address.latitude, address.longitude, address.contact, address.update_date as last_updated, country.name as country, state.name as state, city.name as city, isEnabled AS enabled';

			$mer_reviews = $this->am3->getUserAddress(array(), $columns, $this->limit, $this->start);
			if ($mer_reviews)
				$res['addresses'] = $mer_reviews['result'];
			else
				$res['addresses'] = array();
		}
		else if ($merchant_id && $merchant_for == 'address') 
		{
			//get merchant user id
			$merchant_user_id = $this->am3->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
     		$user_id = $merchant_user_id['result'][0]['userId'];

			$columns = 'SQL_CALC_FOUND_ROWS address_id, address.userId as user_id, merchant_id, address.business_days, address.business_hours, address_line_1, address_line_2, landmark, locality, pin, address.state_id, address.country_id, address.city_id, is_default_address, address.latitude, address.longitude, address.contact, address.update_date as last_updated, country.name as country, state.name as state, city.name as city, isEnabled AS enabled';

			//requestData is for user controller not for mobile services 
			$where = array();
			$n_state_id = isset($this->requestData->stateId) ? $this->requestData->stateId : '';
			$n_city_id = isset($this->requestData->cityId) ? $this->requestData->cityId : '';

			if ($n_state_id) 
				$where['address.state_id'] = $n_state_id;

			if ($n_city_id) 
				$where['address.city_id'] = $n_city_id;

			$where['address.userId'] = $user_id;

			$mer_reviews = $this->am3->getUserAddress($where, $columns, $this->limit, $this->start);
			if ($mer_reviews)
				$res['addresses'] = $mer_reviews['result'];
			else
				$res['addresses'] = array();
		}
		else if ($merchant_id && $merchant_for == 'reviews') 
		{
			$mer_reviews = $this->am3->merchantReviews(array('merchant_review.merchant_id' => $merchant_id), $this->limit, $this->start);
			if ($mer_reviews['result'])
				$res['merchant_reviews'] = $mer_reviews['result'];
			else
				$res['merchant_reviews'] = array();
		}
		else if ($merchant_id && $merchant_for == 'offers') 
			$res = $this->getOffers(array('merchant_id' => $merchant_id));
		else if ($merchant_id && $merchant_for == 'listings')
		{
			$where = array('merchant_id' => $merchant_id);
			$listing_result = $this->getListings($where);

			if ($listing_result['result'])
				$res['listings'] = $listing_result['result'];
			else
				$res['listings'] = array();
		}
		else
		{
			if ($merchant_id)
				$where = array('merchant_id' => $merchant_id);

			$res = $this->getMerchants($where);
		}

		//pagination array
		if (isset($mer_reviews['count'])) 
			$res['paging'] = $this->createPagingArray($mer_reviews['count']);
		else if (isset($listing_result['count'])) 
			$res['paging'] = $this->createPagingArray($listing_result['count']);
		else if ($this->current_page && !isset($res['paging']))
			$this->createPagingArray();

		if (!$where && $merchant_id != 'address' && $merchant_for != 'address' && $merchant_id != 'reviews' && $merchant_for != 'reviews' && $merchant_for != 'offers') 
			$res['deleted_merchant_ids'] = $this->getDeletedItems('MERCHANT');
		else if ($merchant_id == 'address' || $merchant_for == 'address')
			$res['deleted_Address'] = $this->getDeletedItems('ADDRESS');
		else if ($merchant_id == 'reviews' || $merchant_for == 'reviews')
			$res['deleted_merchant_review_ids'] = $this->getDeletedItems('MERCHANT_REVIEW');
		else if ($merchant_for == 'offers')
			$res['deleted_offer_ids'] = $this->getDeletedItems('OFFER');

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);	
	}

	public function getMerchants($where = '', $like = array())
	{
		$res = array();
		$columns = "SQL_CALC_FOUND_ROWS merchant_id, establishment_name, description, userId as user_id, contact, is_verified, business_days, business_hours, IF(merchant_logo, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', merchant_logo), '') as merchant_logo, status as enabled, update_date as last_updated";
		$merchant_result = $this->am3->selectRecords($where, 'merchant', $columns, array(), $this->limit, $this->start, $like, true);

		if ($merchant_result)
		{
			$res['merchants'] = $merchant_result['result'];

			$columns = 'address_id, address.userId as user_id, address_line_1, address_line_2, landmark, locality, pin, address.state_id, address.country_id, address.city_id, is_default_address, address.latitude, address.longitude, address.contact, address.update_date as last_updated, country.name as country, state.name as state, city.name as city';

			$i = 0;
			foreach ($merchant_result['result'] as $mer_value) 
			{
				//select attachment of seller
				$attatchments = array();
				$merchant_id = $mer_value['merchant_id'];
				$seller_imgs = $this->attatchments($merchant_id, "SELLER");
				if ($seller_imgs['result']) 
				{
					foreach ($seller_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$atch_value['atch_url']);

					$res['merchants'][$i]['merchant_images'] = $attatchments;
				}
				else
					$res['merchants'][$i]['merchant_images'] = array();

				//select seller offerings
				$seller_offering = $this->am3->selectRecords(array('merchant_id' => $merchant_id), 'merchant_offering', 'offering');
				
				if ($seller_offering) 
					$res['merchants'][$i]['key_features'] = array_column($seller_offering['result'], 'offering');
				else
					$res['merchants'][$i]['key_features'] = array();

				$i++;
			}

			if (isset($merchant_result['count'])) 
				$res['paging'] = $this->createPagingArray($merchant_result['count']);
		}
		else if ($this->current_page && !isset($res['paging']))
			$this->createPagingArray();

		return $res;
	}

	public function getOffers($where = "")
	{
		$columns = 'SQL_CALC_FOUND_ROWS offer_id, offer_title, merchant_id, ofr_brd_id AS brand_id, description as offer_detail, start_date, end_date, update_date as last_updated, current_status AS enabled';
		$mer_offers = $this->am3->selectRecords($where, 'product_listing_offer', $columns, array(), $this->limit, $this->start, array(), true);

		if ($mer_offers)
		{
			$res['offers'] = $mer_offers['result'];

			$i = 0;
			foreach ($mer_offers['result'] as $mer_offer) 
			{
				$attatchments = array();
				$listing_ids  = array();

				//get offer images
				$offer_id = $mer_offer['offer_id'];
				$offer_imgs = $this->attatchments($offer_id, "OFFER");
				if ($offer_imgs['result']) 
				{
					foreach ($offer_imgs['result'] as $atch_value) 
						array_push($attatchments, $this->config->item('site_url').OFFER_ATTATCHMENTS_PATH.$offer_id.'/'.$atch_value['atch_url']);

					$res['offers'][$i]['offer_images'] = $attatchments;
				}
				else
					$res['offers'][$i]['offer_images'] = array();

				//get listings of offer
				$offer_listing_ids = $this->am3->selectRecords(array('ofr_id' => $offer_id), 'offer_listing_mp', 'lst_id');
				if ($offer_listing_ids['result']) 
				{
					foreach ($offer_listing_ids['result'] as $list_ids) 
						array_push($listing_ids, $list_ids['lst_id']);

					$res['offers'][$i]['listing_ids'] = $listing_ids;
				}
				else
					$res['offers'][$i]['listing_ids'] = array();						

				$res['offers'][$i]['offer_htmls'] = $this->getWebLinks( $offer_id, 'OFFER' );

				$i++;
			}

			//pagination array
			if (isset($mer_offers['count'])) 
				$res['paging'] = $this->createPagingArray($mer_offers['count']);
		}
		else if ($this->current_page && !isset($res['paging']))
			$res['paging'] = $this->createPagingArray();
		else
			$res['offers'] = array();

		if (!$where) 
			$res['deleted_offer_ids'] = $this->getDeletedItems('OFFER');

		return $res;
	}

	public function offers($offer_id = '')
	{
		$where = '';

		if ($offer_id)
			$where = array('offer_id' => $offer_id);

		$res = $this->getOffers($where);

		$this->getJsonData(CODE_SUCCESS, 'ok', $res);
	}

	public function addMerchantReview($mer_id, $con_id)
    {
    	$token = isset($this->requestData->token)?$this->requestData->token:"";
    	$review_data = array();
    	$review_result = array();
    	$review_data['rating'] = isset($this->requestData->rating)?$this->requestData->rating:1;
     	$review_data['review'] = isset($this->requestData->review)?$this->requestData->review:"";
     	$review_data['review_title'] = isset($this->requestData->review_title)?$this->requestData->review_title:"";

     	if ($token != '' && $mer_id && $con_id) 
     	{
     		$this->isValidToken($token, '', $con_id);

     		$review_data['consumer_id'] = $con_id;
     		$review_data['merchant_id'] = $mer_id;
     		$review_data['update_date'] = date("Y-m-d H:i:s");
     		
     		$condition = array('consumer_id' => $con_id, 'merchant_id' => $mer_id);
			$isExistMerchantReview = $this->am3->selectRecords($condition, 'merchant_review', 'review_id');
			if ($isExistMerchantReview) 
			{
				$review_id = $isExistMerchantReview['result'][0]['review_id'];
				$condition = array('review_id' => $review_id);
				$this->am3->updateData('merchant_review', $review_data, $condition);

				$msg = 'Merchant review updated!';
			}
			else
			{
				$review_data['create_date'] = date("Y-m-d H:i:s");
				
				$review_id = $this->am3->insertData('merchant_review', $review_data);

				$msg = 'Merchant review inserted!';
			}

     		if ($review_id)
			{
				$mer_review = $this->am3->merchantReviews(array('review_id' => $review_id));
				if ($mer_review)
		    	{
		    		$review_result['merchant_reviews'] = $mer_review['result'];     		
					$code = CODE_SUCCESS;
		    	}
		    	else
		    	{
		    		$msg = 'ERROR: Review is inserted but unable to get data from db.';     		
					$code = CODE_ERROR_IN_QUERY;
		    	}
			}	
	     	else
	     	{
	     		$msg = 'ERROR: Unable to insert review!';
	     		$code = CODE_ERROR_IN_QUERY;
	     	}
     	}
     	else
     	{
     		$msg = 'ERROR: token, consumer id and merchant id are required';
     		$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $review_result);
	}

	public function addProductReview($prd_id, $con_id)
    {
    	$review_data = array();
    	$review_result = array();
    	$token = isset($this->requestData->token)?$this->requestData->token:"";
    	$review_data['rating'] = isset($this->requestData->rating)?$this->requestData->rating:1;
     	$review_data['review'] = isset($this->requestData->review)?$this->requestData->review:"";
     	$review_data['review_title'] = isset($this->requestData->review_title)?$this->requestData->review_title:"";

     	if ($token != '' && $prd_id && $con_id) 
     	{
     		$this->isValidToken($token, '', $con_id);

     		$review_data['consumer_id'] = $con_id;
     		$review_data['product_id'] = $prd_id;
     		$review_data['update_date'] = date("Y-m-d H:i:s"); 

     		$condition = array('consumer_id' => $con_id, 'product_id' => $prd_id);
			$isExistProductReview = $this->am3->selectRecords($condition, 'product_review', 'review_id');
			if ($isExistProductReview) 
			{
				$review_id = $isExistProductReview['result'][0]['review_id'];
				$condition = array('review_id' => $review_id);
				$this->am3->updateData('product_review', $review_data, $condition);

				$msg = 'Product review updated!';
			}
			else
			{
				$review_data['create_date'] = date("Y-m-d H:i:s");
				
				$review_id = $this->am3->insertData('product_review', $review_data);     		

				$msg = 'Product review inserted!';
			}

	     	if ($review_id)
			{
				//get review data
		    	$product_review = $this->am3->productReviews(array('review_id' => $review_id));

		    	if ($product_review)
		    	{
		    		$review_result['product_reviews'] = $product_review['result'];     		
					$code = CODE_SUCCESS;
		    	}
		    	else
		    	{
		    		$msg = 'ERROR: Review is inserted but unable to get data from db.';     		
					$code = CODE_ERROR_IN_QUERY;
		    	}
			}
	     	else
	     	{
	     		$msg = 'ERROR: Unable to insert review!';
	     		$code = CODE_ERROR_IN_QUERY;
	     	}
     	}
     	else
     	{
     		$msg = 'ERROR: token, consumer id and product id are required';
     		$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $review_result);
	}

	//upload profile picture
	public function uploadProfilePic()
	{
		$user_id = isset($this->requestData->user_id)?$this->requestData->user_id:"";
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		
		if ($token && $user_id) 
     	{
     		$this->isValidToken($token, $user_id);

     		if (isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['tmp_name']))
     		{
     			$condition = array('userId' => $user_id);

     			//check image exist or not
		    	$isExistProfileImage = $this->am3->selectRecords($condition, 'user', 'picture');
		    	if (isset($isExistProfileImage['result'])) 
		    	{
		    		//if exist file, remove profile pic from folder
		    		if (is_file(PROFILE_PIC_PATH.$isExistProfileImage['result'][0]['picture']))
		    			unlink(PROFILE_PIC_PATH.$isExistProfileImage['result'][0]['picture']);

		    		//update record in db
		    		$this->am3->updateData('user', array('picture' => ''), $condition);
		    	}

		    	//upload new picture
	    		$profile_image = $this->common_controller->single_upload(PROFILE_PIC_PATH, '', 'profile_image');

	    		//insert image in db
	    		$this->am3->updateData('user', array('picture' => $profile_image), $condition);

	    		//get user detail
	    		$usr_detail = $this->am3->getConsumer($user_id);
				if ($usr_detail)
				{
					$user['user'] = $usr_detail[0];

					$msg = 'Profile image updated successfully!';
					$code = CODE_SUCCESS;
					$res = json_decode(json_encode($user), True);
				}
				else 
				{
					$msg = 'ERROR: User not varified';
					$code = CODE_ERROR_AUTHENTICATION_FAILED;
				}

	    		$this->getJsonData($code, $msg, $res);
     		}
     	}
     	
     	$msg = 'ERROR: token, user_id, profile_image required';
     	$code = CODE_ERROR_PARAM_MISSING;
     	$this->getJsonData($code, $msg, array());
	}

	public function uploadMerchantProfilePic()
	{
		$res = array();
		$token = isset($this->requestData->token) ? $this->requestData->token : "";
		$merchant_id = isset($this->requestData->merchant_id) ? $this->requestData->merchant_id : "";

		if ($token) 
     	{
			$merchantUserDetail = $this->merchantUserDetail($token);

     		//check authorization
     		if ($merchant_id && (($merchantUserDetail['merchant_id'] != $merchant_id) && !in_array("ADMIN", $merchantUserDetail['roles'])))
     		{
     			$msg = 'ERROR: unauthorized merchant';
	     		$code = CODE_ERROR_AUTHENTICATION_FAILED;
     		}
     		else
     		{
	        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
	        	$user_id = $merchantUserDetail['userId'];
	     		$this->isValidToken($token, $user_id);

	     		//get merchant user id
	     		$merchant = $this->getMerchants(array('merchant_id' => $merchant_id));
				if (count($merchant)==0 || !isset($merchant['merchants'][0]['user_id']))
				{
					$msg = 'ERROR: unauthorized merchant';
	     			$code = CODE_ERROR_AUTHENTICATION_FAILED;
				}
				else
				{
					$user_id = $merchant['merchants'][0]['user_id'];

		     		//upload merchant profile picture
		     		if (isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['tmp_name']))
		     		{
		     			$condition = array('userId' => $user_id);

		     			//check image exist or not
				    	$isExistProfileImage = $this->am3->selectRecords($condition, 'user', 'picture');
				    	if (isset($isExistProfileImage['result']))
				    	{
				    		//if exist file, remove profile pic from folder
				    		if (is_file(PROFILE_PIC_PATH.$isExistProfileImage['result'][0]['picture']))
				    			unlink(PROFILE_PIC_PATH.$isExistProfileImage['result'][0]['picture']);

				    		//update record in db
				    		$this->am3->updateData('user', array('picture' => ''), $condition);
				    	}

				    	//upload new picture
			    		$profile_image = $this->common_controller->single_upload(PROFILE_PIC_PATH, '', 'profile_image');

			    		//insert image in db
			    		$this->am3->updateData('user', array('picture' => $profile_image), $condition);

			    		$msg = 'profile image updated successfully!';
						$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
	                    $res = json_decode(json_encode($merchantDetail), True);
						$code = CODE_SUCCESS;

			    		$this->getJsonData($code, $msg, $res);
		     		}
		     		else
		     		{
		     			$msg = 'ERROR: profile_image required';
	     				$code = CODE_ERROR_PARAM_MISSING;
		     		}
		     	}
	     	}
		}
		else
     	{
     		$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $res);
	}

	public function addUser()
    {
    	$user_id = isset($this->requestData->user_id)?$this->requestData->user_id:"";
    	$token = isset($this->requestData->token)?$this->requestData->token:"";
    	
    	if ($user_id) 
	 	{
	 		if ($token != '') 	
	 			$this->isValidToken($token, $user_id);	
	 		else
	 			$this->getJsonData(CODE_ERROR_PARAM_MISSING, 'ERROR: token is required', array());
	 	}

    	$user_data = array();
     	$consumer_data = array();

     	//user data
     	$user_data['status'] = 1;

     	$full_name = isset($this->requestData->full_name) ? $this->requestData->full_name : "";
     	if ($user_id && !$full_name)
     		$this->getJsonData(CODE_ERROR_PARAM_MISSING, 'ERROR: full_name required', array());
     	elseif (!$user_id && !$full_name) 
     		$this->getJsonData(CODE_ERROR_PARAM_MISSING, 'ERROR: full_name, email and password required', array());
     	else
     		$user_data['first_name'] = $full_name;

     	//consumer data
     		//1. gender
     	if (isset($this->requestData->gender))
     		$consumer_data['gender'] = $this->requestData->gender;

     		//2. birthday
     	if (isset($this->requestData->birthday))
     	{
     		$birthday = $this->requestData->birthday;

     		if (1 !== preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $birthday)) 
				$this->getJsonData(CODE_ERROR_INCORRECT_FORMAT, 'Error: birthday needs to have a valid date format - dd-mm-yyyy', array());
			else
     			$consumer_data['birthday'] = $birthday;
     	}
     	else
     		$consumer_data['birthday'] = "";

     		//3. phone
     	if (isset($this->requestData->phone))
     	{
     		$phone = $this->requestData->phone;

     		if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phone))
     			$this->getJsonData(CODE_ERROR_INCORRECT_FORMAT, 'Error: phone should be in numaric format', array());

            $consumer_data['phone'] = $phone;
     	}

     	if ($user_id) 
     	{
     		$condition = array('userId' => $user_id);
			$this->am3->updateData('user', $user_data, $condition);
			$this->am3->updateData('consumer', $consumer_data, $condition);

			$msg = "user detail updated successfully!";
			$code = CODE_SUCCESS;
     	}
     	else
     	{
     		$user_data['email'] = isset($this->requestData->email)?$this->requestData->email:"";
     		$user_data['password'] = isset($this->requestData->password)?$this->requestData->password:"";

     		if (!$user_data['email'] || !$user_data['password'])
	     		$this->getJsonData(CODE_ERROR_PARAM_MISSING, 'ERROR: full_name, email and password required', array());

     		$isEmailExist = $this->isEmailExist($user_data['email']);
     		if ($isEmailExist) 
     		{
     			$msg = 'ERROR: This email address is already exist.';
     			$code = CODE_ERROR_ALREADY_EXIST; 
     		}
     		else
     		{
     			$user_id = $this->am3->insertData('user', $user_data);

		     	if ($user_id)
				{
					$type_data['usr_id'] = $user_id;
					$type_data['type_name'] = 'BUYER';

					$type_id = $this->am3->insertData('user_type', $type_data);

					if ($type_id)
					{
						$consumer_data['userId'] = $user_id;

						$con_id = $this->am3->insertData('consumer', $consumer_data);

						if ($con_id)
						{
							$msg = 'Consumer signup done!';
							$code = CODE_SUCCESS;
						}
						else
						{
							$msg = 'Error: Unable to add user as consumer!';
							$code = CODE_ERROR_IN_QUERY;
						}
					}
					else
					{
						$msg = 'Error: Unable to add user role';
						$code = CODE_ERROR_IN_QUERY;
					}
				}     		
		     	else
		     	{
		     		$msg = 'Error: Unable to insert user data!';
		     		$code = CODE_ERROR_IN_QUERY;
		     	}
     		}
     	}

     	$consumer_detail = array();
     	if ($user_id) 
     	{
     		$consumer_profile_data = $this->am3->getConsumer($user_id);

     		if ($consumer_profile_data)
     		{
     			$consumer_detail['user'] = $consumer_profile_data[0];
     			$consumer_detail['user']['auth_token'] = $this->createToken($user_id);
     		}
     		else
     			$consumer_detail['user'] = array();
     	}

		$this->getJsonData($code, $msg, $consumer_detail);
	}

	public function login()
	{
		$res = array();
		$email = isset($this->requestData->email)?$this->requestData->email:"";
		$password = isset($this->requestData->password)?$this->requestData->password:"";
		
		if ($email && $password) 
		{
			$usr_id = $this->am3->doLogin($email, $password);

			if ($usr_id) 
			{
				$user_id = $usr_id['userId'];
				$usr_detail = $this->am3->getConsumer($user_id);

				if ($usr_detail)
				{
					$user['user'] = $usr_detail[0];
					$usr_roles = $this->am3->selectRecords(array('usr_id' => $user_id), 'user_type', '*');

					if ($usr_roles) 
					{
						$isConsumer = false;
						foreach ($usr_roles['result'] as $role) 
						{
							if ($role['type_name'] == 'BUYER')
							{
								$isConsumer = true;
								break;
							}
						}

						if ($isConsumer)
						{	
							$msg = 'Consumer login done!';
							$code = CODE_SUCCESS;
							$user['user']['auth_token'] = $this->createToken($user_id);
							
							$res = json_decode(json_encode($user), True);
						}
						else
						{
							$msg = 'ERROR: User is not consumer';
							$code = CODE_ERROR_AUTHENTICATION_FAILED;
						}
					}
					else
					{
						$msg = 'ERROR: No user role found!';
						$code = CODE_ERROR_AUTHENTICATION_FAILED;
					}
				}
				else 
				{
					$msg = 'ERROR: User not varified';
					$code = CODE_ERROR_AUTHENTICATION_FAILED;
				}
			}
			else
			{
				$msg = 'ERROR: email/password is incorrect';
				$code = CODE_ERROR_AUTHENTICATION_FAILED;
			}
		}
		else
		{
			$msg = 'ERROR: email and password are required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $res);
	}

	public function changePassword($user_id='')
	{	
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$old_password = isset($this->requestData->old_password)?$this->requestData->old_password:"";
		$new_password = isset($this->requestData->new_password)?$this->requestData->new_password:"";
		$user_id = isset($this->requestData->user_id)?$this->requestData->user_id:$user_id;
		$new_token = md5(uniqid(rand(), true));
		$data = array();

		if ($user_id != '' && $old_password != '' && $new_password != '' && $token != '') 
		{
			$this->isValidToken($token, $user_id);	

			$condition = array('userId' => $user_id, 'password' => $old_password);
			$isValidaOldPassword['result'] = $this->am3->selectRecords($condition, 'user', 'userId');

			if ($isValidaOldPassword['result']) 
			{
				$condition = array('userId' => $user_id);
				$this->am3->updateData('user', array('password' => $new_password, 'auth_token' => $new_token), $condition);

				$consumer_profile_data = $this->am3->getConsumer($user_id);

	     		if ($consumer_profile_data)
	     			$data['user'] = $consumer_profile_data[0];
	     		else
	     			$data['user'] = array();

				$msg = 'Password changed!';
				$code = CODE_SUCCESS;
			}
			else
			{
				$msg = 'ERROR: Old password is not correct!';
				$code = CODE_ERROR_UNKNOWN;
			}				
		}
		else
		{
			$msg = 'ERROR: token, user_id, old_password and new_password are required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $data);
	}

	public function resetPassword()
	{	
		$email = isset($this->requestData->email)?$this->requestData->email:"";
		$site_code = isset($this->requestData->site_code)?$this->requestData->site_code:"";

		if ($email != '') 
		{
			if (filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$isEmailExist = $this->isEmailExist($email);
				if ($isEmailExist) 
				{
					$user_id = $isEmailExist['result'][0]['userId'];

					//check user role
					if ($site_code) 
					{
						$user_role = $this->am3->selectRecords(array('usr_id' => $user_id), 'user_type', 'type_name');
						$user_roles = array_column($user_role['result'], 'type_name');

						if (!in_array(strtoupper($site_code), $user_roles)) 
						{
							$msg = 'ERROR: wrong authorization';
							$code = CODE_ERROR_PARAM_MISSING;

							$this->getJsonData($code, $msg, array());
						}
					}

					//update user data
					$data = array();
					$data['passwordOtp'] = substr(md5(uniqid(rand(1,6))), 6, 6);
					$data['otpCreatetime'] = $this->current_date;
					$this->am3->updateData('user', $data, array('email' => $email));

					//send mail to user
					$mail_data = array();
					$mail_data['name'] = $isEmailExist['result'][0]['first_name'];
					$mail_data['userId'] = $user_id;
					$mail_data['otp'] = $data['passwordOtp'];
					$mail_data['email'] = $email;
					$mail_data['code'] = MAIL_CODE_RESET_PASSWORD;
					$isSent = $this->common_controller->sendMail($mail_data);
					if ($isSent) 
					{
						$msg = 'Instruction to recover password has been sent to your email.';
						$code = CODE_SUCCESS;
					}
					else
					{
						$msg = 'ERROR: Unable to send email';
						$code = CODE_ERROR_UNKNOWN;
					}
				}
				else
				{
					$msg = 'ERROR: No user found with provided Email Id';
					$code = CODE_ERROR_ALREADY_EXIST;
				}
			}
			else
			{
				$msg = 'ERROR: please provide a valid Email Id';
				$code = CODE_ERROR_ALREADY_EXIST;
			}
		}
		else
		{
			$msg = 'ERROR: email is required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, array());
	}

	public function search()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		if (isset($_GET['str'])) 
		{
			//search categories
			$cat_result = $this->getCategories('', array('category_name', $_GET['str']));	
			if ($cat_result)
				$res['categories'] = $cat_result['categories'];
			else
				$res['categories'] = array();

			//search products
			$prd_result = $this->getProducts('', array('product_name', $_GET['str']));
			if ($prd_result)
				$res['products'] = $prd_result;
			else
				$res['products'] = array();

			//search brand
			$brands = $this->getBrands('', array('name', $_GET['str']));
			if ($brands)
				$res['brands'] = $brands;
			else
				$res['brands'] = array();

			//search merchants
			$merchants = $this->getMerchants('', array('establishment_name', $_GET['str']));
			if ($merchants)
				$res['merchants'] = $merchants;
			else
				$res['merchants'] = array();
		}
		else
		{
			$msg = "ERROR: Search string not found";
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $res);
	}

	public function country()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		$cnt_result = $this->am3->selectRecords('', 'country', 'SQL_CALC_FOUND_ROWS country_id, name, status AS enabled, update_date as last_updated', array(), $this->limit, $this->start, array(), true);
		if ($cnt_result)
			$res['countries'] = $cnt_result['result'];
		else
			$res['countries'] = array();

		$res['deleted_country_ids'] = $this->getDeletedItems('COUNTRY');

		//pagination array
		if (isset($cnt_result['count'])) 
			$res['paging'] = $this->createPagingArray($cnt_result['count']);

		$this->getJsonData($code, $msg, $res);
	}

	public function state()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		$cnt_result = $this->am3->selectRecords('', 'state', 'SQL_CALC_FOUND_ROWS state_id, name, country_id, status AS enabled, update_date as last_updated', array(), $this->limit, $this->start, array(), true);
		if ($cnt_result)
			$res['states'] = $cnt_result['result'];
		else
			$res['states'] = array();

		$res['deleted_state_ids'] = $this->getDeletedItems('STATE');

		//pagination array
		if (isset($cnt_result['count'])) 
			$res['paging'] = $this->createPagingArray($cnt_result['count']);

		$this->getJsonData($code, $msg, $res);
	}

	public function city()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		$cnt_result = $this->am3->selectRecords('', 'city', 'SQL_CALC_FOUND_ROWS city_id, name, latitude, longitude, status AS enabled, state_id, update_date as last_updated', array(), $this->limit, $this->start, array(), true);
		if ($cnt_result)
			$res['cities'] = $cnt_result['result'];
		else
			$res['cities'] = array();

		$res['deleted_city_ids'] = $this->getDeletedItems('CITY');

		//pagination array
		if (isset($cnt_result['count'])) 
			$res['paging'] = $this->createPagingArray($cnt_result['count']);

		$this->getJsonData($code, $msg, $res);
	}

	public function area()
	{
		$msg = '';
		$res = array();
		$code = CODE_SUCCESS;

		$cnt_result = $this->am3->selectRecords('', 'area', 'SQL_CALC_FOUND_ROWS area_id, area_name, latitude, longitude, city_id, status AS enabled, update_date as last_updated', array(), $this->limit, $this->start, array(), true);
		if ($cnt_result)
			$res['areas'] = $cnt_result['result'];
		else
			$res['areas'] = array();

		$res['deleted_area_ids'] = $this->getDeletedItems('AREA');

		//pagination array
		if (isset($cnt_result['count'])) 
			$res['paging'] = $this->createPagingArray($cnt_result['count']);

		$this->getJsonData($code, $msg, $res);
	}

	public function isEmailExist($email)
	{
		$isEmailExist = $this->am3->selectRecords(array('email' => $email), 'user', 'userId, first_name');

		if ($isEmailExist)
			return $isEmailExist;
		else
			return false;
	}

	public function isValidToken($token, $user_id='', $consumer_id='')
	{
		//get user id from consumer id
		if ($consumer_id) 
		{
			$user_data = $this->am3->selectRecords(array('consumer_id' => $consumer_id), 'consumer', 'userId');

			if ($user_data)
				$user_id = $user_data['result'][0]['userId'];
			else
			{
				$msg = 'ERROR: wrong consumer_id';
				$code = CODE_ERROR_AUTHENTICATION_FAILED;
				$this->getJsonData($code, $msg, array());
			}
		}

		if ($token && $user_id) 
		{
			$isValidToken = $this->am3->selectRecords(array('auth_token' => $token, 'userId' => $user_id, 'status' => 1), 'user', 'userId');
			
			if ($isValidToken)
				return true;
		}
		
		$msg = 'ERROR: Your login session expired, please login again';
		$code = CODE_ERROR_LOGIN_EXPIRED;
		$this->getJsonData($code, $msg, array());
	}

	//get attatchments
	public function attatchments($link_id, $atch_for)
	{
		$columns  = 'atch_url';
		$where = array('link_id' => $link_id, 'atch_for' => $atch_for);
		$atch_res = $this->am3->selectRecords($where, 'attatchments', $columns);

		if ($atch_res) 
			return $atch_res;
		else
			return FALSE;
	}

	public function createToken($user_id)
	{
		if ($user_id) 
		{
			$where = array('userId' => $user_id);
			$isExistToken = $this->am3->selectRecords($where, 'user', 'auth_token');

			if ( $isExistToken && !empty($isExistToken['result'][0]['auth_token']) ) 
				return $isExistToken['result'][0]['auth_token'];
			else
			{
				$token_data = array();
				$token_data['auth_token'] = md5(uniqid(rand(), true));
				$token_data['update_date'] = date("Y-m-d H:i:s");

				$this->am3->updateData('user', $token_data, $where);
			}

			$token_data = $this->am3->selectRecords($where, 'user', 'auth_token');
			if ($token_data) 
				return $token_data['result'][0]['auth_token'];
		}

		$msg = 'ERROR: Your login session expired, please login again';
		$code = CODE_ERROR_LOGIN_EXPIRED;
		$this->getJsonData($code, $msg, array());
	}

	public function getDeletedItems($item_type = '')
	{
		$last_updateDate = isset($_GET['last_updateDate']) ? $_GET['last_updateDate'] : "";

	 	if ($item_type)
	 	{
	 		$where = array();
	 		$where['item_type'] = $item_type;
	 		
	 		if ($last_updateDate) 
	 			$where['deletion_time >='] = $last_updateDate;	

	 		$deleted_items = $this->am3->selectRecords($where, 'deleted_items', 'item_id');
	 		$values = array();

	 		if ( $deleted_items ) 
	 		{
	 			foreach ($deleted_items['result'] as $value) 
	 				array_push($values, $value['item_id']);
	 		}

	 		return $values;
	 	}
	 	else
	 	{
	 		$msg = 'ERROR: Unable to get item type.';
			$code = CODE_ERROR_PARAM_MISSING;
			$this->getJsonData($code, $msg, array());
	 	}
	}


	/***********************************************/
	/******** MERCHANT API'S STARTS FROM HERE ******/
	/***********************************************/


	//-- merchant login api
	public function merchantLogin()
    {
        $usr_roles = array(); 
        $usr_details = array();
        $res = array();
        $user = array();
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        
        if ($username && $password) 
        {
	        $usr_id = $this->am3->doLogin($username, $password);
	        if ($usr_id) 
	        {
	            $usr_id = $usr_id['userId'];
	            $usr_details = $this->am3->getUser($usr_id, 1);
	            $usr_roles = $this->am3->selectRecords(array('usr_id' => $usr_id), 'user_type', '*');
	            if ($usr_details) 
	            {
	                $isValidUser = false;
	                $usr_roles = array_column($usr_roles['result'], 'type_name');

	                if (!in_array('SELLER', $usr_roles))
	                {
	                    //insert seller role
	                    $type_data['usr_id'] = $usr_id;
	                    $type_data['type_name'] = "SELLER";

	                    $type_id = $this->am3->insertData('user_type', $type_data);
	                    if (!$type_id)
	                    {
	                    	$msg = 'ERROR: unable to add you as seller.';
							$code = CODE_ERROR_IN_QUERY;

							$this->getJsonData($code, $msg, $res);	
	                    }
	                    else //insert seller data
	                    {
	                        //seller data
	                        $seller_data = array();
	                        $seller_data['userId'] = $usr_id;
	                        $seller_data['is_verified'] = 0;
	                        $seller_data['status'] = 1;
	                        $seller_data['create_date'] = $this->current_date;
	                        $seller_data['update_date'] = $this->current_date;

	                        $seller_id = $this->am3->insertData('merchant', $seller_data);
	                        if (!$seller_id)
	                        {
	                        	$msg = 'ERROR: unable to add you as seller.';
								$code = CODE_ERROR_IN_QUERY;

								$this->getJsonData($code, $msg, $res);	
	                        }
	                    }
	                }
	                else
	                {
	                	$merchantId = $this->am3->selectRecords(array('userId' => $usr_id), 'merchant', 'merchant_id');
	                	$seller_id = $merchantId['result'][0]['merchant_id'];
	                }

	                $msg = 'Selller login done!';
					$merchantDetail = $this->getMerchantData($seller_id, $usr_id);
                    $res = json_decode(json_encode($merchantDetail), True);
					$code = CODE_SUCCESS;
	            }
	            else
	            {
	            	$msg = 'ERROR: You are not a varified user, please contact to system administrator!';
					$code = CODE_ERROR_AUTHENTICATION_FAILED;
	            }
	        }
	        else
	        {
	        	$msg = 'ERROR: Wrong credential.';
				$code = CODE_ERROR_PARAM_MISSING;
	        }
    	}
    	else
		{
			$msg = 'ERROR: email and password are required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $res);	
    }

    //get inserted merchant detail
    private function getMerchantData($seller_id, $user_id)
    {
    	$user = array();
    	$usr_details = $this->am3->getUser($user_id);
        $user = $usr_details[0];
        $user['auth_token'] = $this->createToken($user_id);
		$user['user_id'] = $user['userId'];
		$first_name = $user['first_name'];
		$user['full_name'] = $first_name;
		$user['last_updated'] = $user['update_date'];
		$user['enabled'] = $user['status'];

		//unset unnecessary params
		unset($user['first_name']);
		unset($user['userId']);
		unset($user['create_date']);
		unset($user['update_date']);
		unset($user['status']);

		//get merchant data
		$merchant = $this->am3->selectRecords(array('userId' => $user_id), 'merchant', "merchant_id, establishment_name, description, IF(merchant_logo, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', merchant_logo), '') AS merchant_logo, IF(business_proof, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', business_proof), '') AS business_proof, contact, is_verified, is_completed, status, business_days, business_hours, status AS merchant_enabled");

		//get merchant default values
		$merchant_default_values = $this->am3->selectRecords(array('userId' => $user_id), 'merchant', "finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, replacement_available, replacement_terms, return_available, return_policy, seller_offering");

        //get shop images
        $merchant_images = $this->am3->selectRecords(array('link_id' => $seller_id, 'atch_for' => 'SELLER', 'atch_type' => 'IMAGE'), 'attatchments', "CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', link_id, '/', atch_url) AS atch_url");
        $merchant_images = ($merchant_images) ? $merchant_images['result'] : array();

        //get key features/offering
		$seller_offering = $this->am3->selectRecords(array('merchant_id' => $seller_id), 'merchant_offering', "offering AS value, offering_id AS id");        
		$seller_offering = ($seller_offering) ? $seller_offering['result'] : array();

        $res['user'] = $user+$merchant['result'][0];
        $res['user']['default_values'] = $merchant_default_values['result'][0];
		$res['user']['merchant_images'] = array_column($merchant_images, 'atch_url');
		$res['user']['key_features'] = $seller_offering;

        return $res;
    }

    //-- merchant signup
    public function merchantSignup()
    {
    	$user_data = array();
    	$res = array();

    	//user data
        $user_data['status'] = 1;
        $user_data['first_name'] = isset($this->requestData->full_name)?$this->requestData->full_name:"";
        $user_data['email'] = isset($this->requestData->email)?$this->requestData->email:"";
        $user_data['password'] = isset($this->requestData->password)?$this->requestData->password:"";
        $user_contact = isset($this->requestData->contact)?$this->requestData->contact:"";
        $user_data['create_date'] = $this->current_date;
        $user_data['update_date'] = $this->current_date;
    	
    	if ($user_data['first_name'] && $user_data['email'] && $user_data['password'] && $user_contact) 
    	{
	    	//check email is already exist or not
	        $isEmailExist = $this->isEmailExist($user_data['email']);
	 		if ($isEmailExist) 
	 		{
	 			$msg = 'ERROR: This email address is already exist.';
	 			$code = CODE_ERROR_ALREADY_EXIST; 
	 		}
	        else
	        {
	            //insert user detail
	            $user_id = $this->am3->insertData('user', $user_data);
	            if ($user_id)
	            {
	                //insert seller role
	                $type_data['usr_id'] = $user_id;
	                $type_data['type_name'] = "SELLER";

	                $type_id = $this->am3->insertData('user_type', $type_data);
	                if (!$type_id)
	                {
	                	$msg = 'ERROR: unable to add you as seller!';
						$code = CODE_ERROR_IN_QUERY;
	                }
	                else
	                {
	                    //seller data
	                    $seller_data = array();
	                    $seller_data['userId'] = $user_id;
	                    $seller_data['contact'] = $user_contact;
	                    $seller_data['is_verified'] = 0;
	                    $seller_data['status'] = 0;
	                    $seller_data['create_date'] = $this->current_date;
	                    $seller_data['update_date'] = $this->current_date;
	                    $seller_data['establishment_name'] = isset($this->requestData->establishment_name) ? $this->requestData->establishment_name : "";
	        			$seller_data['business_hours'] = isset($this->requestData->business_hours) ? $this->requestData->business_hours : "";
	        			$seller_data['business_days'] = isset($this->requestData->business_days) ? $this->requestData->business_days : "";

	                    //insert data in db
	                    $seller_id = $this->am3->insertData('merchant', $seller_data);
	                    if (!$seller_id)
	                    {
	                    	$msg = 'ERROR: unable to add you as seller!';
							$code = CODE_ERROR_IN_QUERY;
	                    }
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

	                        //get merchant detail
	                        $merchantDetail = $this->getMerchantData($seller_id, $user_id);
	                        $res = json_decode(json_encode($merchantDetail), True);
	                        $msg = 'Merchant signup done!';
							$code = CODE_SUCCESS;
	                    }
	                }
	            }           
	            else
	            {
	            	$msg = 'ERROR: unable to add you as seller!';
					$code = CODE_ERROR_IN_QUERY;
	            }
	        }
        }
        else
        {
        	$msg = 'ERROR: full_name, email, password, contact are required.';
	 		$code = CODE_ERROR_PARAM_MISSING; 
        }

        $this->getJsonData($code, $msg, $res);
    }

    private function merchantUserDetail($token)
    {
    	$merchantUserDetail = $this->am3->merchantUserDetail($token);
    	if ($merchantUserDetail)
    	{
    		$merchantUserDetail['roles'] = (explode(",",$merchantUserDetail['roles']));

    		return $merchantUserDetail;
    	}
    	else
    	{
    		$msg = 'ERROR: Could not get user detail!';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, array());
    }
    
    public function getMerchantProfile()
    {
    	$merchantUserDetail = $this->checkMerchantAuthorization();

    	$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
		$res = array();

 		//get merchant detail
        $merchantDetail = $this->getMerchantData($merchant_id, $merchantUserDetail['userId']);
        $res = json_decode(json_encode($merchantDetail), True);
		$msg = 'profile image updated successfully!';
		$code = CODE_SUCCESS;

     	$this->getJsonData($code, $msg, $res);
    }

    //merchant step2, update detail
    public function updateMerchant($token1 = '')
    {
    	$token = ($token1) ? $token1 : $this->requestData->token;
    	$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
        $full_name = isset($this->requestData->full_name)?$this->requestData->full_name:"";
        $establishment_name = isset($this->requestData->establishment_name)?$this->requestData->establishment_name:"";
        $contact = isset($this->requestData->contact)?$this->requestData->contact:"";
        $res = array();

        if ($token && $full_name && $establishment_name && $contact) 
        {
        	$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
        	$this->isValidToken($token, $user_id);

        	//address data
	        $line1 = isset($this->requestData->address_line_1) ? $this->requestData->address_line_1 : "";
	        $line2 = isset($this->requestData->address_line_2) ? $this->requestData->address_line_2 : "";
	        $landmark = isset($this->requestData->landmark) ? $this->requestData->landmark : "";
	        $pin = isset($this->requestData->pin) ? $this->requestData->pin : "";
	        $is_default_address = isset($this->requestData->is_default_address) ? $this->requestData->is_default_address : 0;
	        $business_days = isset($this->requestData->business_days) ? $this->requestData->business_days : "";
	        $business_hours = isset($this->requestData->business_hours) ? $this->requestData->business_hours : "";
	        $lat = isset($this->requestData->latitude) ? $this->requestData->latitude : "";
	        $long = isset($this->requestData->longitude) ? $this->requestData->longitude : "";
	        $country_id = isset($this->requestData->country_id) ? $this->requestData->country_id : "";
	        $state_id = isset($this->requestData->state_id) ? $this->requestData->state_id : "";
	        $city_id = isset($this->requestData->city_id) ? $this->requestData->city_id : "";
	        $locality = isset($this->requestData->locality) ? $this->requestData->locality : "";

	        if ($line1 || $line2 || $landmark || $pin || $lat || $long || $country_id || $state_id || $city_id || $locality) 
	        {
	        	if (!$line1 || !$country_id || !$state_id || !$city_id)
	        	{
	        		$msg = 'ERROR: please provide line1, country_id, state_id and city_id to insert address!';
					$code = CODE_ERROR_PARAM_MISSING;

					$this->getJsonData($code, $msg, $res);
	        	}
	        	else
	        	{
	        		//insert merchant address
		            $address_id = $this->insertAddress1($user_id);
		            if ($address_id['status'] > 2) 
		            	$this->getJsonData(CODE_ERROR_PARAM_MISSING, $address_id['msg'], $res);
	        	}
	        }

	        //seller data
            $seller_data = array();
            $seller_data['establishment_name'] = $establishment_name;
            $seller_data['contact'] = $contact;

            if (isset($this->requestData->description))
            	$seller_data['description'] = $this->requestData->description;

            if (isset($this->requestData->business_days))
            	$seller_data['business_days'] = isset($this->requestData->business_days)?$this->requestData->business_days:"";

            if (isset($this->requestData->business_hours))
            	$seller_data['business_hours'] = isset($this->requestData->business_hours)?$this->requestData->business_hours:"";

            //$seller_data['is_verified'] = 1;
            $seller_data['status'] = 1;
            //$seller_data['is_completed'] = 1;
            $seller_data['update_date'] = $this->current_date;

            //update merchant data
            $this->am3->updateData('merchant', $seller_data, array('merchant_id' => $merchant_id));

            //user data
            $user_data = array();
            $user_data['first_name'] = $full_name;
            $user_data['update_date'] = $this->current_date;

            //update user data
            $this->am3->updateData('user', $user_data, array('userId' => $user_id));

            if (!$token1) 
            {
            	//if key_feature exist, then perform action
            	if (isset($this->requestData->key_features)) 
            	{
            		$key_features = $this->requestData->key_features;

            		if ((is_string($key_features) && $key_features == "") || (is_array($key_features) && count($key_features) == 0)) 
            			$this->CommonModel->deleteRecord('merchant_offering', array('merchant_id' => $merchant_id));
            		else
            		{
		            	$seller_offering = isset($key_features) ? $key_features : array();

		            	//delete merchant offering
		            	$ids = array_column($seller_offering, 'id');
		            	$this->am3->deleteOffering($merchant_id, $ids);

		            	foreach ($seller_offering as $value) 
		            	{
		            		//if id exist then go for insert
		            		if (isset($value->id)) 
		            			$this->am3->updateData('merchant_offering', array('offering' => $value->value), array('offering_id' => $value->id));
		            		else //else go for update
		            			$this->am3->insertData('merchant_offering', array('offering' => $value->value, 'merchant_id' => $merchant_id));
		            	}
		            }
	            }

            	//get merchant detail
                $merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);

                if (isset($key_features) && is_string($key_features) && $key_features != "") 
        		{
        			$msg = 'ERROR: key_features not in there correct format!';
					$code = CODE_ERROR_PARAM_MISSING;
        		}
        		else
        		{
		            $msg = 'Merchant update successfully!';
					$code = CODE_SUCCESS;
				}
			}
			else
				return TRUE;
        }
        else
        {
        	$msg = 'ERROR: token, full_name, establishment_name, contact required!';
			$code = CODE_ERROR_PARAM_MISSING;
        }

        $this->getJsonData($code, $msg, $res);
    }

    //insert/update business proof
    public function uploadBusinessProof()
    {
    	$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

     		if (isset($_FILES['business_proof']) && !empty($_FILES['business_proof']['tmp_name']))
     		{
     			$condition = array('merchant_id' => $merchant_id);

     			//check image exist or not
		    	$isExistBusinessProof = $this->am3->selectRecords($condition, 'merchant', 'business_proof');
		    	if (isset($isExistBusinessProof['result'])) 
		    	{
		    		$path = SELLER_ATTATCHMENTS_PATH.$merchant_id.'/';
		    		$proof = $isExistBusinessProof['result'][0]['business_proof'];

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

		    		//if exist file, remove profile pic from folder
		    		if (is_file($path.$proof))
		    			unlink($path.$proof);

		    		//update record in db
		    		$this->am3->updateData('merchant', array('business_proof' => ''), $condition);
		    	}

		    	//upload new picture
	    		$business_proof = $this->common_controller->single_upload(SELLER_ATTATCHMENTS_PATH.$merchant_id, '', 'business_proof');

	    		//insert image in db
	    		$merchant_deta = array();
	    		$merchant_deta['is_verified'] = 1;
	    		$merchant_deta['business_proof'] = $business_proof;
	    		$this->am3->updateData('merchant', $merchant_deta, $condition);

	    		$msg = 'business proof uploaded successfully!';
	     		$code = CODE_SUCCESS;
	     		$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);
     		}
     		else
     		{
     			$msg = 'ERROR: business_proof required';
	     		$code = CODE_ERROR_PARAM_MISSING;
     		}
     	}
     	else
     	{
	     	$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
    }

    //insert/update business proof
    public function uploadShopLogo()
    {
    	$res = array();
        $token = isset($this->requestData->token) ? $this->requestData->token : "";
		$merchant_id = isset($this->requestData->merchant_id) ? $this->requestData->merchant_id : "";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);

     		//check authorization
     		if ($merchant_id && (($merchantUserDetail['merchant_id'] != $merchant_id) && !in_array("ADMIN", $merchantUserDetail['roles'])))
     		{
     			$msg = 'ERROR: unauthorized merchant';
	     		$code = CODE_ERROR_AUTHENTICATION_FAILED;
     		}
     		else
     		{
	        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
	        	$user_id = $merchantUserDetail['userId'];
	     		$this->isValidToken($token, $user_id);

	     		if (isset($_FILES['merchant_logo']) && !empty($_FILES['merchant_logo']['tmp_name']))
	     		{
	     			$condition = array('merchant_id' => $merchant_id);

	     			//check image exist or not
			    	$isExistMerchnantLogo = $this->am3->selectRecords($condition, 'merchant', 'merchant_logo');
			    	if (isset($isExistMerchnantLogo['result'])) 
			    	{
			    		$path = SELLER_ATTATCHMENTS_PATH.$merchant_id.'/';
			    		$proof = $isExistMerchnantLogo['result'][0]['merchant_logo'];

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

			    		//if exist file, remove profile pic from folder
			    		if (is_file($path.$proof))
			    			unlink($path.$proof);

			    		//update record in db
			    		$this->am3->updateData('merchant', array('merchant_logo' => ''), $condition);
			    	}

			    	//upload new picture
		    		$merchant_logo = $this->common_controller->single_upload(SELLER_ATTATCHMENTS_PATH.$merchant_id, '', 'merchant_logo');

		    		//insert image in db
		    		$this->am3->updateData('merchant', array('merchant_logo' => $merchant_logo), $condition);

		    		$msg = 'shop logo uploaded successfully!';
		     		$code = CODE_SUCCESS;
		    		$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
	                $res = json_decode(json_encode($merchantDetail), True);
	     		}
	     		else
	     		{
	     			$msg = 'ERROR: merchant_logo required';
		     		$code = CODE_ERROR_PARAM_MISSING;
	     		}
     		}
     	}
     	else
     	{
	     	$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
    }

    //insert shop images
    public function uploadShopImage()
    {
    	$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

	    	//atatchment data
	        $img_data['link_id'] = $merchant_id;
	        $img_data['atch_type'] = "IMAGE";
	        $img_data['atch_for'] = "SELLER";

	        //insert seller images
	        if (count($_FILES) > 0)
	        //if (isset($_FILES['file1']) && $_FILES['file1']['name'] != '')
	        {
	        	$path = SELLER_ATTATCHMENTS_PATH.$merchant_id;

	            $isUploaded = $this->upload_image1($path, $img_data);
	            if (isset($isUploaded['db_error'])) 
	            {
	            	$msg = 'Error: '.$isUploaded['msg'];
					$code = CODE_ERROR_IN_QUERY;
	            }
	            else
		        {
		        	//get all images of shop
		        	$images = $this->am3->selectRecords(array('link_id' => $merchant_id, 'atch_type' => 'IMAGE'), 'attatchments', 
		        		"CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', link_id, '/', atch_url) AS atch_url");

		        	$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                	$res = json_decode(json_encode($merchantDetail), True);
		        	$msg = 'image uploaded successfully!';
					$code = CODE_SUCCESS;
		        }
	        }
	        else
	        {
	        	$msg = 'Error: there is no such attachment!';
				$code = CODE_ERROR_PARAM_MISSING;
	        }
	    }
	    else
     	{
	     	$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
    }

    private function deleteShopImage1($file_name, $merchant_id)
    {
    	if ($file_name && $merchant_id) 
    	{
	    	//get file from db
	    	$fileData = $this->am3->selectRecords(array('link_id' => $merchant_id), 'attatchments', 'atch_id, atch_url', array(), '', '', array('atch_url', $file_name));
	     	
	     	if ($fileData)
	     	{
	     		foreach ($fileData['result'] as $value) 
	     		{
		     		$fileName = $value['atch_url'];
		     		$fileId = $value['atch_id'];
		     		$path = SELLER_ATTATCHMENTS_PATH.'/'.$merchant_id.'/'.$fileName;

		     		//delete file from db and folder
		     		if (is_file($path))
		    		{
		    			//delete file from folder
			    		unlink($path);

			    		//delete file from db
			    		$this->am3->deleteRecord('attatchments', array('atch_id' => $fileId));

			    		//update record 
						$deletedStatus = $this->admin_controller->saveDeleteItem($merchant_id, 'MERCHANT');
						if (isset($deletedStatus['db_error'])) 
			            {
			            	$msg = 'Error: '.$deletedStatus['msg'];
							$code = CODE_ERROR_IN_QUERY;
			            }
			    	}
			    }
	     	}
	     	else
	     		return false;
	    }
	    else
	    {
	    	$msg = 'ERROR: file_name, merchant_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

	    if (isset($code)) 
	    	$this->getJsonData($code, $msg, array());
	    
	    return true;
    }

    public function deleteShopImage()
    {
    	$res = array();
        $token = isset($this->requestData->token)?$this->requestData->token:"";
		$remove_img = $this->input->post('image_name');
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token && $remove_img) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

     		$isDeleted = $this->deleteShopImage1($remove_img, $merchant_id);
     		if ($isDeleted) 
     		{
     			$msg = 'Image deleted successfully!';
		     	$code = CODE_SUCCESS;
		     	$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);
     		}
     		else
     		{
     			$msg = 'Error: image not found!';
		     	$code = CODE_ERROR_IN_QUERY;
     		}
     		
	    	//remove image from db and folder
			//delete from the folder
			/*$this->am3->deleteRecord('attatchments', array('atch_url' => $remove_img));

			$path = SELLER_ATTATCHMENTS_PATH.$merchant_id;

			//if exist file, remove profile pic from folder
    		if (is_file($path.'/'.$remove_img))
    		{
	    		unlink($path.'/'.$remove_img);

				//update record 
				$deletedStatus = $this->admin_controller->saveDeleteItem($merchant_id, 'MERCHANT');
				if (isset($deletedStatus['db_error'])) 
	            {
	            	$msg = 'Error: '.$deletedStatus['msg'];
					$code = CODE_ERROR_IN_QUERY;
	            }
	            else
	            {
					$msg = 'Image deleted successfully!';
		     		$code = CODE_SUCCESS;
		     	}
		    }
		    else
		    {
		    	$msg = 'Error: unauthorized merchant';
		     	$code = CODE_SUCCESS;
		    }*/
		}
		else
     	{
	     	$msg = 'ERROR: token, image_name are required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
    }

    private function upload_image1($path, $img_data)
	{
		//insert category images
		for ($i = 1; $i < 7; $i++) 
		{ 
			$obj_name = 'file'.$i;
			if (isset($_FILES[$obj_name]['name']) && $_FILES[$obj_name]['name'] != '')
			{
				$new_name = $obj_name.'_'.rand();

				//delete image from db and folder
				$this->deleteShopImage1($obj_name, $img_data['link_id']);

				$img_data['atch_url'] = $this->common_controller->single_upload($path, $new_name, $obj_name);

				//insert images
				if ($img_data['atch_url'])
					$this->am3->insertData('attatchments', $img_data);
			}
		}

		return true;
	}

	//delete listing
	public function deleteListingAPI($list_id)
	{
		$res = array();
		$token = isset($this->requestData->token) ? $this->requestData->token : "";

		if ($token && $list_id) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
     		$merchant_id = $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
     		$this->isValidToken($token, $user_id);

     		//check listing id is available or not
     		$isListingExist = $this->am3->selectRecords(array('listing_id' => $list_id), 'product_listing', 'merchant_id');
     		if (!$isListingExist) 
     		{
     			$msg = 'Error: Listing id not available';
		     	$code = CODE_ERROR_IN_QUERY;
     		}
     		else
     		{
     			if (!in_array("ADMIN", $merchantUserDetail['roles'])) 
	     		{
	     			if ($merchant_id != $isListingExist['result'][0]['merchant_id']) 
	     			{
	     				$msg = 'Error: unauthorized merchant';
			     		$code = CODE_ERROR_AUTHENTICATION_FAILED;

			     		$this->getJsonData($code, $msg, $res);
	     			}

	     			$where['merchant_id'] = $merchant_id;
	     		}

	     		$where['listing_id'] = $list_id;

	     		$isDeleted = $this->am3->deleteRecord('product_listing', $where);
				if ($isDeleted > 0) 
				{
					$isDeleted = $this->admin_controller->saveDeleteItem($list_id, 'LISTING');
					if (isset($isDeleted['db_error'])) 
					{
						$msg = 'Error: '.$isDeleted['msg'];
			     		$code = CODE_ERROR_IN_QUERY;
					}
					else
					{
						$msg = 'Listing deleted successfully!';
			     		$code = CODE_SUCCESS;
			     		$res['deleted_listing_id'] = array($list_id);
			     	}
			    }
			    else
				{
					$msg = 'Error: unable to delete listing';
			     	$code = CODE_ERROR_IN_QUERY;
				}
			}
     	}
     	else
     	{
	     	$msg = 'ERROR: token and listing_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
	}

	//delete listing
	public function deleteOffer1($offer_id)
	{
		$res = array();
		$token = isset($this->requestData->token) ? $this->requestData->token : "";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token && $offer_id) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
     		$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];

     		//check authorization
     		if ($merchant_id && (($merchantUserDetail['merchant_id'] != $merchant_id) && !in_array("ADMIN", $merchantUserDetail['roles'])))
     		{
     			$msg = 'ERROR: unauthorized merchant';
	     		$code = CODE_ERROR_AUTHENTICATION_FAILED;
     		}
     		else
     		{
     			$user_id = $merchantUserDetail['userId'];
	     		$this->isValidToken($token, $user_id);

	     		//check offer id is available or not
	     		$isOfferExist = $this->am3->selectRecords(array('offer_id' => $offer_id), 'product_listing_offer', 'merchant_id');
	     		if (!$isOfferExist) 
	     		{
	     			$msg = 'Error: Offer id not available';
			     	$code = CODE_ERROR_IN_QUERY;
	     		}
	     		else
	     		{
	     			if (!in_array("ADMIN", $merchantUserDetail['roles'])) 
		     		{
		     			if ($merchant_id != $isOfferExist['result'][0]['merchant_id']) 
		     			{
		     				$msg = 'Error: unauthorized merchant';
				     		$code = CODE_ERROR_AUTHENTICATION_FAILED;

				     		$this->getJsonData($code, $msg, $res);
		     			}
		     			else
		     				$where['merchant_id'] = $merchant_id;
		     		}

		     		$where['offer_id'] = $offer_id;

		     		$isDeleted = $this->am3->deleteRecord('product_listing_offer', $where);
					if ($isDeleted > 0) 
					{
						//delete offer attatchment
						$atch_where = array('atch_for' => 'OFFER', 'link_id' => $offer_id);
						$isOfferExist = $this->am3->selectRecords($atch_where, 'attatchments', 'atch_url');
						if ($isOfferExist) 
						{
							foreach ($isOfferExist['result'] as $value) 
							{
								$file = OFFER_ATTATCHMENTS_PATH.$merchant_id.'/'.$value['atch_url'];
				     			if (is_file($file))
						    		unlink($file);
							}

							$this->am3->deleteRecord('attatchments', $atch_where);
						}
						
						//delete offer listing
						$this->am3->deleteRecord('offer_listing_mp', array('ofr_id' => $offer_id));

						//save deleted item
						$isDeleted = $this->admin_controller->saveDeleteItem($offer_id, 'OFFER');
						if (isset($isDeleted['db_error'])) 
						{
							$msg = 'Error: '.$isDeleted['msg'];
				     		$code = CODE_ERROR_IN_QUERY;
						}
						else
						{
							$msg = 'offer deleted successfully!';
				     		$code = CODE_SUCCESS;
				     		$res['deleted_offer_id'] = array($offer_id);
				     	}
				    }
				    else
					{
						$msg = 'Error: unable to delete offer';
				     	$code = CODE_ERROR_IN_QUERY;
					}
				}
			}
     	}
     	else
     	{
	     	$msg = 'ERROR: token and offer_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
	}

	public function addOffer1()
	{
		$merchantUserDetail = $this->checkMerchantAuthorization(false);

		$res = array();
		$data = array();
		$offer_id = isset($this->requestData->offer_id) ? $this->requestData->offer_id : "";
		$data['offer_title'] = isset($this->requestData->offer_title) ? $this->requestData->offer_title : NULL;
		$data['ofr_brd_id'] = (isset($this->requestData->brand_id) && !empty($this->requestData->brand_id)) ? $this->requestData->brand_id : NULL;
		$data['description'] = isset($this->requestData->description) ? $this->requestData->description : NULL;
		$data['start_date'] = isset($this->requestData->start_date) ? $this->requestData->start_date : NULL;
		$data['end_date'] = isset($this->requestData->end_date) ? $this->requestData->end_date : NULL;
		$data['current_status'] = (isset($this->requestData->is_enabled) && $this->requestData->is_enabled == 1) ? $this->requestData->is_enabled : 0;
		$data['merchant_id'] = (isset($this->requestData->merchant_id) && !empty($this->requestData->merchant_id)) ? $this->requestData->merchant_id : NULL;
		$data['update_date'] = $this->current_date;

		if ($data['offer_title'] && $data['description'] && $data['start_date'] && $data['end_date'])
		{
     		if (1 !== preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $data['start_date'])) 
				$this->getJsonData(CODE_ERROR_INCORRECT_FORMAT, 'Error: start_date needs to have a valid date format - yyyy-mm-dd', array());

     		if (1 !== preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $data['end_date'])) 
				$this->getJsonData(CODE_ERROR_INCORRECT_FORMAT, 'Error: end_date needs to have a valid date format - yyyy-mm-dd', array());

 			if (
 				$offer_id && 
 				!in_array("ADMIN", $merchantUserDetail['roles'])
 			) 
 			{
 				// check offer is valid or not
 				$where = array(
 					'offer_id' => $offer_id, 
 					'merchant_id' => $data['merchant_id']
 				);
 				$this->isExist($where, 'product_listing_offer');
 			}

	     	if ($offer_id) 
			{
				$condition = array('offer_id' => $offer_id);
				$isUpdated = $this->am3->updateData('product_listing_offer', $data, $condition);
				if (isset($isUpdated['db_error'])) 
				{
					$msg = 'Error: '.$isUpdated['msg'];
			     	$code = CODE_ERROR_IN_QUERY;
				}
				else
				{
					$msg = "Offer updated successfully!!";
			     	$code = CODE_SUCCESS;
				}
			}
			else
			{
				$data['create_date'] = $this->current_date;

				$offer_id = $this->am3->insertData('product_listing_offer', $data);
				if (isset($offer_id['db_error'])) 
				{
					$msg = 'Error: '.$isUpdated['msg'];
			     	$code = CODE_ERROR_IN_QUERY;
				}
				else if ($offer_id)
				{
					$msg = "Offer inserted successfully!!";
			     	$code = CODE_SUCCESS;
				}
				else
				{
					$msg = "Error: Unable to insert offer!";
			     	$code = CODE_ERROR_IN_QUERY;
				}
			}

			if ($code == CODE_SUCCESS) 
			{
				//image data
				$img_data['link_id'] = $offer_id;
				$img_data['atch_type'] = "IMAGE";
				$img_data['atch_for'] = "OFFER";
				$img_data['folder_path'] = OFFER_ATTATCHMENTS_PATH.$offer_id;

				//save image
				$this->saveImage($img_data);

				$res = $this->getOffers(array('offer_id' => $offer_id));
			}
			else
			{
				$msg = "Error: Unable to insert offer!";
			    $code = CODE_ERROR_IN_QUERY;
			}
		}
		else
		{
			$msg = 'Error: token, offer_title, description, start_date, end_date required';
			$code = CODE_ERROR_PARAM_MISSING;
		}

		$this->getJsonData($code, $msg, $res);
	}

	private function getRequestedProduct1($merchant_id='', $request_id='')
	{
		$where = array();
		if ($merchant_id)
			$where['merchant_id'] = $merchant_id;

		if ($request_id)
			$where['request_id'] = $request_id;

		$a_req_prd_res = $this->am3->selectRecords($where, 'requested_product', 'SQL_CALC_FOUND_ROWS request_id, merchant_id, req_prd_id AS product_id, req_lst_id AS listing_id, brand_name, refer_link, isLinked, update_date AS last_updated, isEnabled AS enabled', array(), $this->limit, $this->start, array(), true);
		
		if ($a_req_prd_res) 
		{
			$a_req_prd_res = $a_req_prd_res['result'];

			foreach ($a_req_prd_res as $key => $value) 
			{
				//get product detail
				$product_result = $this->getProducts(array('product_id' => $value['product_id']));

				if ($product_result)
				{
					unset($product_result['products'][0]['enabled']);

					$a_req_prd_res[$key] = array_merge($a_req_prd_res[$key], $product_result['products'][0]);
				}
				else
					$a_req_prd_res[$key] = array();

				//get listing detail
				$listing_result = $this->getListings(array('listing_id' => $value['listing_id']));

				if ($listing_result)
				{
					unset($listing_result['result'][0]['enabled']);

					$a_req_prd_res[$key] = array_merge($a_req_prd_res[$key], $listing_result['result'][0]);
				}
				else
					$a_req_prd_res[$key] = array();
			}
		}

		return $a_req_prd_res;
	}

	//get requested product
	public function getRequestedProduct()
	{
		$this->checkMerchantAuthorization();

		$res = array();
        $merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

        $req_prds = $this->getRequestedProduct1($merchant_id);

		// $req_prds = $this->am3->getRequestedProduct(array('requested_product.merchant_id' => $merchant_id));
		// if (isset($req_prds['db_error'])) 
			// redirectWithMessage('Error: '.$req_prds['msg'], $controller);

		$msg = 'ok';
     	$code = CODE_SUCCESS;
		$res['requested_products'] = ($req_prds) ? $req_prds : array();
		
		//pagination array
		if (isset($req_prds['count'])) 
			$res['paging'] = $this->createPagingArray($req_prds['count']);

		$this->getJsonData($code, $msg, $res);
	}

	//delete listing
	public function deleteRequestedProduct()
	{
		$this->checkMerchantAuthorization();

		$res = array();
        $request_id = isset($this->requestData->requested_product_id) ? $this->requestData->requested_product_id : "";
		$merchant_id = isset($this->requestData->merchant_id) ? $this->requestData->merchant_id : "";

		if (!in_array("ADMIN", $merchantUserDetail['roles'])) 
		{
			// check offer is valid or not
			$where = array(
				'request_id' => $request_id, 
				'merchant_id' => $merchant_id
			);
			$this->isExist($where, 'requested_product');
		}

		//get product id
		$req_prd_id = $this->am3->selectRecords(array('request_id' => $request_id), 'requested_product', 'req_prd_id');
     	$product_id = $req_prd_id['result'][0]['req_prd_id'];

		$isDeleted = $this->am3->deleteRecord('product', array('product_id' => $product_id));
		if ($isDeleted > 0) 
		{
			$isDeleted = $this->admin_controller->saveDeleteItem($request_id, 'REQUESTED_PRODUCT');
			if (isset($isDeleted['db_error'])) 
			{
				$msg = 'Error: '.$isDeleted['msg'];
	     		$code = CODE_ERROR_IN_QUERY;
			}
			else
			{
				$msg = 'Requested product deleted successfully!';
	     		$code = CODE_SUCCESS;
	     		$res['deleted_requested_product_id'] = $req_id;
	     	}
		}
		else
		{
			$msg = 'Error: unauthorized merchant';
	     	$code = CODE_ERROR_AUTHENTICATION_FAILED;
		}

     	$this->getJsonData($code, $msg, $res);
	}

	public function updateMerchantDefaultValues()
	{
    	$token = isset($this->requestData->token) ? $this->requestData->token : "";
    	$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
        $res = array();

        if ($token) 
        {
        	$merchantUserDetail = $this->merchantUserDetail($token);
        	$merchant_id = ($merchant_id) ? $merchant_id : $merchantUserDetail['merchant_id'];
        	$user_id = $merchantUserDetail['userId'];
        	$this->isValidToken($token, $user_id);

        	//seller data
            $seller_data = array();
            $seller_data['finance_available'] = isset($this->requestData->finance_available) ? $this->requestData->finance_available : "";
            $seller_data['finance_terms'] = isset($this->requestData->finance_terms) ? $this->requestData->finance_terms : "";
            $seller_data['home_delivery_available'] = isset($this->requestData->home_delivery_available) ? $this->requestData->home_delivery_available : "";
            $seller_data['home_delivery_terms'] = isset($this->requestData->home_delivery_terms) ? $this->requestData->home_delivery_terms : "";
            $seller_data['installation_available'] = isset($this->requestData->installation_available) ? $this->requestData->installation_available : "";
            $seller_data['installation_terms'] = isset($this->requestData->installation_terms) ? $this->requestData->installation_terms : "";
            $seller_data['replacement_available'] = isset($this->requestData->replacement_available) ? $this->requestData->replacement_available : "";
            $seller_data['replacement_terms'] = isset($this->requestData->replacement_terms) ? $this->requestData->replacement_terms : "";
            $seller_data['return_available'] = isset($this->requestData->return_available) ? $this->requestData->return_available : "";
            $seller_data['return_policy'] = isset($this->requestData->return_policy) ? $this->requestData->return_policy : "";
            $seller_data['seller_offering'] = isset($this->requestData->seller_offering) ? $this->requestData->seller_offering : "";
            $seller_data['update_date'] = $this->current_date;

            //update merchant data
            $this->am3->updateData('merchant', $seller_data, array('merchant_id' => $merchant_id));

            //get merchant data
            $merchantDetail = $this->getMerchantData($merchant_id, $user_id);
            $res = json_decode(json_encode($merchantDetail), True);
            $msg = 'Merchant update successfully!';
			$code = CODE_SUCCESS;
        }
        else
        {
        	$msg = 'ERROR: token required!';
			$code = CODE_ERROR_PARAM_MISSING;
        }

        $this->getJsonData($code, $msg, $res);
	}

	public function addAddress()
	{
		$token = isset($this->requestData->token) ? $this->requestData->token : "";
    	$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
    	$res = array();

        if ($token) 
        {
        	$merchantUserDetail = $this->merchantUserDetail($token);

        	if ($merchant_id) 
        	{
        		$merchant_user_id = $this->am3->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
     			$user_id = $merchant_user_id['result'][0]['userId'];
        	}
        	else
        	{
        		$user_id = $merchantUserDetail['userId'];
        		$merchant_id = $merchantUserDetail['merchant_id'];
        	}

        	$this->isValidToken($token, $merchantUserDetail['userId']);

        	if ($user_id) 
        	{
	        	//insert merchant address
	            $address_id = $this->insertAddress1($user_id);
	            if ($address_id['status'] > 2) 
		            $this->getJsonData(CODE_ERROR_IN_QUERY, $address_id['msg'], $res);
	            else 
	            {
	            	if ($address_id['status'] == 1) 
	            		$msg = 'Address updated successfully!';
	            	else if ($address_id['status'] == 2) 
	            		$msg = 'Address added successfully!';

					$code = CODE_SUCCESS;

					//get inserted or updated address
		            $columns = 'SQL_CALC_FOUND_ROWS address_id, address.userId as user_id, merchant_id, address.business_days, address.business_hours, address_line_1, address_line_2, landmark, locality, pin, address.state_id, address.country_id, address.city_id, is_default_address, address.latitude, address.longitude, address.contact, address.update_date as last_updated, country.name as country, state.name as state, city.name as city, isEnabled AS enabled';

					$mer_add = $this->am3->getUserAddress(array('address.userId' => $user_id, 'address.address_id' => $address_id['address_id']), $columns);
					$res['addresses'] = $mer_add['result'][0];
	            }
			}
			else
			{
				$msg = 'ERROR: wrong merchant_id';
				$code = CODE_ERROR_PARAM_MISSING;
			}
        }
        else
        {
        	$msg = 'ERROR: token required!';
			$code = CODE_ERROR_PARAM_MISSING;
        }

        $this->getJsonData($code, $msg, $res);
	}

	//add/update user or merchant address
	private function insertAddress1($user_id)
	{
		$address_id = isset($this->requestData->address_id)?$this->requestData->address_id:"";

		//address detail
		$address_data['address_line_1'] = isset($this->requestData->address_line_1)?$this->requestData->address_line_1:"";

		if (isset($this->requestData->address_line_2))
			$address_data['address_line_2'] = $this->requestData->address_line_2;

		if (isset($this->requestData->landmark))
			$address_data['landmark'] = $this->requestData->landmark;

		if (isset($this->requestData->pin))
			$address_data['pin'] = $this->requestData->pin;

		if (isset($this->requestData->locality))
			$address_data['locality'] = $this->requestData->locality;

		$address_data['is_default_address'] = isset($this->requestData->is_default_address)?$this->requestData->is_default_address:0;

		if (isset($this->requestData->contact))
			$address_data['contact'] = $this->requestData->contact;

		if (isset($this->requestData->business_days))
			$address_data['business_days'] = $this->requestData->business_days;

		if (isset($this->requestData->business_hours))
			$address_data['business_hours'] = $this->requestData->business_hours;

		$address_data['latitude'] = isset($this->requestData->latitude)?$this->requestData->latitude:"";
		$address_data['longitude'] = isset($this->requestData->longitude)?$this->requestData->longitude:"";

		$address_data['country_id'] = isset($this->requestData->country_id)?$this->requestData->country_id:"";
		$address_data['state_id'] = isset($this->requestData->state_id)?$this->requestData->state_id:"";
		$address_data['city_id'] = isset($this->requestData->city_id)?$this->requestData->city_id:"";
		$address_data['update_date'] = $this->current_date;

		//get lat long from address
		if (!$address_data['latitude'] || !$address_data['longitude']) 
		{
			$address_values = getLAtLongFromAddress($address_data);
			$address_values = json_decode(json_encode($address_values), True);
			
			if (isset($address_values['msg'])) 
				return array('status' => 3, 'msg' => 'Error: '.$address_values['msg']);

            if ($address_values) 
            {
                $address_data['latitude'] = $address_values['results'][0]['geometry']['location']['lat'];
                $address_data['longitude'] = $address_values['results'][0]['geometry']['location']['lng'];
            }
		}
		else if(preg_match("/^\\d+\\.\\d+$/", $address_data['latitude']) !== 1 || preg_match("/^\\d+\\.\\d+$/", $address_data['longitude']) !== 1)
			return array('status' => 4, 'msg' => 'Error: latitude, longitude are not in correct format.');

		//update address detail
		if ($address_id) 
		{
			//check address is exist or not
			$addressRes = $this->am3->selectRecords(array('address_id' => $address_id), 'address', 'userId');
			if ($addressRes) 
			{
				$condition = array('address_id' => $address_id);
				$this->am3->updateData('address', $address_data, $condition);

				return array('status' => 1, 'address_id' => $address_id);
			}
			else
				return array('status' => 6, 'msg' => 'Error: wrong address_id');
		}
		else
		{
			$address_data['userId'] = $user_id;
			$address_data['create_date'] = $this->current_date;

			$address_id = $this->am3->insertData('address', $address_data);

			if ($address_id) 
				return array('status' => 2, 'address_id' => $address_id);
		}

		return array('status' => 5, 'msg' => 'Error: something went wrong.');
	}

	private function addProduct($request)
	{
		//product data
		$product_data = array();
		$product_data['category_id'] = $request['category_id'];
		$product_data['brand_id'] = $request['brand_id'];
		$product_data['product_name'] = $request['product_name'];
		$product_data['mrp_price'] = $request['product_price'];
		$product_data['description'] = $request['product_description'];
		$product_data['in_the_box'] = $request['in_the_box'];
		$product_data['update_date'] = $this->current_date;
		$product_id = $request['product_id'];

		//check product name is already exist in product table or not
		$isExistProduct = $this->am3->checkProductExistance($product_data['product_name'], $product_id);
		if ($isExistProduct) 
		{
			$msg = 'Error: product_name already exist';
 			$code = CODE_ERROR_PARAM_MISSING;

 			$this->getJsonData($code, $msg, array());
		}

		if ($product_id) // update product
			$this->am3->updateData('product', $product_data, array('product_id' => $product_id));
		else // insert product
		{
			$product_data['create_date'] = $this->current_date;

			$product_id = $this->am3->insertData('product', $product_data);
		}

		if (!$product_id) 
		{
			$msg = 'Error: Unable to insert product';
 			$code = CODE_ERROR_IN_QUERY;

 			$this->getJsonData($code, $msg, $res);
		}
		else
			return $product_id;
	}

	private function addProductAttribute($category_id='', $product_id='', $attribute=array())
	{
		//insert or update product attribute values
		$category_attributes_res = $this->am3->categoryAttributes($category_id, $product_id);	
		if ($category_attributes_res)
			$category_attributes = $category_attributes_res;

		$tbl_name = 'category_attribute_value';
		$i = 0;
		foreach ($category_attributes as $att_value) 
		{
			if ($att_value['mp_id']) 
			{
				$columns = 'value_id';
				$where = array('prd_id' => $product_id, 'cat_att_mp_id' => $att_value['mp_id']);
				$prd_att_res = $this->am3->selectRecords($where, $tbl_name, 'value_id');
				
				$att_values_data['cat_att_mp_id'] = $att_value['mp_id'];
				$att_values_data['prd_id'] = $product_id;
				$att_values_data['att_value'] = isset($attribute[$att_value['att_id']]) ? $attribute[$att_value['att_id']] : "";
				
				if ($prd_att_res) //update attribute value
				{
					$condition = array('value_id' => $prd_att_res['result'][0]['value_id']);
					$this->am3->updateData($tbl_name, $att_values_data, $condition);
				}
				else //insert attribute value
					$this->am3->insertData($tbl_name, $att_values_data);
			}
		}
	}

	public function addRequestedProduct()
	{
		$merchantUserDetail = $this->checkMerchantAuthorization();

		//images are remaining for this api

		$res = array();
		$merchant_id = isset($this->requestData->merchant_id) ? $this->requestData->merchant_id : "";
		$request_id = isset($this->requestData->request_id) ? $this->requestData->request_id : NULL;

		if ($request_id) 
		{
			$where = array();
			$where['request_id'] = $request_id;

			if (!in_array("ADMIN", $merchantUserDetail['roles']))
     			$where['merchant_id'] = $merchant_id;

			$req_ids = $this->am3->selectRecords($where, 'requested_product', 'req_prd_id, req_lst_id');
			if (!$req_ids) 
			{
				$msg = 'ERROR: unauthorized merchant';
 				$code = CODE_ERROR_AUTHENTICATION_FAILED;

 				$this->getJsonData($code, $msg, $res);
			}

     		$product_id = $req_ids['result'][0]['req_prd_id'];
     		$listing_id = $req_ids['result'][0]['req_lst_id'];
		}
		else
		{
			$product_id = NULL;
			$listing_id = NULL;
		}

		//product data
		$product_data = array();
		$product_data['category_id'] = isset($this->requestData->category_id) ? $this->requestData->category_id : "";
		$product_data['brand_id'] = isset($this->requestData->brand_id) ? $this->requestData->brand_id : "";
		$product_data['product_name'] = isset($this->requestData->product_name) ? $this->requestData->product_name : "";
		$product_data['product_price'] = isset($this->requestData->product_price) ? $this->requestData->product_price : "";
		$product_data['product_description'] = isset($this->requestData->product_description) ? $this->requestData->product_description : "";
		$product_data['in_the_box'] = isset($this->requestData->in_the_box) ? $this->requestData->in_the_box : "";
		$product_data['product_id'] = $product_id;

		//set NULL to blank item
		setNULLToBlank($product_data);

		//listing data
		$listing_data = array();
		$listing_data['sell_price'] = isset($this->requestData->seller_price) ? $this->requestData->seller_price : "";
		$listing_data['finance_available'] = (isset($this->requestData->finance_available) && $this->requestData->finance_available == 1) ? 1 : 0;
		$listing_data['finance_terms'] = isset($this->requestData->finance_terms) ? $this->requestData->finance_terms : "";
		$listing_data['home_delivery_available'] = (isset($this->requestData->home_delivery_available) && $this->requestData->home_delivery_available == 1) ? 1 : 0;
		$listing_data['home_delivery_terms'] = isset($this->requestData->home_delivery_terms) ? $this->requestData->home_delivery_terms : "";
		$listing_data['installation_available'] = (isset($this->requestData->installation_available) && $this->requestData->installation_available == 1) ? 1 : 0;
		$listing_data['installation_terms'] = isset($this->requestData->installation_terms) ? $this->requestData->installation_terms : "";
		$listing_data['in_stock'] = (isset($this->requestData->in_stock) && $this->requestData->in_stock == 0) ? 0 : 1;
		$listing_data['will_back_in_stock_on'] = isset($this->requestData->will_back_in_stock_on) ? $this->requestData->will_back_in_stock_on : "";
		$listing_data['replacement_available'] = (isset($this->requestData->replacement_available) && $this->requestData->replacement_available == 1) ? 1 : 0;
		$listing_data['replacement_terms'] = isset($this->requestData->replacement_terms) ? $this->requestData->replacement_terms : "";
		$listing_data['return_available'] = (isset($this->requestData->return_available) && $this->requestData->return_available == 1) ? 1 : 0;
		$listing_data['return_policy'] = isset($this->requestData->return_policy) ? $this->requestData->return_policy : "";
		$listing_data['seller_offering'] = isset($this->requestData->seller_offering) ? $this->requestData->seller_offering : "";
		$listing_data['merchant_id'] = $merchant_id;

		//set NULL to blank item
		setNULLToBlank($listing_data);

		//requested product data
		$req_prd_data = array();
		$req_prd_data['brand_name'] = isset($this->requestData->brand_name) ? $this->requestData->brand_name : "";
		$req_prd_data['refer_link'] = isset($this->requestData->refer_link) ? $this->requestData->refer_link : "";
		$req_prd_data['merchant_id'] = $merchant_id;

		//set NULL to blank item
		setNULLToBlank($req_prd_data);

		//product attributes
		$product_attribute = isset($this->requestData->product_attribute) ? json_decode(json_encode(json_decode($this->requestData->product_attribute)), true) : false;

		if (!$product_data['category_id'] || (!$product_data['brand_id'] && !$req_prd_data['brand_name']) || !$product_data['product_name'] || !$product_data['product_price'] || !$listing_data['sell_price']) 
		{
			$msg = 'Error: category_id, brand_id or brand_name, product_name, product_price, seller_price required';
 			$code = CODE_ERROR_PARAM_MISSING;
		}
		else if ($listing_data['sell_price'] > $product_data['product_price']) 
		{
			$msg = 'Error: seller_price could not more over than product_price';
 			$code = CODE_ERROR_PARAM_MISSING;
		}
		else
		{
			//add or update product
			$product_id = $this->addProduct($product_data);

			//add and update product category attribute
			$this->addProductAttribute($product_data['category_id'], $product_id, $product_attribute);

			//insert or update product images
			if (count($_FILES) > 0)
	        {
	        	//image data
				$img_data['link_id'] = $product_id;
				$img_data['atch_type'] = "IMAGE";
				$img_data['atch_for'] = "PRODUCT";
				$img_data['folder_path'] = PRODUCT_ATTATCHMENTS_PATH.$product_id;
				
				$this->saveImage($img_data);
	        }

			//insert or update product merchant listing
			$listing_data['product_id'] = $product_id;
			if ($listing_id) 
				$this->am3->updateData('product_listing', $listing_data, array('listing_id' => $listing_id));
			else
			{
				$listing_data['create_date'] = $this->current_date;

				$listing_id = $this->am3->insertData('product_listing', $listing_data);
			}

			//insert or update requested product
			$req_prd_data['req_prd_id'] = $product_id;
			$req_prd_data['req_lst_id'] = $listing_id;
			if ($request_id) 
				$this->am3->updateData('requested_product', $req_prd_data, array('request_id' => $request_id));
			else
			{
				$req_prd_data['create_date'] = $this->current_date;

				$request_id = $this->am3->insertData('requested_product', $req_prd_data);
			}

			if ($product_id && $request_id && $listing_id) 
			{
				$msg = 'Operation successfully done on requested product.';
 				$code = CODE_SUCCESS;
 				$res_prd = $this->getRequestedProduct1('', $request_id);
 				$res['requested_products'] = $res_prd[0];
			}
			else
			{
				$msg = 'Error: Unable to insert requested product';
 				$code = CODE_ERROR_IN_QUERY;
			}
		}

     	$this->getJsonData($code, $msg, $res);
	}

	public function addListing()
	{
		$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
		$product_id = isset($this->requestData->product_id)?$this->requestData->product_id:"";
		$list_id = false;

		if ($token && $merchant_id && $product_id) 
     	{
     		//$req_prd_id = $this->input->post('req_prd_id');
			//$merchant_id = $this->input->post('merchant_id');
			//$list_id = $this->input->post('listing_id');

     		$merchantUserDetail = $this->merchantUserDetail($token);

        	if ($merchant_id) 
        	{
        		$merchant_user_id = $this->am3->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
     			$user_id = $merchant_user_id['result'][0]['userId'];
        	}
        	else
        	{
        		$user_id = $merchantUserDetail['userId'];
        		$merchant_id = $merchantUserDetail['merchant_id'];
        	}

        	$this->isValidToken($token, $user_id);

			$listing_data = array();
			$listing_data['merchant_id'] = $merchant_id;
			$listing_data['sell_price'] = isset($this->requestData->price)?$this->requestData->price:"";
			$listing_data['finance_available'] = isset($this->requestData->finance_available)?$this->requestData->finance_available:"0";
			$listing_data['finance_terms'] = isset($this->requestData->finance_terms)?$this->requestData->finance_terms:"";
			$listing_data['home_delivery_available'] = isset($this->requestData->home_delivery_available)?$this->requestData->home_delivery_available:"0";
			$listing_data['home_delivery_terms'] = isset($this->requestData->home_delivery_terms)?$this->requestData->home_delivery_terms:"";
			$listing_data['installation_available'] = isset($this->requestData->installation_available)?$this->requestData->installation_available:"0";
			$listing_data['installation_terms'] = isset($this->requestData->installation_terms)?$this->requestData->installation_terms:"";
			$listing_data['in_stock'] = isset($this->requestData->in_stock)?$this->requestData->in_stock:"0";
			$listing_data['will_back_in_stock_on'] = isset($this->requestData->will_back_in_stock_on)?$this->requestData->will_back_in_stock_on:"";
			$listing_data['replacement_available'] = isset($this->requestData->replacement_available)?$this->requestData->replacement_available:"0";
			$listing_data['replacement_terms'] = isset($this->requestData->replacement_terms)?$this->requestData->replacement_terms:"";
			$listing_data['return_available'] = isset($this->requestData->return_available)?$this->requestData->return_available:"0";
			$listing_data['return_policy'] = isset($this->requestData->return_policy)?$this->requestData->return_policy:"";
			$listing_data['seller_offering'] = isset($this->requestData->seller_offering)?$this->requestData->seller_offering:"";
			$listing_data['update_date'] = $this->current_date;
			$listing_data['isVerified'] = 1;
			$listing_data['product_id'] = $product_id;

			/*if ($this->input->post('prd_id'))
				$listing_data['product_id'] = $this->input->post('prd_id');
			else if($req_prd_id)
				$listing_data['req_prd_id'] = $req_prd_id;*/

			//check merchent and product is already exist or not
			$condition = array('product_id' => $product_id, 'merchant_id' => $merchant_id);
			$isExistMerchantReview = $this->am3->selectRecords($condition, 'product_listing', 'listing_id');
			if ($isExistMerchantReview) 
			{
				$list_id = $isExistMerchantReview['result'][0]['listing_id'];
				$this->am3->updateData('product_listing', $listing_data, array('listing_id' => $list_id));

				$msg = "Detail updated successfully!!";	
				$code = CODE_SUCCESS;
			}
			else
			{
				$listing_data['isVerified'] = 0;
				$listing_data['create_date'] = $this->current_date;

				$list_id = $this->am3->insertData('product_listing', $listing_data);

				if ($list_id)
				{
					$msg = "Detail inserted successfully!!";
					$code = CODE_SUCCESS;
				}
			}

			if ($list_id) 
			{
				$listingData = $this->am3->selectRecords(array('listing_id' => $list_id), 'product_listing', 'listing_id, product_id, merchant_id, sell_price AS price, finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, in_stock, will_back_in_stock_on, replacement_available, replacement_terms, return_available, return_policy, seller_offering, isVerified, isEnabled AS enabled');
				$res['listing'] = $listingData['result'][0];
			}
			else
			{
				$msg = "Error: unable to update information.";
				$code = CODE_ERROR_IN_QUERY;
			}
		}
		else
     	{
	     	$msg = 'ERROR: token, merchant_id, product_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
	    }

     	$this->getJsonData($code, $msg, $res);
	}
	
	public function deleteLogo()
	{
		$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";

		if ($token) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);
     		$user_id = $merchantUserDetail['userId'];
        	if (!$merchant_id) 
        		$merchant_id = $merchantUserDetail['merchant_id'];

        	$merchantLogo = $this->am3->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'merchant_logo');
     		$merchantLogo = $merchantLogo['result'][0]['merchant_logo'];
     		
     		$this->isValidToken($token, $user_id);

     		if ($merchantLogo) 
     		{
     			$file = SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$merchantLogo;
     			if (is_file($file))
		    		unlink($file);

		    	$this->am3->updateData('merchant', array('merchant_logo' => ''), array('merchant_id' => $merchant_id));

		    	$merchantDetail = $this->getMerchantData($merchant_id, $user_id);
                $res = json_decode(json_encode($merchantDetail), True);
				$msg = "Logo removed!";	
				$code = CODE_SUCCESS;
     		} 
     		else
     		{
     			$msg = "Error: logo not found!";	
				$code = CODE_ERROR_IN_QUERY;	
     		}       	
     	}
     	else
     	{
     		$msg = 'ERROR: token required';
	     	$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $res);
	}

	public function deleteAddress1()
	{
		$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
		$address_id = isset($this->requestData->address_id)?$this->requestData->address_id:"";

		if ($token && $address_id) 
     	{
     		$merchantUserDetail = $this->merchantUserDetail($token);

     		if ($merchant_id) 
        	{
        		$userId = $this->am3->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'userId');
     			$user_id = $userId['result'][0]['userId'];
        	}
        	else
        		$user_id = $merchantUserDetail['userId'];

        	if (!in_array("ADMIN", $merchantUserDetail['roles']))
     		{
     			$where['userId'] = $user_id;
     			$msg = 'ERROR: unauthorized merchant';
     		}
     		else
     			$msg = 'ERROR: wrong address_id';

     		$where['address_id'] = $address_id;
     		$address_data = $this->am3->selectRecords($where, 'address', 'userId, is_default_address');

     		if (!$address_data) 
     			$code = CODE_ERROR_IN_QUERY;
     		else
     		{
     			$this->am3->deleteRecord('address', array('address_id' => $address_id));
     			$this->admin_controller->saveDeleteItem($address_id, 'ADDRESS');

     			//check if deleted record has default address
     			if ($address_data['result'][0]['is_default_address'] == 1) 
     			{
     				$address = $this->am3->selectRecords(array('address_id' => $address_id), 'address', 'address_id', array('address_id' => 'ASC'), 1, 0);
     				if ($address) 
     				{
     					$address_id = $userId['result'][0]['address_id'];
     					$this->am3->updateData('address', array('is_default_address' => 1), array('address_id' => $address_id, 'update_date' => $this->current_date));
     				}
     			}

     			$msg = 'address deleted successfully';
	     		$code = CODE_SUCCESS;
	     		$res['deleted_address_id'] = array($address_id);
     		}
        }
        else
     	{
     		$msg = 'ERROR: token, address_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $res);
	}

	public function changeMerchantPassword()
	{
		$res = array();
		$token = isset($this->requestData->token)?$this->requestData->token:"";
		$old_password = isset($this->requestData->old_password)?$this->requestData->old_password:"";
		$new_password = isset($this->requestData->new_password)?$this->requestData->new_password:"";
		$merchant_id = isset($this->requestData->merchant_id)?$this->requestData->merchant_id:"";
		$new_token = md5(uniqid(rand(), true));

		if ($old_password != '' && $new_password != '' && $token != '' && $merchant_id != '') 
     	{
			$merchantUserDetail = $this->merchantUserDetail($token);
	     	$user_id = $merchantUserDetail['userId'];
	     	
	     	if ($merchant_id != $merchantUserDetail['merchant_id']) 
	     	{
	     		$msg = 'ERROR: wrong merchant_id!';
	     		$code = CODE_ERROR_UNKNOWN;
	     	}
	     	else
	     	{
				$condition = array('userId' => $user_id, 'password' => $old_password);
				$isValidaOldPassword = $this->am3->selectRecords($condition, 'user', 'userId');

				if ($isValidaOldPassword) 
				{
					$condition = array('userId' => $user_id);
					$this->am3->updateData('user', array('password' => $new_password, 'auth_token' => $new_token), $condition);

					//get merchant detail
	                $merchantDetail = $this->getMerchantData($merchant_id, $user_id);
	                $res = json_decode(json_encode($merchantDetail), True);
					$msg = 'Password changed!';
					$code = CODE_SUCCESS;
				}
				else
				{
					$msg = 'ERROR: old_password is not correct!';
					$code = CODE_ERROR_UNKNOWN;
				}
			}
		}
		else
     	{
     		$msg = 'ERROR: token, new_password, old_password, merchant_id required';
	     	$code = CODE_ERROR_PARAM_MISSING;
     	}

     	$this->getJsonData($code, $msg, $res);
	}

	public function getCategoryAttribtes($cat_id)
	{
		$category_attributes_res = $this->am3->categoryAttribute1($cat_id);
		
		$res['category_id'] = $cat_id;
		$res['specifications'] = ($category_attributes_res) ? $category_attributes_res : array();

		$code = CODE_SUCCESS;
		$msg = 'category attributes';
		$this->getJsonData($code, $msg, $res);
	}

	//check is exist user email or not
	public function checkUserExist()
	{
		$res = array();
		$token = isset($this->requestData->token) ? $this->requestData->token : "";
		$email = isset($this->requestData->email) ? $this->requestData->email : "";

		//check is exist user email or not
		$isExist = $this->am3->selectRecords(array('email' => $email), 'user', 'userId');		

		if ($isExist) 
		{
			$user_id = $isExist['result'][0]['userId'];

			//get user types
			$user_roles = $this->am3->getUserRoles($user_id);
			$user_roles = array_column($user_roles, 'type_name');
			$is_admin = in_array('ADMIN', $user_roles) ? true : false;
			$is_consumer = in_array('BUYER', $user_roles) ? true : false;
			$is_merchant = in_array('SELLER', $user_roles) ? true : false;

			$res = array(
				"user_exist" => true,
				"is_consumer" => $is_consumer,
				"is_merchant" => $is_merchant,
				"is_admin" => $is_admin
			);
		}
		else
		{
			$res = array(
				"user_exist" => false,
				"is_consumer" => false,
				"is_merchant" => false,
				"is_admin" => false
			);
		}

		$this->getJsonData(CODE_SUCCESS, 'user existance', $res);
	}

	public function claimBusiness($merchant_id)
    {
        $claimed_data = array();
        $claimed_data['clmd_email'] = isset($this->requestData->email) ? $this->requestData->email : "";
        $claimed_data['clmd_name'] = isset($this->requestData->name) ? $this->requestData->name : "";
        $claimed_data['clmd_contact'] = isset($this->requestData->contact) ? $this->requestData->contact : "";
        $claimed_data['clmd_merchant_id'] = $merchant_id;
        $claimed_data['clmd_message'] = isset($this->requestData->message) ? $this->requestData->message : "";

        if (!isset($_FILES['business_proof']['name']) || !$claimed_data['clmd_email'] || !$claimed_data['clmd_name'] || !$claimed_data['clmd_contact'])
        {
            $msg = 'ERROR: email, name, contact, business_proof required';
	     	$code = CODE_ERROR_PARAM_MISSING;
        }
        else
        {
        	$claimed_data['clmd_business_proof'] = $this->common_controller->single_upload(TEMP_FOLDER_PATH, '', 'business_proof');

	        $clmd_id = $this->am3->insertData('claimed_requests', $claimed_data);
	        if ($clmd_id) 
	        {
	        	//get shop name
	        	$establishment_name = $this->am3->selectRecords(array('merchant_id' => $merchant_id), 'merchant', 'establishment_name');
	        	
	        	$claimed_data['establishment_name'] = $establishment_name['result'][0]['establishment_name'];
	            $claimed_data['request_id'] = $clmd_id;
	            $claimed_data['request_url'] = "<a href='".base_url('merchants/'.$claimed_data['establishment_name'].'?merchant_id='.$merchant_id)."'>Shop Detail</a>";
	            $claimed_data['code'] = MAIL_CODE_CLAIM_BUSINESS;
	            $claimed_data['atch'] = base_url(TEMP_FOLDER_PATH.$claimed_data['clmd_business_proof']);

	            $isSend = $this->common_controller->sendMail($claimed_data);
	            if ($isSend) 
		        {
		        	$msg = 'Mail has been sent! We will review your request.';
		     		$code = CODE_SUCCESS;
		        }
		        else
		        {
		            $msg = 'ERROR: unable to get your request.';
		     		$code = CODE_ERROR_IN_QUERY;
		        }
	        }
	        else
	        {
	        	$msg = 'ERROR: unable to get your request.';
		     	$code = CODE_ERROR_IN_QUERY;
	        }
	    }

	    $this->getJsonData($code, $msg, array());
    }

	/****************************************************/
	//-- MOVE BELOW METHODS TO CENTRAL PLACE
	/****************************************************/


	//check merchant authorization
	private function checkMerchantAuthorization($checkMerchantId=true)
	{
		$token = isset($this->requestData->token) ? $this->requestData->token : "";
		$merchant_id = isset($this->requestData->merchant_id) ? $this->requestData->merchant_id : "";
		
		if (!$token)
 		{
 			$msg = 'Error: token required';
			$code = CODE_ERROR_PARAM_MISSING;

			$this->getJsonData($code, $msg, array());
 		}

 		if ($checkMerchantId && !$merchant_id) 
		{
			$msg = 'Error: token, merchant_id required';
			$code = CODE_ERROR_PARAM_MISSING;

			$this->getJsonData($code, $msg, array());
		}

 		//get merchant user detail using token
 		$merchantUserDetail = $this->merchantUserDetail($token);

 		//check token is valid or not
 		$this->isValidToken($token, $merchantUserDetail['userId']);

 		//check admin authorization
 		if (
 			in_array("ADMIN", $merchantUserDetail['roles']) ||
 			(
 				in_array("SELLER", $merchantUserDetail['roles']) &&
 				$merchant_id == $merchantUserDetail['merchant_id']
 			)
 		)
 			return $merchantUserDetail;

 		$msg = 'ERROR: unauthorized merchant';
 		$code = CODE_ERROR_AUTHENTICATION_FAILED;

		$this->getJsonData($code, $msg, array());
	}

	//chech item is exist or not
	private function isExist($where, $tbl_name)
	{
		$isExist = $this->am3->selectRecords($where, $tbl_name, '*');
		if (!$isExist) 
		{
			$msg = 'ERROR: unauthorized merchant';
     		$code = CODE_ERROR_AUTHENTICATION_FAILED;

     		$this->getJsonData($code, $msg, $res);
		}
		else
			return true;
	}

	//add/update image(s) in db and folder
	private function saveImage($img_data)
	{
		if (count($_FILES) > 0)
        {
        	for ($i = 1; $i < 7; $i++) 
			{ 
				$obj_name = 'file'.$i;

				if (
					isset($_FILES[$obj_name]['name']) && 
					$_FILES[$obj_name]['name'] != ''
				)
				{
					//delete file from db and folder if exist
					if ($obj_name && $img_data['link_id']) 
			    	{
				    	//get file(s) from db
				    	$fileData = $this->am3->selectRecords(
					    		array(
					    			'link_id' => $img_data['link_id'],
					    			'atch_for' => $img_data['atch_for']
					    		), 
					    		'attatchments', 
					    		'atch_id, atch_url', 
					    		array(), 
					    		'', 
					    		'', 
					    		array('atch_url', $obj_name)
					    	);

				     	if ($fileData)
				     	{
				     		foreach ($fileData['result'] as $value)
				     		{
					     		$fileName = $value['atch_url'];
					     		$fileId = $value['atch_id'];
					     		$path = $img_data['folder_path'].'/'.$fileName;

					     		//delete file from db and folder
					     		if (is_file($path))
					    		{
					    			//delete file from folder
						    		unlink($path);

						    		//delete file from db
						    		$this->am3->deleteRecord('attatchments', array('atch_id' => $fileId));

						    		//update record 
									$deletedStatus = $this->admin_controller->saveDeleteItem($img_data['link_id'], $img_data['atch_for']);
									if (isset($deletedStatus['db_error'])) 
						            {
						            	$msg = 'Error: '.$deletedStatus['msg'];
										$code = CODE_ERROR_IN_QUERY;

										$this->getJsonData($code, $msg, array());
						            }
						    	}
						    }
				     	}
				    }

					$new_name = $obj_name.'_'.rand();

					$img_data['atch_url'] = $this->common_controller->single_upload($img_data['folder_path'], $new_name, $obj_name);

					//insert image
					if ($img_data['atch_url'])
					{
						//image data
						$data = array();
						$data['link_id'] = $img_data['link_id'];
						$data['atch_type'] = $img_data['atch_type'];
						$data['atch_url'] = $img_data['atch_url'];
						$data['atch_for'] = $img_data['atch_for'];

						$this->am3->insertData('attatchments', $data);
					}
				}
			}
        }
	}

	//-- function for return json encoded data
    public function getJsonData($code, $msg, $data)
	{
		$arrayResponse = $data;
		$arrayResponse['code'] = $code;
		$arrayResponse['msg'] = $msg;
		$arrayResponse['response_date_time'] = date("Y-m-d H:i:s");

		echo json_encode($arrayResponse);
		die;
	}

	public function createPagingArray($count = 0)
	{
		if ($count || $this->current_page == 1) 
		{
			$paging = array();

			$paging['total_results'] = $count;
			
			if (!$count) 
				$paging['total_pages'] = $this->current_page;
			else
				$paging['total_pages'] = ceil($count/$this->limit);
			
			$paging['page'] = $this->current_page;
			$paging['limit'] = $this->limit;

			return $paging;
		}
		else
		{
			$msg = 'ERROR: Requested for wrong page.';
			$code = CODE_ERROR_WRONG_PAGE;
			$this->getJsonData($code, $msg, array());
		}
	}
}
