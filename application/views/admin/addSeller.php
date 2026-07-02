<?php
$merchant_id = isset($data['merchant_id']) ? $data['merchant_id'] : '';
$usr_id = isset($data['userId']) ? $data['userId'] : '';
$email = isset($data['email']) ? $data['email'] : '';
$first_name = isset($data['first_name']) ? $data['first_name'] : '';
$shop_name = isset($data['establishment_name']) ? $data['establishment_name'] : '';
$description = isset($data['description']) ? $data['description'] : '';
$cno = isset($data['contact']) ? $data['contact'] : '';
$business_days = isset($data['business_days']) ? $data['business_days'] : '';
$business_hours = isset($data['business_hours']) ? $data['business_hours'] : '';
$finance_available = (isset($data['finance_available']) && $data['finance_available']) ? 'Yes' : 'No';
$finance_terms = isset($data['finance_terms']) ? $data['finance_terms'] : '';
$home_delivery_available = (isset($data['home_delivery_available']) && $data['home_delivery_available']) ? 'Yes' : 'No';
$home_delivery_terms = isset($data['home_delivery_terms']) ? $data['home_delivery_terms'] : '';
$installation_available = (isset($data['installation_available']) && $data['installation_available']) ? 'Yes' : 'No';
$installation_terms = isset($data['installation_terms']) ? $data['installation_terms'] : '';
$replacement_available = (isset($data['replacement_available']) && $data['replacement_available']) ? 'Yes' : 'No';
$replacement_terms = isset($data['replacement_terms']) ? $data['replacement_terms'] : '';
$return_available = (isset($data['return_available']) && $data['return_available']) ? 'Yes' : 'No';
$return_policy = isset($data['return_policy']) ? $data['return_policy'] : '';
$address_array = isset($data['address']) ? $data['address'] : array();
$seller_images_dir = isset($data['seller_images_dir']) ? $data['seller_images_dir'] : '';
$seller_images = isset($data['images']) ? $data['images'] : '';
$meta_keyword = isset($data['meta_keyword']) ? $data['meta_keyword'] : '';
$meta_description = isset($data['meta_description']) ? $data['meta_description'] : '';
$create_date = isset($data['create_date']) ? convert_to_user_date($data['create_date']) : '';
$update_date = isset($data['update_date']) ? convert_to_user_date($data['update_date']) : '';
$business_proof = isset($data['business_proof']) ? $data['business_proof'] : '';
// $avatar = $this->config->item('site_url').'assets/admin/img/avatar3.png';

//seller/merchant logo
if (isset($data['merchant_logo']))
    $merchant_logo = $data['merchant_logo'];
else $merchant_logo = '';

if (isset($page_label) && $page_label == "edit") 
	$page_title = 'Edit seller';
else if (isset($page_label) && $page_label == "view") 
	$page_title = 'View seller';
else
{
	$page_label = "add";
	$page_title = 'Add seller';
}

