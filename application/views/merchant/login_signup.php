<div class="span12">
    <div class="row">
		<div class="span2"> &nbsp;</div>
		<div class="span4">
			<div class="well">
				<h5>SELLER SIGN UP</h5><br/>
				<form method="post" action="<?= base_url('insertSeller') ?>">
					<div class="control-group">
						<label class="control-label">Owner's Full Name <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="text" name="first_name" value="<?= set_value('first_name') ?>" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Establishment (Shop) Name <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="text" name="shop_name" value="<?= set_value('shop_name') ?>" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="email" name="email" value="<?= set_value('email') ?>" required />
						</div>
						<?= UC_error_label('email') ?>
					</div>
					<div class="control-group">
						<label class="control-label">Password <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="password" name="password" value="<?= set_value('password') ?>" required />
						</div>
						<?= UC_error_label('password') ?>
					</div>
					<div class="control-group">
						<label class="control-label">Confirm Password <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="password" name="confirm_password" value="<?= set_value('confirm_password') ?>" required />
						</div>
						<?= UC_error_label('confirm_password') ?>
					</div>
					<div class="control-group">
						<label class="control-label">Contact (Mobile) Number <sup>*</sup></label>
						<div class="controls">
							91<input class="span3" type="text" name="contact_number" value="<?= set_value('contact_number') ?>" required />
						</div>
						<?= UC_error_label('contact_number') ?>
					</div>
					<div class="controls">
						<button type="submit" class="btn block">Sign up</button>
					</div>
				</form>
			</div>
		</div>
		<div class="span4">
			<div class="well">
				<h5>ALREADY REGISTERED ?</h5>
				<form method="post" action="<?= base_url('merchantLogin') ?>">
					<div class="control-group">
						<label class="control-label">Email <sup>*</sup></label>
						<div class="controls">
							<input class="span3"  type="email" name="username" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Password <sup>*</sup></label>
						<div class="controls">
							<input type="password" class="span3" name="password" required />
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn">Login</button>
							<a href="#resetPassword" data-toggle="modal">Forgot password?</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="span2"> &nbsp;</div>
	</div>	
</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->
