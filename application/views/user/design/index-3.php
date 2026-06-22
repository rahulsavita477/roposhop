<?php
?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>RopoShop</title>

    <meta name="" content="HTML5 Template" />
    <meta name="" content="P">
    <meta name="" content="">
        
       <!---css--->
         <?php include('include/css.php'); ?>
        
       <!---css--->
</head>
<body id="page-home">
    <div class="page-wrapper">
        
        <!---header--->
        <?php include('include/header.php'); ?> 
        <!-- End .header -->
        
        <main class="main">
            <div class="home-slider-container">
                <div class="home-slider owl-carousel owl-theme owl-theme-light">
                    <!-- <div class="home-slide">
                        <div class="slide-bg owl-lazy"  data-src="assets/images/slider/slide-1.jpg"></div>
                        <div class="container">
                            
                            <div class="home-slide-content float-left">
                                <div class="slide-border-top">
                                    <img src="assets/images/slider/border-top.png" alt="Border" width="290" height="38">
                                </div>
                                <h3>50% off for select items</h3>
                                <h1>HOME APPLIANCES</h1>
                                <a href="#" class="btn btn-primary">Shop Now</a>
                                <div class="slide-border-bottom">
                                    <img src="assets/images/slider/border-bottom.png" alt="Border" width="290" height="111">
                                </div>
                            </div>

                        </div>
                    </div> -->

                    <div class="home-slide">
                        <div class="slide-bg owl-lazy"  data-src="assets/images/slider/slide-2.jpg"></div>
                        <div class="container">
                            <div class="row justify-content-end">
                                <div class="col-8 col-md-6 text-center slide-content-right">
                                    <div class="home-slide-content">
                                         <div class="slide-border-top">
                                    <img src="assets/images/slider/border-top.png" alt="Border" width="290" height="38">
                                </div>
                                        <h3>up to 70% off</h3>
                                        <h1>Mobile Phones</h1>
                                        <a href="#" class="btn btn-primary">Shop Now</a>
                                         <div class="slide-border-bottom">
                                    <img src="assets/images/slider/border-bottom.png" alt="Border" width="290" height="111">
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!----slider-->




                </div>
            </div>

            <div class="info-boxes-container">
                <div class="container">
                    <div class="info-box">
                        <i class="icon-shipping"></i>

                        <div class="info-box-content">
                            <h4>FREE SHIPPING & RETURN</h4>
                            <p>Free shipping on all orders</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->

                   
                    <div class="info-box">
                        <i class="icon-support"></i>

                        <div class="info-box-content">
                            <h4>ONLINE SUPPORT 24/7</h4>
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->

                     <div class="info-box">
                        <i class="icon-us-dollar"></i>

                        <div class="info-box-content">
                            <h4>MONEY BACK GUARANTEE</h4>
                            <p>100% money back guarantee</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->




                </div><!-- End .container -->
            </div><!-- End .info-boxes-container -->
            


           
               <div class="mt-2"></div><!---margin-->
            <div class="featured-products-section carousel-section">
                <div class="container">
                   <!--   <h2 class="h3 title float-left">SMART PHONES</h2>
                    <div class="under-l"></div>
                    <a href="#" class="float-right rounded-btn">View All</a>
                    <div class="clearfix"></div><br>
                   <hr class="sethr" style=" margin:0px 0px 20px 0px"> -->
                      


                   <div id="singal-slider" class="new-products owl-carousel owl-theme"  data-toggle="owl" data-owl-options="{
                        'margin': 20,
                         'loop': false,
                        'autoplayHoverPause' : true,
                         'dots':false,
                        'nav' : true,
                        'pagination' :false,
                        'stopOnHover' : true,
                        'items': 1,
                        'autoplayTimeout': 6000,
                        'responsive': {
                            '559': {
                                'items': 2
                            },
                            '975': {
                                'items': 3
                            }

                        }

                    }">

                        <div class="product-default" style="width:99%">
                           <a href="#">
                            <div class="row bg-info pt-2 pb-2">
                              <div class="col-md-12 col-12">
                                <img src="assets/images/products/product-06.jpg" alt="product" style="height:200px; width: auto;">
                              </div>  

                               <div class="col-md-12 col-12 text-left">
                                <h2 class="text-left pt-5 float-left text-white">
                                    <span class="float-left pr-5">infinex </span> <img src="assets/images/brands/infi.png" style="width: auto; height: 30px">
                                </h2><div class="clearfix"></div>
                                <p class="slider-ptext">The Infinix Note 5 is a highly intelligent note-smartphone, which is powered by Google's Android One. </p>
                                  
                                  <ul class="slider-ptext-ul">
                                        <li>4 GB RAM | 64 GB ROM | Expandable Upto 128 GB</li>
                                        <li>15.21 cm (5.99 inch) Full HD+ Display</li>
                                        
                                  </ul>
                                   <button class="rounded-btn">
                                       View More
                                   </button>
                               </div> 
                            </div>    
                           </a>
                       </div>

                        <div class="product-default" style="width:99%">
                           <a href="#">
                            <div class="row bg-danger pt-2 pb-2">
                              <div class="col-md-12 col-12">
                                <img src="assets/images/products/product-06.jpg" alt="product" style="height:200px; width: auto;">
                              </div>  

                               <div class="col-md-12 col-12 text-left">
                                <h2 class="text-left pt-5 float-left text-white">
                                    <span class="float-left pr-5">infinex </span> <img src="assets/images/brands/infi.png" style="width: auto; height: 30px">
                                </h2><div class="clearfix"></div>
                                <p class="slider-ptext">The Infinix Note 5 is a highly intelligent note-smartphone, which is powered by Google's Android One. </p>
                                  
                                  <ul class="slider-ptext-ul">
                                        <li>4 GB RAM | 64 GB ROM | Expandable Upto 128 GB</li>
                                        <li>15.21 cm (5.99 inch) Full HD+ Display</li>
                                        
                                  </ul>
                                   <button class="rounded-btn">
                                       View More
                                   </button>
                               </div> 
                            </div>    
                           </a>
                       </div>

                        <div class="product-default" style="width:99%">
                           <a href="#">
                            <div class="row bg-warning pt-2 pb-2">
                              <div class="col-md-12 col-12">
                                <img src="assets/images/products/product-06.jpg" alt="product" style="height:200px; width: auto;">
                              </div>  

                               <div class="col-md-12 col-12 text-left">
                                <h2 class="text-left pt-5 float-left text-white">
                                    <span class="float-left pr-5">infinex </span> <img src="assets/images/brands/infi.png" style="width: auto; height: 30px">
                                </h2><div class="clearfix"></div>
                                <p class="slider-ptext">The Infinix Note 5 is a highly intelligent note-smartphone, which is powered by Google's Android One. </p>
                                  
                                  <ul class="slider-ptext-ul">
                                        <li>4 GB RAM | 64 GB ROM | Expandable Upto 128 GB</li>
                                        <li>15.21 cm (5.99 inch) Full HD+ Display</li>
                                        
                                  </ul>
                                   <button class="rounded-btn">
                                       View More
                                   </button>
                               </div> 
                            </div>    
                           </a>
                       </div>

                        <div class="product-default" style="width:99%">
                           <a href="#">
                            <div class="row bg-success pt-2 pb-2">
                              <div class="col-md-12 col-12">
                                <img src="assets/images/products/product-06.jpg" alt="product" style="height:200px; width: auto;">
                              </div>  

                               <div class="col-md-12 col-12 text-left">
                                <h2 class="text-left pt-5 float-left text-white">
                                    <span class="float-left pr-5">infinex </span> <img src="assets/images/brands/infi.png" style="width: auto; height: 30px">
                                </h2><div class="clearfix"></div>
                                <p class="slider-ptext">The Infinix Note 5 is a highly intelligent note-smartphone, which is powered by Google's Android One. </p>
                                  
                                  <ul class="slider-ptext-ul">
                                        <li>4 GB RAM | 64 GB ROM | Expandable Upto 128 GB</li>
                                        <li>15.21 cm (5.99 inch) Full HD+ Display</li>
                                        
                                  </ul>
                                   <button class="rounded-btn">
                                       View More
                                   </button>
                               </div> 
                            </div>    
                           </a>
                       </div>

 </div><!-- End .featured-proucts -->

                </div><!-- End .container -->
            </div><!-- End .featured-proucts-section -->


           
               <div class="mt-2"></div><!---margin-->
            <div class="featured-products-section carousel-section">
                <div class="container">
                    <h2 class="h3 title float-left">SMART PHONES</h2>
                    <div class="under-l"></div>
                    <a href="#" class="float-right rounded-btn">View All</a>
                    <div class="clearfix"></div><br>
                    <!-- <hr class="sethr" style=" margin:0px 0px 20px 0px"> -->
                      


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
                                'items': 4
                            }

                        }

                    }">
                        <div class="product-default" style="width:270px">
                            <a href="#">
                            <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-01.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                               <h2 class="product-title text-black">
                                    Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                  <strong><strike>₹13999</strike>
                                    &nbsp; ₹1000<br>
                                  </strong>
                                    33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                                              
                                  </h2>
                                <div class="price-box">
                                 </div><!-- End .price-box -->
                                
                            </div><!-- End .product-details -->
                             </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                             <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-02.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                                <div class="price-box">
                                 </div><!-- End .price-box -->
                             </div><!-- End .product-details -->
                           </a>
                        </div>

                        <div class="product-default" style="width:270px">
                             <a href="#">
                                 <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span>
                            <figure>
                                <img src="assets/images/products/product-03.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                                <div class="price-box">
                                 </div><!-- End .price-box -->
                             </div><!-- End .product-details -->
                         </a>
                        </div>

                        <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-02.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                              <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                                <div class="price-box">
                                 </div><!-- End .price-box -->
                             </div><!-- End .product-details -->
                             </a>
                        </div>

                         <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                             <figure>
                                 <img src="assets/images/products/product-01.jpg" alt="product">
                             </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                                <div class="price-box">
                                 </div><!-- End .price-box -->
                             </div><!-- End .product-details -->
                            </a>
                        </div>
                        
                       
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#08c;opacity:0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-06.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                                <div class="price-box">
                                 </div><!-- End .price-box -->
                             </div><!-- End .product-details -->
                         </a>
                        </div>
                    </div><!-- End .featured-proucts -->

                </div><!-- End .container -->
            </div><!-- End .featured-proucts-section -->
            <div class="mt-2"></div><!---margin-->




            <div class="featured-products-section carousel-section">
                <div class="container">

                    <h2 class="h3  title float-left">SMART WEARABLE TECH</h2>
                    <div class="under-l"></div>
                    <a href="#" class="float-right rounded-btn">View All</a>
                     <div class="clearfix"></div>
                     <!-- <hr class="sethr" style=" margin:0px 0px 20px 0px"> --><br>

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
                                'items': 4
                            }

                        }

                    }">
                        <div class="product-default" style="width:270px">
                            <a href="#">
                            <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-21.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                               
                                
                            </div><!-- End .product-details -->
                             </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                             <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-22.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                               <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                           </a>
                        </div>
                        <div class="product-default" style="width:270px">
                             <a href="#">
                                 <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-23.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                              <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </a>
                        </div>

                        <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-24.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                               
                             </div><!-- End .product-details -->
                             </a>
                        </div>

                         <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                             <figure>
                                 <img src="assets/images/products/product-21.jpg" alt="product">
                             </figure>
                            <div class="product-details text-left">
                               <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                            </a>
                        </div>
                        
                       
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#08c;opacity:0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-22.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                               <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </a>
                        </div>
                    </div><!-- End .featured-proucts -->

                </div><!-- End .container -->
            </div><!-- End .featured-proucts-section -->
            <div class="mt-2"></div><!---margin-->

             <div class="featured-products-section carousel-section">
                <div class="container">
                    <h2 class="h3 title float-left">MOBILE ACCESSORIES</h2>
                    <div class="under-l"></div>
                    <a href="#" class="float-right rounded-btn">View All</a>
                    <div class="clearfix"></div><br>
                    <!-- <hr class="sethr" style=" margin:0px 0px 20px 0px"> -->

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
                                'items': 4
                            }

                        }

                    }">
                        <div class="product-default" style="width:270px">
                            <a href="#">
                            <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-21.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                               
                            </div><!-- End .product-details -->
                             </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                             <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-25.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                           </a>
                        </div>
                        <div class="product-default" style="width:270px">
                             <a href="#">
                                 <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-26.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </a>
                        </div>

                        <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-27.jpg" alt="product">
                            </figure>
                            <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                               
                             </div><!-- End .product-details -->
                             </a>
                        </div>

                         <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                             <figure>
                                 <img src="assets/images/products/product-28.jpg" alt="product">
                             </figure>
                            <div class="product-details text-left">
                                  <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                            </a>
                        </div>
                        
                        
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                 <span class="rating" style="background:#08c;opacity:0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-25.jpg" alt="product">
                            </figure>
                             <div class="product-details text-left">
                                  <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </a>
                        </div>
                    </div><!-- End .featured-proucts -->

                </div><!-- End .container -->
            </div><!-- End .featured-proucts-section -->
            <div class="mt-2"></div><!---margin-->

            <div class="">
                <div class="container">
                 <div class="row">   
                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color:#0088cc;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-mo.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                     <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">Starting from Rs 9999  Up to 70% discount</a>
                    </div>
                    </div>
                    </div> 
                    </div>   
                 </div>

                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #0088cc;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-mo.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                    <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">Starting from Rs 9999  Up to 70% discount</a>
                    </div>
                    </div>
                    </div> 
                    </div>   
                 </div>

                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #0088cc;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-mo.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                    <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">Starting from Rs 9999  Up to 70% discount</a>
                    </div>
                   </div>
                    </div> 
                    </div>   
                 </div>

                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #0088cc;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-mo.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                     <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">Starting from Rs 9999  Up to 70% discount</a>
                    </div>
                    </div>
                    </div> 
                    </div>   
                 </div>

               </div><!---row--->
                </div><!--container--->    
            </div><!---section-->
           
            <div class="mb-2"></div><!-- margin -->

            <div class="featured-products-section carousel-section">
                <div class="container">
                   <h2 class="h3 title float-left">TVS & HOME ENTERTAINMENT</h2>
                   <div class="under-l"></div>
                    <a href="#" class="float-right rounded-btn">View All</a>
                    <div class="clearfix"></div><br>
                    <!-- <hr class="sethr" style=" margin:0px 0px 20px 0px"> -->


                    <div class="new-products owl-carousel owl-theme"  data-toggle="owl" data-owl-options="{
                        'margin': 20,
                        'autoplayHoverPause' : true,
                        'nav' : true,
                        'items': 2,
                        'autoplayTimeout': 5000,
                        'responsive': {
                            '559': {
                                'items': 3
                            },
                            '975': {
                                'items': 4
                            }

                        }

                    }">
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <figure>
                                <img src="assets/images/products/product-8.jpg" alt="product">
                               </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                  <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                           </div><!-- End .product-details -->
                            </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-9.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </div><!-- End .product-details -->
                        </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#08c; opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-10.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                  <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                          </div><!-- End .product-details -->
                      </a>
                        </div>
                       <div class="product-default" style="width:270px">
                        <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-11.jpg" alt="product">
                                 </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </div><!-- End .product-details -->
                     </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-8.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </div><!-- End .product-details -->
                        </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-9.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                          </div><!-- End .product-details -->
                      </a>
                        </div>
                    </div><!-- End .news-proucts -->
                </div>
            </div>
            <div class="mt-2"></div>


            <div class="mb-2"></div><!-- margin -->

              <div class="featured-products-section carousel-section">
                <div class="container">
                    <h2 class="h3 title float-left">TELEVISIONS</h2>
                     <div class="under-l"></div>
                    <a href="#" class="float-right rounded-btn">View All</a>
                    <div class="clearfix"></div><br>
                    <!-- <hr class="sethr" style=" margin:0px 0px 20px 0px"> -->

                      <div class="new-products owl-carousel owl-theme"  data-toggle="owl" data-owl-options="{
                        'margin': 20,
                        'autoplayHoverPause' : true,
                        'nav' : true,
                        'items': 2,
                        'autoplayTimeout': 5000,
                        'responsive': {
                            '559': {
                                'items': 3
                            },
                            '975': {
                                'items': 4
                            }

                        }

                    }">
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-8.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </div><!-- End .product-details -->
                         </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-9.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </div><!-- End .product-details -->
                         </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-10.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                           </div><!-- End .product-details -->
                       </a>
                        </div>
                       <div class="product-default" style="width:270px">
                        <a href="#">
                                <span class="rating" style="background:#08c;opacity: 0">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                 <img src="assets/images/products/product-11.jpg" alt="product">
                             </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                          </div><!-- End .product-details -->
                         </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-8.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                            </div><!-- End .product-details -->
                        </a>
                        </div>
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-9.jpg" alt="product">
                             </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </div><!-- End .product-details -->
                     </a>
                        </div>
                    </div><!-- End .news-proucts -->
                </div>
            </div>
            <div class="mt-2"></div>


                   
                        <div class="">
                <div class="container">
                 <div class="row">

                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #37489e;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-tv.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                     <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">30% Off Lotus Electronics</a>
                    </div>
                   </div>
                    </div> 
                    </div>   
                 </div>

                <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #37489e;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-tv.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                     
                     <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">30% Off Lotus Electronics</a>
                    </div>
                    </div>
                    </div> 
                    </div>   
                 </div>

                <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #37489e;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-tv.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                     <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">30% Off Lotus Electronics</a>
                    </div>
                   </div>
                    </div> 
                    </div>   
                 </div>

                <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #37489e;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-tv.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                      <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">30% Off Lotus Electronics</a>
                    </div>
                   </div>
                    </div> 
                    </div>   
                 </div>

               </div><!---row--->
                </div><!--container--->    
            </div>

                    </div>
                    <div class="mb-1"></div>
                </div><!-- End .container -->
            </div><!-- End .carousel-section -->


             <div class="mb-2"></div><!-- margin -->

              <div class="featured-products-section carousel-section">
                <div class="container">
                      <h2 class="h3 title float-left">Home Appliances</h2>
                    <div class="under-l"></div>
                    <a href="#" class="float-right rounded-btn">View All</a>
                    <div class="clearfix"></div><br>
                    <!-- <hr class="sethr" style=" margin:0px 0px 20px 0px"> -->



                    <div class="new-products owl-carousel owl-theme"  data-toggle="owl" data-owl-options="{
                        'margin': 20,
                        'autoplayHoverPause' : true,
                        'nav' : true,
                        'items': 2,
                        'autoplayTimeout': 5000,
                        'responsive': {
                            '559': {
                                'items': 3
                            },
                            '975': {
                                'items': 4
                            }

                        }

                    }">

                       <?php for ($i=1; $i <=5; $i++) { $name=11; $count=$name+$i;?>
                           
                        
                        <div class="product-default" style="width:270px">
                            <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-<?php echo $count;?>.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </div><!-- End .product-details -->
                     </a>
                        </div>
                       
                     <?php } ?>
                        
                       
                    </div><!-- End .news-proucts -->

                    <div class="mt-2"></div>

                     <div class="featured-products-section carousel-section">
                     	 <h2 class="h3 title float-left">WATER GEYSERS</h2>
                     	  <div class="under-l"></div>
                    <a href="#" class="float-right rounded-btn">View All</a>
                    <div class="clearfix"></div><br>
                    <!-- <hr class="sethr" style=" margin:0px 0px 20px 0px"> -->

                        <div class="new-products3 owl-carousel owl-theme"  data-toggle="owl" data-owl-options="{
                        'margin': 20,
                        'autoplayHoverPause' : true,
                        'nav' : true,
                        'items': 2,
                        'autoplayTimeout': 6000,
                        'responsive': {
                            '559': {
                                'items': 3
                            },
                            '975': {
                                'items': 4
                            }

                        }

                    }">


                    <?php for ($i=1;$i<=5;$i++) { $name=18; $count=$name-$i;?>
                           
                        
                        <div class="product-default" style="width:270px">
                             <a href="#">
                                <span class="rating" style="background:#28a745">
                                    2&nbsp;<i class="fa fa-star"></i> (1) 
                                </span><!-- End .ratings -->
                            <figure>
                                <img src="assets/images/products/product-<?php echo $count;?>.jpg" alt="product">
                            </figure>
                            <div class="product-details">
                                <div class="product-details text-left">
                                 <h2 class="product-title text-black">
                                Redmi Y3 (64 GB) (4 GB RAM)....<br>
                                <strong><strike>₹13999</strike>
                                &nbsp; ₹1000<br>
                                </strong>
                                33.2%&nbsp; Off  &nbsp; [Discount &nbsp; ₹4520]
                                </h2>
                             </div><!-- End .product-details -->
                         </div><!-- End .product-details -->
                     </a>
                        </div>
                       
                     <?php } ?>
                    </div><!-- End .news-proucts -->

                    <div class="mt-2">
                        <div class="">
                <div class="container">
                 <div class="row">   
                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #bc882c;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-was.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                     <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">Starting from Rs 9999  Up to 70% discount</a>
                    </div>
                    </div>
                    </div> 
                    </div>   
                 </div>

                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #bc882c;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-was.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                     <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">Starting from Rs 9999  Up to 70% discount</a>
                    </div>
                   </div>
                    </div> 
                    </div>   
                 </div>

                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #bc882c;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-was.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                     <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">Starting from Rs 9999  Up to 70% discount</a>
                    </div>
                  </div>
                    </div> 
                    </div>   
                 </div>

                 <div class="col-md-3 col-xs-6">
                    <div class="home-banner1 mb-2" style="background-color: #bc882c;background-image:url(assets/images/bg-border.png);background-position: center top;
    background-size: cover;">
                        <div class="row">
                        <div class="col-md-4 col-4">
                            <img src="assets/images/add-was.jpg">
                        </div> 

                     <div class="col-md-8 col-8">
                    
                    <div class="banner-content">
                        <h3 class="mb-0">
                        	Samsung Galaxy</h3>
                        <a href="#">Starting from Rs 9999  Up to 70% discount</a>
                    </div>
                </div>
                    </div> 
                    </div>   
                 </div>

               </div><!---row--->
                </div><!--container--->    
            </div>

                    </div>
                    <div class="mb-0"></div>
                </div><!-- End .container -->
            </div><!-- End carousel-section -->

            <div class="mb-2"></div><!-- margin -->

           
             <div class="featured-products-section carousel-section">
            <div class="container">
                       <h2 class="h3 title float-left">Popular Brands</h2>
                        <a href="#" class="rounded-btn float-right">View All</a>
                      <div class="clearfix"></div><br>
                      <hr class="sethr" style=" margin:0px 0px 20px 0px">
                   

             <div class="partners-container pt-1 pb-1 ">
                <div class="container">
                    <div class="partners-carousel  owl-carousel owl-theme min-123" data-toggle="owl" data-owl-options="{
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
                                'items': 6
                            }

                        }

                    }">
                       <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="https://www.RopoShop.com/assets/brand/20/1547141057.jpeg" alt="" style="height:80px;width: auto;">
                        </a>
                        <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="https://www.RopoShop.com/assets/brand/21/1547141107.png" alt="" style="height:80px;width: auto;">
                        </a>
                        <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                             <img src="https://www.RopoShop.com/assets/brand/22/1549906444.png" alt="" style="height:80px;width: auto;">
                        </a>
                       <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                           <img src="https://www.RopoShop.com/assets/brand/23/1550291698.png" alt="" style="height:80px;width: auto;">
                        </a>
                        <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                             <img src="https://www.RopoShop.com/assets/brand/24/1550424601.jpeg" alt="" style="height:80px;width: auto;">
                        </a>
                         <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                           <img src="https://www.RopoShop.com/assets/brand/25/1550427470.png" alt="">
                        </a>
                       <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;background:#08c">
                           <h3 style="color:#fff">Oppo fsdfdfdfdfdfd</h3>
                        </a>
                        <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="https://www.RopoShop.com/assets/brand/26/1550431333.png" alt="" >
                        </a>
                        
                    </div><!-- End .partners-carousel -->
                </div><!-- End .container -->
            </div><!-- End .partners-container -->
            </div></div>

            <div class="featured-products-section carousel-section">
           	<div class="container">
                     	<h2 class="h3 title  float-left">Nearby Sellers</h2>
                     	 <a href="#" class="rounded-btn float-right">View All</a>
                      <div class="clearfix"></div><br>
                      <hr class="sethr" style=" margin:0px 0px 20px 0px">

                   

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
                       <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="assets/images/merchants/1.png" alt="" style="height:80px;width: auto;">
                        </a>
                        <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="assets/images/merchants/2.jpeg" alt="" style="height:80px;width: auto;">
                        </a>
                        <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="assets/images/merchants/3.jpeg" alt="" style="height:80px;width: auto;">
                        </a>
                       <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="assets/images/merchants/4.jpeg" alt="" style="height:80px;width: auto;">
                        </a>
                        <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="assets/images/merchants/5.jpeg" alt="" style="height:80px;width: auto;">
                        </a>
                         <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="assets/images/merchants/6.jpeg" alt="">
                        </a>
                       <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;background:red">
                           <h3 style="color:#fff">Kamal Shop dfgfg fgfg  rtrtrtertr rt rtr</h3>
                        </a>
                        <a href="#" class="partner" style="width:auto;height:90px;max-height:90px;max-width:200px;">
                            <img src="assets/images/merchants/7.jpeg" alt="" >
                        </a>
                        
                    </div><!-- End .partners-carousel -->
                </div><!-- End .container -->
            </div><!-- End .partners-container -->
            </div></div>


            <!----App Download---->
            <div class="info-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="assets/images/mob-frame.jpg">
                        </div><!-- End .col-md-4 -->

                        <div class="col-md-6">

                         <h1>Download RopopShop <br>
                          App Now !</h1> 
                          <p>Fast, Simple & Delightful.<br>All it takes is 30 seconds to Download.</p> <br>
                           <div class="row">
                            <div class="col-md-6">
                          <a href="#"><img src="assets/images/appstore.jpg"></a>  
                      </div>
                           <div class="col-md-6">
                          <a href="#"><img src="assets/images/googleplay.jpg"></a>
                          </div>
                      </div>
                            
                        </div><!-- End .col-md-4 -->
                        
                        
                       
                       
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div>
            <!----App Download----->

            <!---------------->
            <div class="">
                <div class="container">
                   <div class="row">
                     <div class="col-md-12 lg-12 col-12 pt-2 pb-5">
                      <h3> ABOUT RopoShop</h3><P>About RopoShop – India’s Ultimate Online Shopping Site RopoShop’s vision is to create India’s most reliable and frictionless commerce ecosystem that creates life-changing experiences for buyers and sellers. In February 2010, Kunal Bahl along with Rohit Bansal, started RopoShop.com - India’s largest online shopping marketplace, with the widest assortment of 35 million plus products across 800 plus diverse categories from over 125,000 regional, national, and international brands and retailers. With millions of users and more than 300,000 sellers, RopoShop is the online shopping site for Internet users across the country, delivering to 6000+ cities and towns in India. In its journey till now, RopoShop has partnered with several global marquee investors and individuals such as SoftBank, BlackRock, Temasek, Foxconn, Alibaba, eBay Inc., Premji Invest, Intel Capital, Bessemer Venture Partners, Mr. Ratan Tata, among others. Online Shopping – A Boon The trend of online shopping is becoming a household name and so is RopoShop. RopoShop is the preferred choice of hundreds of thousands of online shoppers given its mammoth assortment of 15 million+ products, quick delivery even to the remotest corners of the country, and daily deals, discounts & offers to make products available at slashed down prices to our valuable customers. Get Started! Shop Online Today at RopoShop If you have been missing out on all the fun of online shopping thinking it requires one to be a technology aficionado then we have good news for you. Shopping online particularly at RopoShop is a child’s play; all you need is a mobile phone or laptop or tablet with Internet connection to get started. Simply log into RopoShop.com and browse through the wide assortment of products across categories. Once you have zeroed in on your favorite products, simply place the order by filling in the details; the products will be delivered right at your doorstep. Fulfill Your Entrepreneurial Dreams! Sell Today at RopoShop Thanks to easy-to-understand, flexible policies and SD Advisors to help sellers at each step, anyone from a manufacturer to wholesaler to retailer can sell on RopoShop.</P>
                   </div> 
                </div>    
            </div>
            <!---------------->


        </main><!-- End .main -->

        
        <!----Start footer-->
        <?php include('include/footer.php'); ?>
        <!-- End .footer -->
    </div><!-- End .page-wrapper -->

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

       <!--Mobile-menu-container-->
           <?php include('include/mobile-menu.php'); ?>
       <!-- End .mobile-menu-container -->

   

   
    

    <a id="scroll-top" href="#top" role="button"><i class="icon-angle-up"></i></a>

       <!----------js-------->
       <?php include('include/js.php'); ?>
       
       <!---------=Js-------->
</body>

</html>