<!DOCTYPE html>
<html lang="en" class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>ROPOshop | Reset Password</title>
        <link rel="shortcut icon" href="<?= $this->config->item('site_url').'assets/4d_logo.ico' ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- bootstrap 3.0.2 -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/font-awesome.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/AdminLTE.css' ?>" rel="stylesheet" type="text/css" />

		<style>
		.form-box {
			width: 450px;
		}
		</style>
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Reset Password</div>
            
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

            <?= form_open('resetPassword') ?>
				<input type="hidden" name="user_id" value="<?= $user_id ?>">
                <div class="body bg-gray">
					<div class="form-group">
						<label for="otp">OTP <sup>*</sup></label>
                        <input type="password" class="form-control" id="otp" name="otp" placeholder="OTP" required />
                    </div>
					<div class="form-group">
						<label for="password">New Password <sup>*</sup></label>
						<input type="password" class="form-control" id="password" name="password" placeholder="New Password" minlength="5" required />
                    </div>
                    <div class="form-group">
						<label for="cpassword">Confirm Password <sup>*</sup></label>
						<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" minlength="5" required />
                    </div>
                </div>

                <div class="footer text-center">
                    <button type="submit" class="btn bg-olive btn-block">Reset Password</button>
					<a href="<?= base_url() ?>">Click Here For Login</a>
                </div>
            <?= form_close() ?>
        </div>
    </body>
</html>