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
<body>
    <div class="page-wrapper">
        
        <!---header--->
        <?php include('include/header.php'); ?> 
        <!-- End .header -->

        <main class="main">

       <div class="banner banner-cat" style="height: 100px;">
                <div class="banner-content container">
                    <i><h3 class="banner-subtitle"><a href="index.php">Home </a>/Brands Details</h3></i>
                   
                </div><!-- End .banner-content -->
            </div>

            <!-------->

             <div class="container mt-3 mb-3">
               <div class="row row-sm">

                <div class="col-md-4">
                    <img src="assets/images/big-brand.jpeg">
                </div>

                <div class="col-md-8">
                   <h2> Samsung</h2>
                   <hr class="mt-1 mb-1">
                   <p>
                       Samsung is a South Korean multinational conglomerate headquartered in Samsung Town, Seoul. It comprises numerous affiliated businesses, most of them united under the Samsung brand, and is the largest South Korean chaebol. Samsung was founded by Lee Byung-chul in 1938 as a trading company.</p>

                       <p class="toggset" style="display: none;">numerous affiliated businesses, most of them united under the Samsung brand, and is the largest South Korean chaebol. Samsung was founded by Lee Byung-chul in 1938 as a trading company.numerous affiliated businesses, most of them united under the Samsung brand, and is the largest South Korean chaebol. Samsung was founded by Lee Byung-chul in 1938 as a trading company.numerous affiliated businesses, most of them united under the Samsung brand, and is the largest South Korean chaebol.
                   </p>
                   <a href="javascript:void(0)" class="btn btn-primary float-right togg-btn">View More</a>

                </div>
              </div><!--row-->
               <hr class="mt-1 mb-1">
              <div class="row row-sm mt-5"><!---row-->

                             <div class="col-md-12 pb-3"><h2>Product</h2></div>
                             <br>
                             <?php for ($i = 0; $i <= 7; $i++) { ?>
    <div class="col-6 col-md-3">
     <div class="product-default">
      <a href="details.php">
         <figure>
         <img src="assets/images/products/product-01.jpg">
                                        
        </figure>
     <div class="product-details">
    <div class="product-details text-left">
     <h2 class="product-title text-black"> Redmi Y3 (64 GB) (4 GB RAM)....<br><strong><strike>13999</strike> 1000<br></strong>Off 33.2%<br>Discount ₹4520</h2>
    <div class="price-box">
    </div><!-- End .price-box -->
     </div>
                                       
    </div><!-- End .product-details -->
    </a>
    </div>
   </div> <!---col-->
<?php
   }
?>

                            

                             
                           
                             
                           
                             
                          

                             

                        </div><!---row-->

                        <nav class="toolbox toolbox-pagination">
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
            </div> <!-----container---->   

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


       
       
       <script>
$(document).ready(function(){
  $(".togg-btn").click(function(){
    $(".toggset").toggle();
  });
});
</script>

       
       <!---------=Js-------->
</body>

</html>           
