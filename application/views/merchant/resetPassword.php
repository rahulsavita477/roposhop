<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>RopoShop | Reset Password</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $this->config->item('site_url').'assets/favicon.ico' ?>" />

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="<?= $this->config->item('site_url').'assets/user/assets2/css/bootstrap.min.css' ?>" />

    <!-- Main CSS File -->
    <link rel="stylesheet" href="<?= $this->config->item('site_url').'assets/user/assets2/css/style.min.css' ?>" />
    <link rel="stylesheet" type="text/css"
        href="<?= $this->config->item('site_url').'assets/user/assets2/vendor/fontawesome-free/css/all.min.css' ?>" />
    <link rel="stylesheet" type="text/css"
        href="<?= $this->config->item('site_url').'assets/user/assets2/css/custom.css' ?>" />
</head>

<header class="header">
    <?php if (SITE_ENVIRONMENT != '') { ?>
    <div>
        <div class="container">
            <div class="info-box">
                <div class="info-box-content">
                    <h4><b>ENVIRONMENT : <?= SITE_ENVIRONMENT ?></b></h4>
                </div><!-- End .info-box-content -->
            </div><!-- End .info-box -->
        </div><!-- End .container -->
    </div><!-- End .info-boxes-container -->
    <?php } ?>

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <a href="<?= base_url() ?>" class="logo">
                    <img src="<?= $this->config->item('site_url').'assets/user/assets2/images/logo.png' ?>"
                        alt="RopoShop" width="180">
                </a>
            </div><!-- End .header-left -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header>

<body id="page-details" class="loaded">
    <div class="container mb-3">
        <div class="row row-sm">
            <div class="col-md-6 pt-5 pb-5 pl-5 pr-5 mx-auto" style="padding: 5px !important;">
                <div class="bdr-d" style="padding: 10px;">
                    <div class="text-center pb-0 mt-0">
                        <h3 style="margin-bottom: 0px;">Reset Password</h3>
                    </div>
                    
                    <?php if ($this->session->flashdata('errors')): ?>
                        <div class="col-md-12 pageErrorDiv">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <?php
                                echo $this->session->flashdata('errors');
                                $this->session->unset_userdata('errors');
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('resetPassword') ?>">
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <div class="form-group">
                            <label for="">OTP <sup>*</sup></label>
                            <input type="password" class="form-control" id="" name="otp" required />
                        </div>
                        <div class="form-group">
                            <label for="">Password <sup>*</sup></label>
                            <input type="password" class="form-control" id="" name="password" required />
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password <sup>*</sup></label>
                            <input type="password" class="form-control" id="" name="cpassword" required />
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-1">Reset Password</button>
                        <div class="d-flex justify-content-center">
                            <a href="<?= base_url() ?>" data-toggle="modal">Click Here For Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-----container---->