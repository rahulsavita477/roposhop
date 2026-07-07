<?php 
//product rating
$avg_rating = (isset($product['rating_info']['avg_rating'])) ? $product['rating_info']['avg_rating'] : 0;
$prd_avg_rating_width = ($avg_rating*100)/5;

//listing detail
$finance_available = isset($listing['finance_available']) ? 'Yes' : 'No';
$home_delivery_available = isset($listing['home_delivery_available']) ? 'Yes' : 'No';
$installation_available = isset($listing['installation_available']) ? 'Yes' : 'No';
$in_stock = isset($listing['in_stock']) ? 'Yes' : 'No';
$replacement_available = isset($listing['replacement_available']) ? 'Yes' : 'No';
$in_stock = isset($listing['in_stock']) ? 'Yes' : 'No';
$url = isset($_GET['category']) ? '&category='.$_GET['category'] : '';

//merchant detail
$address_id = isset($merchant['address']['nearest_address']['address_id']) ? $merchant['address']['nearest_address']['address_id'] : '';
$lat = isset($merchant['address']['nearest_address']['latitude']) ? $merchant['address']['nearest_address']['latitude'] : '';
$long = isset($merchant['address']['nearest_address']['longitude']) ? $merchant['address']['nearest_address']['longitude'] : '';
$pin = isset($merchant['address']['nearest_address']['pin']) ? $merchant['address']['nearest_address']['pin'] : '';
$contact = isset($merchant['address']['nearest_address']['contact']) ? $merchant['address']['nearest_address']['contact'] : '';
$business_days = isset($merchant['address']['nearest_address']['business_days']) ? $merchant['address']['nearest_address']['business_days'] : '';
$business_hours = isset($merchant['address']['nearest_address']['business_hours']) ? $merchant['address']['nearest_address']['business_hours'] : '';
$line1 = isset($merchant['address']['nearest_address']['address_line_1']) ? $merchant['address']['nearest_address']['address_line_1'] : '';
$line2 = isset($merchant['address']['nearest_address']['address_line_2']) ? $merchant['address']['nearest_address']['address_line_2'] : '';
$landmark = isset($merchant['address']['nearest_address']['landmark']) ? $merchant['address']['nearest_address']['landmark'] : '';
$cnt_id = isset($merchant['address']['nearest_address']['country_id']) ? $merchant['address']['nearest_address']['country_id'] : '';
$state_id = isset($merchant['address']['nearest_address']['state_id']) ? $merchant['address']['nearest_address']['state_id'] : '';
$city_id = isset($merchant['address']['nearest_address']['city_id']) ? $merchant['address']['nearest_address']['city_id'] : '';
$country_name = isset($merchant['address']['nearest_address']['country_name']) ? $merchant['address']['nearest_address']['country_name'] : '';
$state_name = isset($merchant['address']['nearest_address']['state_name']) ? $merchant['address']['nearest_address']['state_name'] : '';
$city_name = isset($merchant['address']['nearest_address']['city_name']) ? $merchant['address']['nearest_address']['city_name'] : '';

$avg_rating = (isset($merchant['rating_info']['avg_rating'])) ? $merchant['rating_info']['avg_rating'] : 0;
$merchant_avg_rating_width = ($avg_rating*100)/5;
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
});

function open_modal2(name, data) 
{
    $("#tc_span").html(atob(data));
    $("#tc_name_span").html(name);
    $("#tc").modal();
}
</script>

