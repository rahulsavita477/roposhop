<?php
$seller_page = $brand_page = $products_page = $place_management = $seller_management = $product_seller_linking = $product_linking = $countryManagement = $stateManagement = $cityManagement = $areaManagement = $userManagement = $offerManagement = $requestProduct = $merchantReview = $productReview = $review = $data_import_export = $productExcel = $merchantExcel = $listingExcel = $addressExcel = $siteSettings = $claimed_request = $countryExcel = $stateExcel = $cityExcel = $areaExcel = $maintenance = $sellerOfferings = $list_new_product = '';

// $parse_url = parse_url($_SERVER['REQUEST_URI']);
// $url = explode('/', $_SERVER['REQUEST_URI']);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = explode('/', trim($path, '/'));

$dashboard_page = in_array("dashboard", $url) ? "active" : '';
$sellerServicePolicyScreen = in_array("service_policy", $url) ? "active" : '';
$sellerProfileScreen = in_array("merchantSignupStep2", $url) ? "active" : '';
$category_page = (in_array("category", $url) || in_array("addCategory", $url) || in_array("editCategory", $url)) ? "active" : "";
$attributes_page = (in_array("attributes", $url) || in_array("addAttribute", $url) || in_array("editAttribute", $url)) ? "active" : "";
$address_management = ((isset($_GET['user_id']) || isset($_GET['address_id'])) && $_COOKIE['site_code'] == 'seller') ? "active" : "";

if (in_array("sellersTable", $url) || in_array("sellersList", $url) || in_array("addSeller", $url) || in_array("seller", $url) || in_array("listings", $url) || in_array("getProductDetail", $url) || isset($_GET['user_id']) || isset($_GET['address_id']) || in_array("viewRequest", $url))
{
    $seller_page = "active";

    if (in_array("listings", $url) && in_array("add", $url)) {
        
        $list_new_product = 'active';
        $product_linking = 'active';

    } elseif (in_array("sellersList", $url) || in_array("listings", $url) || in_array("getProductDetail", $url)) {
        
        $product_seller_linking = 'active';
        $product_linking = 'active';

    } elseif (in_array("sellersTable", $url) || in_array("addSeller", $url) || in_array("seller", $url) || isset($_GET['user_id']) || isset($_GET['address_id'])) {
        $seller_management = 'active';
    }
} elseif (in_array("brand", $url) || in_array("addBrand", $url) || in_array("editBrand", $url)) {
    $brand_page = "active";
} elseif (in_array("products", $url) || in_array("addProduct", $url) || in_array("editProduct", $url) || isset($_GET['cat']) || in_array("insertProduct", $url)) {
    $products_page = "active";
}
elseif (in_array("countryManagement", $url) || in_array("stateManagement", $url) || in_array("editCountry", $url) || in_array("addCountry", $url) || (isset($_GET['getStateList']) && $parse_url['path'] != '/stateExcel') || isset($_GET['addNewState']) || in_array('cityManagement', $url) || (isset($_GET['getCityList']) && $parse_url['path'] != '/cityExcel') || isset($_GET['addNewCity']) || in_array("areaManagement", $url) || ((isset($_GET['getAreaList'])) && $parse_url['path'] != '/areaExcel') || isset($_GET['addNewArea'])) 
{
    $place_management = "active";

    if (in_array("countryManagement", $url) || in_array("addCountry", $url) || in_array("editCountry", $url))
        $countryManagement = "active";
    elseif (in_array("stateManagement", $url) || isset($_GET['getStateList']) || isset($_GET['addNewState']))
        $stateManagement = "active";
    elseif (in_array("cityManagement", $url) || isset($_GET['getCityList']) || isset($_GET['addNewCity']))
        $cityManagement = "active";
    elseif (in_array("areaManagement", $url) || isset($_GET['getAreaList']) || isset($_GET['addNewArea'])) 
        $areaManagement = "active";
}
elseif (in_array("userManagement", $url) || in_array("addUser", $url) || isset($_GET['user_type']) || in_array("editUser", $url))
    $userManagement = "active";
