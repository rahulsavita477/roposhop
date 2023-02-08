<?php
str_replace("admin.", "", $_SERVER['HTTP_HOST']);
if(strpos($_SERVER['HTTP_HOST'], 'admin') !== false)
    $url = str_replace("admin.", "", $_SERVER['HTTP_HOST']);
else if(strpos($_SERVER['HTTP_HOST'], 'seller') !== false)
    $url = str_replace("seller.", "", $_SERVER['HTTP_HOST']);

$home_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$url;
?>

<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>ROPO SHOP | Log in</title>
        <link rel="shortcut icon" href="<?= $this->config->item('site_url').'assets/4d_logo.ico' ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- bootstrap 3.0.2 -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/font-awesome.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/AdminLTE.css' ?>" rel="stylesheet" type="text/css" />
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <?= form_open('doLogin') ?>
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="email" name="username" class="form-control" placeholder="username" required />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required />
                    </div>
                </div>

                <div class="footer">         
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="<?= $home_url ?>"><span class="glyphicon glyphicon-home"></span> Home page</a></p>

                    <p><a href="#myModal" data-toggle="modal"><span class="glyphicon glyphicon-lock"></span> I forgot my password</a></p>

                    <?php if ($_COOKIE['site_code'] == 'seller') {  ?>
                        <a href="<?= base_url('signup') ?>"><span class="glyphicon glyphicon-user"></span> Register a new merchant</a>
                    <?php } ?>
                </div>
            <?= form_close() ?>
        </div>
    </body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Recover Password</h4>
            </div>
            
            <div class="modal-body">
                Please enter the email id you used to signup, we will send the instructions to recover your password if provided email id exists in our record.<br /><br /><br />

                <input type="text" placeholder="email" id="email" />
                <input type="text" id="site_code" value="<?= $_COOKIE['site_code'] ?>" />
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default" onclick="resetPasswordMail()">Submit</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.modal-body{
    color: black;
}
.modal-title{
    color: #428bca;
}
</style>

<script type="text/javascript">
//get state of country
function resetPasswordMail()
{
    email = $('#email').val();
    site_code = $('#site_code').val();

    if (email) 
    {
        $.ajax({
            type: "POST",
            url: '<?= base_url("api/v1/users/merchants/resetPassword") ?>',
            data: {
                email: email,
                site_code: site_code
            },
            success: function(data){
                if (data) 
                {
                    a = JSON.parse(data); 
                    $("#myModal").modal("hide");
                    alert(a.msg);
                }
            },
        }); 
    }
    else
        alert('Please provide email');
}
</script>