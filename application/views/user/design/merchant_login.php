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
    <div class="row row-sm">
        <div class="col-md-6  pt-5 pb-5 pl-5 pr-5 mx-auto">
            <div class="bdr-d pt-2 pb-2">
                <div class="text-center pb-2 mt-1">
                    <h3>SELLER SIGN UP</h3>
                </div>
                <form method="post" class="pl-5 pt-3" action="<?= base_url('insertSeller') ?>">
                    <div class="form-group">
                        <label for="">Owner's Full Name <sup>*</sup></label>
                        <input type="text" class="form-control" id="" name="first_name" value="<?= set_value('first_name') ?>" required /> 
                    </div>
                    <div class="form-group">
                        <label for="">Establishment (Shop) Name <sup>*</sup></label>
                        <input type="text" class="form-control" id="" name="shop_name" value="<?= set_value('shop_name') ?>" required /> 
                    </div>
                    <div class="form-group">
                        <label for="">Email <sup>*</sup></label>
                        <input type="email" class="form-control" id="" name="email" value="<?= set_value('email') ?>" required /> 
                        <?= UC_error_label('email') ?>
                    </div>

                    <div class="form-group">
                        <label for="">Password <sup>*</sup></label>
                        <input type="password" class="form-control" name="password" value="<?= set_value('password'); ?>" required /> 
                        <?= UC_error_label('password') ?>
                    </div>
                    <div class="alert alert-warning" role="alert">Password should be minimum 5 characters of length.</div>

                    <div class="form-group">
                        <label for="">Confirm Password <sup>*</sup></label>
                        <input type="password" class="form-control" name="confirm_password" value="<?= set_value('confirm_password') ?>" required /> 
                        <?= UC_error_label('confirm_password') ?>
                    </div>

                    <div class="form-group">
                        <label for="">Contact (Mobile) Number <sup>*</sup></label>
                        <input type="password" class="form-control" name="contact_number" value="<?= set_value('contact_number') ?>" required /> 
                        <?= UC_error_label('contact_number') ?>
                    </div>
                    <div class="alert alert-warning" role="alert">Mobile Number need to be exact 10 digits.</div>
                    <center>
                        <button class="btn btn-success">Sign Up</button>
                    </center>
                </form>
            </div>
        </div>

        <div class="col-md-6  pt-5 pb-5 pl-5 pr-5 mx-auto">
            <div class="bdr-d pt-2 pb-2">
                <div class="text-center pb-2 mt-1">
                    <h3>SIGN IN</h3>
                </div>
                <form method="post" class="pl-5 pt-3" action="<?= base_url('merchantLogin') ?>">
                    <div class="form-group">
                        <label for="">Email <sup>*</sup></label>
                        <input type="text" class="form-control" id="" name="username" required /> 
                    </div>
                    <div class="form-group">
                        <label for="">Password <sup>*</sup></label>
                        <input type="password" class="form-control" id="" name="password" required /> 
                    </div>
                    <center>
                        <button class="btn btn-success">Login</button>
                        <a href="#resetPassword" data-toggle="modal">Forgot password?</a>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-----container---->