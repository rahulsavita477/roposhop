<?php 
if (isset($start_date)) 
	$start_date = explode(" ", $start_date);

if (isset($end_date)) 
	$end_date = explode(" ", $end_date);

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

if (isset($page_label) && $page_label == 'view') 
	$page_title = 'Offer Detail';
else if (isset($page_label) && $page_label == 'edit') 
	$page_title = 'Edit Offer';
else
{
	$page_label = 'add';
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
            <div class="col-md-8 col-md-offset-2">
				<!-- general form elements -->
				<div class="box box-primary">
				    <div class="box-header">
				        <?php if ($page_label == "view") {
							echo '<div class="box-footer" align="right">';

							if ($_COOKIE['site_code'] == 'admin') {
						?>
							<a href='<?= base_url("sellers/offers") ?>' class='btn btn-default'>Back</a>
						<?php } else { ?>
							<a href='<?= base_url("page/offerManagement") ?>' class='btn btn-default'>Back</a>
						<?php } ?>
							<a href='<?= base_url("editOffer/$offer_id/edit") ?>' class='btn btn-primary'>Edit</a>
							<a href='<?= base_url("deleteOffer/$offer_id") ?>' class='btn btn-danger'>Delete</a>
							</div>
					    <?php } ?>
					</div><!-- /.box-header -->

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
                        			<label>Offer status:</label>	
                        		</div>
                        		<div class="col-sm-10">
                        			<?php
                        			if ($current_status)
                            			echo "Active";
	                            	else
	                            		echo "Not active";
                        			?>
                        		</div>
                        	</div>

                        	<?php if ($_COOKIE['site_code'] == 'admin') { ?>
	                        	<div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>HTML File(s):</label>	
	                        		</div>
	                        		<div class="col-sm-10">
	                        			<?php
	                        			for ( $i = 1, $j = 0; $i <= 5; $i++, $j++ )
				                    	{
				                    		$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';

											if ($link)
												echo $this->config->item('site_url').HTML_FILES_PATH.$link;
				                    	}
	                        			?>
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
					    <?= form_open_multipart('addOffer'); ?>
					    	<div class="box-body">
				        		<?php if ($_COOKIE['site_code'] == 'admin') { ?>
						        	<!-- select brand -->
			                        <div class="row form-group">
		                        		<div class="col-sm-2">
		                        			<label>Seller:</label>
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<?php
								    		echo '<select class="form-control" name="merchant_id">
								    				<option value="">select seller</option>';

								    			foreach ($sellers as $seller) 
								    			{
								    				if (!$seller['establishment_name'])
								    					continue;

								    				$selected = $seller['merchant_id'] == $merchant_id ? 'selected' : '';

								    				echo "<option value='".$seller['merchant_id']."' ".$selected.">".$seller['establishment_name']."</option>";
								    			}

								    		echo "</select>
								    			</div>";
								    		?>
		                        	</div>
	                        	<?php } ?>

	                            <!-- select brand -->
		                        <div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Brand:</label>
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<?php
							    		echo '<select class="form-control" name="ofr_brd_id">
							    				<option value="">Please select a brand!!</option>';

							    			foreach ($brands['result'] as $brands_value) 
							    			{
							    				$selected = $brands_value['brand_id'] == $ofr_brd_id ? 'selected' : '';

							    				echo "<option value='".$brands_value['brand_id']."' ".$selected.">".$brands_value['name']."</option>";
							    			}
							    		
							    		echo "</select>
							    			</div>";
							    		?>
	                        	</div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					                	<label>Title*: </label>
					                </div>
					                <div class="col-sm-5">
						                <input type="hidden" name="offer_id" value="<?= $offer_id; ?>">
						                <input type="text" name="offer_title" class="form-control" placeholder="Enter Offer Title" value="<?= $offer_title; ?>" required />
						            </div>
					            </div>

					            <div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Start Date*:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<input type="date" class="form-control" name="offer_startDate" value="<?= $start_date; ?>" required />
	                        		</div>
	                        	</div>

	                        	<div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>End Date*:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<input type="date" class="form-control" name="offer_endDate" value="<?= $end_date; ?>" required />
	                        		</div>
	                        	</div>

	                        	<!-- select category -->
		                        <div class="row form-group">
		                        	<div class="col-sm-2">
		                            	<label>Status</label>
		                            </div>
		                            <div class="col-sm-5">
		                            	<?php
		                            	$active_selected = "";
		                            	$deactive_selected = "";

		                            	if (isset($current_status))
		                            	{
		                            		if ($current_status)
		                            			$active_selected = "selected";
			                            	else
			                            		$deactive_selected = "selected";
		                            	}
										?>

		                            	<select class="form-control" name="offer_status">
		                            		<option value="1" <?= $active_selected ?> >ACTIVE</option>
		                            		<option value="0" <?= $deactive_selected ?> >DEACTIVE</option>
		                            	</select>
							    	</div>
							    </div>

								<div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Offer Description*:</label>	
					            	</div>
					                <div class="col-sm-8">
					                	<textarea name="offer_desc" class="form-control address" placeholder="Enter Offer Description" rows="1" required /><?= $offer_desc; ?></textarea>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="box-body table-responsive">
					                    <table class="table table-bordered table-striped data-pagination-table">
					                        <thead>
					                            <tr>
					                                <th colspan="3"><center>Offer Images</center></th>
					                            </tr>
					                        </thead>
					                        <tbody>
						                        <?php for ( $i = 1, $j = 0; $i < 7; $i++, $j++ ) { ?>
						                        	<tr>
						                        		<td>
						                        			<div class="btn btn-primary btn-file">
							                                    <i class="fa fa-paperclip"></i> Image<?= $i ?>
							                                    <input type="file" name="file<?= $i ?>" id="file<?= $i ?>" />
							                                </div>
						                        		</td>
						                        		<?php 
						                        		if ($page_label == 'edit') 
						                        		{
							                        		echo "<td>";
								                        		if (isset($attatchments[$j]))
								                        		{
								                        			$img_src = $atch_path.'/'.$offer_id.'/'.$attatchments[$j]['atch_url'];
									                        		
									                        		echo '<div class="thumbnail">
									                        				<figure>
																				<img src="'.$img_src.'">
																				<center>
																		    		<figcaption><a href="'.base_url().'deleteAttactchment/'.$attatchments[$j]['atch_url'].'/editOffer/'.$offer_id.'" class="btn btn-danger">DELETE</a></figcaption>
																		    	</center>
																		    </figure>
																		</div>

																		<input type="hidden" name="remove_img'.$i.'" value="'.$attatchments[$j]['atch_url'].'" />';
									                        	}
									                        echo "</td>";
								                        } ?>
						                        		</td>
						                        		<td><div class="file<?= $i ?>"></div></td>
						                        	</tr>
						                        <?php } ?>
					                    	</tbody>
					                    </table>
					                </div>
					            </div>

					            <?php if ($_COOKIE['site_code'] == 'admin') { ?>
									<div class="box-body table-responsive">
					                    <table class="table table-bordered table-striped">
					                        <thead>
					                        	<tr>
					                        		<th colspan="4">
					                        			<center>HTML FILE(s)</center>
					                        		</th>
					                        	</tr>
					                            <tr>
					                                <th></th>
					                                <th>Prefix Path</th>
					                                <th>File Path</th>
					                                <th>Action</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php
					                        	for ( $i = 1, $j = 0; $i <= 5; $i++, $j++ )
					                        	{
					                        		$link_id = isset( $html_files['result'][$j]['html_file_id'] ) ? $html_files['result'][$j]['html_file_id'] : '';
													$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';

													if ( $link ) 
													{
														$buttons = "<a href='".base_url("deleteLink/$link_id/$offer_id/OFFER")."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
				                                                <a href='".$this->config->item('site_url').HTML_FILES_PATH.$link."' class='btn-custom btn-primary' target='_blank'>Preview</a>";
													}
													else
														$buttons = '';
													
					                                echo "<tr>
				                        					<td>HTML LINK".$i."</td>
				                        					<td><span class='label label-default'>".$this->config->item('site_url').HTML_FILES_PATH."/</span></td>
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
					                </div><!-- /.box-body -->
				                <?php } ?>
					        </div><!-- /.box-body -->

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