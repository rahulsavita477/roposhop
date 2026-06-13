<style type="text/css">
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

<body id="page-details" class="loaded">
    <div class="page-wrapper">
        <main class="main">
<div class="container">
    <ol class="breadcrumb mt-0 mb-2">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">categories</a></li>
    </ol>

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
                <div class="col-md-5">
                    <form method="get" action="javascript:void(0)" class="form-inline" >
                        <input class="w-50" type="text"  placeholder="Search Product" id="search_text">
                        <button type="button" class="btn-primaryss" onclick="getAndSetProductListing(1)"> <i class="icon-magnifier"></i></button>
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
                            <a id="product_url'.$i.'">
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
                                            <strike id="product'.$i.'_price_div">₹<span id="product'.$i.'_price">&nbsp;</strike> 
                                                ₹<span id="listing'.$i.'_price"></span>
                                        </span>
                                        <span id="product'.$i.'_discount_div">
                                            <span id="product'.$i.'_off"></span>%&nbsp;   &nbsp; (Discount &nbsp;₹<span id="product'.$i.'_discount"></span>)
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
                                <div class="widget-body">
                                    <ul class="cat-list">
                                        <?php
                                        foreach ($tree_list as $parent_category) 
                                        {
                                            echo '<li><a href="'.base_url('categories/'.url_title($parent_category['category_name'], '-', true)).'?category='.$parent_category['category_id'].'">'.$parent_category['category_name'].'</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-z" role="button" aria-expanded="true" aria-controls="widget-body-z">Brands</a>
                        </h3>
                        <div class="collapse show" id="widget-body-z">
                            <div class="widget-body">
                                <div class="filt">
                                    <ul class="cd-filter-content cd-filters list">
                                        <?php
                                        foreach ($brands['result'] as $key => $brand) 
                                        {
                                            echo '<li class="brand_filter">
                                                    <input 
                                                        name="brand_filter"
                                                        class="filter" 
                                                        data-filter=".check'.$key.'" 
                                                        type="checkbox"
                                                        value="'.$brand['brand_id'].'"
                                                    />
                                                    <label class="checkbox-label" for="checkbox'.$key.'">'.$brand['name'].'
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

<script type="text/javascript">
//get and set product listing data (function will call from parent page)
function getAndSetProductListing(page) 
{
    //show loader
    $('#divLoading1').css('display', 'block');

    for (var i = 1; i < 16; i++) 
        $("#product_url"+i).css("display", "block");

    //set data in products page
    $.when(getProducts(page)).done(function(products){        
        resp = JSON.parse(products);

        if (resp.products == null || resp.products == 'undefined') 
        {
            for (var i = 1; i < 16; i++) 
                $("#product_url"+i).css("display", "none");

            //hide loader
            $('#divLoading1').css('display', 'none');
        }
        else //set data in template (merchant products page)
            setProductData(resp.products, resp.paging);
    });
}

//set merchant product data in product boxes
async function setProductData(products, paging) 
{
    let start_from = eval((paging.limit*paging.page)-paging.limit+1); 

    //set pagignation bar
    $(".paging_count").html(
        start_from 
        + '-' + 
        eval((paging.page*paging.limit)-(paging.limit-products.length)) 
        + ' of ' + 
        paging.total_results
    );

    //set li for pagignation
    let pagination_li = '';
    for (var i = 1; i <= paging.total_pages; i++) 
    {
        active_class = (i==paging.page) ? 'active' : '';
        pagination_li += '<li class="page-item '+active_class+'"><a class="page-link" href="javascript:void(0)" onclick="getAndSetProductListing('+i+')">'+i+'</a></li>';
    }

    $("#pagination").html(pagination_li);

    //remove product box if items are below then 15 (15 is default limit)
    if (products.length != 15) 
    {
        //remove product box where we do not have products for them
        for (var i = products.length+1; i < 16; i++) 
            $("#product_url"+i).css("display", "none");
    } 

    //set products
    for (var i=0,j=1; i < products.length; i++) 
    {
        await sleep(150);

        let k=i+1;
        let productURL = "<?= base_url('products/') ?>"+url_title(products[i].product_name)+'?prd_id='+products[i].product_id; 

        //set product href link
        $("#product_url"+k).attr("href", productURL);

        //set data in categories page
        $.when(getProduct(products[i].product_id)).done(function(product){
            resp = JSON.parse(product);

            //add one line break if charater has less than 37 charaters
            $("#product"+j+"_name").html(resp.product.product_name.substr(0, 35));

            if (resp.product.offer_price == 0)
                $("#listing"+j+"_price").html(resp.product.mrp_price);
            else
                $("#listing"+j+"_price").html(resp.product.offer_price);

            $("#product"+j+"_img").prop('src', resp.product.image);  
            $("#product"+j+"_img").prop('att', resp.product.product_name);

            if (
                resp.product.discount_price > 0 && 
                resp.product.offer_price > 0
            ) 
            {
                $("#product"+j+"_price").html(resp.product.mrp_price);
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
                //hide rating div
                $("#product_rating_div"+j).css('display', 'none');
            }

            if (resp.product.product_name)
                j++;

            if (i == products.length)
                $('#divLoading1').css('display', 'none');
        });
    }
}

$(document).ready(function() {
    $( "#orderby" ).change(function() {
        getAndSetProductListing(1);
    });

    $('.category_filter').click(function(e) 
    { 
        getAndSetProductListing(1);
    });

    $('.brand_filter').click(function(e) 
    { 
        getAndSetProductListing(1);
    });

    //get and set product listing data
    getAndSetProductListing(1);
});
</script>