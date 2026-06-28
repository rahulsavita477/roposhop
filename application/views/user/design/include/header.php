<?php 
$seller_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://").'seller.'.str_replace("seller.", "", $_SERVER['HTTP_HOST']); 
$seller_url = str_replace("www.", "", $seller_url); 
$site_url = str_replace("seller.", "", $seller_url);
$meta_title = isset($meta_data['title']) ? $meta_data['title'] : "";
$meta_description = isset($meta_data['description']) ? $meta_data['description'] : "";
$meta_keywords = isset($meta_data['keywords']) ? $meta_data['keywords'] : "";
$meta_image = isset($meta_data['image']) ? $meta_data['image'] : "";
$current_page_url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if (isset($_COOKIE['location']) && $_COOKIE['location'] != '') 
    $location = $_COOKIE['location'];
else
    $location = 'Location Setting';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $meta_title ?></title>

    <meta name="description" content="<?= $meta_description ?>" />
    <meta name="keywords" content="<?= $meta_keywords ?>" />
    
    <meta property="og:title" content="<?= $meta_title ?>" />
    <meta property="og:description" content="<?= $meta_description ?>" />
    <meta property="og:image" content="<?= $meta_image ?>" />
    <meta property="og:url" content="<?= $current_page_url ?>" />
    <meta property="og:type" content="website" />

    <meta name="twitter:title" content="<?= $meta_title ?>" />
    <meta name="twitter:description" content=" <?= $meta_description ?>" />
    <meta name="twitter:image" content=" <?= $meta_image ?>" />
    <meta name="twitter:card" content="<?= $current_page_url ?>" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $this->config->item('site_url').'assets/favicon.ico' ?>" />

    <script src="<?= $_SERVER['REQUEST_SCHEME'] ?>://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-29056639-44"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-29056639-44');
    </script>
    
    <?php include('css.php'); ?>
</head>

<header class="header">
    <div id="divLoading1" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8; display: none;">
        <p style="position: absolute; top: 50%; left: 45%;">
            <img src="<?= $this->config->item('site_url').'assets/admin/img/ajax-loader1.gif' ?>" />
        </p>
    </div>
            
    <?php if (SITE_ENVIRONMENT != '') { ?>
        <div>
            <div class="container">
                <div class="info-box">
                    <div class="info-box-content">
                        <h4><b>ENVIRONMENT : <?= SITE_ENVIRONMENT ?></b></h4>
                    </div><!-- End .info-box-content -->
                </div><!-- End .info-box -->
            </div><!-- End .container -->
        </div><!-- End .info-boxes-container -->
    <?php } ?>

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <a href="<?= $site_url ?>" class="logo">
                    <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/logo.png' ?>" alt="RopoShop" width="180">
                </a>

            </div><!-- End .header-left -->

            <div class="header-center">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                    <form action="<?= $site_url.'/search' ?>" method="get">
                        <div class="header-search-wrapper">
                            <!-- <div class="select-custom">
                                   <i class="fa fa-angle-down srt"></i>
                                <select id="cat" name="cat">
                                <option value="">Everyting</option>
                                <option value="">Products</option>
                                <option value="">Categories</option>
                                <option value="">Brands</option>
                                <option value="">Sellers</option>
                                <option value="">Offers</option>
                                </select>
                            </div> --><!-- End .select-custom -->
                            <input type="search" class="form-control" name="str" placeholder="Search: Product, Brand, Seller, Offer" value="<?= isset($_GET['str']) ? $_GET['str'] : '' ?>" required>
                           
                            <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div><!-- End .headeer-center -->

            <div class="header-right">
                <button class="mobile-menu-toggler" type="button">
                    <i class="icon-menu"></i>
                </button>
                <div class="header-contact">
                   <a href="<?= $seller_url.'/merchantLoginSignup' ?>" class="btn-warning btn-custom">Free Listing</a>&nbsp;
                   <a href="<?= $site_url.'/#app' ?>" class="btn-primary btn-custom">App</a>&nbsp;
                   <a href="<?= $site_url.'/location_setting' ?>" class="btn-danger btn-custom" id="location"><i class="fa fa-map-marker"></i> &nbsp; <?= $location ?></a>&nbsp;

                    <?php
                    if (!isset($_COOKIE['consumer_id'])) 
                    {
                        echo "<a href='".$site_url."/userLogin' class='btn-success btn-custom'>Login</a>&nbsp;";
                    }
                    else
                    {
                        echo "<a href='".$site_url."/userProfile' class='btn-info btn-custom'><i class='icon-user'></i></a>&nbsp;";
                        echo "&nbsp;<a href='".$site_url."/userLogout' class='btn-default btn-custom' title='logout'><i class='fas fa-power-off'></i></a>";   
                    }
                    ?>        
                </div>
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

    <div class="header-bottom sticky-header">
        <div class="container">
            <nav class="main-nav" >
                <ul class="menu sf-arrows">
                    <?php 
                    foreach ($tree_list as $category) 
                    {
                        echo '<li><a href="#" class="sf-with-ul">'.$category['category_name'].'</a><ul>';

                            foreach ($category['child_category'] as $key => $child_category)
                            {
                                if($key == 0)
                                    echo '<li><a href="'.base_url('categories/'.url_title($category['category_name'], '-', true).'?category=').$category['category_id'].'">ALL IN '.$category['category_name'].'</a></li>';

                                echo '<li><a href="'.base_url('categories/'.url_title($child_category['category_name'], '-', true).'?category=').$child_category['category_id'].'">'.$child_category['category_name'].'</a></li>';
                            }

                        echo '</ul></li>';
                    } 
                    ?>  

                    <li><a href="<?= $site_url ?>/brands">Brands</a></li>
                    <li><a href="<?= $site_url ?>/merchants">Sellers</a></li>
                </ul>
            </nav>
        </div><!-- End .header-bottom -->
    </div><!-- End .header-bottom -->
</header>