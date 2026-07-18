<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>ROPOshop</title>

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
          button.btn.btn-success {
           background: #004bcc;
           } 

           button.btn.btn-success:hover {
         border-color: #fff;
          }
           .error{
  color:red;
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
                        <li class="breadcrumb-item"><a href="#" class="text-active">User SignUp</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav>


               <div class="row row-sm">
                         <div class="col-md-6  pt-5 pb-5 pl-5 pr-5 mx-auto">
                  <div class="bdr-d pt-2 pb-2">
                  <div class="text-center pb-2 mt-1"><h3>SIGN UP</h3></div>
                 
                  <form id="register-form" class="pl-5 pt-3" method="post" accept="#">
                    <div class="form-group">
                          <label for="">Full name</label>
                               <input type="text" class="form-control" id="" name="name">
                    </div> 

                    <div class="form-group">
                      <label for="">Email</label>
                               <input type="email" class="form-control" id="" name="email" autocomplete="off">
                    </div>

                   <div class="form-group">
                          <label for="">Password</label>
                               <input type="password" class="form-control" id="" name="password2" autocomplete="off">
                    </div>

                    
                    <div class="form-group">
                          <label for="">Confirm Password</label>
                               <input type="password" class="form-control" id="" name="password" autocomplete="off">
                    </div>

                    <center> <button class="btn-custom btn-primary">Sign Up</button><br>

                     <a href="login.php">Login Now</a>
                     </center>
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
        <!---------=Js-------->
          <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
       <script>
           $(document).ready(function($) {
        
        $("#register-form").validate({
                rules: {
                    name: "required",   
                    email: "required",                 
                    password: {
                        required: true,
                        minlength: 6
                    },
                     password2: {
                        required: true,
                        minlength: 6
                    },
                   city: "required",
                  gender: "required"
                 
                },
                messages: {
                    name: "Please enter your Name",        
                    email: "Please enter your correct Email id",                   
                    password: {
                        required: "Please enter your correct password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    password2: {
                        required: "Please enter your  password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                  city: "Please enter your city",
                  gender: "This field is required"
                },
                 errorPlacement: function(error, element) 
        {
            if ( element.is(":radio") ) 
            {
                error.appendTo( element.parents('.form-group') );
            }
            else 
            { // This is the default behavior 
                error.insertAfter( element );
            }
         },
                submitHandler: function(form) {
                    form.submit();
                }
                
            });
    });
       </script>
</body>

</html>           