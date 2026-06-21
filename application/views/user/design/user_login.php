<body id="page-details" class="loaded">
<div class="container mb-3">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb mt-0">
                <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">User SignUp</a></li>
            </ol>
        </div>
        <!-- End .container -->
    </nav>
    <form method="post" action="<?= base_url('insertUser') ?>">
        <div class="row row-sm">
            <div class="col-md-6 pt-5 pb-5 pl-5 pr-5 mx-auto" style="padding: 5px !important;">
                <div class="bdr-d" style="margin-top: 15px; padding: 10px;">
                    <div class="text-center pb-0 mt-0">
                        <h3 style="margin-bottom: 0px;">SIGN UP</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Full name <sup>*</sup></label>
                        <input type="text" class="form-control" id="" name="full_name" required /> 
                    </div>
                    <div class="form-group">
                        <label for="">Email <sup>*</sup></label>
                        <input type="email" class="form-control" id="" name="email" autocomplete="off" required /> 
                    </div>
                    <div class="form-group">
                        <label for="">Password <sup>*</sup></label>
                        <input type="password" class="form-control" id="" name="password" autocomplete="off" required /> 
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password <sup>*</sup></label>
                        <input type="password" class="form-control" id="" name="confirm_password" autocomplete="off" required /> 
                    </div>
                    <center>
                        <button class="btn-custom btn-success">Create new account</button>
                    </center>
                </div>
            </div>

            <div class="col-md-6 pt-5 pb-5 pl-5 pr-5 mx-auto" style="padding: 5px !important;">
                <div class="bdr-d" style="margin-top: 15px; padding: 10px;">
                    <div class="text-center pb-0 mt-0">
                        <h3 style="margin-bottom: 0px;">SIGN IN</h3>
                    </div>
                    <form method="post" class="pl-5 pt-3" action="<?= base_url('userLogin') ?>">
                        <div class="form-group">
                            <label for="">Email <sup>*</sup></label>
                            <input type="text" class="form-control" id="" name="email" required /> 
                        </div>
                        <div class="form-group">
                            <label for="">Password <sup>*</sup></label>
                            <input type="password" class="form-control" id="" name="password" autocomplete="off" required /> 
                        </div>
                        <center>
                            <button class="btn-custom btn-primary">Login</button>
                            <a href="#resetPassword" data-toggle="modal">Forgot password?</a>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
<!-----container---->