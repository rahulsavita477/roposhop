<style type="text/css">
 .rotate.down {
 -moz-transform:rotate(180deg);
 -webkit-transform:rotate(180deg);
 transform:rotate(180deg);
 }
 a.text-active {
 color: #08c !important;
 } 
 .widget .owl-carousel .owl-nav {
 position: absolute;
 top: -40px !important;
 right: 0.6rem !important;
 }
 button.owl-prev, button.owl-next{
 /* width: 20px !important;
 height: 20px !important; */
 background:transparent !important;
 }
 .featured-col {
 text-align: left;
 }
 .product-site {
 color: #777;
 background: #fff;
 box-shadow: 0px 0px 3px #00000038;
 margin: 5px 10px;
 padding: 0px 4px;
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
 .product-widget figure{
 margin-top:10px;
 }
 .featured-col a:hover{
 text-decoration: none;
 }
 a.text-deco:hover {
 text-decoration: none;
 }
 .product-default figure img {
 height: auto !important;
 width: 280px;
 }
 .product-default{
 position:relative;
 }
 .rating-right {
 position: absolute;
 left: 5px;
 top: 4px;
 color: #fff;
 font-size:12px;
 padding: 1px;
 z-index: 99
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
 input.w-50:focus{
 border: none;
 }
 select.form-control:not([size]):not([multiple]) {
 height: 40px;
 padding: 5px !important;
 }
 a.sorter-btn {
 margin-top: -10px;
 }
</style>

<body id="page-details" class="loaded">
    <div class="page-wrapper">
        <main class="main">
<div class="container">
    <ol class="breadcrumb mt-0 mb-2">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">search</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active"><i><?= $_GET['str'] ?></i></a></li>
    </ol>

    <div class="row">
        <div class="col-lg-9">
            <!-- <div class="row">
                <div class="col-md-3">
                    <div class="toolbox-item toolbox-sort">
                        <div class="select-custom">
                            <select id="orderby" class="form-control">
                                <option value="name_asc">Products First</option>
                                <option value="name_desc">Categories First</option>
                                <option value="sell_price_asc">Brands First</option>
                                <option value="sell_price_desc">Sellers First</option>
                                <option value="sell_price_desc">Offers First</option>
                            </select>
                        </div>
                        <a href="#" class="sorter-btn" title="Set Ascending Direction"><i class="fa fa-arrow-down rotate" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-md-5">
                    <form method="get" action="javascript:void(0)" class="form-inline" >
                        <input class="w-50" type="text"  placeholder="Search Product" id="search_text">
                        <button type="button" class="btn-primaryss" onclick="getAndSetProductListing(1)"> <i class="icon-magnifier"></i></button>
                    </form>
                </div>
                <div class="col-md-3">
                    <label class="pt-2 float-left">Showing <span class="paging_count"></span> results</label>
                    <div class="layout-modes float-left">
                        <a href="category.php" class="layout-btn btn-grid active" title="Grid">
                            <i class="icon-mode-grid"></i>
                        </a>
                        <a href="category-list.php" class="layout-btn btn-list" title="List">
                            <i class="icon-mode-list"></i>
                        </a>
                    </div>
                </div>
            </div> -->

            <div class="row">
                <?php 
                if(!$search_result['products'] && !$search_result['brands'] && !$search_result['merchants']) {
                    echo "No Result Found!";
                }

                if ($search_result['products']) 
                {
                    foreach ($search_result['products']['result'] as $value) 
                    {
                ?>
                       <div class="col-6 col-12 product-default left-details mb-1 pt-1">
                          <a href="<?= base_url('products/'.url_title($value['product_name'], '-', true).'?prd_id='.$value['product_id']) ?>" style="columns:#000">
                             <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <?php
                                    if ($value['rating']['avg_rating']) 
                                    {
                                        echo '<span class="rating-right" style="background:#28a745">'.$value['rating']['avg_rating'].'&nbsp;<i class="fa fa-star"></i> ('.$value['rating']['rating_count'].') </span>';
                                    }
                                    ?>
                                    <figure class="">
                                        <img
                                            style="
                                                max-height: 250px;
                                                height: auto;
                                                width: auto;
                                                margin-left: auto;
                                                margin-right: auto;" 
                                            src="<?= $value['products_images'][0] ?>"
                                        />
                                   </figure>
                                </div>
                                <div class="col-md-8 col-xs-12">
                                   <div class="product-details">
                                      <h2><?= $value['product_name'] ?></h2>
                                      <div class="product-filters-container">
                                         <ul>
                                            <?php
                                            foreach ($value['key_features'] as $feature) 
                                            {
                                                echo "<li>".$feature."</li>";
                                            }
                                            ?>
                                         </ul>
                                      </div>
                                      <div class="price-box">
                                         <strong><strike>₹<?= $value['mrp_price'] ?></strike> ₹<?= $value['offer_price'] ?><br></strong><?= $value['off'] ?>%  Off [Discount ₹<?= $value['discount_price'] ?>]
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </a>
                       </div>
                    <?php } 
                } ?>
            </div>

            <div class="row">
                <?php 
                if ($search_result['brands']) 
                {
                    foreach ($search_result['brands']['result'] as $value) 
                    {
                ?>
                       <div class="col-6 col-12 product-default left-details mb-1 pt-1">
                          <a href="<?= base_url('brands/'.url_title($value['name'], '-', true).'?brand_id='.$value['brand_id']) ?>" style="columns:#000">
                             <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <figure>
                                        <img
                                            style="
                                                max-height: 250px;
                                                height: auto;
                                                width: auto;
                                                margin-left: auto;
                                                margin-right: auto;" 
                                            src="<?= $value['logo'] ?>"
                                        />
                                   </figure>
                                </div>
                                <div class="col-md-8 col-xs-12">
                                   <div class="product-details">
                                        <?php
                                            echo '<h2>'.$value['name'].'</h2>';

                                            if ($value['brand_desc']) 
                                            {
                                                echo '<div class="product-filters-container">
                                                    <strong>About</strong><br>
                                                    '.$value['brand_desc'].'
                                                </div>';   
                                            }
                                        ?>
                                   </div>
                                </div>
                             </div>
                          </a>
                       </div>
                    <?php } 
                } ?>
            </div>

            <div class="row">
                <?php 
                if ($search_result['merchants']) 
                {
                    foreach ($search_result['merchants']['result'] as $value) 
                    {
                ?>
                        <div class="col-6 col-12 product-default left-details mb-1 pt-1">
                          <a href="<?= base_url('merchants/'.url_title($value['establishment_name'], '-', true).'?merchant_id='.$value['merchant_id']) ?>" style="columns:#000">
                             <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <figure>
                                        <img
                                            style="
                                                max-height: 250px;
                                                height: auto;
                                                width: auto;
                                                margin-left: auto;
                                                margin-right: auto;" 
                                            src="<?= $value['logo'] ?>"
                                        />
                                   </figure>
                                </div>
                                <div class="col-md-8 col-xs-12">
                                   <div class="product-details">
                                        <?php
                                            echo '<h2>'.$value['establishment_name'].'</h2>';

                                            if (isset($value['nearest_address'])) 
                                            {
                                                echo '<div class="product-filters-container">
                                                    <strong>Address</strong><br>';
                                                
                                                echo $value['nearest_address']['address_line_1']."<br />".$value['nearest_address']['address_line_2'];

                                                if ($value['nearest_address']['address_line_2'])
                                                    echo ", ";

                                                echo $value['nearest_address']['landmark'];

                                                if ($value['nearest_address']['landmark'])
                                                    echo ", ";

                                                echo $value['nearest_address']['city_name'];

                                                if ($value['nearest_address']['pin'])
                                                    echo " - ".$value['nearest_address']['pin'];

                                                echo ", ".$value['nearest_address']['state_name'].", ".$value['nearest_address']['country_name'];

                                                if ($value['nearest_address']['contact'])
                                                    echo "<br /><label>Contact no: </label> ".$value['nearest_address']['contact'];

                                                if ($value['nearest_address']['business_days'])
                                                    echo "<br /><label>Business days :</label> ".$value['nearest_address']['business_days'];

                                                if ($value['nearest_address']['business_hours'])
                                                {
                                                    echo "<br /><label>Business hours :</label> ".$value['nearest_address']['business_hours'];
                                                }
                                                echo '</div>';   
                                            }
                                        ?>
                                   </div>
                                </div>
                             </div>
                          </a>
                       </div>
                    <?php } 
                } ?>
            </div>

            <!-- <nav class="toolbox toolbox-pagination mt-2">
                <div class="toolbox-item toolbox-show">
                    <label>Showing <span class="paging_count"></span> results</label>
                </div>
                <ul class="pagination" id="pagination">
                    <li class="page-item disabled">
                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                    </li> 
                    <li class="page-item"><span>...</span></li>
                    <li class="page-item"><a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a></li>
                </ul>
            </nav> -->
        </div>

        <style type="text/css">
        .sidebar-shop .widget-title a::after{
            content: none;
        }
        </style>
        <aside class="sidebar-shop col-lg-3 order-lg-first">
            <div class="pin-wrapper" style="height: 1404px;">
                <div class="sidebar-wrapper sticky-active" style="border-bottom: 0px none rgb(122, 125, 130); width: 270px;">
                    <div class="widget">
                        <h3 class="widget-title">
                            <a href="<?= base_url('products') ?>">Products</a>
                        </h3>
                    </div>

                    <div class="widget">
                        <h3 class="widget-title">
                            <a href="<?= base_url('categories') ?>">Categories</a>
                        </h3>
                    </div>

                    <div class="widget">
                        <h3 class="widget-title">
                            <a href="<?= base_url('brands') ?>">Brands</a>
                        </h3>
                    </div>

                    <div class="widget">
                        <h3 class="widget-title">
                            <a href="<?= base_url('sellers') ?>">Sellers</a>
                        </h3>
                    </div>

                    <div class="widget">
                        <h3 class="widget-title">
                            <a href="<?= base_url('offers') ?>">Offers</a>
                        </h3>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>