<?php
if (isset($page_label) && $page_label == "edit") {
	$page_title = 'Edit address';
} else if (isset($page_label) && $page_label == "view") {
	$page_title = 'View address';
} else {

	$page_label = "add";
	$page_title = 'Add address';
}

$merchant_logo = isset($merchant['result'][0]['merchant_logo']) ? $merchant['result'][0]['merchant_logo'] : '';
$shop_name = isset($merchant['result'][0]['establishment_name']) ? $merchant['result'][0]['establishment_name'] : '';
$merchant_id = isset($merchant['result'][0]['merchant_id']) ? $merchant['result'][0]['merchant_id'] : '';
$merchant_id = isset($merchant['result'][0]['merchant_id']) ? $merchant['result'][0]['merchant_id'] : '';
$user_id = isset($user['userId']) ? $user['userId'] : '';
$user_name = isset($user['first_name']) ? $user['first_name'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller Addresses
            <small><?= ucfirst($page_label) ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php if ($_COOKIE['site_code'] == 'admin') { ?>
	            <li><a href="<?= base_url('sellers/sellersTable') ?>">Seller Management</a></li>
	        <?php } ?>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
        	<?php if ($_COOKIE['site_code'] == 'admin') { ?>
	        	<div class="col-sm-1">
					<?php if ($merchant_logo) {
						echo '<img src="'.$merchant_logo.'" height="80px" />';
					} else {
						echo '<img src="'.base_url('assets/admin/img/shopAvtar.png').'" height="80px" />';
					} ?>
	        	</div>
				<div class="col-sm-5">
					<h2 style="margin: 0px;"><?= $shop_name ?></h2>
					<span class="text-muted"><?= $user_name ?></span>
	        	</div>
	        <?php } ?>

			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-body">
						<div class="row">
							<form id="addressForm" method="post" action="<?= base_url('page/addressManagement') ?>">
		
								<input type="hidden" name="user_id" value="<?= $user_id ?>" />
								<input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />

								<div class="col-sm-3 input-field" style="padding-right: 5px;">
									<label for="state_id">State</label>
									<select class="form-control" name="state_id" id="state_id" onchange="getCity(this.value);" required>
										<option value="">Select State</option>
										<?php foreach ($states as $state) {

											if (isset($_GET['state_id']) && $state['state_id'] == $_GET['state_id']) {
												$selected = "selected='selected'";
											} else {
												$selected = "";
											}

											echo "<option value='".$state['state_id']."' ".$selected.">".$state['name']."</option>";
										} ?>
									</select>
								</div>
								
								<div class="col-sm-3 input-field" style="padding-left: 0px; padding-right: 5px;">
									<label for="state_cities">City</label>
									<select class="form-control" name="city_id" id="state_cities"></select>
								</div>

								<div class="col-sm-3" style="padding-left: 0px;">
									<label class="label_hide" for="">make space equal to label</label><br />
									<button class="btn btn-primary" type="button" onclick="submitBoth()">Find</button>
									<button type="submit" name="reset" value="1" class="btn btn-link" title="Reset Filter" style="padding:0; border:none; background:none;">
										<span class="fa-stack fa-lg">
											<i class="fa fa-filter fa-stack-1x"></i>
											<i class="fa fa-times fa-stack-1x text-danger" style="margin-top: 6px; margin-left: 6px; font-size: 0.6em;"></i>
										</span>
									</button>
								</div>
							</form>

							<div class="col-sm-3 input-field">
								<label class="label_hide" for="">make space equal to label</label><br />
								<form method="post" action="<?= base_url('page/addAddress') ?>" style="display:inline;">
									<input type="hidden" name="user_id" value="<?= $user_id ?>" />
									<input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />
									<button type="submit" class="btn btn-primary pull-right">
										<i class="fa fa-plus"></i> Add New Address
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
        	<?php if (count($address)>0) {

				foreach ($address as $add_value) {

					$isPrimary = "";
					if ( $add_value['is_default_address'] == 1 ) {
						$isPrimary = '<h3 class="box-title"><b>Primary Address</b></h3>';
					}

					$address_id = $add_value['address_id'];
					$lat = $add_value['latitude'];
					$long = $add_value['longitude'];
					$pin = $add_value['pin'];
					$contact = $add_value['contact'];
					$business_days = $add_value['business_days'];
					$business_hours = $add_value['business_hours'];
					$line1 = $add_value['address_line_1'];
					$line2 = $add_value['address_line_2'];
					$landmark = $add_value['landmark'];
					$cnt_id = $add_value['country_id'];
					$state_id = $add_value['state_id'];
					$city_id = $add_value['city_id'];
					$country_name = $add_value['country_name'];
					$state_name = $add_value['state_name'];
					$city_name = $add_value['city_name']; 
					?>

        			<div class="col-sm-3" style="padding-right: 0px;">
						<div class="box box-primary1">
							<div class="box-body">
								<div class="row form-group">
					                <div class="col-sm-12 address">
										<form id="editForm<?= $address_id ?>" method="post" action="<?= base_url('page/addAddress') ?>" style="display:inline;">
											<input type="hidden" name="address_id" value="<?= $address_id ?>" />
											<input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />
											<input type="hidden" name="user_id" value="<?= $user_id ?>" />
											<a href="javascript:void(0)" onclick="document.getElementById('editForm<?= $address_id ?>').submit();" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;
										</form>
										
					                	<?php if (!$isPrimary) {
											echo "<a href='".base_url("deleteAddress/$address_id").'/'.$user_id."/".$merchant_id."' onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i></a>";
										} ?>
					                </div>
					            	<div class="col-sm-12 address">
					            		<?= $line1.'<br />'.$line2.'<br />'.$landmark.'<br />'.$city_name." - ".$pin.'<br />'.$state_name.", ".$country_name."<br /><br />" ?>
					            		<label for="">Lat-Long :</label> <?= $lat.", ".$long ?><br />
					            		<label for="">Phone no :</label> <?= $contact ?><br />
					            		<label for="">Business days :</label> <?= $business_days ?><br />
					            		<label for="">Business hours :</label> <?= $business_hours ?>
									</div>
					            </div>
				        	</div>
			        	</div>
			        </div>
				<?php }
			} else {
				echo '<div class="col-md-12">No shop found!</p></div>';
			} ?>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<style type="text/css">
.box .box-header a{
	color: #fff;
	margin: 10px;
}

.address{
	margin: 5px;
}
</style>

<script type="text/javascript">
$(document).ready(function() {

    state_id = $('#state_id').val();
	
	if (parseInt(state_id)) {
		getCity(state_id);
	}
});

function submitBoth() {

    let form = document.getElementById("addressForm");
    let stateId = document.getElementById("state_id").value;
    let cityId = document.getElementById("state_cities").value;
	let query = "?state_id=" + stateId + "&city_id=" + cityId; // build GET query

    // change form action dynamically
    form.action = "<?= base_url('page/addressManagement') ?>" + query;
    form.submit();
}
</script>