<body id="page-details" class="loaded">
    <div class="page-wrapper">
        <main class="main">
            <div class="container">
                <ol class="breadcrumb mt-0 mb-2">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('merchants') ?>">sellers</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('merchants/'.url_title($merchant['establishment_name'], '-', true).'?merchant_id='.$merchant['merchant_id']) ?>"><?= $merchant['establishment_name'] ?></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">Listing</a></li>
                </ol>
                    
                <div class="product-single-container product-single-default">
                    <div class="row">
                        <div class="col-lg-5 product-single-gallery">
                            <div class="sticky-slider">
                                <div class="product-slider-container product-item">
                                    <div class="product-single-carousel owl-carousel">
                                        <?php
                                        if(isset($product)){
                                        foreach ($product['images'] as $key => $imgs) 
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
                                                        alt="'.$product['product_name'].'_'.$key.'" />
                                                </div>';
                                        }}
                                        ?>
                                    </div>
                                    <!-- End .product-single-carousel -->
                                    <span class="prod-full-screen">
                                        <i class="icon-plus"></i>
                                    </span>
                                </div>

                                <div class="prod-thumbnail row owl-dots transparent-dots" id='carousel-custom-dots'>
                                    <?php
                                    if(isset($product['images'])) {
                                        
                                        foreach ($product['images'] as $imgs) 
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
                                    <a href="<?= base_url('product/rating/').$_GET['list_id'] ?>">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:<?= $prd_avg_rating_width ?>%"></span>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="product-filters-container pt-2">
                                <ul style="list-style: inside;color:#000">
                                    <?php if (isset($product['key_features']) && $product['key_features']) {
                                        foreach ($product['key_features'] as $feature) 
                                            echo "<li>".$feature."</li>";
                                    } ?>
                                </ul>
                            </div><!-- End .product-filters-container -->
                            <table class="table table-bordered mt-2">
                                <tbody>
                                    <tr><th colspan="2">Product Listing Detail</th></tr>
                                    <tr>
                                        <td>Brand</td>
                                        <td>
                                            <?= isset($product['brand_name']) ? $product['brand_name'] : '' ?>
                                            &nbsp;&nbsp;
                                            <a href="<?= base_url('brands/'.$product['brand_name'].'?brand_id='.$product['brand_id']) ?>">
                                                <img 
                                                    style="
                                                        width: 15%;
                                                        display: inline;" 
                                                    src="<?= $product['brand_logo'] ?>" 
                                                    alt="brand_logo" 
                                                />
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>In the box</td>
                                        <td>
                                            <?= isset($product['in_the_box']) ? $product['in_the_box'] : ' - ' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>MRP</td>
                                        <td><strike><?php if(isset($product['mrp_price'])) { echo currency_format($product['mrp_price']); }  ?></strike></td>
                                    </tr>  
                                    <tr>
                                        <td>Offer Price</td>
                                        <td>
                                            <?php if(isset($listing['sell_price'])) { echo currency_format($listing['sell_price']); }    ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Offered By</td>
                                        <td><?php if(isset($merchant['establishment_name'])) { echo $merchant['establishment_name']; } ?></td>
                                    </tr>  
                                    <tr>
                                        <td>Discount</td>
                                        <td>
                                            <?php
                                            if(isset($product['mrp_price']) && isset($listing['sell_price'])) {
                                                echo calculatePercentage(
                                                    (int) $product['mrp_price'], 
                                                    (int) $listing['sell_price']
                                                )."% Off, ";
                                            }

                                            if(isset($product['mrp_price']) && isset($listing['sell_price'])) { 

                                                echo currency_format($product['mrp_price']-$listing['sell_price'])." Discount";
                                            }
                                            ?>
                                        </td>
                                    </tr>  

                                    <?php
                                    if (isset($listing['seller_offering']))
                                    echo '<tr>
                                            <td>Seller offerings</td>
                                            <td>'.$listing['seller_offering'].'</td>
                                        </tr>';

                                    $finance_terms =  isset($listing['finance_terms']) ? '<a 
                                    href="javascript:void(0);" 
                                    onclick="open_modal2(
                                        \'Finance\',
                                        \''.base64_encode(
                                            nl2br(
                                                str_replace(
                                                    "“",
                                                    "&quot;",
                                                    str_replace(
                                                        "”", 
                                                        "&quot;", 
                                                        $listing['finance_terms'])
                                                )
                                            )
                                        ).'\'
                                    );" 
                                    data-toggle="modal" 
                                    style="padding: 5px;
                                        color: #08c;"
                                    >T&C</a>' : '';

                                    $home_delivery_terms = isset($listing['home_delivery_terms']) ? '<a 
                                    href="javascript:void(0);" 
                                    onclick="open_modal2(
                                        \'Home Delivery\',
                                        \''.base64_encode(
                                            nl2br(
                                                str_replace(
                                                    "“",
                                                    "&quot;",
                                                    str_replace(
                                                        "”", 
                                                        "&quot;", 
                                                        $listing['home_delivery_terms'])
                                                )
                                            )
                                        ).'\'
                                    );" 
                                    data-toggle="modal" 
                                    style="padding: 5px;
                                        color: #08c;"
                                    >T&C</a>' : '';

                                    $installation_terms = isset($listing['installation_terms']) ? '<a 
                                    href="javascript:void(0);" 
                                    onclick="open_modal2(
                                        \'Installation\',
                                        \''.base64_encode(
                                            nl2br(
                                                str_replace(
                                                    "“",
                                                    "&quot;",
                                                    str_replace(
                                                        "”", 
                                                        "&quot;", 
                                                        $listing['installation_terms'])
                                                )
                                            )
                                        ).'\'
                                    );" 
                                    data-toggle="modal" 
                                    style="padding: 5px;
                                        color: #08c;"
                                    >T&C</a>' : '';

                                    $replacement_terms = isset($listing['replacement_terms']) ? '<a 
                                    href="javascript:void(0);" 
                                    onclick="open_modal2(
                                        \'Replacement\',
                                        \''.base64_encode(
                                            nl2br(
                                                str_replace(
                                                    "“",
                                                    "&quot;",
                                                    str_replace(
                                                        "”", 
                                                        "&quot;", 
                                                        $listing['replacement_terms'])
                                                )
                                            )
                                        ).'\'
                                    );" 
                                    data-toggle="modal" 
                                    style="padding: 5px;
                                        color: #08c;"
                                    >T&C</a>' : '';

                                    $return_policy = isset($listing['return_policy']) ? '<a 
                                    href="javascript:void(0);" 
                                    onclick="open_modal2(
                                        \'Return\',
                                        \''.base64_encode(
                                            nl2br(
                                                str_replace(
                                                    "“",
                                                    "&quot;",
                                                    str_replace(
                                                        "”", 
                                                        "&quot;", 
                                                        $listing['return_policy'])
                                                )
                                            )
                                        ).'\'
                                    );" 
                                    data-toggle="modal" 
                                    style="padding: 5px;
                                        color: #08c;"
                                    >T&C</a>' : '';

                                    echo '<tr>
                                        <td>Finance available</td>
                                        <td>'.$finance_available.$finance_terms.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;">Home Delivery Available</td>
                                        <td>'.$home_delivery_available.$home_delivery_terms.'</td>
                                    </tr>
                                    <tr>
                                        <td>Installation available</td>
                                        <td>'.$installation_available.$installation_terms.'</td>
                                    </tr>
                                    <tr>
                                        <td>In stock</td>
                                        <td>'.$in_stock.'</td>
                                    </tr>
                                    <tr>
                                        <td>Replacement available</td>
                                        <td>'.$replacement_available.$replacement_terms.'</td>
                                    </tr>';
                                    ?>   
                                </tbody>
                            </table>     
                        </div><!-- End .product-single-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
                
                <div class="product-single-container product-single-default" style="margin-top: 100px;">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-lg-7">
                                    <h2><?= isset($merchant['establishment_name']) ? $merchant['establishment_name'] : '' ?></h2>
                                    <div class="ratings-container">
                                        <a href="<?= base_url('merchant/rating/').$merchant['merchant_id'] ?>">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:<?= $merchant_avg_rating_width ?>%"></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <?php if(isset($merchant)){
                                    echo '<a href="'.base_url('merchants/'.url_title($merchant['establishment_name'], '-', true).'?merchant_id='.$merchant['merchant_id']).'">
                                        <img 
                                            style="    
                                                width: auto;
                                                max-width: 343px;
                                                margin-left: auto;
                                                margin-right: auto;
                                                height: auto;
                                                max-height: 400px;" 
                                            class="product-single-image" 
                                            src="'.$merchant['images'][0].'" 
                                            alt="'.$merchant['establishment_name'].'_'.$key.'" />
                                    </a>';
                                    }?>
                                </div>
                            </div>

                            <div class="container">
                                <!-- Modal -->
                                <div class="modal fade" id="tc" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <span id="tc_name_span"></span>&nbsp;T&C
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <span id="tc_span"></span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="close btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-filters-container pt-2">
                                <ul style="list-style: inside;color:#000">
                                    <?php 
                                    if (isset($merchant['heighlights']['result'])) 
                                    {
                                        echo 'Highlights :<br />';

                                        foreach ($merchant['heighlights']['result'] as $heighlight) 
                                        {
                                            echo "<li>".$heighlight['offering']."</li>";
                                        }
                                    } 
                                    ?>
                                </ul>
                            </div>

                            <div 
                                class="row"
                                style="
                                    padding: 10px; 
                                    border-bottom: 1px solid #ddd; 
                                    margin-bottom: 35px;"
                            >
                                <div class="col-lg-9">
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

                                <div class="col-lg-3">
                                    <?php
                                    if (isset($merchant['address']['total_address']) && $merchant['address']['total_address'] > 1)
                                        echo '<a href="'.base_url('merchant/'.$merchant['merchant_id'].'/address').'" class="btn btn-primary pull-right">View all '.$merchant['address']['total_address'].' addresses</a><br /><br />';

                                    echo '<a target="_blank" href="https://www.google.com/maps/place/'.$lat.','.$long.'" class="btn btn-warning pull-right"><i class="fa fa-walking" aria-hidden="true"></i> '.distance($lat, $long).' KM</a>';
                                    ?>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?= isset($merchant['description']) ? $merchant['description'] : '' ?>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</main>   