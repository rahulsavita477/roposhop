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
            width: 20px !important;
            height: 20px !important;
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
   </head>
   <body id="page-category-list">
    <div class="page-wrapper">
        
        <!---header--->
        <?php include('include/header.php'); ?> 
        <!-- End .header -->

        <main class="main">

           <!--  <div class="banner banner-cat" style="height: 100px;">
                <div class="banner-content container">
                    <i><h3 class="banner-subtitle"><a href="index.php">Home </a>/ Mobile-phones</</h3></i>
                </div>
            </div> -->

            <!-------->
            <div class="container">
                
              <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb mt-0">
                        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="category.php">Categories</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-active">Mobile Phone</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">

                        <div class="col-md-3">
                           <div class="toolbox-item toolbox-sort">
                                    <div class="select-custom">
                                        <select name="orderby" class="form-control">  
                                            <option value="popularity">popularity</option>
                                            <option value="rating">average rating</option>
                                            <option value="date">Sort by newness</option>
                                           
                                        </select>
                                    </div><!-- End .select-custom -->

                                    <a href="#" class="sorter-btn" title="Set Ascending Direction"><i class="fa fa-arrow-down rotate" aria-hidden="true"></i></a>
                                   
                                </div><!-- End .toolbox-item -->
                        </div>
                        <div class="col-md-3"></div>
                         <div class="col-md-5">
                            <form method="get" action="/" class="form-inline">
                            <input name="" class="w-50" type="text" placeholder="Page search" required="">
                                <button type="submit" class="btn-primaryss"> <i class="icon-magnifier"></i></button>
                            </form>
                         </div>

                        <!-- <div class="col-md-4">
                           <label class="pt-2 float-left">Showing 1–9 of 60 results</label>
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
                            <?php for ($i=1; $i <=8; $i++){?>
                            <div class="col-6 col-sm-12 product-default left-details mb-1 pt-1">
                                
                                <span class="rating-right" style="background:#28a745">
                                           2&nbsp;<i class="fa fa-star"></i> (1) 
                                           </span>
                               <a href="details.php" style="columns:#000">
                                <div class="row">
                                  
                                <figure class="float-left">
                                 <img src="assets/images/products/product-01.jpg">
                                </figure>

                                 <div class="product-details">
                                    <h2>Redmi Y3 (64 GB) (4 GB RAM)</h2>
                                   <div class="product-filters-container">
                                 <ul>
                                 <li>4 GB RAM | 64 GB ROM | Expandable Upto 512 GB</li><li>15.24 cm (6.0 inch) FHD+ Display</li><li>24MP + 5MP + 8MP | 24MP Front Camera</li><li>3300 Lithium-ion Battery</li><li>Octa Core Processor (2.2 GHz)</li><li>Glass Design with Side Fingerprint Sensor</li> 
                                 </ul>

                                </div>
                                    <div class="price-box">
                                         <strong><strike>₹13999</strike> ₹1000<br></strong>
                                          33.2% Off [Discount ₹4520]
                                      
                                    </div><!-- End .price-box -->
                                    
                                </div><!-- End .product-details -->
                              </a>
                              </div>
                            </div>
                            <?php } ?>
                        </div>

                        <nav class="toolbox toolbox-pagination mt-2">
                            <div class="toolbox-item toolbox-show">
                                <label>Showing 1–9 of 60 results</label>
                            </div><!-- End .toolbox-item -->

                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><span>...</span></li>
                                <li class="page-item"><a class="page-link" href="#">15</a></li>
                                <li class="page-item">
                                    <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div><!-- End .col-lg-9 -->

                    <aside class="sidebar-shop col-lg-3 order-lg-first">
                       <div class="pin-wrapper" style="height: 1404px;"><div class="sidebar-wrapper sticky-active" style="border-bottom: 0px none rgb(122, 125, 130); width: 270px;">
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true" aria-controls="widget-body-1">Mobile Phones</a>
                                </h3>

                                <div class="collapse show" id="widget-body-1">
                                    <div class="widget-body">
                                        <ul class="cat-list">
                                            <li><a href="#">All in Mobile Phones</a></li>
                                            <li><a href="#">Smart Phones</a></li>
                                            <li><a href="#">Smart Wearable Tech</a></li>
                                            <li><a href="#">Mobile Accessories</a></li>
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                           
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true" aria-controls="widget-body-4">Brands</a>
                                </h3>

                                <div class="collapse show" id="widget-body-4">
                                    <div class="widget-body">
                                       <div class="filt">
                                        <ul class="cd-filter-content cd-filters list">
            <li>
              <input class="filter" data-filter=".check1" type="checkbox" id="checkbox1">
                <label class="checkbox-label" for="checkbox1">iPhone
                     <small>12</small>
                </label>
            </li>

            <li>
              <input class="filter" data-filter=".check2" type="checkbox" id="checkbox2">
              <label class="checkbox-label" for="checkbox2">iPad
               <small>16</small>
             </label>
            </li>

            <li>
              <input class="filter" data-filter=".check3" type="checkbox" id="checkbox3">
              <label class="checkbox-label" for="checkbox3">Apple TV
               <small>17</small>
             </label>
            </li>
                        <li>
              <input class="filter" data-filter=".check4" type="checkbox" id="checkbox4">
              <label class="checkbox-label" for="checkbox4">Macbook
               <small>20</small>
             </label>
            </li>
                        <li>
              <input class="filter" data-filter=".check5" type="checkbox" id="checkbox5">
              <label class="checkbox-label" for="checkbox5">Macbook Air
               <small>12</small>
             </label>
            </li>
                        <li>
              <input class="filter" data-filter=".check6" type="checkbox" id="checkbox6">
              <label class="checkbox-label" for="checkbox6">Macbook Pro 
                <small>55</small>
              </label>
            </li>
                        <li>
              <input class="filter" data-filter=".check7" type="checkbox" id="checkbox7">
              <label class="checkbox-label" for="checkbox7">Apple Accessories 
                <small>12</small>
              </label>
            </li>
          </ul>
                            </div>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                           

                               <!-------->
                  <div class="widget widget-featured">
                                <h3 class="widget-title pt-2">Featured Products</h3>
                                
                                <div class="widget-body">
                                    <div class="owl-carousel widget-featured-products owl-loaded owl-drag">
                                        <!-- End .featured-col -->

                                        <!-- End .featured-col -->
                                    <div class="owl-stage-outer owl-height" style="height: 297px;">
                                    <div class="owl-stage" style="transform: translate3d(-516px, 0px, 0px); transition: all 0.25s ease 0s; width: 1548px;">

                    <div class="owl-item active"><div class="featured-col">

                     <div class="owl-item cloned">
                        <?php for ($i=1; $i <=3; $i++){?>
                            
                      <div class="featured-col">
                  <a href="details.php"> 

                     <div class="product-site">
                    <span class="rating-left" style="background:#28a745">
                          2&nbsp;<i class="fa fa-star"></i> (1) 
                     </span><!-- End .ratings -->
                       
                      <div class="row">  
                      <div class="col-md-4 pl-0 pr-0">               
                     <img class="img-fluid" src="assets/images/products/product-12.jpg">
                      </div>

                      <div class="col-md-8 pl-0 pr-0">                 
                     <div class="product-details">
                        <h2 class="product-title text-black pt-2" style="font-size: 13px;font-weight: 500">
                           Redmi Y3 (64 GB) (4 GB RAM)....<br>
                         <strong><strike>₹13999</strike>&nbsp; ₹1000<br></strong>
                          33.2%&nbsp; Off  &nbsp;
                        </h2>
                    </div><!-- End .product-details -->
                      </div>
                       </div><!---row-->                  
                   </div>
                 </a>
                     
                      </div>
                        <?php } ?>
                      </div>
                 </div>
                  </div><!----1------->

                   <div class="owl-item"><div class="featured-col">

                     <div class="owl-item cloned">
                        <?php for ($i=1; $i <=4; $i++){?>
                            
                      <div class="featured-col">
                  <a href="details.php"> 

                     <div class="product-site">
                    <span class="rating-left" style="background:#28a745">
                          2&nbsp;<i class="fa fa-star"></i> (1) 
                     </span><!-- End .ratings -->
                       
                      <div class="row">  
                      <div class="col-md-4 pl-0 pr-0">               
                     <img class="img-fluid" src="assets/images/products/product-12.jpg">
                      </div>

                      <div class="col-md-8 pl-0 pr-0">                 
                     <div class="product-details">
                        <h2 class="product-title text-black pt-2" style="font-size: 13px;font-weight: 500">
                           Redmi Y3 (64 GB) (4 GB RAM)....<br>
                         <strong><strike>₹13999</strike>&nbsp; ₹1000<br></strong>
                          33.2%&nbsp; Off  &nbsp;
                        </h2>
                    </div><!-- End .product-details -->
                      </div>
                       </div><!---row-->                  
                   </div>
                 </a>
                     
                      </div>
                        <?php } ?>
                      </div>
                 </div>
                  </div><!----2------->

                   <div class="owl-item active"><div class="featured-col">

                     <div class="owl-item cloned">
                        <?php for ($i=1; $i <=5; $i++){?>
                            
                      <div class="featured-col">
                  <a href="details.php"> 

                     <div class="product-site">
                    <span class="rating-left" style="background:#28a745">
                          2&nbsp;<i class="fa fa-star"></i> (1) 
                     </span><!-- End .ratings -->
                       
                      <div class="row">  
                      <div class="col-md-4 pl-0 pr-0">               
                     <img class="img-fluid" src="assets/images/products/product-12.jpg">
                      </div>

                      <div class="col-md-8 pl-0 pr-0">                 
                     <div class="product-details">
                        <h2 class="product-title text-black pt-2" style="font-size: 13px;font-weight: 500">
                           Redmi Y3 (64 GB) (4 GB RAM)....<br>
                         <strong><strike>₹13999</strike>&nbsp; ₹1000<br></strong>
                          33.2%&nbsp; Off  &nbsp;
                        </h2>
                    </div><!-- End .product-details -->
                      </div>
                       </div><!---row-->                  
                   </div>
                 </a>
                     
                      </div>
                        <?php } ?>
                      </div>
                 </div>
                  </div><!----3------->





                      </div>
                            </div>

                                        <div class="owl-dots disabled "></div></div><!-- End .widget-featured-slider -->
                                </div><!-- End .widget-body -->




                            </div><!-- End .widget -->
                 
                <!-------->   

                            <div class="widget widget-block">
                                <h3 class="widget-title">Custom Messages</h3>
                                <h5>This is a custom sub-title.</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur elitad adipiscing Cras non placerat mi. </p>
                            </div><!-- End .widget -->
                        </div></div><!-- End .sidebar-wrapper -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
               
            </div>
            <!-------->

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

         <script>
           $(".rotate").click(function () {
    $(this).toggleClass("down");
})
       </script>
</body>

</html>    