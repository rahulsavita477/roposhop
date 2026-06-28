<?php 
$avg_rating = ($rating_info['avg_rating']) ? $rating_info['avg_rating'] : 0;
$rating_count = ($rating_info['rating_count']) ? $rating_info['rating_count'] : 0;
$one_star = $rating_info['rating_count_1_star'];
$two_star = $rating_info['rating_count_2_star'];
$three_star = $rating_info['rating_count_3_star'];
$four_star = $rating_info['rating_count_4_star'];
$five_star = $rating_info['rating_count_5_star'];
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

$address_id = isset($address['nearest_address']['address_id']) ? $address['nearest_address']['address_id'] : '';
$lat = isset($address['nearest_address']['latitude']) ? $address['nearest_address']['latitude'] : '';
$long = isset($address['nearest_address']['longitude']) ? $address['nearest_address']['longitude'] : '';
$pin = isset($address['nearest_address']['pin']) ? $address['nearest_address']['pin'] : '';
$contact = isset($address['nearest_address']['contact']) ? $address['nearest_address']['contact'] : '';
$line1 = isset($address['nearest_address']['address_line_1']) ? $address['nearest_address']['address_line_1'] : '';
$line2 = isset($address['nearest_address']['address_line_2']) ? $address['nearest_address']['address_line_2'] : '';
$landmark = isset($address['nearest_address']['landmark']) ? $address['nearest_address']['landmark'] : '';
$cnt_id = isset($address['nearest_address']['country_id']) ? $address['nearest_address']['country_id'] : '';
$state_id = isset($address['nearest_address']['state_id']) ? $address['nearest_address']['state_id'] : '';
$city_id = isset($address['nearest_address']['city_id']) ? $address['nearest_address']['city_id'] : '';
$country_name = isset($address['nearest_address']['country_name']) ? $address['nearest_address']['country_name'] : '';
$state_name = isset($address['nearest_address']['state_name']) ? $address['nearest_address']['state_name'] : '';
$city_name = isset($address['nearest_address']['city_name']) ? $address['nearest_address']['city_name'] : '';

$business_days = false;
if($merchant_detail['business_days']) {
    $business_days = $merchant_detail['business_days'];
} elseif(isset($address['nearest_address']['business_days'])) {
    $business_days = $address['nearest_address']['business_days'];
}

$business_hours = false;
if($merchant_detail['business_hours']) {
    $business_hours = $merchant_detail['business_hours'];
} elseif(isset($address['nearest_address']['business_hours'])) {
    $business_hours = $address['nearest_address']['business_hours'];
}
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

    a.morelink {
        text-decoration:none;
        outline: none;
        color: #08c;
        font-weight: bold;
    }
    .morecontent span {
        display: none;
    }
    .less{
        color: #08c;
        font-weight: bold;
    }
    .more{
        text-align: justify;
    }
    #rating_text{
        color: #08c;  
        text-decoration: none; 
        pointer-events: none;
    }
</style>