elseif (in_array("claimedRequest", $url) || in_array("viewClaimRequest", $url)) {
    $claimed_request = 'active';
} elseif ( in_array("offerManagement", $url) || in_array("addOffer", $url) || isset($_GET['ofr_id']) || in_array("editOffer", $url) || in_array("offers", $url) )
    $offerManagement = "active";
elseif (in_array("review", $url) || in_array("merchantReview", $url) || in_array("editReview", $url) || in_array("viewReview", $url))
{
    $review = "active";
    if (in_array("merchant", $url) || in_array("merchantReview", $url))
        $merchantReview = 'active';
    elseif (in_array("product", $url))
        $productReview = 'active';
}
elseif (in_array("requestProduct", $url) || in_array("fillListingDetailOfRequestedProduct", $url) || in_array("requestedProducts", $url) || in_array("merchantRequestedProducts", $url) || in_array("editRequestedProduct", $url) || isset($_GET['req_prd_id']))
    $requestProduct = "active";
elseif (isset($_SERVER['REDIRECT_URL']) && (strpos("/productExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/merchantExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/addressExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/listingExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/countryExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/stateExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/cityExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/areaExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/importAddressXls", $_SERVER['REDIRECT_URL']) !== false))
{
    $data_import_export = "active";
    if (strpos("/productExcel", $_SERVER['REDIRECT_URL']) !== false)
        $productExcel = 'active';
    elseif (strpos("/merchantExcel", $_SERVER['REDIRECT_URL']) !== false)
        $merchantExcel = 'active';
    elseif (strpos("/addressExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/importAddressXls", $_SERVER['REDIRECT_URL']) !== false)
        $addressExcel = 'active';
    elseif (strpos("/listingExcel", $_SERVER['REDIRECT_URL']) !== false)
        $listingExcel = 'active';
    elseif (strpos("/countryExcel", $_SERVER['REDIRECT_URL']) !== false)
        $countryExcel = 'active';
    elseif (strpos("/stateExcel", $_SERVER['REDIRECT_URL']) !== false)
        $stateExcel = 'active';
    elseif (strpos("/cityExcel", $_SERVER['REDIRECT_URL']) !== false)
        $cityExcel = 'active';
    elseif (strpos("/areaExcel", $_SERVER['REDIRECT_URL']) !== false)
        $areaExcel = 'active';
}
elseif (in_array("siteSettings", $url))
    $siteSettings = 'active';
elseif (in_array("claimedRequests", $url))
    $claim_requests = 'active';
elseif (in_array("maintenance", $url))
    $maintenance = 'active';
elseif (in_array("offerings", $url)) {
    $sellerOfferings = 'active';
}

$usr_profile_pic = $shop_logo = $this->config->item('site_url').'assets/admin/img/avatar3.png';

if (isset($_COOKIE['image']))
    $usr_profile_pic = $_COOKIE['image'];

if (isset($_COOKIE['shop_logo']))
    $shop_logo = $_COOKIE['shop_logo'];    
?>

<style type="text/css">
.sidebar{
    max-height: calc(100vh - 5rem);
    overflow-y: auto;
}
</style>

