<?php
class Admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        
        //get lastupdate date
        $this->last_updateDate = isset($_GET['last_updateDate']) ? $_GET['last_updateDate'] : "";
        if ($this->last_updateDate) //check last updatedate is in correct format or not
        {
            if($this->last_updateDate != date('Y-m-d H:i:s',strtotime($this->last_updateDate)))
            {
                $arrayResponse['code'] = CODE_ERROR_PARAM_MISSING;
                $arrayResponse['msg'] = "Error: last_updateDate is not in correct format!";

                echo json_encode($arrayResponse);
                die;
            }
        }
                
        //get requested controller name
        $this->router->fetch_class();
        $ci =& get_instance();
        $this->controller_name = $ci->router->fetch_class();
    }

    public function trimAllColumnsValue()
    {
        $sql = $this->db->query('show tables');
        $tables = $sql->result();

        foreach($tables as $table) {
            $db = 'Tables_in_'.DB_DATABASE;
            $table_name = $table->$db;
            $sql = $this->db->query("SHOW COLUMNS FROM ".$table_name);
            $columns = $sql->result();

            foreach ($columns as $column) 
            {
                $this->db->query("UPDATE ".$table_name." SET ".$column->Field." = LTRIM(".$column->Field.")");
                $this->db->query("UPDATE ".$table_name." SET ".$column->Field." = RTRIM(".$column->Field.")");
            }
        }
    }

    public function createDbBackup()
    {
        $this->load->dbutil();
        
        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        $file_name = date("Y-m-d H:i:s").'.gz';
        write_file(DB_BACKUP_PATH.date("Y-m-d H:i:s").'.gz', $backup);

        // Load the download helper and send the file to your desktop
        //$this->load->helper('download');
        //force_download('mybackup.gz', $backup);

        $prefs = array(
            'tables' => array('user'),   // Array of tables to backup.
            'ignore' => array(), // List of tables to omit from the backup
            'format' => 'txt', // gzip, zip, txt
            'filename' => 'mybackup.sql', // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n" // Newline character used in backup file
        );

        $this->dbutil->backup($prefs);

        //insert file in db
        $data = array();
        $data['atch_url'] = $file_name;
        $data['atch_type'] = "ZIP";
        $data['atch_for'] = "DB_BACKUP";
        $this->insertData('attatchments', $data);
    }

    public function fetchCategoryIdList($parent = 0, $user_tree_array = '') 
    {
        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $sql = $this->db->query("SELECT * FROM `product_category` WHERE `parent_category_id` = $parent ORDER BY category_id ASC");
        
        if ($sql->num_rows() > 0) 
        {
            foreach ($sql->result() as $row) 
            {
                $user_tree_array[] = $row->category_id;
                $user_tree_array = $this->fetchCategoryIdList($row->category_id, $user_tree_array);
            }
        }

        return $user_tree_array;
    }

    public function doLogin($username, $password)
    {
        $this->db->where(array('email' => $username, 'password' => $password));
        $this->db->select('userId');
        $query = $this->db->get('user');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() == 1)  
            return $query->row_array();
        else
            return FALSE;
    }

    public function getUser($user_id = '', $status = '')
    {
        $where = '';
        if ($user_id)
            $where = " WHERE user.userId = ".$user_id;

        if ($status)
            $where .= " AND user.status = ".$status;
        
        $query = $this->db->query("
            SELECT 
                user.userId, 
                email, 
                status, 
                first_name, 
                IF(picture, CONCAT('".$this->config->item('site_url').PROFILE_PIC_PATH."',picture), '') as profile_image, 
                auth_token, 
                create_date, 
                update_date,
                password 
            FROM 
                user".
            $where
        );

        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function getUserRoles($usr_id)
    {
        $where = array();

        if ($usr_id)
            $where['usr_id'] = $usr_id;

        $this->db->where($where);
        $this->db->select('*');
        $this->db->from('user_type');
        $query  = $this->db->get();
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        return $query->result_array();
    }

    public function insertData($tbl_name, $data)
    {
        $this->db->insert($tbl_name, $data);
        $insert_id = $this->db->insert_id();
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        return $insert_id;
    }

    public function updateData($tbl_name, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($tbl_name, $data);
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;
    }

    public function selectRecords($where = "", $tbl_name = '', $columns = '', $order_by = array(), $limit = '', $start = '', $like = array(), $hasUpdateDateField = false, $where_in=array())
    {   
        if (empty($where)) 
            $where = array();
        
        if ($this->last_updateDate && $hasUpdateDateField) 
            $where['update_date >='] = $this->last_updateDate;

        if (count($where)>0) 
            $this->db->where($where);
        
        if (count($where_in)>0) 
        {
            //$this->db->where_in($where_in['where_column_name'], $where_in['ids']);

            foreach ($where_in as $key => $value) 
                $this->db->where_in($key, $value);
        }

        $this->db->select($columns, False);

        if ($hasUpdateDateField)
            $this->db->order_by('update_date', "ASC");

        if (count($order_by)>0)
        {
            foreach ($order_by as $key => $value) 
                $this->db->order_by($key, $value);
        }

        if($limit != '' && ($start != '' || $start == 0))
            $this->db->limit($limit, $start);

        if (count($like) > 0) 
        {
            $this->db->like($like[0], $like[1]);
            // foreach ($where_in as $key => $value) 
            //     $this->db->where_in($key, $value);
        }

        $query = $this->db->get($tbl_name);
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
        {
            $data['result'] = $query->result_array();
            //echo $this->db->last_query(); die;

            if($limit != '' && ($start != '' || $start == 0))
            {
                $count = $this->db->query('SELECT FOUND_ROWS() count')->row_array();

                $data['count'] = $count['count'];
            }
            
            return $data;
        }
        else
            return FALSE;
    }

    public function deleteRecord($tbl_name, $where)
    {
        $this->db->where($where);
        $this->db->delete($tbl_name); 
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;
        else
            return $this->db->affected_rows();
    }

    public function products($where=array(), $isRequestedProduct = false)
    {
        $this->db->select('product_id, product_name, product.meta_keyword, product.meta_title, product.meta_description, amazon_prd_id, flipkart_prd_id, product_category.category_id, description, mrp_price, category_name, hasVarient, name as brand_name, product.create_date, product.update_date, in_the_box, notes, isEnabled');
        $this->db->join('product_category', 'product.category_id = product_category.category_id', 'inner');
        $this->db->join('brand', 'product.brand_id = brand.brand_id', 'left');

        if (count($where)>0) {
            
            $this->db->where($where);
        }

        if ($this->last_updateDate) {
            
            $this->db->where(array('update_date >=' => $this->last_updateDate));
        }
        
        //product should not present in requested list
        if(!$isRequestedProduct) {

            $this->db->where('product_id NOT IN (SELECT req_prd_id FROM requested_product WHERE isLinked = 0)', null, false);
        }
        
        $this->db->order_by('update_date', 'ASC');

        // $sql = $this->db->get_compiled_select('product');
        // echo $sql; die;
        $query = $this->db->get('product');
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function merchantUserDetail($token)
    {
        $this->db->select('merchant_id, merchant.userId, auth_token, GROUP_CONCAT(type_name) AS roles');
        $this->db->join('merchant', 'merchant.userId = user.userId', 'inner');
        $this->db->join('user_type', 'user_type.usr_id = user.userId', 'inner');
        $this->db->where(array('auth_token' => $token));
        $query = $this->db->get('user');

        $isDbError = $this->dbError();
        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() == 1)  
            return $query->row_array();
        else
            return FALSE;
    }

    public function categoryAttribute($cat_id)
    {
        $this->db->select('att_name, attribute_name.att_id, mp_id');
        $this->db->join('category_attribute_mp', 'category_attribute_mp.att_id = attribute_name.att_id AND cat_id = '.$cat_id, 'left');
        $query = $this->db->get('attribute_name');
        $isDbError = $this->dbError();
        
        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    //need to remove as we already have categoryAttribute method for this
    public function categoryAttribute1($cat_id)
    {
        $this->db->select('att_name AS spec, attribute_name.att_id AS spec_id, "" AS spec_value, isEnabled AS enabled');
        $this->db->join('category_attribute_mp', 'category_attribute_mp.att_id = attribute_name.att_id AND cat_id = '.$cat_id, 'inner');
        $query = $this->db->get('attribute_name');
        $this->dbError();

        return $query->result_array();
    }

    public function categoryAttributes($cat_id, $prd_id=0)
    {
        if ($prd_id != 0) 
        {
            $join_where_clause = " AND category_attribute_value.prd_id = ".$prd_id;
            $where_clause = " AND category_attribute_mp.att_id NOT IN (SELECT product_varient.att_id FROM product_varient WHERE product_varient.prd_id = '$prd_id')";
        }
        else
        {
            $join_where_clause = '';
            $where_clause = '';
        }

        //select category att_id which are working as varients
        $sql = "SELECT attribute_name.att_name, attribute_name.att_id, category_attribute_value.att_value, category_attribute_mp.mp_id
                FROM `category_attribute_mp` 
                RIGHT JOIN attribute_name ON category_attribute_mp.att_id = attribute_name.att_id 
                LEFT JOIN category_attribute_value ON category_attribute_mp.mp_id = category_attribute_value.cat_att_mp_id".$join_where_clause."
                WHERE cat_id = ".$cat_id.$where_clause;
        $query = $this->db->query($sql);
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function productVarients($prd_id = "")
    {
        $this->db->select('vrnt_id, product_varient.att_id, att_value, att_name');
        $this->db->join('attribute_name', 'attribute_name.att_id = product_varient.att_id', 'left');
        
        if ($prd_id) 
            $this->db->where(array('prd_id' => $prd_id));

        $query = $this->db->get('product_varient');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function productTags($prd_id = "")
    {
        $this->db->select('product_tags.tag_id, tag_name');
        $this->db->join('tags', 'product_tags.tag_id = tags.tag_id', 'inner');
        
        if ($prd_id) 
            $this->db->where(array('prd_id' => $prd_id));

        $query = $this->db->get('product_tags');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function sellers($sel_id = "")
    {
        $where = '';
        if ($sel_id)
            $where = "WHERE merchant_id = ".$sel_id;
        
        $query = $this->db->query("SELECT merchant_id, merchant.userId, establishment_name, description, meta_keyword, meta_description, is_verified, is_completed, contact, business_days, business_hours, email, first_name, merchant.create_date, merchant.update_date, IF(merchant_logo, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', merchant_logo), '') as merchant_logo, IF(business_proof, CONCAT('".$this->config->item('site_url').SELLER_ATTATCHMENTS_PATH."', merchant_id, '/', business_proof), '') as business_proof, merchant.status, finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, replacement_available, replacement_terms, return_available, return_policy, seller_offering FROM merchant INNER JOIN user ON user.userId = merchant.userId ".$where);

        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function getProductsForLinking($sel_id=null, $where='')
    {
        $this->db->select('product.product_id, product_name, name as brand_name, mrp_price, sell_price as price, in_stock, product_listing.merchant_id, listing_id, product.create_date, product.update_date, in_the_box, atch_url, category_name, isVerified');

        $merchant_where = $sel_id ? 'AND merchant_id = '.$sel_id : '';
    
        $this->db->join('product_listing', 'product_listing.product_id = product.product_id '.$merchant_where, 'left');

        $this->db->join('brand', 'product.brand_id = brand.brand_id', 'left');
        $this->db->join('product_category', 'product.category_id = product_category.category_id', 'left');
        $this->db->join('attatchments', 'product.product_id = attatchments.link_id AND atch_for = "PRODUCT" AND atch_type = "IMAGE"', 'left');
        $this->db->group_by('product.product_id');


        if($sel_id == null) {
            $this->db->where('product.product_id NOT IN (SELECT req_prd_id FROM requested_product WHERE isLinked = 0)');
        } else {
            $this->db->where('product.product_id NOT IN (SELECT req_prd_id FROM requested_product WHERE isLinked = 0 AND merchant_id = '.$sel_id.')');
        }
        
        $query = $this->db->get('product');
        //echo $this->db->last_query(); die;

        $isDbError = $this->dbError();
        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function getAvailableProductsForOfferlink($mer_id)
    {
        $this->db->select('product.product_id, product_name, listing_id');
        $this->db->join('product_listing', 'product_listing.product_id = product.product_id AND merchant_id = '.$mer_id, 'inner');

        $query = $this->db->get('product');
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;   
    }

    public function getLinkedproductsToOffer($ofr_id, $mer_id)
    {
        $this->db->select('listing_id, lst_id as ofr_mp_lst_id, product_name');
        $this->db->join('offer_listing_mp', 'listing_id = lst_id AND ofr_id = '.$ofr_id, 'left');
        $this->db->join('product', 'product.product_id = product_listing.product_id', 'left');
        $this->db->where(array('merchant_id' => $mer_id));
        $query = $this->db->get('product_listing');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;   
    }

    public function productAttributes($prd_id)
    {
        $this->db->select('att_value AS value, att_name AS spec, attribute_name.att_id');
        $this->db->join('category_attribute_mp', 'cat_att_mp_id = mp_id', 'inner');
        $this->db->join('attribute_name', 'attribute_name.att_id = category_attribute_mp.att_id', 'inner');
        $this->db->where(array('prd_id' => $prd_id));
        $query = $this->db->get('category_attribute_value');
        
        $isDbError = $this->dbError();

        if ( isset($isDbError['db_error']) ) 
            return $isDbError;

        if ( $query->num_rows() > 0 )  
            return $query->result_array();
        else
            return FALSE;   
    }

    public function getProductListings($where, $like=array(), $limit='', $start='', $orderby='', $brand_ids=array(), $category_ids=array())
    {
        $this->db->select('
            SQL_CALC_FOUND_ROWS listing_id, 
            product_listing.merchant_id, 
            product_listing.product_id, 
            sell_price, 
            merchant_logo, 
            establishment_name, 
            product_listing.finance_available, 
            product_listing.finance_terms, 
            product_listing.home_delivery_available, 
            product_listing.home_delivery_terms, 
            product_listing.installation_available, 
            product_listing.installation_terms, 
            in_stock, 
            product_listing.replacement_available, 
            product_listing.replacement_terms, 
            product_listing.return_available, 
            product_listing.return_policy, 
            product_listing.seller_offering, 
            merchant.userId, 
            product_name, 
            mrp_price, 
            business_days, 
            business_hours, 
            product_listing.meta_description, 
            product_listing.meta_keyword', 
            FALSE
        );
        $this->db->join('merchant', 'merchant.merchant_id = product_listing.merchant_id', 'left');
        $this->db->join('product', 'product.product_id = product_listing.product_id', 'left');

        $this->db->where($where);

        if (count($brand_ids)>0) 
            $this->db->where_in('product.brand_id', $brand_ids);

        if (count($category_ids)>0) 
            $this->db->where_in('product.category_id', $category_ids);

        if (count($like) > 0) 
            $this->db->like($like[0], $like[1]);

        if($limit != '' && ($start != '' || $start == 0))
            $this->db->limit($limit, $start);

        switch ($orderby) 
        {
            case 'name_desc':
                $s_orderbyKey = 'product.product_name';
                $s_orderbyValue = 'desc';
                break;

            case 'name_asc':
                $s_orderbyKey = 'product.product_name';
                $s_orderbyValue = 'asc';
                break;

            case 'sell_price_asc':
                $s_orderbyKey = 'sell_price';
                $s_orderbyValue = 'asc';
                break;

            case 'sell_price_desc':
                $s_orderbyKey = 'sell_price';
                $s_orderbyValue = 'desc';
                break;
            
            default:
                $s_orderbyKey = 'product.product_name';
                $s_orderbyValue = 'asc';
                break;
        }

        $this->db->order_by($s_orderbyKey, $s_orderbyValue);

        $query = $this->db->get('product_listing');
        
        $isDbError = $this->dbError();
        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows()>0)  
        {
            $data['result'] = $query->result_array();

            if($limit != '' && ($start != '' || $start == 0))
            {
                $count = $this->db->query('SELECT FOUND_ROWS() count')->row_array();

                $data['count'] = $count['count'];
            }
            
            return $data;
        }
        else
            return FALSE;
    }

    public function getNearestAddress($where='')
    {
        $sql = "SELECT address_id , (3956 * 2 * ASIN(SQRT( POWER(SIN(( ".$_COOKIE['lat']." - latitude) *  pi()/180 / 2), 2) +COS( ".$_COOKIE['lat']." * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( ".$_COOKIE['long']." - longitude) * pi()/180 / 2), 2) ))) as distance from address ".$where." order by distance DESC";
        $query = $this->db->query($sql);
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function listingMerchants($listing_id)
    {
        $this->db->select('merchant.merchant_id, establishment_name, userId as user_id, contact, is_verified, business_days, business_hours, product_listing.update_date as last_updated, status AS enabled');
        $this->db->join('merchant', 'merchant.merchant_id = product_listing.merchant_id', 'left');
        $this->db->where(array('listing_id' => $listing_id));
        $query = $this->db->get('product_listing');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;   
    }

    public function listingProducts($where)
    {
        $this->db->select('product.product_id, product_name, description, sell_price, mrp_price, category_id, brand_id, product.isEnabled AS enabled');
        $this->db->join('product', 'product.product_id = product_listing.product_id', 'left');
        $this->db->where($where);
        $query = $this->db->get('product_listing');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;   
    }

    public function getUserAddress($where, $columns, $limit = '', $start = '')
    {
        $this->db->select($columns, false);
        $this->db->join('country', 'address.country_id = country.country_id', 'left');
        $this->db->join('state', 'state.state_id = address.state_id', 'left');
        $this->db->join('city', 'city.city_id = address.city_id', 'left');
        $this->db->join('merchant', 'address.userId = merchant.userId', 'left');

        if ($this->last_updateDate) 
            $where['address.update_date >= '] = $this->last_updateDate;

        if (count($where)>0)
            $this->db->where($where);

        $this->db->order_by('establishment_name', "ASC");

        if($limit != '' && ($start != '' || $start == 0))
            $this->db->limit($limit, $start);

        $this->db->order_by('address.update_date', "ASC");

        $query = $this->db->get('address');
        $isDbError = $this->dbError();

        if ($query->num_rows() > 0)  
        {
            $data['result'] = $query->result_array();

            if($limit != '' && ($start != '' || $start == 0))
            {
                $count = $this->db->query('SELECT FOUND_ROWS() count')->row_array();

                $data['count'] = $count['count'];
            }
            else
                $data['count'] = count($data['result']);
                   
            return $data;
        }
        else
            return FALSE;
    } 

    public function merchantReviews($where = array(), $limit = '', $start = '', $order_by=array())
    {
        $this->db->select('SQL_CALC_FOUND_ROWS review_id, rating, review, consumer.consumer_id, merchant_review.merchant_id, review_title, merchant_review.create_date as review_date, merchant_review.update_date as last_updated, first_name as consumer_name, consumer.userId as consumer_user_id, establishment_name as shop_name, merchant_review.status AS enabled, picture', FALSE);
        $this->db->join('merchant', 'merchant.merchant_id = merchant_review.merchant_id', 'left');
        $this->db->join('consumer', 'consumer.consumer_id = merchant_review.consumer_id', 'inner');
        $this->db->join('user', 'consumer.userId = user.userId', 'inner');

        if ($this->last_updateDate) 
            $where['merchant_review.update_date >='] = $this->last_updateDate;

        if (count($where))
            $this->db->where($where);

        if (count($order_by)>0)
        {
            foreach ($order_by as $key => $value) 
                $this->db->order_by($key, $value);
        }
        else
            $this->db->order_by('merchant_review.update_date', 'DESC');

        if($limit != '' && ($start != '' || $start == 0))
            $this->db->limit($limit, $start);

        $query = $this->db->get('merchant_review');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ( $query->num_rows() > 0 )  
        {
            $data['result'] = $query->result_array();

            if( $limit != '' && ( $start != '' || $start == 0 ) )
            {
                $count = $this->db->query('SELECT FOUND_ROWS() count')->row_array();

                $data['count'] = $count['count'];
            }
            
            return $data;
        }
        else
            return FALSE;
    }

    public function productReviews($where=array(), $limit='', $start='', $order_by=array())
    {
        $this->db->select('SQL_CALC_FOUND_ROWS review_id, rating, review, consumer.consumer_id, product_review.product_id, review_title, product_review.create_date as review_date, product_review.update_date as last_updated, first_name as consumer_name, product_name, product_review.status AS enabled, picture, ', FALSE);
        $this->db->join('product', 'product.product_id = product_review.product_id', 'left');
        $this->db->join('consumer', 'consumer.consumer_id = product_review.consumer_id', 'left');
        $this->db->join('user', 'consumer.userId = user.userId', 'left');

        if ($this->last_updateDate) 
            $where['product_review.update_date >= '] = $this->last_updateDate;

        if (count($where))
            $this->db->where($where);
        
        if (count($order_by)>0)
        {
            foreach ($order_by as $key => $value) 
                $this->db->order_by($key, $value);
        }
        else
            $this->db->order_by('product_review.update_date', 'DESC');

        $query = $this->db->get('product_review');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
        {
            $data['result'] = $query->result_array();

            if($limit != '' && ($start != '' || $start == 0))
            {
                $count = $this->db->query('SELECT FOUND_ROWS() count')->row_array();

                $data['count'] = $count['count'];
            }
            
            return $data;   
        }
        else
            return FALSE;
    }

    public function getConsumer($consumer_id)
    {
        $query = $this->db->query("SELECT user.userId as user_id, email, first_name as full_name, consumer_id, gender, phone, birthday, IF(picture, CONCAT('".$this->config->item('site_url').PROFILE_PIC_PATH."', picture), '') as profile_image, auth_token, status AS enabled FROM user inner JOIN consumer ON consumer.userId = user.userId AND consumer_id = ".$consumer_id);

        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->row_array();
        else
            return FALSE;
    }

    public function getSellerOffers($offer_id = '', $merchant_id = '')
    {
        $this->db->select('product_listing_offer.*, establishment_name');
        $this->db->join('merchant', 'product_listing_offer.merchant_id = merchant.merchant_id', 'left');

        if (!empty($merchant_id)) 
            $this->db->where(array('product_listing_offer.merchant_id' => $merchant_id));
        
        if (isset($_GET['status'])) 
            $this->db->where(array('product_listing_offer.current_status' => $_GET['status']));

        if (isset($_GET['seller'])) 
            $this->db->where(array('product_listing_offer.merchant_id' => $_GET['seller']));

        $query = $this->db->get('product_listing_offer');
        //echo $this->db->last_query(); die;
        $isDbError = $this->dbError();

        if ( isset($isDbError['db_error']) ) 
            return $isDbError;

        if ( $query->num_rows() > 0 )  
            return $query->result_array();
        else
            return FALSE;
    }

    public function getListingOffers($where)
    {
        $this->db->select('product.product_id, product.product_name, product_listing_offer.description, product_listing.merchant_id');
        $this->db->join('product_listing_offer', 'offer_id = ofr_id', 'left');
        $this->db->join('product_listing', 'lst_id = listing_id', 'left');
        $this->db->join('product', 'product.product_id = product_listing.product_id', 'left');

        if ($where) 
            $this->db->where($where);

        $query = $this->db->get('offer_listing_mp');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function getRequestedProduct($where = '')
    {
        $this->db->select('request_id, requested_product.req_prd_id, req_lst_id, requested_product.merchant_id, brand_name, refer_link, isLinked, requested_product.product_name, requested_product.description, mrp_price AS prd_price, category_id, brand_id, in_the_box, sell_price, finance_available, finance_terms, home_delivery_available, home_delivery_terms, installation_available, installation_terms, in_stock, will_back_in_stock_on, replacement_available, replacement_terms, return_available, return_policy, seller_offering, product_listing.merchant_id as linkedMerchantId');
        $this->db->join('product_listing', 'listing_id = req_lst_id', 'left');
        $this->db->join('product', 'product.product_id = requested_product.req_prd_id', 'left');

        if ($where) 
            $this->db->where($where);

        $query = $this->db->get('requested_product');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function getRequestedProductsAvailableForLinking($where = '')
    {
        $this->db->select('request_id, requested_product.req_prd_id, req_lst_id, requested_product.merchant_id, brand_name, refer_link, isLinked, requested_product.product_name, requested_product.description, mrp_price AS prd_price, category_id, brand_id, in_the_box');
        // $this->db->join('product_listing', 'listing_id = req_lst_id AND product_listing.merchant_id != '.$_COOKIE['merchant_id'], 'left');
        // $this->db->where('product_id NOT IN (SELECT product_id FROM product_listing WHERE product_listing.merchant_id = '.$_COOKIE['merchant_id'].')', null, false);
        $this->db->join('product', 'product.product_id = requested_product.req_prd_id', 'left');

        if ($where) 
            $this->db->where($where);

        $query = $this->db->get('requested_product');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function claimedRequest($req_id='')
    {
        $this->db->select('clmd_email, clmd_name, clmd_contact, clmd_message, clmd_business_proof, clmd_business_proof, establishment_name, merchant_id, clmd_id, claimed_requests.create_date, claimed_requests.update_date, is_clmd_approved, userId');
        $this->db->join('merchant', 'clmd_merchant_id = merchant_id', 'left');

        if ($req_id) 
            $this->db->where(array('clmd_id' => $req_id));

        $query = $this->db->get('claimed_requests');
        
        $isDbError = $this->dbError();

        if (isset($isDbError['db_error'])) 
            return $isDbError;

        if ($query->num_rows() > 0)  
            return $query->result_array();
        else
            return FALSE;
    }

    public function deleteOffering($merchant_id, $ids)
    {
        $this->db->query("DELETE FROM merchant_offering WHERE merchant_id = ".$merchant_id." AND offering_id NOT IN (".implode(',',$ids).")");

        return true;
    }

    public function getCategoriesHavingProduct($merchant_id='', $brand_id='')
    {
        $s_sql = "SELECT
                    product_category.*,
                    category_name,
                    COUNT(product.product_id) AS productCnt
                FROM product_category
                INNER JOIN product
                    ON product.category_id = product_category.category_id ";

        if ($merchant_id) 
        {
            $s_sql .= "INNER JOIN product_listing
                        ON 
                            product_listing.product_id = product.product_id AND 
                            merchant_id = ".$merchant_id;
        }
        else if ($brand_id) 
        {
            $s_sql .= " AND brand_id = ".$brand_id;
        }

        $s_sql .= " WHERE has_parent = 1
                    GROUP BY product_category.category_id 
                    ORDER BY category_name ASC";

        $a_sql = $this->db->query($s_sql);

        return $a_sql->result_array();
    }

    public function getBrandHavingProduct($merchant_id='')
    {
        $s_sql = "SELECT
                    brand.brand_id,
                    brand.name,
                    COUNT(product.product_id) AS productCnt
                FROM brand
                INNER JOIN product
                    ON product.brand_id = brand.brand_id ";

        if ($merchant_id) 
        {
            $s_sql .= " INNER JOIN product_listing
                        ON product_listing.product_id = product.product_id AND merchant_id = ".$merchant_id;
        }
        
        $s_sql .= " GROUP BY brand.brand_id
                    ORDER BY name ASC";

        $a_sql = $this->db->query($s_sql);

        return $a_sql->result_array();
    }

    public function insert_batch($table_name, $data)
    {
        $this->db->insert_batch($table_name, $data); 
        $isDbError = $this->dbError();
        if (isset($isDbError['db_error'])) 
            return $isDbError;
        else
            return false;
    }

    public function update_batch($table_name, $data, $where)
    {
        $this->db->update_batch($table_name, $data, $where); 
        $isDbError = $this->dbError();
        if (isset($isDbError['db_error'])) 
            return $isDbError;
        else
            return false;
    }

    public function dbError()
    {
        try 
        {
            $db_error = $this->db->error();

            if ($db_error['message']) 
                throw new Exception();
            else
                return TRUE;
        } 
        catch (Exception $e) 
        {
            $arrayResponse['db_error'] = TRUE;
            $arrayResponse['code'] = $db_error['message'];
            $arrayResponse['msg'] = str_replace("'", "", $db_error['code']);

            if ($this->controller_name == 'admin_controller') 
                return $arrayResponse;
            else
            {
                echo json_encode($arrayResponse);
                die;
            }
        }
    }
}
