<?php 
$avg_rating = ($product['rating_info']['avg_rating']) ? $product['rating_info']['avg_rating'] : 0;
$rating_count = ($product['rating_info']['rating_count']) ? $product['rating_info']['rating_count'] : 0;
$one_star = $product['rating_info']['rating_count_1_star'];
$two_star = $product['rating_info']['rating_count_2_star'];
$three_star = $product['rating_info']['rating_count_3_star'];
$four_star = $product['rating_info']['rating_count_4_star'];
$five_star = $product['rating_info']['rating_count_5_star'];
$avg_rating_width = ($avg_rating*100)/5;

if ($rating_count) 
{
    $five_star_width = ($five_star*100)/$rating_count;
    $four_star_width = ($four_star*100)/$rating_count;
    $three_star_width = ($three_star*100)/$rating_count;
    $two_star_width = ($two_star*100)/$rating_count;
    $one_star_width = ($one_star*100)/$rating_count;
}
else
    $five_star_width = $four_star_width = $three_star_width = $two_star_width = $one_star_width = 0;
?>

<style type="text/css" media="screen">
html {
    scroll-behavior: smooth;
}

.product-default:hover figure {
    box-shadow:none;
}

.color-change {
    color: #08c !important;
}

#pro-img .product-default img {
    height: 150px;
    width: auto;
    margin: 0 auto;
}

#scs button.owl-prev, #scs button.owl-next{
    width: 20px !important;
    height: 20px !important;
}

.fa-star{
    color:#000;
}

.ratt {
    position: absolute;
    margin: -4px 18px 0px;
}

.ratt:hover{
    color: #fff;
}

.ratt:hover .fa-star {
    color: #1278bd;
}

a.text-active {
    color: #08c;
}

.rating-left {
    float: left;
    position: absolute;
    top: 5px;
    left: 5px;
    font-size: 10px;
    color: #fff;
    padding: 2px;
}

.fa-star {
    color: #fff;
}

.fa-star {
    color: #fff;
}

.widget-body button.owl-next{
    background:transparent !important;
}

.widget-body button.owl-prev{
    background:transparent !important;
}

h2.product-title.text-black {
    text-align: left;
}

.featured-col a:hover{
    text-decoration: none;
}

.form-control{
    max-width: 100%;
}

textarea.form-control{
    max-width: 100%;
}

.s {
    font-size: 14px;
    padding: 4px;
    margin: 0px;
    color: #fff;
}

.product-default:hover{
  border:none;
}

.product-filters-container {
    padding-left: 5px;
}

.price-box {
    text-align: left !important;
    font-weight: 600;
    font-size: 17px;
    color: #000;
    margin: 0px;
    padding-left: 5px;
}

.under-l:before {
    content: '';
    left: 10px;
}

.under-l:after {
    content: '';
    left: 10px;
}

.hi{
    display: none;
}

.height-100{
    height: 100px;
}

.viewSection a{
    color: #08c;
    font-weight: bold;
}

#rating_text{
    color: #08c;
    text-decoration: none;
    pointer-events: none;
}
</style>