<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php if ($_COOKIE['site_code'] == "admin") { ?>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <!-- dashboard -->
                    <li class="<?= $dashboard_page ?>">
                        <a href="<?= base_url('dashboard') ?>">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- category -->
                    <li class="<?= $category_page ?>">
                        <a href="<?= base_url('category') ?>">
                            <i class="fa fa-sitemap"></i> <span>Category</span>
                        </a>
                    </li>

                    <!-- attributes -->
                    <li class="<?= $attributes_page ?>">
                        <a href="<?= base_url('page/attributes') ?>">
                            <i class="fa fa-list-ul"></i> <span>Attributes</span>
                        </a>
                    </li>

                    <!-- brand -->
                    <li class="<?= $brand_page ?>">
                        <a href="<?= base_url('brand') ?>">
                            <i class="fa fa-bookmark"></i> <span>Brand</span>
                        </a>
                    </li>

                    <!-- products -->
                    <li class="<?= $products_page ?>">
                        <a href="<?= base_url('products') ?>">
                            <i class="fa fa-archive"></i> <span>Product</span>
                        </a>
                    </li>

                    <style type="text/css">
                    .sidebar .sidebar-menu .active .treeview-menu {
                        display: block;
                    }
                    </style>

                    <!-- seller -->
                    <li class="treeview <?= $seller_page ?>" id="treeview1" onclick="openTreeView('#treeview1');">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>Seller</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $seller_management ?>">
                                <a href="<?= base_url('sellers/sellersTable') ?>">
                                    <i class="fa fa-briefcase"></i>
                                    Seller Management
                                </a>
                            </li>
                            <li class="<?= $product_seller_linking ?>">
                                <a href="<?= base_url('listings') ?>">
                                    <i class="fa fa-list-alt"></i>
                                    Product Listing
                                </a>
                            </li>
                            <li class="<?= $list_new_product ?>">
                                <a href="<?= base_url('listings/add') ?>">
                                    <i class="fa fa-plus"></i>
                                    List New Product
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- user management -->
                    <li class="<?= $userManagement ?>">
                        <a href="<?= base_url('page/userManagement') ?>">
                            <i class="fa fa-user"></i> <span>User Management</span>
                        </a>
                    </li>

                    <!-- review -->
                    <li class="treeview <?= $review ?>" id="treeview3" onclick="openTreeView('#treeview3');">
                        <a href="#">
                            <i class="fa fa-comments-o"></i>
                            <span>Review</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $merchantReview ?>">
                                <a href="<?= base_url('review/merchant') ?>">
                                    <i class="fa fa-thumbs-up"></i> 
                                    Merchant
                                </a>
                            </li>
                            <li class="<?= $productReview ?>">
                                <a href="<?= base_url('review/product') ?>">
                                    <i class="fa fa-star"></i> 
                                    Product
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- claimed request management -->
                    <li class="<?= $claimed_request ?>">
                        <a href="<?= base_url('page/claimedRequest') ?>">
                            <i class="fa fa-check-square-o"></i>
                            Claimed Request
                        </a>
                    </li>

                    <!-- Requested product management -->
                    <li class="<?= $requestProduct ?>">
                        <a href="<?= base_url('page/requestedProducts') ?>">
                            <i class="fa fa-shopping-cart"></i> <span>Requested Products</span>
                        </a>
                    </li>

                    <!-- offer management -->
                    <li class="<?= $offerManagement ?>">
                        <a href="<?= base_url('sellers/offers') ?>">
                            <i class="fa fa-gift"></i> <span>Offer Management</span>
                        </a>
                    </li>
                    
                    <!-- place -->
                    <li class="treeview <?= $place_management ?>" id="treeview2" onclick="openTreeView('#treeview2');">
                        <a href="#">
                            <i class="fa fa-globe"></i>
                            <span>Place Management</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <!-- <li class="<?= $countryManagement ?>">
                                <a href="<?= base_url('page/countryManagement') ?>">
                                    <i class="fa fa-flag"></i> 
                                    Country Management
                                </a>
                            </li> -->

                            <li class="<?= $stateManagement ?>">
                                <a href="<?= base_url('page/stateManagement') ?>">
                                    <i class="fa fa-globe"></i> 
                                    State Management
                                </a>
                            </li>

                            <li class="<?= $cityManagement ?>">
                                <a href="<?= base_url('page/cityManagement') ?>">
                                    <i class="fa fa-home"></i>
                                    City Management
                                </a>
                            </li>

                            <li class="<?= $areaManagement ?>">
                                <a href="<?= base_url('page/areaManagement') ?>">
                                    <i class="fa fa-location-arrow"></i>
                                    Area Management
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- review -->
                    <li class="treeview <?= $data_import_export ?>" id="treeview4" onclick="openTreeView('#treeview4');">
                        <a href="#">
                            <i class="fa fa-exchange"></i>
                            <span>Import/Export</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $productExcel ?>">
                                <a href="<?= base_url('productExcel') ?>">
                                    <i class="fa fa-archive"></i> 
                                    Product
                                </a>
                            </li>
                            <li class="<?= $merchantExcel ?>">
                                <a href="<?= base_url('merchantExcel') ?>">
                                    <i class="fa fa-user"></i> 
                                    Merchant
                                </a>
                            </li>
                            <li class="<?= $listingExcel ?>">
                                <a href="<?= base_url('listingExcel') ?>">
                                    <i class="fa fa-th-list"></i> 
                                    Listing
                                </a>
                            </li>
                            <li class="<?= $addressExcel ?>">
                                <a href="<?= base_url('addressExcel') ?>">
                                    <i class="fa fa-envelope"></i> 
                                    Address
                                </a>
                            </li>
                            <!-- <li class="<?= $countryExcel ?>">
                                <a href="<?= base_url('countryExcel') ?>">
                                    <i class="fa fa-flag"></i> 
                                    Country
                                </a>
                            </li> -->
                            <!-- <li class="<?= $stateExcel ?>">
                                <a href="<?= base_url('stateExcel') ?>">
                                    <i class="fa fa-globe"></i> 
                                    State
                                </a>
                            </li> -->
                            <!-- <li class="<?= $cityExcel ?>">
                                <a href="<?= base_url('cityExcel') ?>">
                                    <i class="fa fa-home"></i> 
                                    City
                                </a>
                            </li> -->
                            <li class="<?= $areaExcel ?>">
                                <a href="<?= base_url('areaExcel') ?>">
                                    <i class="fa fa-location-arrow"></i> 
                                    Area
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- site settings -->
                    <li class="<?= $siteSettings ?>">
                        <a href="<?= base_url('page/siteSettings') ?>">
                            <i class="fa fa-cogs"></i> <span>Settings</span>
                        </a>
                    </li>

                    <!-- site maintenance -->
                    <!-- <li class="<?= $maintenance ?>">
                        <a href="<?= base_url('page/maintenance') ?>">
                            <i class="fa fa-wrench"></i> <span>Maintenance</span>
                        </a>
                    </li> -->
                </ul>
            </section>
        </aside>
    <?php } else { ?>
        <aside class="left-side sidebar-offcanvas">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <!-- dashboard -->
                    <li class="<?= $dashboard_page ?>">
                        <a href="<?= base_url('dashboard') ?>">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- product linking -->
                    <li class="<?= $product_linking ?>">
                        <a href="<?= base_url('listings') ?>">
                            <i class="fa fa-th-list"></i> 
                            Product Listing
                        </a>
                    </li>

                    <!-- request for product -->
                    <li class="<?= $requestProduct ?>">
                        <a href="<?= base_url('page/merchantRequestedProducts') ?>">
                            <i class="fa fa-shopping-cart"></i> <span>Request Product</span>
                        </a>
                    </li>

                    <!-- view review -->
                    <li class="<?= $merchantReview ?>">
                        <a href="<?= base_url('page/merchantReview') ?>">
                            <i class="fa fa-comments"></i> <span>Seller Review</span>
                        </a>
                    </li>

                    <!-- offer management -->
                    <li class="<?= $offerManagement ?>">
                        <a href="<?= base_url('page/offerManagement') ?>">
                            <i class="fa fa-gift"></i> <span>Offer Management</span>
                        </a>
                    </li>

                    <li class="<?= $sellerOfferings ?>">
                        <a href="<?= base_url('page/offerings') ?>">
                            <i class="fa fa-tags"></i>Seller Offerings
                        </a>
                    </li>

                    <!-- seller default values -->
                    <li class="<?= $sellerServicePolicyScreen ?>">
                        <a href="<?= base_url('page/service_policy') ?>">
                            <i class="fa fa-shield"></i>Global Service & Policy
                        </a>
                    </li>

                    <!-- Address management -->
                    <li class="<?= $address_management ?>">
                        <a href="<?= base_url().'page/addressManagement?user_id='.$_COOKIE['user_id'].'&merchant_id='.$_COOKIE['merchant_id'] ?>">
                            <i class="fa fa-home"></i> 
                            Shop Address
                        </a>
                    </li>

                    <li class="<?= $sellerProfileScreen ?>">
                        <a href="<?= base_url('merchantSignupStep2/'.$_COOKIE['user_id'].'/'.$_COOKIE['merchant_id']) ?>" target="_blank">
                            <i class="fa fa-user"></i> Seller Profile
                        </a>
                    </li>
                </ul>
            </section>
        </aside>
    <?php } ?>

    <script>
    function openTreeView(id) {
        $(id).addClass('active');
    }
    </script>