<script type="text/javascript">
$(document).ready(function() {
    $('.tableSeconday').each(function () {
        $(this).find('tr:gt(14)').hide();
    });

    $(".viewSection a").click(function () {
        var $table = $(this).parent().prevAll('div').find('.tableSeconday');
        $table.find('tr:gt(14)').toggle();
        $(this).html($(this).html() == 'view less' ? 'view more' : 'view less');
    });

    //show limited character
    var showChar = 1000;
    var ellipsestext = "...";
    var moretext = "view more";
    var lesstext = "view less";
    $('.more').each(function() {
        var content = $(this).html();

        if(content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar-1, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink"><strong>' + moretext + '</strong></a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });

    //get and set product listing data
    getAndSetProductListing(1);
});

function open_modal(merchant_id, establishment_name) 
{
    $("#merchant_id").val(merchant_id);
    $("#establishment_name").val(establishment_name);
    $('#establishment_name_span').html('#'+merchant_id+' '+establishment_name);
    $("#claim_business").modal();
}
</script>

<body id="page-details" class="loaded">
    <div class="page-wrapper">
        <main class="main">
            <div class="container">
                <ol class="breadcrumb mt-0 mb-2">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('merchants') ?>">sellers</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active"><?= $merchant_detail['establishment_name'] ?></a></li>
                </ol>
                    
                <div class="product-single-container product-single-default">
                    <div class="row">
                        <div class="col-lg-5 product-single-gallery">
                            <div class="sticky-slider">
                                <div class="product-slider-container product-item">
                                    <div class="product-single-carousel owl-carousel">
                                        <?php
                                        foreach ($shop_images as $key => $imgs) 
                                        {
                                            echo '<div class="product-item">
                                                    <img 
                                                        style="    
                                                            width: auto;
                                                            max-width: 343px;
                                                            margin-left: auto;
                                                            margin-right: auto;
                                                            height: auto;
                                                            max-height: 400px;" 
                                                        class="product-single-image" 
                                                        src="'.$imgs.'" 
                                                        data-zoom-image="'.$imgs.'" 
                                                        alt="'.$merchant_detail['establishment_name'].'_'.$key.'" />
                                                </div>';
                                        }
                                        ?>
                                    </div>
                                    <!-- End .product-single-carousel -->
                                    <span class="prod-full-screen">
                                        <i class="icon-plus"></i>
                                    </span>
                                </div>

                                <div class="prod-thumbnail row owl-dots transparent-dots" id='carousel-custom-dots'>
                                    <?php
                                    foreach ($shop_images as $imgs) 
                                    {
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
                                                    alt="'.$merchant_detail['establishment_name'].'_'.$key.'" />
                                            </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="product-single-details">
                                <h2 class="product" style="display:flex; margin-bottom: 0px;">
                                    <?= $merchant_detail['establishment_name'] ?>
                                    <?php if ($merchant_detail['is_verified']) {
                                        
                                        echo '<img src="'.base_url('assets/user/assets2/images/approved.png').'"  alt="Verified" style="height:30px;">';
                                        
                                    } elseif(!$userDetail['email']) {
                                        echo '<a 
                                            href="javascript:void(0);" 
                                            onclick="open_modal('.
                                                $merchant_detail['merchant_id'].',
                                                &apos;'.$merchant_detail['establishment_name'].'&apos;
                                            );" 
                                            data-toggle="modal" 
                                            class="btn btn-primary" 
                                            style="padding: 5px;"
                                        >Claim this business</a>';
                                    } ?>
                                </h2>
                                
                                <div class="ratings-container">
                                    <a href="<?= base_url('merchant/rating/').$_GET['merchant_id'] ?>">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:<?= $avg_rating_width ?>%"></span>
                                        </div>
                                    </a>                                    
                                </div>
                            </div>

                            <!-- Request for ownership form in modal -->
                            <div class="container">
                                <!-- Modal -->
                                <div class="modal fade" id="claim_business">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                Request Ownership for&nbsp;<span id="establishment_name_span"></span>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form 
                                                    action="<?= base_url('claimBusiness') ?>" 
                                                    method="post" 
                                                    enctype="multipart/form-data" 
                                                    onsubmit="return validateForm()"
                                                >
                                                    <input type="hidden" name="mail_code" value="<?= CLAIM_BUSINESS ?>" />
                                                    <input type="hidden" name="merchant_id" id="merchant_id" />
                                                    <input type="hidden" name="establishment_name" id="establishment_name" />

                                                    <div class="form-group-inline">
                                                        <input class="form-control" type="text" placeholder="Full name*" name="name" value="<?= set_value('name') ?>" required />
                                                    </div>
                                                    <div class="form-group-inline">
                                                        <input class="form-control" type="email" placeholder="Email*" name="email" value="<?= set_value('email') ?>" required />
                                                    </div>
                                                    <div class="form-group-inline">
                                                        +91-<input class="form-control" type="text" placeholder="Contact (Mobile) number*" name="contact_number" value="<?= set_value('contact_number') ?>" required />
                                                    </div>
                                                    <div class="form-group-inline">
                                                        <div class="alert alert-warning" role="alert">Mobile Number need to be exact 10 digits.</div>
                                                    </div>
                                                    <div class="form-group-inline">
                                                        <label>Business Proof*:</label>
                                                        <input class="form-control" type="file" name="file" required />
                                                    </div>
                                                    <div class="form-group-inline">
                                                        <div class="alert alert-warning" role="alert"><b>Allowed Business proof :</b> GST Certificate, Shop & Establishment License, Udhyog Aadhar, Trade Certificate / License, FSSAI Registration, Current Cheque.<br />Allowed File types: PDF, JPG and PNG.</div>
                                                    </div>
                                                    <div class="form-group-inline">
                                                        <textarea class="form-control" name="message" placeholder="Message" name="message"><?= set_value('message') ?></textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn-custom btn-primary">Send</button>
                                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- merchant heighlights div -->
                            <div class="product-filters-container pt-2">
                                <ul style="list-style: inside;color:#000">
                                    <?php 
                                    if (isset($merchant_heighlights['result'])) 
                                    {
                                        echo 'Highlights :<br />';

                                        foreach ($merchant_heighlights['result'] as $heighlight) 
                                        {
                                            echo "<li>".$heighlight['offering']."</li>";
                                        }
                                    } 
                                    ?>
                                </ul>
                            </div>

                            <?php
                            // merchant contact div
                            if ($merchant_detail['contact']) 
                            {
                                echo '<div class="pt-1 pb-1">
                                        <div class="pt-5 step-title" style="padding-top: 0px !important;">
                                            <span style="font-weight: 400;">Contact: </span>
                                        '.$merchant_detail['contact'].'
                                        </div>
                                    </div>';
                            }

                            // business days div
                            if ($business_days) 
                            {
                                echo '<div class="pt-1 pb-1">
                                        <div class="pt-5 step-title" style="padding-top: 0px !important;">
                                            <span style="font-weight: 400;">Business Days: </span>
                                        '.$business_days.'
                                        </div>
                                    </div>';
                            }

                            // business hours div
                            if ($business_hours) {
                                echo '<div class="pt-1 pb-1">
                                        <div class="pt-5 step-title" style="padding-top: 0px !important;">
                                            <span style="font-weight: 400;">Business Hours: </span>
                                        '.$business_hours.'
                                        </div>
                                    </div>';
                            }

                            echo "<p><p>".$merchant_detail['description']."</p></p>";
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="featured-products-section carousel-section">
                    <div class="row pt-5">
                        <div class="col-lg-9">
                            <?php if($address_id): ?>
                            <div class="row" style=" padding: 10px; border-bottom: 1px solid #ddd; margin-bottom: 35px;">
                                <div class="col-sm-6">
                                    <b>Address:</b><br /><br />
                                    <?php
                                    echo $line1."<br />".$line2;

                                    if ($line2)
                                        echo "<br />";

                                    echo $landmark;

                                    if ($landmark)
                                        echo "<br />";

                                    echo $city_name;

                                    if ($pin)
                                        echo " - ".$pin;

                                    echo "<br />".$state_name.", ".$country_name;

                                    if ($contact)
                                        echo "<br /><label>Contact no :</label> ".$contact;

                                    if ($business_days)
                                        echo "<br /><label>Business days :</label> ".$business_days;

                                    if ($business_hours)
                                        echo "<br /><label>Business hours :</label> ".$business_hours;
                                    ?>
                                </div> 

                                <div class="col-sm-6">
                                    <?php
                                    if ($address['total_address'] > 1)
                                        echo '<a href="'.base_url('merchant/'.$_GET['merchant_id'].'/address').'" class="btn btn-primary">View all '.$address['total_address'].' addresses</a><br /><br />';

                                    echo '<a target="_blank" href="https://www.google.com/maps/place/'.$lat.','.$long.'" class="btn btn-warning"><i class="fa fa-walking" aria-hidden="true"></i> '.distance($lat, $long).' KM</a>';
                                    ?>
                                </div> 
                            </div>
                            <?php endif; ?>

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
                                    <a href="<?= base_url('merchant/rating/').$_GET['merchant_id'] ?>" class="btn btn-warning">Rate Merchant</a>
                                </div>      
                            </div>     

                            <div class="container">
                                <div class="row mt-3">
                                    <?php 
                                    if ($reviews) 
                                    {
                                        foreach ($reviews['result'] as $key => $review) 
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

                                        if ($reviews['count'] > 3) 
                                        {
                                            echo '<div align="right">
                                                <a href="'.base_url('merchant/rating/').$_GET['merchant_id'].'">View all comments</a>
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