<body id="page-details" class="loaded">
    <div class="page-wrapper">
        <main class="main">
            <div class="container">
                <ol class="breadcrumb mt-0 mb-2">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
                    <?php if (isset($_GET['category'])) { ?>
                        <li class="breadcrumb-item"><a href="<?= base_url('products?category='.$_GET['category']) ?>">Products</a></li>
                    <?php } 
                    elseif (isset($_GET['prd_id'])) { ?>
                        <li class="breadcrumb-item"><a href="<?= base_url('products') ?>">Products</a></li>
                    <?php } ?>

                    <li class="breadcrumb-item"><a href="#" class="text-active">Product Detail</a></li>
                </ol>
                    
                <div class="product-single-container product-single-default">
                    <div class="row">
                        <div class="col-lg-5 product-single-gallery">
                            <div class="sticky-slider">
                                <div class="product-slider-container product-item">
                                    <div class="product-single-carousel owl-carousel">
                                        <?php
                                        if(isset($product['images']) && isset($product['product_name'])) {
                                            
                                            foreach ($product['images'] as $key => $imgs) {

                                                echo '<div class="product-item">
                                                        <img
                                                            style="width: auto;
                                                                max-width: 343px;
                                                                margin-left: auto;
                                                                margin-right: auto;
                                                                height: auto;
                                                                max-height: 400px;"
                                                            class="product-single-image"
                                                            src="'.$imgs.'"
                                                            data-zoom-image="'.$imgs.'"
                                                            alt="'.$product['product_name'].'_'.$key.'" />
                                                    </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <!-- End .product-single-carousel -->
                                    <span class="prod-full-screen">
                                        <i class="icon-plus"></i>
                                    </span>
                                </div>

                                <div class="prod-thumbnail row owl-dots transparent-dots" id='carousel-custom-dots'>
                                    <?php if(isset($product['images']) && isset($product['product_name'])) {
                                        
                                        foreach ($product['images'] as $imgs) {
                                            
                                            echo '<div class="owl-dot">
                                                    <img
                                                        style="
                                                            width: auto;
                                                            max-width: 80px;
                                                            margin-left: auto;
                                                            margin-right: auto;
                                                            height: auto;
                                                            max-height: 80px;"
                                                        src="'.$imgs.'"
                                                        alt="'.$product['product_name'].'_'.$key.'" />
                                                </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="product-single-details">
                                <h2 class="product"><?= isset($product['product_name']) ? $product['product_name'] : '' ?></h2>
                                <div class="ratings-container">
                                    <a href="<?= base_url('product/rating/').$_GET['prd_id'] ?>">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:<?= $avg_rating_width ?>%"></span>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <?php if ($product['key_features']): ?>
                            <div class="product-filters-container pt-2">
                                <ul class="productFeatures_ul">
                                    <?php foreach ($product['key_features'] as $feature) {
                                        echo "<li>".$feature."</li>";
                                    } ?>
                                </ul>
                            </div><!-- End .product-filters-container -->
                            <?php endif; ?>

                            <table class="table table-bordered mt-1 mb-0">
                                <tbody>
                                    <tr><th colspan="2">Product Details</th></tr>
                                    <tr>
                                        <td>Brand</td>
                                        <td>
                                            <?= isset($product['brand_name']) && $product['brand_name'] ? $product['brand_name'] : '' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>In the box</td>
                                        <td>
                                            <?= isset($product['in_the_box']) && $product['in_the_box'] ? $product['in_the_box'] : '' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>MRP</td>
                                        <td>
                                            <?= isset($product['mrp_price']) && $product['mrp_price'] ? currency_format($product['mrp_price']) : '' ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <a class="small-brand" href="<?= base_url('brands/'.$product['brand_name'].'?brand_id='.$product['brand_id']) ?>" style="text-decoration: none;">
                                <?php if($product['brand_logo']): ?>
                                    <img style="max-height: 50px" class="img-fluid" src="<?= $product['brand_logo'] ?>" alt="brand_logo" />
                                <?php else: ?>
                                    <div style="display:inline-block;
                                        background:#007BFF;
                                        border-radius:8px;
                                        text-decoration:none;
                                        padding:5px 15px;
                                        box-sizing:border-box;
                                        color:#fff;
                                        margin:5px 0px 0px 0px;
                                        font-size:14px;
                                        font-weight:600;"
                                    ><?= $product['brand_name'] ?></div>
                                <?php endif; ?>
                            </a>
                        </div><!-- End .product-single-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
                     
                <div class="featured-products-section carousel-section">
                    <?php if($product['sold_by_merchants']): ?>
                    <div class="container pb-5">
                        <h2 class="h3 title float-left">Offered By</h2>
                        <div class="under-l"></div>
                        <!-- <a href="#" class="float-right rounded-btn">View All</a> -->
                        <div class="clearfix"></div>
                        <div class="partners-container pb-0 pt-5">
                            <div class="container pl-0 pr-0">
                                <div class="partners-carousel owl-carousel owl-theme min-123 pl-0 pr-0" data-toggle="owl" data-owl-options="{
                                    'loop': false,
                                    'margin': 10,
                                    'autoplayHoverPause' : true,
                                    'nav' : true,
                                    'items': 1,
                                    'autoplayTimeout': 2000,
                                    'responsive': {
                                        '559': {
                                            'items': 2
                                        },
                                        '975': {
                                            'items': 5
                                        }
                                    }
                                }">
                                    <?php if(isset($product['product_name'])) {
                                        
                                        foreach ($product['sold_by_merchants'] as $merchant) {

                                            $listing_url = base_url('listings').'/'.url_title($merchant['establishment_name'].'-'.$product['product_name'], '-', true)
                                                .'?list_id='.$merchant['listing_id'].'&prd_id='.$_GET['prd_id'].$url;

                                            $lat = $merchant['nearest_address']['latitude'];
                                            $long = $merchant['nearest_address']['longitude'];
                                            $distance = distance($lat, $long);

                                            echo '<a href="'.$listing_url.'" 
                                                    class="partner d-flex flex-column align-items-center justify-content-between" 
                                                    style="width:auto;max-width:220px;height:200px;border:1px solid #ddd;border-radius:8px;
                                                            text-decoration:none;padding:10px;box-sizing:border-box;margin:0px 10px 10px 0px;">';

                                                // Logo or fallback block
                                                if ($merchant['merchant_logo']) {
                                                    echo '<div style="height:90px;display:flex;align-items:center;justify-content:center;">
                                                            <img src="'.base_url(SELLER_ATTATCHMENTS_PATH.$merchant['merchant_id'].'/'.$merchant['merchant_logo']).'" 
                                                                alt="'.$merchant['establishment_name'].'" 
                                                                style="max-height:80px;width:auto;" />
                                                        </div>';
                                                } else {
                                                    echo '<div style="height:90px;display:flex;align-items:center;justify-content:center;
                                                                background:#007BFF;border-radius:6px;padding:5px 10px;">
                                                            <span style="color:#fff;font-size:14px;font-weight:600;text-align:center;
                                                                        overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                                                '.htmlspecialchars($merchant['establishment_name']).'
                                                            </span>
                                                        </div>';
                                                }

                                                // Price + discount + distance
                                                echo '<div class="w-100 d-flex justify-content-between align-items-center mt-2">
                                                        <div style="font-size:14px;color:#333;">
                                                            '.currency_format($merchant['sell_price']).'<br />
                                                            <small style="color:#28a745;">('.calculatePercentage($product['mrp_price'], $merchant['sell_price']).'% Off)</small>
                                                        </div>
                                                        <div>
                                                            <span style="background:#f8f9fa;border:1px solid #ccc;border-radius:4px;
                                                                        padding:4px 8px;font-size:12px;color:#333;">
                                                                <i class="fa fa-walking"></i> '.$distance.' KM
                                                            </span>
                                                        </div>
                                                    </div>';

                                            echo '</a>';
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="product-single-collapse" id="productAccordion">
                                <?php if ($product['specifications'] || $product['varients']): ?>
                                <div class="product-collapse-panel">
                                    <h3 class="product-collapse-title" style="padding-bottom: 0px;">
                                        <a class="collapsed" data-toggle="collapse" href="#product-specifications" role="button" aria-expanded="false" aria-controls="product-specifications">Specifications</a>
                                    </h3>

                                    <div class="product-collapse-body collapse show" id="product-specifications" data-parent="#product-specifications">
                                        <div class="collapse-body-wrapper" style="padding-top: 0px;">
                                            <div class="product-specifications">
                                                <div class="add-product-review">
                                                    <div class="childTable">
                                                        <table class="table show tableSeconday">
                                                            <tbody id="specTableBody">
                                                                <?php
                                                                $rowCount = 0;
                                                                if ($product['specifications']) {
                                                                    foreach ($product['specifications'] as $spec_value) {
                                                                        if ($spec_value['value']) {
                                                                            $rowCount++;
                                                                            echo '<tr class="spec-row'.($rowCount > 4 ? ' d-none' : '').'">
                                                                                    <td>'.$spec_value['spec'].'</td>
                                                                                    <td>'.$spec_value['value'].'</td>
                                                                                </tr>';
                                                                        }
                                                                    }
                                                                }

                                                                if ($product['varients']) {
                                                                    foreach ($product['varients'] as $vrnt_key_name => $vrnt_values) {
                                                                        $rowCount++;
                                                                        echo '<tr class="spec-row'.($rowCount > 4 ? ' d-none' : '').'">
                                                                            <td>'.$vrnt_key_name.'</td>
                                                                            <td>'.implode(", ", $vrnt_values).'</td>
                                                                        </tr>';
                                                                    }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="viewSection">
                                                        <a href="javascript:void(0)" id="specificationTableToggleBtn" style="color:#08c">
                                                            <strong>View More</strong>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="product-collapse-panel">
                                    <h3 class="product-collapse-title">
                                        <a class="collapsed" data-toggle="collapse" href="#product-collapse-description" role="button" aria-expanded="false" aria-controls="product-collapse-description">Description</a>
                                    </h3>

                                    <div class="product-collapse-body collapse show" id="product-collapse-description" data-parent="#product-collapse-description">
                                        <p class="more">
                                            <?= isset($product['description']) ? $product['description'] : "" ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <h4>Rating</h4>
                                    <h1 class="rating-num"><?= $avg_rating ?> <i class="fa fa-star text-dark"></i></h1>
                                    <div>
                                        <span><?= $rating_count ?></span> Ratings &  Reviews
                                    </div>
                                </div> 

                                <div class="col-sm-6">
                                    <div class="pull-left">
                                        <div class="pull-left" style="width:35px; line-height:1;">
                                            <div style="height:9px; margin:5px 0;">5 <span class="fa fa-star"></span></div>
                                        </div>
                                        <div class="pull-left" style="width:320px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: <?= $five_star_width ?>%;background: #5cb85c">
                                                    <span class="sr-only">80% Complete (danger)</span>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="pull-right" style="margin-left:10px;"><?= $five_star ?></div>
                                    </div>
                                    <div class="pull-left">
                                        <div class="pull-left" style="width:35px; line-height:1;">
                                            <div style="height:9px; margin:5px 0;">4 <span class="fa fa-star"></span></div>
                                        </div>
                                        <div class="pull-left" style="width:320px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?= $four_star_width ?>%;background: #428bca">
                                                    <span class="sr-only">80% Complete (danger)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right" style="margin-left:10px;"><?= $four_star ?></div>
                                    </div>
                                    <div class="pull-left">
                                        <div class="pull-left" style="width:35px; line-height:1;">
                                            <div style="height:9px; margin:5px 0;">3 <span class="fa fa-star"></span></div>
                                        </div>
                                        <div class="pull-left" style="width:320px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: <?= $three_star_width ?>%;background:#5bc0de">
                                                    <span class="sr-only">80% Complete (danger)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right" style="margin-left:10px;"><?= $three_star ?></div>
                                    </div>
                                    <div class="pull-left">
                                        <div class="pull-left" style="width:35px; line-height:1;">
                                            <div style="height:9px; margin:5px 0;">2 <span class="fa fa-star"></span></div>
                                        </div>
                                        <div class="pull-left" style="width:320px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: <?= $two_star_width ?>%;background:#f0ad4e">
                                                    <span class="sr-only">80% Complete (danger)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right" style="margin-left:10px;"><?= $two_star ?></div>
                                    </div>
                                    <div class="pull-left">
                                        <div class="pull-left" style="width:35px; line-height:1;">
                                            <div style="height:9px; margin:5px 0;">1 <span class="fa fa-star"></span></div>
                                        </div>
                                        <div class="pull-left" style="width:320px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: <?= $one_star_width ?>%;background:#d9534f">
                                                    <span class="sr-only">80% Complete (danger)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right" style="margin-left:10px;"><?= $one_star ?></div>
                                    </div>
                                </div>    
                                <div class="col-sm-2">
                                    <a href="<?= base_url('product/rating/').$_GET['prd_id'] ?>" class="btn btn-warning">Rate Product</a>
                                </div>      
                            </div>     

                            <div class="container">
                                <div class="row mt-3">
                                    <?php 
                                    if ($product['reviews']) 
                                    {
                                        foreach ($product['reviews']['result'] as $key => $review)
                                        {
                                            switch ($review['rating']) 
                                            {
                                                case 1:
                                                    $rating_text = 'Very Bad';
                                                    break;
                                                
                                                case 2:
                                                    $rating_text = 'Not Good';
                                                    break;

                                                case 3:
                                                    $rating_text = 'Quite OK';
                                                    break;

                                                case 4:
                                                    $rating_text = 'Very Good';
                                                    break;

                                                case 5:
                                                    $rating_text = 'Excellent';
                                                    break;

                                                default:
                                                    $rating_text = 'Select Rating';
                                                    break;
                                            }

                                            if($key == 0)
                                                $rating_parent_div = '<div class="entry-body" style="width: 100%">';
                                            else
                                                $rating_parent_div = '<div class="entry-body pt-2" style="width: 100%">';

                                            echo $rating_parent_div.
                                            '<div class="entry-date mr-5" style="background:#28a745;color: #fff;padding: 3px 4px;margin: 0px;width:60px">
                                                    '.$review['rating'].'&nbsp;<i class="fa fa-star "></i> 
                                                </div>

                                                <h2 class="entry-title pl-5 ml-5">
                                                    <a href="#" id="rating_text">'.$rating_text.'</a>
                                                </h2>

                                                <div class="entry-content">
                                                    <p>'.$review['review'].'</p>
                                                </div>
                                          
                                                <div class="entry-meta">
                                                    <span><i class="icon-calendar"></i>'.time_elapsed_string($review['last_updated']).'</span>
                                                    <span><i class="icon-user"></i> '.$review['consumer_name'].'</span>
                                                </div>
                                            </div>';
                                        }  

                                        if ($product['reviews']['count'] > 3) 
                                        {
                                            echo '<div align="right">
                                                <a href="'.base_url('product/rating/').$_GET['prd_id'].'">View all comments</a>
                                            </div>';
                                        }
                                    }  
                                    ?>
                                </div>       
                            </div>
                            <div class="mb-5"></div>
                        </div>
                        <!-- <div class="sidebar-shop col-lg-3 mobile-sidebar" id="scs">
                            <div class="widget widget-featured">
                                <h3 class="widget-title pt-2">Featured Products</h3>
                                <div class="widget-body">
                                    <div class="owl-carousel widget-featured-products owl-loaded owl-drag">
                                        <div class="owl-stage-outer owl-height" style="height: 297px;">
                                            <div class="owl-stage" style="transform: translate3d(-516px, 0px, 0px); transition: all 0.25s ease 0s; width: 1548px;">
                                                <div class="owl-item active">
                                                    <div class="featured-col">
                                                        <div class="owl-item cloned">
                                                            <?php for ($i=1; $i <=3; $i++){?>
                                                                <div class="featured-col">
                                                                    <a href="details.php"> 
                                                                        <div class="product-site">
                                                                            <span class="rating-left" style="background:#28a745">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                                                            <div class="row">  
                                                                                <div class="col-md-4 pl-0 pr-0">
                                                                                    <img class="img-fluid" src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-12.jpg' ?>">
                                                                                </div>
                                                                                <div class="col-md-8 pl-0 pr-0">
                                                                                    <div class="product-details">
                                                                                        <h2 class="product-title text-black pt-2" style="font-size: 13px;font-weight: 500">
                                                                                            Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                                                                            <strong><strike>₹13999</strike>&nbsp; ₹1000<br></strong>
                                                                                            33.2%&nbsp; Off  &nbsp;
                                                                                        </h2>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="owl-item">
                                                    <div class="featured-col">
                                                        <div class="owl-item cloned">
                                                            <?php for ($i=1; $i <=4; $i++){?>
                                                                <div class="featured-col">
                                                                    <a href="details.php"> 
                                                                        <div class="product-site">
                                                                            <span class="rating-left" style="background:#28a745">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                                                            <div class="row">  
                                                                                <div class="col-md-4 pl-0 pr-0">
                                                                                    <img class="img-fluid" src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-12.jpg' ?>">
                                                                                </div>
                                                                                <div class="col-md-8 pl-0 pr-0">
                                                                                    <div class="product-details">
                                                                                        <h2 class="product-title text-black pt-2" style="font-size: 13px;font-weight: 500">
                                                                                            Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                                                                            <strong><strike>₹13999</strike>&nbsp; ₹1000<br></strong>33.2%&nbsp; Off  &nbsp;
                                                                                        </h2>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="owl-item active">
                                                    <div class="featured-col">
                                                        <div class="owl-item cloned">
                                                            <?php for ($i=1; $i <=5; $i++){?>
                                                                <div class="featured-col">
                                                                    <a href="details.php"> 
                                                                        <div class="product-site">
                                                                            <span class="rating-left" style="background:#28a745">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                                                            <div class="row">  
                                                                                <div class="col-md-4 pl-0 pr-0">   
                                                                                    <img class="img-fluid" src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-12.jpg' ?>">
                                                                                </div>
                                                                                <div class="col-md-8 pl-0 pr-0">
                                                                                    <div class="product-details">
                                                                                        <h2 class="product-title text-black pt-2" style="font-size: 13px;font-weight: 500">
                                                                                            Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                                                                            <strong><strike>₹13999</strike>&nbsp; ₹1000<br></strong>
                                                                                            33.2%&nbsp; Off  &nbsp;
                                                                                        </h2>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="owl-dots disabled "></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <!-- <div class="row pb-5">
                        <div id="pro-img" class="featured-products-section carousel-section">
                            <div class="container">
                                <h2 class="h3 title float-left">Similar products</h2>
                                <div class="under-l"></div>
                                <a href="#" class="float-right rounded-btn">View All</a>
                                <div class="clearfix"></div><br>
                                <div class="new-products owl-carousel owl-theme"  data-toggle="owl" data-owl-options="{
                                    'margin': 10,
                                    'width':228,
                                    'autoplayHoverPause' : true,
                                    'dots':false,
                                    'nav' : true,
                                    'pagination' :false,
                                    'stopOnHover' : true,
                                    'items': 2,
                                    'autoplayTimeout': 6000,
                                    'responsive': {
                                        '559': {
                                            'items': 3
                                        },
                                        '975': {
                                            'items': 5
                                        }
                                    }
                                }">
                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#28a745">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                        <figure>
                                            <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-21.jpg" alt="product' ?>">
                                        </figure>
                                        <div class="product-details text-left">
                                            <h2 class="product-title text-black">
                                                Redmi Y3 (64 GB) (4 GB RAM)<br>
                                                <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#28a745">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                        <figure>
                                            <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-25.jpg" alt="product' ?>">
                                        </figure>
                                        <div class="product-details text-left">
                                            <h2 class="product-title text-black">
                                            Redmi Y3 (64 GB) (4 GB RAM)<br>
                                                <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#08c;opacity: 0">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                        <figure>
                                            <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-26.jpg" alt="product' ?>">
                                        </figure>
                                        <div class="product-details text-left">
                                            <h2 class="product-title text-black">
                                                Redmi Y3 (64 GB) (4 GB RAM)<br>
                                                <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#28a745">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                        <figure>
                                            <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-28.jpg' ?>" alt="product">
                                        </figure>
                                        <div class="product-details text-left">
                                            <h2 class="product-title text-black">
                                                Redmi Y3 (64 GB) (4 GB RAM)<br>
                                                <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#08c;opacity:0">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                        <figure>
                                            <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-25.jpg' ?>" alt="product">
                                            </figure>
                                            <div class="product-details text-left">
                                                <h2 class="product-title text-black">
                                                Redmi Y3 (64 GB) (4 GB RAM)<br>
                                                <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!-- <div class="row pb-5">
                    <div id="pro-img"class="featured-products-section carousel-section">
                        <div class="container">
                            <h2 class="h3 title float-left">Related products</h2>
                            <div class="under-l"></div>
                                <a href="#" class="float-right rounded-btn">View All</a>
                                <div class="clearfix"></div><br>
                                <div class="new-products owl-carousel owl-theme"  data-toggle="owl" data-owl-options="{
                                    'margin': 10,
                                    'width':228,
                                    'autoplayHoverPause' : true,
                                    'dots':false,
                                    'nav' : true,
                                    'pagination' :false,
                                    'stopOnHover' : true,
                                    'items': 2,
                                    'autoplayTimeout': 6000,
                                    'responsive': {
                                        '559': {
                                            'items': 3
                                        },
                                        '975': {
                                            'items': 5
                                        }
                                    }
                                }">
                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#28a745">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                        <figure>
                                            <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-21.jpg' ?>" alt="product">
                                        </figure>
                                        <div class="product-details text-left">
                                            <h2 class="product-title text-black">
                                                Redmi Y3 (64 GB) (4 GB RAM)<br>
                                                <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#28a745">
                                            2&nbsp;<i class="fa fa-star"></i> (1) 
                                        </span>
                                        <figure>
                                            <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-25.jpg' ?>" alt="product">
                                        </figure>
                                        <div class="product-details text-left">
                                            <h2 class="product-title text-black">
                                                Redmi Y3 (64 GB) (4 GB RAM)<br>
                                                <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#08c;opacity: 0">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                        <figure>
                                            <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-26.jpg' ?>" alt="product">
                                        </figure>
                                        <div class="product-details text-left">
                                            <h2 class="product-title text-black">
                                                Redmi Y3 (64 GB) (4 GB RAM)<br>
                                                <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                            </h2>
                                        </div>
                                    </a>
                                </div>

                                <div class="product-default w-set">
                                    <a href="#">
                                        <span class="rating" style="background:#08c;opacity: 0">
                                            2&nbsp;<i class="fa fa-star"></i> (1) 
                                        </span>
                                    <figure>
                                        <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-27.jpg' ?>" alt="product">
                                    </figure>
                                    <div class="product-details text-left">
                                        <h2 class="product-title text-black">
                                            Redmi Y3 (64 GB) (4 GB RAM)<br>
                                            <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                        </h2>
                                    </div>
                                </a>
                            </div>

                            <div class="product-default w-set">
                                <a href="#">
                                    <span class="rating" style="background:#28a745">
                                        2&nbsp;<i class="fa fa-star"></i> (1) 
                                    </span>
                                    <figure>
                                        <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-28.jpg' ?>" alt="product">
                                    </figure>
                                    <div class="product-details text-left">
                                       <h2 class="product-title text-black">
                                        Redmi Y3 (64 GB) (4 GB RAM)<br>
                                            <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                        </h2>
                                    </div>
                                </a>
                            </div>
                            <div class="product-default w-set">
                                <a href="#">
                                    <span class="rating" style="background:#08c;opacity:0">2&nbsp;<i class="fa fa-star"></i> (1)</span>
                                    <figure>
                                        <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/products/product-25.jpg' ?>" alt="product">
                                    </figure>
                                    <div class="product-details text-left">
                                       <h2 class="product-title text-black">
                                        Redmi Y3 (64 GB) (4 GB RAM)<br>
                                            <span class="color-change"> <strong><strike>₹13999</strike>&nbsp; ₹1000</strong>33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹4520)</span>
                                        </h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div> 
        </div>
    </div>
</main>   