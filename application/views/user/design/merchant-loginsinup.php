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
</head>
<body>
    <div class="page-wrapper">
        
        <!---header--->
        <?php include('include/header.php'); ?> 
        <!-- End .header -->

        <main class="main">

       <div class="banner banner-cat" style="height: 100px;">
                <div class="banner-content container">
                    <i><h3 class="banner-subtitle"><a href="index.php">Home </a>/ Merchant Signin SignUp </h3></i>
                   
                </div><!-- End .banner-content -->
            </div>

            <!-------->

             <div class="container mt-3 mb-3">
               <div class="row row-sm">
                 
                 <div class="col-md-6  pt-5 pb-5 pl-5 pr-5">
                  <div class="bdr-d pt-2 pb-2">
                  <div class="text-center pb-2 mt-1"><h3>SELLER SIGN UP</h3></div>
                  <form class="pl-5 pt-3" method="post" accept="#">
                    <div class="form-group required-field">
                          <label for="">First Name</label>
                               <input type="text" class="form-control" id="" name="" required="">
                    </div> 

                    <div class="form-group required-field">
                          <label for="">Last Name</label>
                               <input type="text" class="form-control" id="" name="" required="">
                    </div> 

                    <div class="form-group required-field">
                          <label for="">Email</label>
                               <input type="email" class="form-control" id="" name="" required="">
                    </div>

                    <div class="form-group required-field">
                          <label for="">Password</label>
                               <input type="Password" class="form-control" id="" name="" required="">
                    </div>

                    <div class="form-group required-field">
                          <label for="">Confirm Password</label>
                               <input type="Password" class="form-control" id="" name="" required="">
                    </div>

                    <div class="form-group required-field">
                          <label for="">Contact number</label>
                               <input type="tel" class="form-control" id="" name="" required="">
                    </div>

                     <button class="btn-custom btn-primary">Sign Up</button>
                    
                  </form>
                     
                 </div>
                </div>

                 <div class="col-md-6  pt-5 pb-5 pl-5 pr-5">
                  <div class="bdr-d pt-2 pb-2">
                  <div class="text-center pb-2 mt-1"><h3>ALREADY REGISTERED ?</h3></div>
                  <form class="pl-5 pt-3" method="post" accept="#">
                    <div class="form-group required-field">
                          <label for="">Email</label>
                               <input type="email" class="form-control" id="" name="" required="">
                    </div>

                     <div class="form-group required-field">
                          <label for="">Password</label>
                               <input type="password" class="form-control" id="" name="" required="">
                    </div>

                    <button class="btn-custom btn-primary">Login</button>
                        &nbsp;&nbsp;&nbsp;<a href="#"> Forgot password?</a>


                    </form>
                  </div>
                </div> 
                     
                 </div>

               </div>  
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
       
       <!---------=Js-------->
</body>

</html>           