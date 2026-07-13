<div class="container">
	<ol class="breadcrumb mt-0 mb-2">
		<li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">Profile</a></li>
	</ol>
	
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left" style="padding-top:7.5px;">
                Your Personal Information
            </h4>
			<?php if (!isset($_GET['profile'])): ?>
				<a href="<?= base_url('userProfile?profile=edit') ?>" class="pull-right" title="Edit Profile">
					<i class="fa fa-edit"></i>
				</a>
			<?php elseif (isset($_GET['profile']) && $_GET['profile'] == 'edit'): ?>
				 <a href="<?= base_url('userProfile') ?>" class="pull-right" title="View Profile">
					<i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

        </div>

        <div class="panel-body">
            <?php if (!isset($_GET['profile'])): ?>
				<div class="row">
					<div class="col-sm-3 text-center">
						<?php if (!empty($profile_image)) { ?>
							<img src="<?= $profile_image ?>" alt="Profile" class="img-thumbnail"
							style="width:150px;height:150px;object-fit:cover;" />
						<?php } else {
							// initials fallback
							$initials = '';
							$parts = explode(' ', $full_name);
							foreach ($parts as $p) {
								$initials .= strtoupper(substr($p, 0, 1));
							}
						?>
						<div class="img-thumbnail"
							style="width:150px;height:150px;display:flex;align-items:center;justify-content:center;background:#007BFF;color:#fff;font-size:48px;font-weight:bold;">
							<?= $initials ?>
						</div>
						<?php } ?>
					</div>

					<div class="col-sm-9">
						<table class="table table-striped">
							<tbody>
								<tr>
									<th style="width:150px;">Name:</th>
									<td><?= $full_name ?></td>
								</tr>
								<tr>
									<th>Email:</th>
									<td><?= $email ?></td>
								</tr>
								<tr>
									<th>Date of Birth:</th>
									<td><?= date("d-m-Y", strtotime($birthday)) ?></td>
								</tr>
								<tr>
									<th>Phone:</th>
									<td><?= $phone ?></td>
								</tr>
								<tr>
									<th>Gender:</th>
									<td><?= $gender ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
            <?php elseif (isset($_GET['profile']) && $_GET['profile'] == 'edit'): ?>
				<form class="form-horizontal" method="post" action="<?= base_url('insertUser') ?>" enctype="multipart/form-data">
					<input type="hidden" name="consumer_id" value="<?= $_COOKIE['consumer_id'] ?>" />

					<div class="row">
						<!-- Left Column -->
						<div class="col-sm-6">
							<!-- Name -->
							<div class="form-group">
								<label class="control-label">Name <sup>*</sup></label>
								<input type="text" name="full_name" class="form-control" placeholder="Name" value="<?= $full_name ?>" required />
							</div>

							<!-- Email -->
							<div class="form-group">
								<label class="control-label">Email</label>
								<input type="email" class="form-control" value="<?= $email ?>" readonly />
							</div>

							<!-- Date of Birth -->
							<div class="form-group">
								<label class="control-label">Date of Birth</label>
								<input type="date" 
									name="dob" 
									class="form-control" 
									value="<?= $birthday ?>" 
									placeholder="dd-mm-yyyy" 
									min="1970-01-01" 
									max="<?= date('Y-m-d') ?>"
								/>
							</div>

							<!-- Gender -->
							<div class="form-group">
								<label class="control-label">Gender</label>
								<select class="form-control" name="gender">
									<?php
									$male_selected = ($gender == "MALE") ? 'selected' : '';
									$female_selected = ($gender == "FEMALE") ? 'selected' : '';
									$other_selected = ($gender == "OTHER") ? 'selected' : '';
									?>
									<option value="MALE" <?= $male_selected ?>>Male</option>
									<option value="FEMALE" <?= $female_selected ?>>Female</option>
									<option value="OTHER" <?= $other_selected ?>>Other</option>
								</select>
							</div>
						</div>

						<!-- Right Column -->
						<div class="col-sm-6">
							<!-- Profile Picture -->
							<div class="form-group">
								<label class="control-label">Profile Picture</label>
								<input type="file" name="file" onchange="readURL(this);" />
								<img id="blah" src="<?= $profile_image ?: 'http://placehold.it/180' ?>" class="img-thumbnail" style="margin-top:10px;max-width:150px;" />
							</div>

							<!-- Phone -->
							<div class="form-group">
								<label class="control-label">Phone</label>
								<input type="text" name="phone" class="form-control" placeholder="Contact no" value="<?= $phone ?>" />
							</div>

							<!-- Submit -->
							<div class="form-group text-right">
								<input class="btn btn-success" type="submit" value="Update" />
							</div>
						</div>
					</div>
				</form>
            <?php endif; ?>
        </div>
    </div>
</div>