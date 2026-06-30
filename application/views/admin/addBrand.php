<?php 
$brand_id = isset($data['brand_id']) ? $data['brand_id'] : '';
$brand_desc = isset($data['brand_desc']) ? $data['brand_desc'] : '';
$brand_name = isset($data['name']) ? $data['name'] : '';
$brand_logo = isset($data['brand_logo']) ? $data['brand_logo'] : false;
$brand_images_dir = isset($data['brand_images_dir']) ? $data['brand_images_dir'] : '';
$brand_images = isset($data['brand_images']) ? $data['brand_images'] : '';
$meta_keyword = isset($data['meta_keyword']) ? $data['meta_keyword'] : '';
$meta_description = isset($data['meta_description']) ? $data['meta_description'] : '';
$create_date = isset($data['create_date']) ? convert_to_user_date($data['create_date']) : '';
$update_date = isset($data['update_date']) ? convert_to_user_date($data['update_date']) : '';
$isRequiredLogo = "";
$star = "";
$page_label = isset($page_label) ? $page_label : 'Add Brand';

if (!$brand_id)
{
	$isRequiredLogo = "required";
	$star = '*';
}

if (isset($page_label) && $page_label == "edit") 
	$page_title = 'Edit brand';
else if (isset($page_label) && $page_label == "view") 
	$page_title = 'View brand';
