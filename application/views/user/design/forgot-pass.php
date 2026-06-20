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
           a.text-active {
              color: #08c;
          }

       </style>
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
                        <li class="breadcrumb-item"><a href="#" class="text-active">Forget Password</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav>


               <div class="row row-sm">

                <div class="col-md-6  pt-5 pb-5 pl-5 pr-5 mx-auto">
                  <div class="bdr-d pt-2 pb-2">
                  <div class="text-center pb-2 mt-1"><h3>Forgot Password</h3></div>
                  <form class="pl-5 pt-3" method="post" accept="#">
                    <div class="form-group required-field">
                          <label for="">Email</label>
                               <input type="email" class="form-control" id="" name="" required="">
                    </div>


                    <button class="btn-custom btn-primary">Submit</button>

                        

                        <br>
                          <a href="merchant-signup.php">Create an account</a>


                          <div class="alert alert-success alert-dismissible mr-3 mt-3 text-center">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong><br> sent link for email address please check your email address
                          </div>

                          


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