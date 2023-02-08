<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Roposhop</title>

    <meta name="" content="HTML5 Template" />
    <meta name="" content="P">
    <meta name="" content="">
        
       <!---css--->
         <?php include('include/css.php'); ?>
       <!---css--->
       <style type="text/css">
         .color-change {
    color: #08c !important;
}
     .product-default:hover{
      border: none;
      padding: 5px;
     }
     .product-default{
      border: none;
      padding: 5px;
     }
       </style>
     }
</head>
<body>
    <div class="page-wrapper">
        
        <!---header--->
        <?php include('include/header.php'); ?> 
        <!-- End .header -->

        <main class="main">
 <!-------->

             <div class="container mb-3">
                 <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb mt-0">
                        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="category.php">Categories</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-active">Merchant-Detail</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav>
               <div class="row row-sm mt-5">

                <div class="col-md-4">
                    <img src="assets/images/merchants/4.jpeg">
                </div>

                <div class="col-md-8">
                   <h2> Gaurav Enterprises</h2>
                      <h2 class="pt-5 step-title">Merhant address</h2>
                          <p>142-143, REVENUE NAGAR, Annapurna Road, NEAR DUSSHERA MAIDAN, Indore, Madhya Pradesh, India - 452009
                          Shop no: 9152769319</p>
                          <hr class="mt-1 mb-1">

                     <div class="pt-1 pb-1">
                             <h2 class="pt-5 step-title">Business Days</h2>
                             <strong>All day</strong>
                          <p></p>
                    </div>
                          

                          
                    <div class="pt-1 pb-1">
                             <h2 class="pt-5 step-title">Business Hours</h2>

                             <strong>10:30 am - 9:30 pm</strong>
                          <p></p>
                          </div>
                   </div>

                </div><!---row--->
             
               
              <div class="row row-sm mt-5"><!---row-->

                             <div class="col-md-12 pb-3"><h2>Available Product</h2></div>
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
                                 <h2 class="product-title text-black">
                     Redmi Y3 (64 GB) (4 GB RAM)<br>
                     
                     <span class="color-change"> <strong><strike>₹ 13999</strike>
                                    &nbsp; ₹ 1000
                     </strong>
                     33.2%&nbsp; Off  &nbsp; (Discount &nbsp; ₹ 4520)
                     </span>                                     
                   </h2>
                               
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
