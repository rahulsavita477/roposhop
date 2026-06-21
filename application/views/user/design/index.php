<body id="page-home" class="loaded">
    <div class="page-wrapper">
<main class="main">
    <div class="home-slider-container">
        <div class="home-slider owl-carousel owl-theme owl-theme-light">
            <?php 
            if ($offers) { 
                foreach ($offers as $offer) { ?>
                    <div class="home-slide">
                        <div class="slide-bg owl-lazy"  data-src="<?= $offer['offer_images'][0] ?>" style="width: 50%; margin: 5%;"></div><!-- End .slide-bg -->
                        <div class="container">
                            <div class="row justify-content-end">
                                <div class="col-8 col-md-6 text-center slide-content-right">
                                    <div class="home-slide-content">
                                        <div class="slide-border-top">
                                            <img src="assets/user/assets2/images/slider/border-top.png" alt="Border" width="290" height="38" />
                                        </div>
                                        <h1><?= $offer['offer_title'] ?></h1>
                                        <a href="<?= base_url().'offer/'.url_title($offer['offer_title'], '-', true).'?offer_id='.$offer['offer_id'] ?>" class="btn btn-primary">Know More</a>
                                        <div class="slide-border-bottom">
                                            <img src="assets/user/assets2/images/slider/border-bottom.png" alt="Border" width="290" height="111">
                                        </div><!-- End .slide-border-bottom -->
                                    </div><!-- End .home-slide-content -->
                                </div><!-- End .col-lg-5 -->
                            </div><!-- End .row -->
                        </div><!-- End .container -->
                    </div><!-- End .home-slide -->
                <?php } 
            } else { ?>
                <div class="home-slide">
                    <div class="slide-bg owl-lazy"  data-src="<?= base_url('assets/user/assets2/images/slider/slide-1.jpg') ?>"></div><!-- End .slide-bg -->
                    <div class="container">        
                        <div class="home-slide-content float-left">
                            <div class="slide-border-top">
                                <img src="<?= base_url('assets/user/assets2/images/slider/border-top.png') ?>" alt="Border" width="290" height="38" />
                            </div><!-- End .slide-border-top -->
                            <h3>50% off for select items</h3>
                            <h1>HOME APPLIANCES</h1>
                            <a href="<?= base_url('categories/home-appliances?category=67') ?>" class="btn btn-primary">Shop Now</a>
                            <div class="slide-border-bottom">
                                <img src="<?= base_url('assets/user/assets2/images/slider/border-bottom.png') ?>" alt="Border" width="290" height="111">
                            </div><!-- End .slide-border-bottom -->
                        </div>
                    </div><!-- End .container -->
                </div><!-- End .home-slide -->

                <div class="home-slide">
                    <div class="slide-bg owl-lazy"  data-src="<?= base_url('assets/user/assets2/images/slider/slide-2.jpg') ?>"></div><!-- End .slide-bg -->
                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-8 col-md-6 text-center slide-content-right">
                                <div class="home-slide-content">
                                    <div class="slide-border-top">
                                        <img src="<?= base_url('assets/user/assets2/images/slider/border-top.png') ?>" alt="Border" width="290" height="38">
                                    </div><!-- End .slide-border-top -->
                                    <h3>up to 70% off</h3>
                                    <h1>Mobile Phones</h1>
                                    <a href="<?= base_url('categories/mobile-phones?category=61') ?>" class="btn btn-primary">Shop Now</a>
                                     <div class="slide-border-bottom">
                                        <img src="<?= base_url('assets/user/assets2/images/slider/border-bottom.png') ?>" alt="Border" width="290" height="111">
                                    </div><!-- End .slide-border-bottom -->
                                </div><!-- End .home-slide-content -->
                            </div><!-- End .col-lg-5 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .home-slide -->
            <?php } ?>
        </div><!-- End .home-slider -->
    </div><!-- End .home-slider-container -->

    <div class="info-boxes-container">
        <div class="container">
            <div class="info-box">
                <i class="icon-shipping"></i>
                <div class="info-box-content">
                    <h4>SHORTER DELIVERY TIME</h4>
                    <p>Get the possession of product immediately from the Shop.</p>
                </div><!-- End .info-box-content -->
            </div><!-- End .info-box -->

            <div class="info-box">
                <i class="icon-support"></i>
                <div class="info-box-content">
                    <h4>IMMEDIATE VALUE</h4>
                    <p>Immediate value to you through the product search and compare product features.</p>
                </div><!-- End .info-box-content -->
            </div><!-- End .info-box -->

            <div class="info-box">
                <i class="icon-us-dollar"></i>
                <div class="info-box-content">
                    <h4>BEST DEAL</h4>
                    <p>Look for the sellers offering the product and compare price from different sellers.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="featured-products-section carousel-section">
        <?php 
        foreach ($categories as $category) 
        {
            if (count($category['products'])>0) 
            { 
        ?>
                <div class="container">
                    <h2 class="h3 title float-left"><?= $category['category_name'] ?></h2>
                    <a href="<?= base_url('categories/'.url_title($category['category_name'], '-', true).'?category=').$category['category_id'] ?>" class="float-right rounded-btn">View All</a>
                    <div class="clearfix"></div><br>
                    <hr class="sethr" style=" margin:0px 0px 20px 0px" />
                    <div class="new-products owl-carousel owl-theme"  data-toggle="owl" data-owl-options="{
                        'margin': 20,
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
                        <?php 
                        foreach ($category['products'] as $product)
                        { 
                            $product_name = $product['product_name'];
                            $tt_prd_name = (strlen($product_name) > 35) ? substr($product_name, 0, 35).'...' : ((strlen($product_name) < 22) ? $product_name."<br />" : $product_name);
                        ?>
                            <div class="product-default" style="width:200px">
                                <a href="<?= base_url('products/'.url_title($product_name, '-', true).'?prd_id='.$product['product_id']) ?>">

                                    <?php
                                    if ($product['rating']['rating_count']) 
                                    {
                                        echo '<span class="rating" style="background:#28a745">'.ceil($product['rating']['avg_rating']).'&nbsp;<i class="fa fa-star"></i>'.$product['rating']['rating_count'].'</span>';
                                    }
                                    ?>

                                    <figure><img src="<?= $product['products_images'][0] ?>" alt="product"></figure>
                                    <div class="product-details text-left">
                                        <h2 class="product-title text-black">
                                            <span data-toggle="tooltip" title="<?= $product_name ?>"><?= $tt_prd_name ?></span><br />

                                            <?php if ($product['offer_price']) { ?>
                                                <strong>
                                                    <strike><?= $product['mrp_price'] ?></strike> <?= $product['offer_price']?><br>
                                                </strong>
                                                Off <?= $product['off'] ?>%<br />Discount &#8377;<?= $product['discount_price'] ?>
                                            <?php 
                                            } 
                                            else 
                                                echo "<strong>".$product['mrp_price']."</strong><br /><br /><br />";
                                            ?>
                                        </h2>
                                    </div><!-- End .product-details -->
                                </a>
                            </div>
                        <?php } ?>
                    </div><!-- End .featured-proucts -->
                </div><!-- End .container -->

                <div class="mb-2"></div><!---margin-->
            <?php }
        } ?>
    </div>
    
    <div class="mb-2"></div><!-- margin -->

    <div class="featured-products-section carousel-section">
        <div class="container">
            <h2 class="h3 title float-left">Popular Brands</h2>
            <a href="<?= base_url('brands') ?>" class="rounded-btn float-right">View All</a>
            <div class="clearfix"></div><br>
            <hr class="sethr" style=" margin:0px 0px 20px 0px" />
            <div class="partners-container pt-1 pb-1 ">
                <div class="container">
                    <div class="partners-carousel  owl-carousel owl-theme min-123" data-toggle="owl" data-owl-options="{
                        'margin': 20,
                        'autoplayHoverPause' : true,
                        'nav' : true,
                        'items': 1,
                        'autoplayTimeout': 4000,
                        'responsive': {
                            '559': {
                                'items': 5
                            },
                            '975': {
                                'items': 6
                            }
                        }
                    }">
                        <?php foreach ($brands['result'] as $brand) { ?>
                            <a href="<?= base_url('brands/'. url_title($brand['name'], '-', true).'?brand_id='.$brand['brand_id']) ?>" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;"><img src="<?= base_url(BRAND_ATTATCHMENTS_PATH.$brand['brand_id'].'/'.$brand['brand_logo']) ?>" style="height:80px;width: auto;"></a>
                        <?php } ?>
                    </div><!-- End .partners-carousel -->
                </div><!-- End .container -->
            </div><!-- End .partners-container -->
        </div>
    </div>

    <div class="mb-2"></div><!-- margin -->

    <div class="featured-products-section carousel-section">
        <div class="container">
            <h2 class="h3 title float-left">Nearby Sellers</h2>
            <a href="<?= base_url('merchants') ?>" class="rounded-btn float-right">View All</a>
            <div class="clearfix"></div><br>
            <hr class="sethr" style=" margin:0px 0px 20px 0px" />
            <div class="partners-container pt-1 pb-1 ">
                <div class="container">
                    <div id="brands" class="partners-carousel owl-carousel owl-theme min-123" data-toggle="owl" data-owl-options="{
                        'loop': false,
                        'margin': 20,
                        'autoplayHoverPause' : true,
                        'nav' : true,
                        'items': 1,
                        'autoplayTimeout': 2000,
                        'responsive': {
                            '559': {
                                'items': 5
                            },
                            '975': {
                                'items': 7
                            }
                        }
                    }">
                        <?php foreach ($merchants['result'] as $merchant)
                        { 
                            $merchant_logo = ($merchant['merchant_logo']) ? $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant['merchant_id'].'/'.$merchant['merchant_logo'] : '';
                            
                            if ($merchant_logo) 
                            {
                                echo '<a href="'.base_url('merchants/'. url_title($merchant['establishment_name'], '-', true).'?merchant_id='.$merchant['merchant_id']).'" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;"><img src="'.$merchant_logo.'" style="height:80px;width: auto;"></a>';
                            }
                            else
                            {
                                echo '<a href="'.base_url('merchants/'. url_title($merchant['establishment_name'], '-', true).'?merchant_id='.$merchant['merchant_id']).'" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;background:red"><h3 style="color:#fff">'.$merchant['establishment_name'].'</h3></a>';
                            }
                            ?>
                        <?php } ?>
                    </div><!-- End .partners-carousel -->
                </div><!-- End .container -->
            </div><!-- End .partners-container -->
        </div>
    </div>

    <!-- App Download -->
    <div class="info-section bg-white" id="app">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="assets/user/assets2/images/mob-frame.jpg">
                </div><!-- End .col-md-4 -->

                <div class="col-md-6">
                    <h1>Download RopopShop <br>
                    App Now !</h1> 
                    <p>Fast, Simple & Delightful.<br>All it takes is 30 seconds to Download.</p> <br>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#"><img src="assets/user/assets2/images/appstore.jpg"></a>  
                        </div>
                        <div class="col-md-6">
                            <a href="#"><img src="assets/user/assets2/images/googleplay.jpg"></a>
                        </div>
                    </div>
                </div><!-- End .col-md-4 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div>
    <!-- App Download -->

    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12 lg-12 col-12 pt-2 pb-5">
                    <h3> ABOUT Roposhop</h3>
                    <P>ROPOshop - Research Online Purchase Offline is a web and mobile enabled platform to help people find products in there locality with the information of detailed product features, price and distance to the shop. In Addition users can also read and provide reviews for the products and sellers.</P>
                    <p>ROPOshop also helps sellers who don't want to sell there products to online portals, they can list there products on ROPOshop at no extra cost. The services are absolutely free for both consumers and sellers.</p>
                    <p>A new way of shopping for the people who like to buy offline but also like to research online before purchase. Now you need not to visit multiple websites to compare features or get the rating of the product you want to purchase, at the same time you will get the information about the local dealers who are offering the product you are looking for with the price and distance to the shop. All this from a single app ROPOshop.</p>
                    <p>ROPOshop is different from traditional Online shopping portal as it provides the user the information of local business selling the product. At the same time user will have all the information about product like detailed specifications and reviews etc. ROPOshop is also different from other business directory applications in the way that it provides complete information of specific product along with price and distance to the shop, user need not to migrate from shop to shop to find the right product and the best deal.</p>
                    <p>Online shopping is emerging very fast in recent years. Now a day the internet holds the attention of retail market. Millions and millions of people shop online. On the other hand the purchasing of product from traditional market is continuing since years. Many customers go for purchasing offline so as to examine the product and hold the possession of the product just after the payment for the product. In this contemporary world customer’s loyalty depends upon the consistent ability to deliver quality, value and satisfaction. Some go for offline shopping, some for online and many go for both kind of shopping.</p>
                    <h4>Differentiation from Online shopping Portals</h4>
                    <h5> Risk:</h5>
                    <p>​ When customer buy products from online shopping they do not touch or feel the product in a physical sense .Hence we understand that lot of risk is involve while buying an online product whether it will reach us on proper time or not is also a concern and a lso there may arise a risk of product size and colour as it may differ in real view or sense. Sometimes the product ordered is kind of damaged. With ROPOShop a user buy product from shop after physical checks so this risk is not there.</p>

                    <h5>Convenience :</h5>
                    <p>​ Online shopping is much more convenient than offline shopping. Instead of taking out your vehicle and visit shop to shop you can just sit at your home and do the shopping. It is convenient to sit at one place and shop the product of our choice without moving from place to place. Online shopping makes things more convenient. We can have a lot of choice over there in any kind of material we want to deal with that too without any fear of dealing with any dealer or distributers. Online s hopping is convenient in its real sense as it do not carry any dealing with issues of asking for wanted items or issues of asking for desired kind of items which helps in avoiding the part of waiting, asking, questioning about the product.<br />​ ROPOShop offers a user same convenience of shopping at home, once user have decided on what he/she want to buy and from which seller then only he/she need to visit the shop and make purchase.</p>

                    <h5>Tangibility of the product:</h5>
                    <p>​ At the store the customer gets to touch and feel the product they purchase before buying which help the customer to take the decision to buy the product or not whether the product will suit the customer need or not. Whether, we can and see feel a product is also a reason which determines whether a person’s wants to go for shopping or not. Tangibility of any product also determines the online shopping.Without touching the preferred or desired substance nobody can get its security about the worthiness or quality or sense of any preferred product.<br />With ROPOShop customer get a chance to touch and feel the product before making final purchase.</p>

                    <h5>Delivery time:</h5>
                    <p>​ The product ordered by the customer in online shopping takes a minimum of six to seven days to deliver the product to the customer. But in offline shopping the possession of the goods is immediately transferred to the buyer. So this is a major factor which affects the online shopping. People want a good delivery time; they prefer to get a product in a desired time or in short time of duration. Duration is the second major factor affecting the demand of product.<br />With ROPOShop customer also get the possession of product immediately.</p>

                    <h5>Variety:</h5>
                    <p>The kind of variety that a customer gets online is hard to match any product purchased offline. The online retailer’s stock products from the entire major brand and a customer can find any product in their listing no matter how hard to find it is in the offline store.<br />ROPOShop also offer same kind of Variety of prodcts to the customers.</p>

                    <h5>Instant gratification:</h5>
                    <p>Customer buying offline gets their products as soon as they pay for it but in online shopping customer have to wait for their product to get their product. Under normal circumstances waiting a day or two does not matter much but when a customer want to get the product instantly than offline shopping become necessary.<br />ROPOShop alows user to get their products as soon as they purchase it.</p>
                </div> 
            </div>    
        </div>
    </div>
</main><!-- End .main -->