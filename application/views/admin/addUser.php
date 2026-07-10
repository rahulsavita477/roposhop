<?php 
//user data
$usr_id = isset($user['userId']) ? $user['userId'] : '';
$email = isset($user['email']) ? $user['email'] : set_value('email');
$password = isset($user['password']) ? $user['password'] : DEFAULT_PASSWORD;
$fname = isset($user['first_name']) ? $user['first_name'] : set_value('fname');
$roles = isset($user['roles']) ? $user['roles'] : false;
$create_date = isset($user['create_date']) ? convert_to_user_date($user['create_date']) : false;
$update_date = isset($user['update_date']) ? convert_to_user_date($user['update_date']) : false;
$adminChecked = "";
$buyerChecked = "";
$sellerChecked = "";
$testUserChecked = "";
$executiveUserChecked = "";

//user profile picture
if ( isset($user['profile_image']) )
    $profile_pic = $user['profile_image'];
else
    $profile_pic = $this->config->item('site_url').'assets/admin/img/avatar3.png';

//merchant data
$merchant_id = isset($merchant['merchant_id']) ? $merchant['merchant_id'] : '';
$comp_name = isset($merchant['establishment_name']) ? $merchant['establishment_name'] : '';
$cno = isset($merchant['contact']) ? $merchant['contact'] : '';
$business_days = isset($merchant['business_days']) ? $merchant['business_days'] : '';
$business_hours = isset($merchant['business_hours']) ? $merchant['business_hours'] : '';
$description = isset($merchant['description']) ? $merchant['description'] : '';
$finance_available = (isset($merchant['finance_available']) && $merchant['finance_available']) ? 'Yes' : 'No';
$finance_terms = isset($merchant['finance_terms']) ? $merchant['finance_terms'] : '';
$home_delivery_available = (isset($merchant['home_delivery_available']) && $merchant['home_delivery_available']) ? 'Yes' : 'No';
$home_delivery_terms = isset($merchant['home_delivery_terms']) ? $merchant['home_delivery_terms'] : '';
$installation_available = (isset($merchant['installation_available']) && $merchant['installation_available']) ? 'Yes' : 'No';
$installation_terms = isset($merchant['installation_terms']) ? $merchant['installation_terms'] : '';
$replacement_available = (isset($merchant['replacement_available']) && $merchant['replacement_available']) ? 'Yes' : 'No';
$replacement_terms = isset($merchant['replacement_terms']) ? $merchant['replacement_terms'] : '';
$return_available = (isset($merchant['return_available']) && $merchant['return_available']) ? 'Yes' : 'No';
$return_policy = isset($merchant['return_policy']) ? $merchant['return_policy'] : '';
$address_array = isset($merchant['address']) ? $merchant['address'] : array();
$seller_images_dir = isset($merchant['seller_images_dir']) ? $merchant['seller_images_dir'] : '';
$seller_images = isset($merchant['images']) ? $merchant['images'] : '';
$page_label = isset($merchant['page_label']) ? $merchant['page_label'] : 'Add Seller and shop detail';

//seller/merchant logo
if ( isset($merchant['merchant_logo']) )
    $merchant_logo = $merchant['merchant_logo'];
else
    $merchant_logo = $this->config->item('site_url').'assets/admin/img/avatar3.png';

//get user roles
$showAddressManagementButton = false;
$count = 0;
$user_roles = '';
if ($roles) 
{
	foreach ($roles as $role) 
	{
		if ($role['type_name'] == "ADMIN")
			$adminChecked = 'checked="checked"';

		if ($role['type_name'] == "BUYER")
			$buyerChecked = 'checked="checked"';

		if ($role['type_name'] == "SELLER")
		{
			$sellerChecked = 'checked="checked"';
			$showAddressManagementButton = true;
		}

		if ($role['type_name'] == "TEST USER")
			$testUserChecked = 'checked="checked"';

		if ($role['type_name'] == "EXECUTIVE")
			$executiveUserChecked = 'checked="checked"';
	
		if ($count > 0 && sizeof($roles) > $count)
			$user_roles .= ',&nbsp;&nbsp;';

		$user_roles .= $role['type_name'];

		$count++;
	}
}
else
	$user_roles = "Not defined";