if ($_COOKIE['site_code'] == 'admin') 
{
	$required = "";
	$star = "";
}
else
{
	$required = "required";
	$star = "*";
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller
            <small><?= $page_label ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('sellers/sellersTable') ?>">Seller Management</a></li>
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
				    <?php if ($page_label == "view") { ?>
			    		<div class='box-footer' style="text-align: right; padding-bottom: 0px;">
							<a href='../../sellers/sellersTable' title='Back'><i class='fa fa-undo' aria-hidden='true'></i></a>&nbsp;
							<a href='../../seller/<?= $merchant_id ?>/edit' title='Edit'><i class='fa fa-edit'></i></a>
						</div>
						
						<div class="box-body">
			    			<div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Seller logo:</label>	
				            	</div>
				                <div class="col-sm-10">
				            		<?php if (isset($merchant_logo) && !empty($merchant_logo)) {

										echo '<div class="row form-group">
											<div class="col-sm-3">
												<img src="'.$seller_images_dir.'/'.$merchant_logo.'" width="80">
											</div>
										</div>';
									} else {
										echo "Not Available";
									} ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Owner's Full Name:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $first_name ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Establishment (Shop) Name:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $shop_name ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Shop images:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?php 
			                        if (!empty($seller_images)) 
			                        {
			                        	foreach ($seller_images as $img_value) 
			                        		echo '<div class="thumbnail">
			                        				<figure>
														<img src="'.$seller_images_dir.'/'.$img_value['atch_url'].'" class="img-rounded" />
												    </figure>
												</div>';
			                        }
			                        ?>
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

	                        <div class="row form-group" style="clear: both;">
				            	<div class="col-sm-2">
				            		<label>Contact number:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $cno ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Business days:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $business_days ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Business hours:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $business_hours ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>finance available:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $finance_available ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>finance terms:</label>	
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

				            <?php if (count($data['address']) > 0) 
				            {
				            	$sno = 1;
				            	foreach ($data['address'] as $address_value) 
				            	{
				            		if ( $address_value['address_line_1'] )
				            			$line1 = $address_value['address_line_1'];
				            		else
				            			$line1 = '';

				            		if ( $address_value['address_line_2'] )
				            			$line2 = ', '.$address_value['address_line_2'];
				            		else
				            			$line2 = '';

				            		if ( $address_value['landmark'] )
				            			$landmark = ', '.$address_value['landmark'];
				            		else
				            			$landmark = '';

				            		if ( $address_value['city_name'] )
				            			$city_name = ', '.$address_value['city_name'];
				            		else
				            			$city_name = '';

				            		if ( $address_value['pin'] )
				            			$pin = ', '.$address_value['pin'];
				            		else
				            			$pin = '';

				            		if ($address_value['state_name'])
				            			$state_name = ', '.$address_value['state_name'];
				            		else
				            			$state_name = '';

				            		if ($address_value['country_name'])
				            			$country_name = ', '.$address_value['country_name'];
				            		else
				            			$country_name = '';

				            		echo '<div class="row form-group">
							            	<div class="col-sm-3">
							            		<label>Address '.$sno.':</label>	
							            	</div>
							                <div class="col-sm-10">'.
							                	$line1.$line2.$landmark.$city_name.$pin.$state_name.$country_name."<br />Shop no: ".$address_value['contact']
							                .'</div>
							            </div>';

				            		$sno++;
				            	}
				            } ?>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Meta Keyword:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $meta_keyword ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Meta Description:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $meta_description ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Create date:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $create_date ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Update date:</label>	
				            	</div>
				                <div class="col-sm-10">
				                	<?= $update_date ?>
				                </div>
				            </div>
				        </div>
				    <?php } else { ?>
				    	<!-- seller offering Modal -->
                        <div class="modal fade" id="sellerOfferingModal">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Seller Offering</h4>
                                    </div>

                                    <?= form_open('addSellerOffering') ?>
                                        <div class="modal-body">
                                            <input type='hidden' name='offering_id' id='offering_id'>
                                            <input type='hidden' name='merchant_id' id='merchant_id'>

                                            <div class='row form-group'>
                                                <div class='col-sm-3'>
                                                    <label>Seller Offering:</label>    
                                                </div>
                                                <div class='col-sm-9'>
                                                    <input type='text' name='offering' id='offering' class='form-control' required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>

				    	<!-- form start -->
					    <form method="post" action="<?= base_url('addSeller') ?>" enctype="multipart/form-data" <?= $page_label != "edit" ? 'onsubmit="return validateForm()"' : '' ?>>

					    	<input type="hidden" name="merchant_id" value="<?= $merchant_id; ?>">
					        <input type="hidden" name="usr_id" value="<?= $usr_id; ?>">
					        <input type="hidden" name="is_default_address" value="1" />

				        	<div class="box-body">
				        		<div class="row">
									<div class="col-sm-3">
										<label>Establishment (Shop) Name *</label>
										<input type="text" name="comp_name" class="form-control" placeholder="Enter Company Name" value="<?= $shop_name ?>" required />
									</div>

									<div class="col-sm-3">
										<label>Email *</label>
										<input type="text" name="email" class="form-control" placeholder="Enter Company Name" value="<?= $email ?>" required />
									</div>

									<div class="col-sm-3">
										<label>Contact Number</label>
										
										<div class="input-group">
											<span class="input-group-addon">+91-</span>
											<input type="text"
												class="form-control"
												name="contact_no"
												maxlength="10"
												placeholder="Enter 10-digit number"
												value="<?= set_value($cno) ?>"
												id=""
											/>
										</div>
									</div>

									<div class="col-sm-3">
										<label>Owner's Full Name<?= $star ?></label>
										<input type="text" name="fname" class="form-control" placeholder="Enter full Name" value="<?= $first_name ?>" <?= $required ?> />
									</div>
								</div>

					            <?php if ($page_label != "edit"): ?>
									<!-- Toggle button/link -->
									<a data-toggle="collapse" href="#address" aria-expanded="false" aria-controls="address">+ Location & Address</a>

									<div class="show" id="address">
										<div class="well">
											<div class="row">
												<div class="col-sm-4">
													<label>Address Line 1 *</label>
													<textarea name="line1" rows="1" id="addressLine1" class="form-control address" placeholder="Line1 Address"></textarea>
												</div>
												
												<div class="col-sm-4">
													<label>Line2 address</label>
													<textarea name="line2" rows="1" id="addressLine2" class="form-control address" placeholder="Line2 Address"></textarea>
												</div>
												<div class="col-sm-4">
													<label>Landmark</label>
													<textarea name="landmark" rows="1" id="landMark" class="form-control address" placeholder="Landmark"></textarea>
												</div>
											</div>

											<div class="row nextFormLine">
												<div class="col-sm-3">
													<label>Country *</label>
													<select class="form-control" name="country_id" id="cnt_id" onchange="getState(this.value);">
														<?php if ($countries) {

															echo "<option value=''>select country</option>";

															foreach ($countries as $cnt_key => $cnt_value) {

																echo "<option value='".$cnt_value['country_id']."'>".$cnt_value['name']."</option>";
															}
														} else {
															echo "<option>country not available!</option>";
														} ?>
													</select>
												</div>
												
												<div class="col-sm-3" style="padding-right: 0px;">
													<div class="col-sm-12" style="padding: 0px;">
														<label>State *</label>
													</div>
													<div class="col-sm-10" style="padding: 0px;">
														<select class="form-control" name="state_id" onchange="getCity(this.value);" id="states"></select>
													</div>
													<div class="col-sm-2" style="padding: 5px;">
														<a href="javascript:void(0);" onclick="getState();" title="Refresh States"><i class="fa fa-undo" aria-hidden="true" style="margin-top: 5px;"></i></a>
													</div>
												</div>

												<div class="col-sm-3" style="padding: 0px;">
													<div class="col-sm-12" style="padding: 0px;">
														<label>City *</label>
													</div>
													<div class="col-sm-10" style="padding: 0px;">
														<select class="form-control" name="city_id" id="state_cities"></select>
													</div>
													<div class="col-sm-2" style="padding: 5px;">
														<a href="javascript:void(0);" onclick="getCity();" title="Refresh Cities"><i class="fa fa-undo" aria-hidden="true" style="margin-top: 5px;"></i></a>
													</div>
												</div>

												<div class="col-sm-3" style="padding-left: 0px;">
													<label>Postal Code *</label>
													<input type="number" name="pin" id="pin" class="form-control" placeholder="Postal Code" />
												</div>
											</div>

											<div class="row nextFormLine">
												<div class="col-sm-4">
													<label>Shop Contact Number</label>
													<input type="text" name="contact" class="form-control" placeholder="Shop Contact Number" />
												</div>
												<div class="col-sm-4">
													<label>Address Business Days</label>
													<input type="text" name="business_days" class="form-control" placeholder="Enter Company Business Days" value="<?= $business_days ?>" />
												</div>
												<div class="col-sm-4">
													<label>Address Business Hours</label>
													<input type="text" name="business_hours" class="form-control" placeholder="Enter Company Business Hours" value="<?= $business_hours ?>" />
												</div>
											</div>

											<div class="row nextFormLine">
												<div class="col-sm-2">
													<label>Latitude *</label>
													<input type="number" step="any" name="lat" class="form-control" placeholder="Enter Latitude" onkeyup="initialize();" id="lat" />
												</div>
												<div class="col-sm-2">
													<label>Longitude *</label>
													<input type="number" step="any" name="long" id="long" class="form-control" placeholder="Enter Longitude" onkeyup="initialize();" />
												</div>
												<div class="col-sm-8">
													<label class="label_hide" style="width: 100%;">make space equal to label</label>
													<button type="button" onclick="getLatLongFromAddress();" class="btn btn-primary">Get Coordinates from Address</button>
													<span class="text-muted small">
														Or click anywhere on the map to select your location and fetch its coordinates.
													</span>
												</div>
											</div>

											<!-- google map -->
											<div class="row">
												<div class="col-sm-12">
													<div id="googleMap" style="height:400px; margin-top: 10px;"></div>
												</div>
											</div>
										</div>
									</div>
						        <?php endif; ?>

								<div class="row">
									<div class="col-sm-8">
										<div class="table-responsive editTable">
											<table class="table table-bordered dataTable">
												<thead>
													<tr>
														<th class="text-align-center" colspan="6">
															Shop Images
															<i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#shopImages_tableBody" style="cursor:pointer;"></i>
														</th>
													</tr>
												</thead>
												<tbody style="height: auto;" id="shopImages_tableBody" class="collapse in">
													<tr>
														<?php echo renderImages($seller_images, $seller_images_dir, $merchant_id, 'seller', 6); ?>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="table-responsive editTable">
											<table class="table table-bordered dataTable">
												<thead>
													<tr>
														<th class="text-align-center">
															Shop Logo
															<i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#shopLogo_tableBody" style="cursor:pointer;"></i>
														</th>
													</tr>
												</thead>
												<tbody id="shopLogo_tableBody" class="collapse in">
													<tr>
														<?php
														echo renderSingleImage($merchant_logo, $seller_images_dir, $merchant_id, 'sellerLogo', $shop_name, 8);
														if ($merchant_logo) {
															echo '<input type="hidden" name="merchant_logo" value="'.$merchant_logo.'">';
														} ?>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="col-sm-2">
										<div class="table-responsive editTable">
											<table class="table table-bordered dataTable">
												<thead>
													<tr>
														<th class="text-align-center">
															<!-- Tooltip icon -->
															<i class="fa fa-info-circle text-primary"
																data-toggle="tooltip"
																data-placement="right"
																title="Allowed Business proof: GST Certificate, Shop & Establishment License, Udhyog Aadhar, Trade Certificate / License, FSSAI Registration, Current Cheque."
															></i>
															Business Proof
															<i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#businessProof_tableBody" style="cursor:pointer;"></i>
														</th>
													</tr>
												</thead>
												<tbody id="businessProof_tableBody" class="collapse in">
													<tr>
														<?php
														echo renderSingleImage($business_proof, $seller_images_dir, $merchant_id, 'businessProof', $shop_name, 9, ".gif, .jpg, .png, .pdf, .jpeg, .pdf");

														if ($business_proof) {
														
															echo '<input type="hidden" name="business_proof" value="'.$business_proof.'">';
														} ?>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
									
				        		<div class="row">
									<div class="col-sm-6">
										<div class="col-sm-6 nextFormLine" style="padding-left: 0px;">
											<label>Global Business days</label>
											<input type="text" name="business_days" class="form-control" placeholder="Enter Company Business Days" value="<?= $business_days ?>" />
										</div>
										<div class="col-sm-6 nextFormLine" style="padding-right: 0px;">
											<label>Global Business hours</label>
											<input type="text" name="business_hours" class="form-control" placeholder="Enter Company Business Hours" value="<?= $business_hours ?>" />
										</div>
										<div class="col-sm-12 nextFormLine" style="padding: 0px;">
											<label>Shop Description</label>
											<textarea name="description" rows="7" class="form-control address" placeholder="Enter description"><?= $description ?></textarea>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="table-responsive editTable">
											<table class="table table-bordered table-striped dataTable" style="white-space: normal;">
												<thead>
													<tr>
														<th colspan="2" class="text-align-center">
															Seller Offerings
															<button type="button" class="btn btn-primary pull-right" id="createSellerOfferingBtn"><i class="fa fa-plus"></i></button>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<div class="row form-group">
																<div class="col-sm-8" id="seller_offering_input_field_div"></div>
															</div>
														</td>
													</tr>
													<?php if (isset($data['seller_offering']) && $data['seller_offering']) {

														foreach ($data['seller_offering']['result'] as $seller_offering_value) {

															$offering_id = $seller_offering_value['offering_id'];
															$offering = $seller_offering_value['offering'];
															$params = $offering_id.', "'.$offering.'", '.$merchant_id;

															echo "<tr>
																<td>
																	<a href='javascript:void(0);' onclick='open_seller_offering_modal($params)'><i class='fa fa-edit'></i></a>&nbsp;
																	<a href='".base_url()."deleteSellerOffering/".$offering_id."/".$merchant_id."' onclick='return confirm(\"Are you sure?\")' style='margin-left: 1px;'><i class='fa fa-trash-o'></i></a>&nbsp;
																	".$offering."
																</td>
															</tr>";
														}
													} ?>
												</tbody>
											</table>
										</div><!-- /.box-body -->
									</div>
								</div>

								<!-- Toggle button/link -->
								<a data-toggle="collapse" href="#service_policies" aria-expanded="false" aria-controls="service_policies">+ Service & Policy Options</a>

								<div class="collapse" id="service_policies">
									<div class="well">
										<div class="row form-group nextFormLine">
											<div class="col-sm-1 termsMainLabel">
												<label>Finance Available:</label>
											</div>
											<div class="col-sm-1 termsAvailabilitySelectBox">
												<select class="form-control" name="finance_available">
													<?php if ($finance_available == "No") {

														$value0 = "selected";
														$value1 = '';
													
													} else {
														$value0 = '';
														$value1 = "selected";
													} ?>
													<option value="0" <?= $value0 ?> >No</option>
													<option value="1" <?= $value1 ?> >Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="finance_terms" placeholder="Enter Finance Terms"><?= $finance_terms ?></textarea>
											</div>
										</div>

										<div class="row form-group nextFormLine">
											<div class="col-sm-1 termsMainLabel">
												<label>Home Delievery:</label>
											</div>
											<div class="col-sm-1 termsAvailabilitySelectBox">
												<select class="form-control" name="home_delievery">
													<?php if ($home_delivery_available == "No") {

														$value0 = "selected";
														$value1 = '';

													} else {
														$value0 = '';
														$value1 = "selected";
													} ?>
													<option value="0" <?= $value0 ?> >No</option>
													<option value="1" <?= $value1 ?> >Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="delievery_terms" placeholder="Enter Delievery Terms"><?= $home_delivery_terms ?></textarea>
											</div>
										</div>

										<div class="row form-group nextFormLine">
											<div class="col-sm-1 termsMainLabel">
												<label>Installation Available:</label>
											</div>
											<div class="col-sm-1 termsAvailabilitySelectBox">
												<select class="form-control" name="installation_available">
													<?php if ($installation_available == "No") {

														$value0 = "selected";
														$value1 = '';
													} else {

														$value0 = '';
														$value1 = "selected";
													} ?>
													<option value="0" <?= $value0 ?> >No</option>
													<option value="1" <?= $value1 ?> >Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="installation_terms" placeholder="Enter Installation Terms"><?= $installation_terms ?></textarea>
											</div>
										</div>

										<div class="row form-group nextFormLine">
											<div class="col-sm-1 termsMainLabel">
												<label>Replacement Available:</label>
											</div>
											<div class="col-sm-1 termsAvailabilitySelectBox">
												<select class="form-control" name="replacement_available">
													<?php 
													if ($replacement_available == "No")
													{
														$value0 = "selected";
														$value1 = '';
													}
													else
													{
														$value0 = '';
														$value1 = "selected";
													}
													?>
													<option value="0" <?= $value0 ?> >No</option>
													<option value="1" <?= $value1 ?> >Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="replacement_terms" placeholder="Enter Replacement Terms"><?= $replacement_terms ?></textarea>
											</div>
										</div>

										<div class="row form-group nextFormLine">
											<div class="col-sm-1 termsMainLabel">
												<label>Return Available:</label>
											</div>
											<div class="col-sm-1 termsAvailabilitySelectBox">
												<select class="form-control" name="return_available">
													<?php 
													if ($return_available == "No")
													{
														$value0 = "selected";
														$value1 = '';
													}
													else
													{
														$value0 = '';
														$value1 = "selected";
													}
													?>
													<option value="0" <?= $value0 ?> >No</option>
													<option value="1" <?= $value1 ?> >Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="return_policy" placeholder="Enter Return Terms"><?= $return_policy ?></textarea>
											</div>
										</div>
									</div>
								</div>

	                            <div class="row nextFormLine">
	                        		<div class="col-sm-6">
	                        			<label>Meta Keyword</label>
	                        			<textarea class="form-control" rows="1" name="meta_keyword" placeholder="Enter Meta Keyword"><?= $meta_keyword ?></textarea>
	                        		</div>
	                        		<div class="col-sm-6">
	                        			<label>Meta Description</label>
	                        			<textarea class="form-control" rows="1" name="meta_description" placeholder="Enter Meta Description"><?= $meta_description ?></textarea>
	                        		</div>
	                        	</div>
					        </div>

					        <div class="box-footer"  align="right">
					        	<a href='<?= base_url("sellers/sellersTable") ?>' class='btn btn-default'>Cancel</a>
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    </form>
				    <?php } ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<script>
$(document).ready(function() {
    cnt_id = $('#cnt_id').val();
	if (parseInt(cnt_id)) 
		getState(cnt_id);

	var count1 = 1;
    var count2 = 1;
    $('#createSellerOfferingBtn').click(function () {
        $('#seller_offering_input_field_div').append('<div class="row" style="margin-top:10px;" id="con1'+count1+'">'+
                                        '<div class="col-sm-9">'+
                                            '<input type="text" class="form-control" name="seller_offering_values[]" placeholder="Offering'+count1+'" required/>' + 
                                        '</div>'+
                                        '<div class="col-sm-3">'+
                                            '<button type="button" class="btn btn-danger" id="btnRemove1'+count1+'" onclick="removeBtn(1'+count1+')">Remove</button>'+
                                        '</div>'+
                                    '</div>'
                                    );
        
        count1++;
    });
});

function validateForm() {

	let addressLine1 = $("#addressLine1").val();
	if (addressLine1 == '') {

        alert("Error: Address Line 1 is required!");
        return false;
    }

	let cnt_id = $("#cnt_id").val();
	if (cnt_id == '') 
    {
        alert("Error: Invalid country!");
        return false;
    }

	let states = $("#states").val();
	if (!states || states == '') 
    {
        alert("Error: Invalid state!");
        return false;
    }

	let state_cities = $("#state_cities").val();
	if (!state_cities || state_cities == '') 
    {
        alert("Error: Invalid city!");
        return false;
    }
	
	let pin = $("#pin").val();
	if (!pin || pin == '') 
    {
        alert("Error: Invalid pin is required!");
        return false;
    }
	
	//for address lat
    let lat = floatValidation($("input[name='lat']").val());
    if (!lat) 
    {
        alert("Error: Invalid latitude!");
        return false;
    }

    //for address long
    let long = floatValidation($("input[name='long']").val());
    if (!long) 
    {
        alert("Error: Invalid longitude!");
        return false;
    }
}

function open_seller_offering_modal(offering_id, Offering, merchant_id) 
{
    $('#offering_id').val(offering_id);
    $('#offering').val(Offering);
    $('#merchant_id').val(merchant_id);
    $("#sellerOfferingModal").modal();
}

function removeBtn(id) 
{
	$('#con'+id).remove();
}

function getLatLongFromAddress() 
{
    geocoder = new google.maps.Geocoder();
    line1 = ($('[name="line1"]').val()) ? $('[name="line1"]').val()+', ' : '';
    line2 = ($('[name="line2"]').val()) ? $('[name="line2"]').val()+', ' : '';
    landmark = ($('[name="landmark"]').val()) ? $('[name="landmark"]').val()+', ' : '';
    country = ($("#cnt_id option:selected").val()) ? $("#cnt_id option:selected").html()+', ' : '';
    state = ($("#states option:selected").html()) ? $("#states option:selected").html()+', ' : '';
    city = ($("#state_cities option:selected").html()) ? $("#state_cities option:selected").html() : '';
    pin = ($('[name="pin"]').val()) ? '-'+$('[name="pin"]').val() : '';
    address = line1+line2+landmark+country+state+city+pin;
    
    // debugger;
	if(address) {
		geocoder.geocode({'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				//get lat-long
				latitude = results[0].geometry.location.lat().toFixed(6);
				longitude = results[0].geometry.location.lng().toFixed(6);

				//set lat-long in text fields
				$('[name="lat"]').val(latitude);
				$('[name="long"]').val(longitude);

				//call map for map initialization
				initialize();
			}
		});
	} else {
		alert('Error: Fill address details');
	}
}

