<?php
if (isset($start_date)) {
	$start_date = explode(" ", $start_date);
}

if (isset($end_date)) {
	$end_date = explode(" ", $end_date);
}

$offer_id = isset($offer_id) ? $offer_id : '';
$offer_title = isset($offer_title) ? $offer_title : set_value('offer_title');
$offer_desc = isset($description) ? $description : set_value('offer_desc');
$start_date = isset($start_date[0]) ? $start_date[0] : '';
$end_date = isset($end_date[0]) ? $end_date[0] : '';
$create_date = isset($create_date) ? convert_to_user_date($create_date) : '';
$update_date = isset($update_date) ? convert_to_user_date($update_date) : '';
$attatchments = isset($attatchments) ? $attatchments : array();
$merchant_id = isset($merchant_id) ? $merchant_id : '';
$brand_id = isset($brand_id) ? $brand_id : '';

if (isset($page_label) && $page_label == 'view') {
	$page_title = 'Offer Detail';
} elseif (isset($page_label) && $page_label == 'edit') {
	$page_title = 'Edit Offer';
} else {
	$page_label = 'Add';
	$page_title = 'Add Offer';
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Offer<small><?= $page_label ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php if ($_COOKIE['site_code'] == 'seller') { ?>
        		<li><a href="<?= base_url('page/offerManagement') ?>">Offer Management</a></li>
        	<?php } elseif ($_COOKIE['site_code'] == 'admin') { ?>
            	<li><a href="<?= base_url('sellers/offers') ?>">Offer Management</a></li>
            <?php if ($page_label == 'add') { ?>
            	<li><a href="<?= base_url('sellers/offerManagement') ?>">Sellers</a></li>
            <?php } } ?>
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
					<?php if ($page_label == "view"): ?>
						<div class="box-footer">
							<div class="box-footer" style="margin-right: 10px; text-align: right;">
								<?php if ($_COOKIE['site_code'] == 'admin') { ?>
									<a href='<?= base_url("sellers/offers") ?>' title='Back'><i class="fa fa-undo" aria-hidden="true"></i></a>&nbsp;
								<?php } else { ?>
									<a href='<?= base_url("page/offerManagement") ?>' title='Back'><i class="fa fa-undo" aria-hidden="true"></i></a>&nbsp;
								<?php } ?>
							
								<form action="<?= base_url('offer/edit') ?>" method="post" id='offer/edit' style="display:none;">
									<input type="hidden" name="offer_id" value="<?= $offer_id ?>" />
								</form>
								<a href='javascript:void(0)' onclick='document.getElementById("offer/edit").submit();' title='Edit'><i class='fa fa-edit'></i></a>

								<a href='<?= base_url("deleteOffer/$offer_id") ?>' onclick='return confirm("Are you sure?")'title='Delete'><i class='fa fa-trash-o'></i></a>
							</div>
						</div><!-- /.box-header -->
					<?php endif; ?>

					<?php if ($page_label == "view") { ?>
						<div class="box-body">
				        	<div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Offer title:</label>	
				            	</div>
				            	<div class="col-sm-10">
				            		<?= $offer_title ?>
				            	</div>
				            </div>

				            <div class="row form-group">
                        		<div class="col-sm-2">
                        			<label>Description:</label>	
                        		</div>
                        		<div class="col-sm-10">
                        			<?= $offer_desc; ?>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-2">
                        			<label>Start date:</label>	
                        		</div>
                        		<div class="col-sm-10">
                        			<?= $start_date; ?>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-2">
                        			<label>End date:</label>	
                        		</div>
                        		<div class="col-sm-10">
                        			<?= $end_date; ?>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-2">
                        			<label for="">Offer status:</label>
                        		</div>
                        		<div class="col-sm-10">
                        			<?php if ($current_status) {
                            			echo "Active";
									} else {
	                            		echo "Not active";
									} ?>
                        		</div>
                        	</div>

                        	<?php if ($_COOKIE['site_code'] == 'admin') { ?>
	                        	<div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label for="">HTML File(s):</label>
	                        		</div>
	                        		<div class="col-sm-10">
	                        			<?php for ( $i = 1, $j = 0; $i <= 5; $i++, $j++ ) {

				                    		$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';

											if ($link) {
												echo $this->config->item('site_url').HTML_FILES_PATH.$link;
											}
				                    	} ?>
	                        		</div>
	                        	</div>
                        	<?php } ?>

                        	<?php if (!empty($attatchments)) { ?>
                        	<div class="row form-group">
                        		<div class="col-sm-2">
                        			<label>Offer Images:</label>	
                        		</div>
	                        	<div class="col-sm-10">
	                        		<?php 
		                        	foreach ($attatchments as $img_value)
		                        	{
		                        		$img_src = $atch_path.'/'.$offer_id.'/'.$img_value['atch_url'];
		                        		
		                        		echo '<div class="thumbnail">
		                        				<figure>
													<img src="'.$img_src.'" class="img-rounded" />
											    </figure>
											</div>';
		                        	}	
			                        ?>
		                        </div>
	                        </div>
	                        <?php } ?>

	                        <div class="row form-group">
						    	<div class="col-sm-2">
									<label>Listing Products:</label>
								</div>
								<div class="col-sm-10">
									<span class="bigcheck">
										<?php
										$count = 1;

										if ($linked_products) 
			    						{
			    							foreach ($linked_products as $linked_product_val)
			    							{
			    								if ($linked_product_val['ofr_mp_lst_id']) 
			    								{
			    									echo $linked_product_val['product_name'];

													if ( sizeof($linked_products)>$count )
														echo ", ";

													$count++;
			    								}
			    							}
			    						}
										
										if ( $count == 1 )
			    							echo "Not available";
	                                	?>
	                                </span>
								</div>
							</div>

	                        <div class="row form-group">
                        		<div class="col-sm-2">
                        			<label>Create Date:</label>	
                        		</div>
                        		<div class="col-sm-10">
                        			<?= $create_date; ?>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-2">
                        			<label>Update Date:</label>	
                        		</div>
                        		<div class="col-sm-10">
                        			<?= $update_date; ?>
                        		</div>
                        	</div>
				        </div><!-- /.box-body -->
					<?php } else { ?>
						<!-- form start -->
					    <?php if ($offer_id) {
							$formAttributes = ['onsubmit' => 'return confirmSave(\'' . UPDATE_MSG . '\');'];
						} else {
							$formAttributes = ['onsubmit' => 'return confirmSave(\'' . SAVE_MSG . '\');'];
						}
						echo form_open_multipart('addOffer', $formAttributes);
						?>
							
							<input type="hidden" name="offer_id" value="<?= $offer_id; ?>" />

					    	<div class="box-body">
								<div class="row">
									<?php if ($_COOKIE['site_code'] == 'admin'): ?>
										<div class="col-sm-3">
											<label for="">Seller *</label>
											<?php
											echo '<select class="form-control" name="merchant_id" id="" required>
													<option value="">Select Seller</option>';

												foreach ($sellers as $seller) {

													if (!$seller['establishment_name']) {
														continue;
													}

													$selected = $seller['merchant_id'] == $merchant_id ? 'selected' : '';

													echo "<option value='".$seller['merchant_id']."' ".$selected.">".$seller['establishment_name']."</option>";
												}

											echo "</select>";
											?>
										</div>
									<?php endif; ?>
								
									<div class="col-sm-3">
										<label for="">Brand</label>
										<?php
										echo '<select class="form-control" name="ofr_brd_id" id="">
												<option value="">Select Brand</option>';

											foreach ($brands['result'] as $brands_value) {

												$selected = $brands_value['brand_id'] == $ofr_brd_id ? 'selected' : '';

												echo "<option value='".$brands_value['brand_id']."' ".$selected.">".$brands_value['name']."</option>";
											}
										
										echo "</select>";
										?>
									</div>
									<div class="col-sm-3">
										<label for="">Status</label>
										<?php
										$active_selected = "";
										$deactive_selected = "";

										if (isset($current_status)) {
											
											if ($current_status) {
												$active_selected = "selected";
											} else {
												$deactive_selected = "selected";
											}
										}
										?>

										<select class="form-control" name="offer_status" id="">
											<option value="1" <?= $active_selected ?> >ACTIVE</option>
											<option value="0" <?= $deactive_selected ?> >DEACTIVE</option>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="">Title *</label>
										<input type="text" name="offer_title" class="form-control" placeholder="Offer Title" value="<?= $offer_title; ?>" id="" required />
									</div>
								</div>

					            <div class="row nextFormLine">
	                        		<div class="col-sm-3">
	                        			<label for="">Start Date *</label>
	                        			<input type="date" class="form-control" name="offer_startDate" value="<?= $start_date; ?>" id="" required />
	                        		</div>
									<div class="col-sm-3">
	                        			<label for="">End Date *</label>
	                        			<input type="date" class="form-control" name="offer_endDate" value="<?= $end_date; ?>" id="" required />
	                        		</div>
									<div class="col-sm-6">
					            		<label for="">Offer Description *</label>
					                	<textarea name="offer_desc" class="form-control address" placeholder="Enter Offer Description" rows="1" id="" required><?= $offer_desc; ?></textarea>
					                </div>
	                        	</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="table-responsive editTable">
											<table class="table table-bordered dataTable">
												<thead>
													<tr>
														<th class="text-align-center" colspan="6">
															Offer Images
															<i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#offerImages_tableBody" style="cursor:pointer;"></i>
														</th>
													</tr>
												</thead>
												<tbody style="height: auto;" id="offerImages_tableBody" class="collapse in">
													<tr>
													<?php echo renderImages($attatchments, $atch_path.$offer_id, $offer_id, 'editOffer', 6); ?>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<?php if ($offer_id): ?>
									<!-- Toggle button/link -->
									<a data-toggle="collapse" href="#additionalDetails" aria-expanded="false" aria-controls="additionalDetails">+ Show Advanced Options</a>
									
									<!-- Collapsible content -->
									<div class="collapse in" id="additionalDetails">
										<div class="well">
											<div class="row nextFormLine">
												<div class="col-sm-4">
													<label for="">Meta Title</label>
													<input type="text" class="form-control" placeholder="Meta Title" name="meta_title" value="<?= $meta_title; ?>" id="" />
												</div>
												<div class="col-sm-4">
													<label for="">Meta Keywords</label>
													<textarea rows="1" class="form-control" placeholder="Meta Keyword(s)" name="meta_keyword" id=""><?= $meta_keyword ?></textarea>
												</div>

												<div class="col-sm-4">
													<label for="">Meta Description</label>
													<textarea rows="1" class="form-control" placeholder="Meta Description" name="meta_description" id=""><?= $meta_description ?></textarea>
												</div>
											</div>

											<?php if ($_COOKIE['site_code'] == 'admin') { ?>
												<div class="row">
													<div class="col-sm-12">
														<div class="table-responsive editTable">
															<table class="table table-bordered dataTable">
																<thead>
																	<tr>
																		<th colspan="4" class="text-align-center">
																			HTML Files
																			<i class="fa fa-chevron-down toggle-icon" data-toggle="collapse" data-target="#HTMLFiles_tableBody" style="cursor:pointer;"></i>
																		</th>
																	</tr>
																	<tr>
																		<th></th>
																		<th id="">Prefix Path</th>
																		<th id="">File Path</th>
																		<th id="">Action</th>
																	</tr>
																</thead>
																<tbody id="HTMLFiles_tableBody" class="in">
																	<?php for($i = 1, $j = 0; $i <= 5; $i++, $j++) {

																		$link_id = isset( $html_files['result'][$j]['html_file_id'] ) ? $html_files['result'][$j]['html_file_id'] : '';
																		$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';

																		if ($link) {

																			$buttons = "<a href='".$this->config->item('site_url').HTML_FILES_PATH.$link."' target='_blank'><i class='fa fa-paperclip'></i></a>&nbsp;
																			<a href='".base_url("deleteLink/$link_id/$offer_id/OFFER")."' onclick='return confirm(\"Are you sure?\")'><i class='fa fa-trash-o'></i></a>";
																		} else {
																			$buttons = '';
																		}
																		
																		echo "<tr>
																				<td>HTML LINK".$i."</td>
																				<td class='statusLabel'><span class='label label-default'>".$this->config->item('site_url').HTML_FILES_PATH."</span></td>
																				<td>
																					<input type='hidden' name='html_id".$i."' value='".$link_id."' />
																					<input type='text' name='html_link".$i."' value='".$link."' class='form-control' />
																				</td>
																				<td>".$buttons."</td>
																			</tr>";
																	}
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div><!-- /.box-body -->
											<?php } ?>
										</div>
									</div>
								<?php endif; ?>

								<div class="box-footer"  align="right">
									<?php if ($_COOKIE['site_code'] == 'seller') { ?>
										<a href='<?= base_url("page/offerManagement") ?>' class='btn btn-default'>Cancel</a>
									<?php } elseif ($_COOKIE['site_code'] == 'admin') { 
										if ($page_label == 'add') { ?>
											<a href='<?= base_url("sellers/offerManagement") ?>' class='btn btn-default'>Cancel</a>
										<?php } else { ?>
											<a href='<?= base_url("sellers/offers") ?>' class='btn btn-default'>Cancel</a>
									<?php } } ?>

									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
					        </div><!-- /.box-body -->
					    <?= form_close(); ?>
					<?php } ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<style>
span.bigcheck-target {
	font-family: FontAwesome;
	color: #D35400;
}

input[type='checkbox'].bigcheck {
  position: relative;
  left: -999em;
}

input[type='checkbox'].bigcheck + span.bigcheck-target:after {
  content: "\f096";
}

input[type='checkbox'].bigcheck:checked + span.bigcheck-target:after {
  content: "\f046";
}

.thumbnail img {
    height:50px;
    float: left;
}

.thumbnail {
	border: none;
    float: left;
    margin-bottom: 0;
}
</style>