if (isset($_GET['edit'])) 
{
	$page_label = 'edit';
	$page_title = 'Edit user';
}
else if (isset($_GET['view'])) 
{
	$page_label = 'view';
	$page_title = 'View user';
}
else
{
	$page_label = "add";
	$page_title = 'Add user';
}

$detail_label = ($_COOKIE['site_code'] == 'ADMIN') ? 'User Detail' : 'Owner Detail';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            User
            <small><?= $page_label ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php
            if($_COOKIE['site_code'] == 'admin')
            	echo "<li><a href='".base_url('page/userManagement')."'>User Management</a></li>";
            ?>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<?php if (isset($_GET['view'])) { ?>
						<div class="box-header">
					        <h3 class="box-title"><?= $detail_label ?></h3>
					        <div class="box-footer" align="right">
					        	<?php if ($_COOKIE['site_code'] == 'admin')
					            	echo "<a href='".base_url("page/userManagement")."' title='Back'><i class='fa fa-undo' aria-hidden='true'></i></a>&nbsp;";
					            
					            echo "<a href='".base_url("editUser/$usr_id?edit")."' title='Edit'><i class='fa fa-edit'></i></a>&nbsp;";

			            		if ($usr_id != $_COOKIE['user_id'])
					            	echo "<a href='".base_url("deleteUser/$usr_id")."' title='Delete'><i class='fa fa-trash-o'></i></a>";
					            ?>
					        </div>
						</div>

						<div class="box-body">
							<?php if ($profile_pic)
								echo '<img src="'.$profile_pic.'" width="100px" />';
							?>

				        	<div class="row form-group">
				            	<div class="col-sm-2">
				            		<?php
				            		if ($_COOKIE['site_code'] == 'seller')
				            			echo "<label>Owner's Full Name: </label>";
				            		else
				            			echo "<label>Full Name: </label>";
				            		?>
				                </div>
				                <div class="col-sm-10">
					                <?= $fname ?>
					            </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				                	<label>Email: </label>
				                </div>
				                <div class="col-sm-10">
					        		<?= $email ?>
					            </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Contact number:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $cno ?>
				                </div>
				            </div>

				            <?php if ($_COOKIE['site_code'] == "admin") { ?>
					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Role:</label>
					            	</div>
					            	<div class="col-sm-10">
					            		<?= $user_roles ?>
					            	</div>
					            </div>
					        <?php } ?>
				        </div><!-- /.box-body -->

				        <?php if ($_COOKIE['site_code'] == 'seller') { ?>
					        <div class="box-header">
						        <h3 class="box-title">Business Detail</h3>
							</div>

							<div class="box-body">
					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Establishment (Shop) Name:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $comp_name ?>
					                </div>
								</div>
								<div class="row form-group">
									<div class="col-sm-2">
					            		<label>Business Days:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $business_days ?>
					                </div>
								</div>
								<div class="row form-group">
									<div class="col-sm-2">
					            		<label>Business Hours:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $business_hours ?>
					                </div>
								</div>
								<div class="row form-group">
									<div class="col-sm-2">
					            		<label>Description:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $description ?>
					                </div>
					            </div>
								
						        <?php if (!empty($seller_images)) {

		                        	foreach ($seller_images as $img_key => $img_value) {
										echo '<div class="thumbnail">
											<figure>
												<img src="'.$seller_images_dir.'/'.$img_value['atch_url'].'" class="img-rounded" width="150" height="100">
											</figure>
										</div>';
									}
		                        } ?>

					            <div class="row form-group" style="clear: both;">
					            	<div class="col-sm-2">
					            		<label>Finance available:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $finance_available ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Finance terms:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $finance_terms ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Home delivery available:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $home_delivery_available ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Home delivery terms:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $home_delivery_terms ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Installation available:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $installation_available ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Installation terms:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $installation_terms ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Replacement available:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $replacement_available ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Replacement terms:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $replacement_terms ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Return available:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $return_available ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Return policy:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?= $return_policy ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Seller offerings:</label>
					            	</div>
					                <div class="col-sm-10">
					                	<?php if ($merchant['seller_offering']) {

					                		echo "<ul>";
					                			foreach ($merchant['seller_offering'] as $offering) {
													echo "<li>".$offering['offering']."</li>";
												}
					                		echo "</ul>";
					                	} ?>
					                </div>
					            </div>
					        </div>
					<?php }
					} else { ?>
					    <!-- form start -->
					    <?= form_open_multipart('addUser'); ?>
					    	<input type="hidden" name="usr_id" value="<?= $usr_id; ?>">
					        <div class="box-body">
					        	<div class="row">
									<div class="col-sm-8">
										<div class="col-sm-6 nextFormLine">
											<label>Full Name * </label>
											<input type="text" name="fname" class="form-control" placeholder="Enter Full Name" value="<?= $fname ?>" id="" required />
										</div>

										<div class="col-sm-6 nextFormLine">
											<label>Email * </label>
											<?php if ($usr_id) { ?>
												<input type="text" class="form-control" value="<?= $email ?>" disabled>
											<?php } else { ?>
												<input type="email" name="email" class="form-control" placeholder="Enter email address" id="" required />
											<?php } ?>
										</div>

										<?php if ($_COOKIE['site_code'] == "admin") { ?>
											<div class="col-sm-12 nextFormLine">
													<label>User Role:</label>
													<label class="bigcheck tag-label">
														<input type="checkbox" class="bigcheck" name="user_type[]" value="ADMIN" <?= $adminChecked ?>>
														<span class="bigcheck-target"></span>
														<span class="tag-text">Admin</span>
													</label>
													<label class="bigcheck tag-label">
														<input type="checkbox" class="bigcheck" name="user_type[]" value="SELLER" <?= $sellerChecked ?>>
														<span class="bigcheck-target"></span>
														<span class="tag-text">Seller</span>
													</label>
													<label class="bigcheck tag-label">
														<input type="checkbox" class="bigcheck" name="user_type[]" value="BUYER" <?= $buyerChecked ?>>
														<span class="bigcheck-target"></span>
														<span class="tag-text">Buyer</span>
													</label>
													<label class="bigcheck tag-label">
														<input type="checkbox" class="bigcheck" name="user_type[]" value="TEST USER" <?= $testUserChecked ?>>
														<span class="bigcheck-target"></span>
														<span class="tag-text">Test user</span>
													</label>
													<label class="bigcheck tag-label">
														<input type="checkbox" class="bigcheck" name="user_type[]" value="EXECUTIVE" <?= $executiveUserChecked ?>>
														<span class="bigcheck-target"></span>
														<span class="tag-text">Executive</span>
													</label>
											</div>
										<?php } ?>

										<?php if ($_COOKIE['site_code'] == 'admin') { ?>
											<div class="col-sm-12 nextFormLine">
												<label>Password * </label>
												<input type="text" name="password" class="form-control" placeholder="Enter password address" value="<?= $password ?>" id="" required />
											</div>
										<?php } ?>
									</div>
									<div class="col-sm-4">
										<div class="col-sm-12">
											<label>Update Profile picture</label>
										</div>
										<div class="col-sm-12">
											<input type="file" name="file7" id="file7" />
											<?php if ($profile_pic) {
												echo '<img class="nextFormLine" src="'.$profile_pic.'" width="100px">';
											} ?>
										</div>
									</div>
					            </div>
					        </div><!-- /.box-body -->

					        <div class="box-footer"  align="right">
					        	<?php if ($_COOKIE['site_code'] == "admin") { ?>
					        		<a href='<?= base_url("page/userManagement") ?>' class='btn btn-default'>Cancel</a>
					        	<?php } else { ?>
					        		<a href='<?= base_url("editUser/$usr_id?view") ?>' class='btn btn-default'>Cancel</a>
					        	<?php } ?>
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>

					    <?= form_close(); ?>
					<?php } ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<style type="text/css">
.thumbnail img {
    //width:115;
    height:80px;
    float: left;
    margin: 10px;
}

.thumbnail {
	border: none;
    float: left;
    padding: 20px;
}

.tag-label {
	width: auto;
}

.tag-label {
	overflow: auto;
	display: contents;
}
</style>