//initialize google map
function initialize() 
{
    var lat = ($('[name="lat"]').val()) ? $('[name="lat"]').val() : 22.7196;
    var long = ($('[name="long"]').val()) ? $('[name="long"]').val() : 75.8577;

    //set location on google map using lat long
    var myLatlng = new google.maps.LatLng(lat, long);
    var mapOptions = {
		zoom: 15,
		center: myLatlng,
		draggable: true
	}
    var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
    setMarkerOnClickMap(myLatlng, map);

    google.maps.event.addListener(map, 'click', function (e) {
        lat1 = (e.latLng.lat()).toFixed(6);
        long1 = (e.latLng.lng()).toFixed(6);

        $('[name="lat"]').val(lat1);
        $('[name="long"]').val(long1);

        setMarkerOnClickMap(e.latLng, map);
    });
}

var gmarkers = [];

//set marker on click map
function setMarkerOnClickMap(latLng, map) 
{
    for(i=0; i<gmarkers.length; i++) gmarkers[i].setMap(null); //remove old markers from map
	var marker = new google.maps.Marker({position: latLng}); //set marker on google map
    marker.setMap(map); // To add the marker to the map, call setMap();
    gmarkers.push(marker); //push old marker in array

    //show info window for address
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    showFormattedAddress((latLng.lat()), (latLng.lng())); //show address div on click marker
}

//show address div on click marker
function showFormattedAddress(lat, long) 
{
    infowindow = new google.maps.InfoWindow();
    latlng = new google.maps.LatLng(lat, long);
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) 
            infowindow.setContent(results[0].formatted_address);
    });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI&callback=initialize"></script>

<style type="text/css">
.thumbnail img {
    height:50px;
    float: left;
}

.thumbnail {
	border: none;
    float: left;
    margin-bottom: 0px;
}

.well {
	padding: 10px;
}
</style>
