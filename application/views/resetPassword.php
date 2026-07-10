<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - RopoShop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f9f9f9;
    }

    .reset-container {
        max-width: 500px;
        margin: 60px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .btn-roposhop {
        background-color: #08c;
        color: #fff;
        font-weight: bold;
    }

    .btn-roposhop:hover {
        background-color: #006bb3;
        color: #fff;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="reset-container">
            <h3 class="text-center mb-4">🔒 Reset Your Password</h3>
            <form method="post" action="<?= base_url('resetPassword') ?>">

                <!-- OTP -->
                <div class="form-group">
                    <label for="otp">OTP <sup>*</sup></label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label for="password">New Password <sup>*</sup></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password"
                        minlength="5" required>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="cpassword">Confirm Password <sup>*</sup></label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword"
                        placeholder="Confirm Password" minlength="5" required>
                </div>

                <!-- Hidden User ID -->
                <input type="hidden" name="user_id" value="<?= $user_id ?>">

                <!-- Submit -->
                <button type="submit" class="btn btn-roposhop btn-block">Reset Password</button>
            </form>
        </div>
    </div>
</body>

</html>