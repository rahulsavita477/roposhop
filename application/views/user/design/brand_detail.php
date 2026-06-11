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
    #more{
        display: none;
    }
    #more1{
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
    .widget .owl-carousel .owl-nav {
 position: absolute;
 top: -40px !important;
 right: 0.6rem !important;
 }
 button.owl-prev, button.owl-next{
 width: 20px !important;
 height: 20px !important;
 background:transparent !important;
 }
 a.text-active {
 color: #08c;
 }
 /*.rotate {
 -moz-transition: all .5s linear;
 -webkit-transition: all .5s linear;
 transition: all .5s linear;
 }*/
 .rotate.down {
 -moz-transform:rotate(180deg);
 -webkit-transform:rotate(180deg);
 transform:rotate(180deg);
 }
 #page-category .product-default img {
 height: 150px;
 width: auto;
 margin: 0 auto;
 }
 .featured-col {
 text-align: left;
 }
 .product-site{
 position: relative;
 }
 .rating-left {
 float: left;
 position: absolute;
 top: 5px;
 left: 5px;
 font-size: 10px;
 color: #fff;
 padding: 2px;
 z-index: 4;
 }
 .product-widget figure{
 margin-top:10px;
 }
 .featured-col a:hover{
 text-decoration: none;
 }
 a.text-deco:hover {
 text-decoration: none;
 }
 .product-site {
 color: #777;
 background: #fff;
 box-shadow: 0px 0px 3px #00000038;
 margin: 5px 10px;
 padding: 0px 4px;
 }
 .color-change {
 color: #08c !important;
 }
 .btn-primaryss {
 border: 1px solid #3364b0;
 height: 29px;
 border-radius: 0px 3px 3px 0px;
 position: absolute;
 right: 4px;
 width: 60px;
 height: 40px;
 background:#3364b0;
 color: #fff;
 }
 input.w-50{
 height: 40px
 }
 a.sorter-btn {
 margin-top: -10px;
 }
 input.w-50:focus{
 border: none;
 }
 select.form-control:not([size]):not([multiple]) {
 height: 40px;
 padding: 5px !important;
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
                    <li class="breadcrumb-item"><a href="<?= base_url('brands') ?>">Brands</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active"><?= $brand['name'] ?></a></li>
                </ol>
                    
                <div class="product-single-container product-single-default">
                    <div class="row">
                        <div class="col-lg-5 product-single-gallery">
                            <div class="sticky-slider">
                                <div class="product-slider-container product-item">
                                    <div class="product-single-carousel owl-carousel">
                                        <?php
                                        foreach ($brand_images as $key => $imgs) 
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
                                                        alt="'.$brand['name'].'_'.$key.'" />
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
                                    foreach ($brand_images as $imgs) 
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
                                                    alt="'.$brand['name'].'_'.$key.'" />
                                            </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="product-single-details">
                                <h2 class="product"><?= $brand['name'] ?></h2>
                            </div>

                            <?= "<p><p>".$brand['brand_desc']."</p></p>" ?>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</main>   

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="toolbox-item toolbox-sort">
                        <div class="select-custom">
                            <select id="orderby" class="form-control">
                                <option value="name_asc">Product Name Ascending</option>
                                <option value="name_desc">Product Name Descending</option>
                                <option value="sell_price_asc">Price Ascending</option>
                                <option value="sell_price_desc">Price Descending</option>
                            </select>
                        </div>
                        <!-- <a href="#" class="sorter-btn" title="Set Ascending Direction"><i class="fa fa-arrow-down rotate" aria-hidden="true"></i></a> -->
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-5">
                    <form method="get" action="javascript:void(0)" class="form-inline" >
                        <input class="w-50" type="text"  placeholder="Search Product" id="search_text">
                        <button type="button" class="btn-primaryss" onclick="getAndSetBrandProducts(1)"> <i class="icon-magnifier"></i></button>
                    </form>
                </div>
                <!-- <div class="col-md-3">
                    <label class="pt-2 float-left">Showing <span class="paging_count"></span> results</label>
                    <div class="layout-modes float-left">
                        <a href="category.php" class="layout-btn btn-grid active" title="Grid">
                            <i class="icon-mode-grid"></i>
                        </a>
                        <a href="category-list.php" class="layout-btn btn-list" title="List">
                            <i class="icon-mode-list"></i>
                        </a>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <?php 
                $n_totalProduct = $totalProduct > 15 ? 15 : $totalProduct;

                for ($i=1; $i <=$n_totalProduct; $i++)
                {
                    echo '<div class="col-6 col-md-4 pl-1 pr-1">
                        <div class="product-default w-set">
                            <a id="listing_product_url'.$i.'">
                                <span 
                                    class="rating" 
                                    style="background:#28a745"
                                    id="product_rating_div'.$i.'"
                                >
                                    <span id="product_avg_rating'.$i.'"></span>&nbsp;
                                    <i class="fa fa-star"></i> (<span id="product_rating_count'.$i.'"></span>)
                                </span>
                                <figure>
                                    <img 
                                        style="height: 150px; 
                                        object-fit: scale-down;"
                                        id="product'.$i.'_img"
                                    />
                                </figure>
                                <div class="product-details text-left">
                                    <h2 class="product-title text-black">
                                        <span id="product'.$i.'_name"></span><br>
                                        <span class="color-change"> 
                                            <strong>
                                                <strike id="product'.$i.'_price_div">₹ <span id="product'.$i.'_price">&nbsp;</strike> 
                                                ₹ <span id="listing'.$i.'_price"></span>
                                            </strong>
                                            <span id="product'.$i.'_discount_div">
                                                <span id="product'.$i.'_off"></span>%&nbsp; Off  &nbsp; (Discount &nbsp;₹ <span id="product'.$i.'_discount"></span>)
                                            </span>
                                        </span>
                                    </h2>
                                    <div class="price-box"></div>
                                </div>
                            </a>
                        </div>
                    </div>';
                } 
                ?>
            </div>
            <nav class="toolbox toolbox-pagination mt-2">
                <div class="toolbox-item toolbox-show">
                    <label>Showing <span class="paging_count"></span> results</label>
                </div>
                <ul class="pagination" id="pagination">
                    <!-- <li class="page-item disabled">
                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                    </li> 
                    <li class="page-item"><span>...</span></li>
                    <li class="page-item"><a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a></li> -->
                </ul>
            </nav>
        </div>
        <aside class="sidebar-shop col-lg-3 order-lg-first">
            <div class="pin-wrapper" style="height: 1404px;">
                <div class="sidebar-wrapper sticky-active" style="border-bottom: 0px none rgb(122, 125, 130); width: 270px;">
                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-y" role="button" aria-expanded="true" aria-controls="widget-body-y">Categories</a>
                        </h3>
                        <div class="collapse show" id="widget-body-y">
                            <div class="widget-body">
                                <div class="filt">
                                    <ul class="cd-filter-content cd-filters list">
                                        <?php
                                        foreach ($categories as $key => $category) 
                                        {
                                            echo '<li class="category_filter">
                                                    <input 
                                                        name="category_filter"
                                                        class="filter" 
                                                        data-filter=".check'.$key.'" 
                                                        type="checkbox"
                                                        value="'.$category['category_id'].'"
                                                    />
                                                    <label class="checkbox-label" for="checkbox'.$key.'">'.$category['category_name'].'
                                                    <small>'.$category['productCnt'].'</small>
                                                    </label>
                                                </li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<input name="brand_filter" type="checkbox" value="<?= $_GET['brand_id'] ?>" checked style="display: none;" />

<script type="text/javascript">
//get and set product listing data (function will call from parent page)
function getAndSetBrandProducts(page) 
{
    //show loader
    $('#divLoading1').css('display', 'block');
    
    for (var i = 1; i < 16; i++) 
        $("#listing_product_url"+i).css("display", "block");

    //set data in products page
    $.when(getProducts(page)).done(function(brandProducts){        
        resp = JSON.parse(brandProducts);

        if (resp.products == null || resp.products == 'undefined') 
        {
            for (var i = 1; i < 16; i++) 
                $("#listing_product_url"+i).css("display", "none");

            //hide loader
            $('#divLoading1').css('display', 'none');
        }
        else //set data in template (merchant products page)
            setBrandProductData(resp.products, resp.paging);
    });
}

//set merchant product data in product boxes
async function setBrandProductData(listing_products, paging) 
{
    let start_from = eval((paging.limit*paging.page)-paging.limit+1); 

    //set pagignation bar
    $(".paging_count").html(
        start_from 
        + '-' + 
        eval((paging.page*paging.limit)-(paging.limit-listing_products.length)) 
        + ' of ' + 
        paging.total_results
    );

    //set li for pagignation
    let pagination_li = '';
    for (var i = 1; i <= paging.total_pages; i++) 
    {
        active_class = (i==paging.page) ? 'active' : '';
        pagination_li += '<li class="page-item '+active_class+'"><a class="page-link" href="javascript:void(0)" onclick="getAndSetBrandProducts('+i+')">'+i+'</a></li>';
    }

    $("#pagination").html(pagination_li);

    //remove product box if items are below then 15 (15 is default limit)
    if (listing_products.length != 15) 
    {
        //remove product box where we do not have products for them
        for (var i = listing_products.length+1; i < 16; i++) 
            $("#listing_product_url"+i).css("display", "none");
    } 

    //set products
    for (var i=0,j=1; i < listing_products.length; i++) 
    {
        await sleep(150);

        let k=i+1;

        //set product-listing href link
        $("#listing_product_url"+k).attr("href", "<?= base_url('listings/'.url_title('establishment_name', '-', true).'?') ?>"+'list_id='+listing_products[i].listing_id+'&prd_id='+listing_products[i].product_id);

        //set data in products page
        $.when(getProduct(listing_products[i].product_id)).done(function(product){
            resp = JSON.parse(product);
            
            //add one line break if charater has less than 37 charaters
            $("#product"+j+"_name").html(resp.product.product_name.substr(0, 35));
            $("#listing"+j+"_price").html(resp.product.offer_price);
            $("#product"+j+"_img").prop('src', resp.product.image);  
            $("#product"+j+"_img").prop('att', resp.product.product_name);

            if (resp.product.discount_price > 0) 
            {
                $("#product"+j+"_price").html(resp.product.mrp_price+'&nbsp;');
                $("#product"+j+"_off").html(resp.product.off);
                $("#product"+j+"_discount").html(resp.product.discount_price);

                //show price & discount div
                $("#product"+j+"_price_div").css('display', 'show');
                $("#product"+j+"_discount_div").css('display', 'show');
            }
            else
            {
                //hide price & discount div
                $("#product"+j+"_price_div").css('display', 'none');
                $("#product"+j+"_discount_div").css('display', 'none');
            }

            if (resp.product.rating.rating_count>0) 
            {
                $("#product_rating_div"+j).css('display', 'show');
                $("#product_avg_rating"+j).html(resp.product.rating.avg_rating);
                $("#product_rating_count"+j).html(resp.product.rating.rating_count);
            }
            else
            {
                $("#product_rating_div"+j).css('display', 'none');
            }

            if (resp.product.product_name)
                j++;

            if (i == listing_products.length)
                $('#divLoading1').css('display', 'none');
        });
    }
}

$(document).ready(function() {
    $( "#orderby" ).change(function() {
        getAndSetBrandProducts(1);
    });

    $('.category_filter').click(function(e) 
    { 
        getAndSetBrandProducts(1);
    });

    //get and set product listing data
    getAndSetBrandProducts(1);
});
</script>