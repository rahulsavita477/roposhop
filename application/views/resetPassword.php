<div class="span9">
    <ul class="breadcrumb">
		<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
		<li class="active">User Reset Password</li>
    </ul>
	<hr class="soft"/>
	
	<div class="row">
		<div class="span5">
			<div class="well">
				<h5>RESET PASSWORD</h5><br/>
				<form method="post" action="<?= base_url('resetPassword') ?>">
					<div class="control-group">
						<label class="control-label">OTP <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="text" name="otp" placeholder="OTP" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">New Password <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="text" name="password" placeholder="Password" minlength="5" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Confirm Password <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="password" name="cpassword" placeholder="Confirm Password" minlength="5" required />
						</div>
					</div>
					<input type="hidden" name="user_id" value="<?= $user_id ?>">
					<div class="controls">
						<button type="submit" class="btn block">Reset</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->