else
{
	$page_label = "add";
	$page_title = 'Add brand';
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
	<section class="content-header">
		<h1>
			Brand
			<small>
				<?= ucfirst($page_label) ?>
			</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url('brand') ?>">Brand Management</a></li>
			<li class="active">
				<?= $page_title ?>
			</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<?php if ($page_label == "view") { ?>
						<div class="box-footer" align="right">
							<a href='<?= base_url("brand") ?>' title='Back'><i class="fa fa-undo" aria-hidden="true"></i></a>&nbsp;
							<a href='<?= base_url("editBrand/$brand_id/edit") ?>' title='Edit'><i class='fa fa-edit'></i></a>&nbsp;
							<a href='<?= base_url("deleteBrand/$brand_id") ?>' onclick='return confirm("Are you sure?")'title='Delete'><i class='fa fa-trash-o'></i></a>
						</div>
						<?php } ?>

					</div><!-- /.box-header -->

					<?php if ($page_label == "view") { ?>
					<div class="box-body">
						<div class="row form-group">
							<center>
								<?php if ($brand_logo) { ?>
								<img src="<?= $brand_images_dir." /".$brand_logo; ?>" width="100px">
								<?php } else 
				        				echo "Logo not available!";
				        			?>
							</center>
						</div>

						<div class="row form-group">
							<div class="col-sm-2">
								<label>Brand Name:</label>
							</div>
							<div class="col-sm-10">
								<?= $brand_name ?>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-2">
								<label>Description:</label>
							</div>
							<div class="col-sm-10">
								<?= $brand_desc ?>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-2">
								<label>Brand Images:</label>
							</div>
							<div class="col-sm-10">
								<?php 
                        			if (!empty($brand_images)) 
                        			{
			                        	foreach ($brand_images as $img_value) 
			                        		echo '<div class="thumbnail">
			                        				<figure>
														<img src="'.$brand_images_dir.'/'.$img_value['atch_url'].'" class="img-rounded" />
												    </figure>
												</div>';
			                        }
			                        ?>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-3">
								<label>HTML File(s):</label>
							</div>
							<div class="col-sm-9">
								<?php
									for ( $i = 1, $j = 0; $i <= 5; $i++, $j++ )
		                        	{
		                        		$link = isset($html_files['result'][$j]['html_file']) ? $html_files['result'][$j]['html_file'] : '';
										
										if ($link) 
											echo $this->config->item('site_url').HTML_FILES_PATH.$link."<br />";
		                        	}
                                	?>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-2">
								<label>Meta keywords:</label>
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
					</div><!-- /.box-body -->
					<?php
					} else {
					if ($page_label == 'edit') {
						$formAttributes = ['onsubmit' => 'return confirmSave(\'' . UPDATE_MSG . '\');'];
					} else {
						$formAttributes = ['onsubmit' => 'return confirmSave(\'' . SAVE_MSG . '\');'];
					}
					echo form_open_multipart('addBrand', $formAttributes);
					?>
					<div class="box-body" style="padding-bottom: 0px;">

						<div class="row">
							<div class="col-sm-4">
								<label>Brand Name *</label>
								<input type="hidden" name="brand_id" value="<?= $brand_id; ?>">
								<input type="text" name="brand_name" class="form-control" placeholder="Enter Brand Name" value="<?= $brand_name; ?>" required />
							</div>

							<div class="col-sm-8">
								<label>Description:</label>
								<textarea class="form-control" rows="1" name="brand_desc"
									placeholder="Please enter brand description ..."><?= $brand_desc; ?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2">
								<div class="table-responsive editTable">
									<table class="table table-bordered dataTable">
										<thead>
											<tr>
												<th class="text-align-center" colspan="6">
													Brand Logo
													<i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#brandLogo_tableBody" style="cursor:pointer;"></i>
												</th>
											</tr>
										</thead>
										<tbody style="height: auto;" id="brandLogo_tableBody" class="collapse in">
											<tr>
												<?php 
												echo renderSingleImage($brand_logo, $brand_images_dir, $brand_id, 'brandLogo', $brand_name);
												if ($brand_logo) {
													echo '<input type="hidden" name="brand_logo" value="'.$brand_logo.'">';
												} ?>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="col-sm-10">
								<div class="table-responsive editTable">
									<table class="table table-bordered dataTable">
										<thead>
											<tr>
												<th class="text-align-center" colspan="6">
													Brand Images
													<i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#brandImages_tableBody" style="cursor:pointer;"></i>
												</th>
											</tr>
										</thead>
										<tbody style="height: auto;" id="brandImages_tableBody" class="collapse in">
											<tr>
												<?php echo renderImages($brand_images, $brand_images_dir, $brand_id, 'editBrand', 6); ?>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<?php if ($brand_id): ?>
						<!-- Toggle button/link -->
						<a data-toggle="collapse" href="#additionalDetails" aria-expanded="false" aria-controls="additionalDetails">+ Show Advanced Options</a>
		
						<!-- Collapsible content -->
						<div class="collapse" id="additionalDetails">
							<div class="well">
								<div class="row">
									<div class="col-sm-6">
										<label>Meta Keywords</label>
										<textarea rows="1" class="form-control" placeholder="please enter meta keyword(s)" name="meta_keyword"><?= $meta_keyword ?></textarea>
									</div>

									<div class="col-sm-6">
										<label>Meta Description:</label>
										<textarea rows="1" class="form-control" placeholder="please enter meta description" name="meta_description"><?= $meta_description ?></textarea>
									</div>
								</div>

								<div class="row nextFormLine">
									<div class="col-sm-12">
										<div class="table-responsive editTable">
											<table class="table table-bordered table-striped dataTable">
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
													<?php for ($i = 1, $j = 0; $i <= 5; $i++, $j++) {

														$link_id = isset($data['html_files']['result'][$j]['html_file_id']) ? $data['html_files']['result'][$j]['html_file_id'] : '';
														$link = isset($data['html_files']['result'][$j]['html_file']) ? $data['html_files']['result'][$j]['html_file'] : '';

														if ($link) {

															$buttons = "<a href='".base_url(HTML_FILES_PATH.$link)."' target='_blank'><i class='fa fa-paperclip'></i></a>&nbsp;
															<a href='".base_url("deleteLink/$link_id/$brand_id/BRAND")."' onclick='return confirm(\"Are you sure?\")'><i class='fa fa-trash-o'></i></a>";
														} else {
															$buttons = '';
														}
														
														echo "<tr>
															<td>HTML LINK".$i."</td>
															<td><span class='label label-default'>".$this->config->item('site_url').HTML_FILES_PATH."</span></td>
															<td>
																<input type='hidden' name='html_id".$i."' value='".$link_id."' />
																<input type='text' name='html_link".$i."' value='".$link."' class='form-control' />
															</td>
															<td>".$buttons."</td>
														</tr>";
													} ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>

					<div class="box-footer" align="right" style="clear: both;">
						<a href='<?= base_url("brand") ?>' class='btn btn-default'>Cancel</a>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<?= form_close() ?>
					<?php } ?>
				</div><!-- /.box -->
			</div> <!-- /.row -->
	</section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<style type="text/css">
	.thumbnail img {
		height: 50px;
		float: left;
	}

	.thumbnail {
		border: none;
		float: left;
		margin-bottom: 0px;
	}

	input[type="file"] {
		display: block;
	}
</style>