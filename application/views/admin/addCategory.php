<?php
$required = "";
$star = "";

if (isset($page_label) && $page_label == "edit") {
	$page_title = 'Edit category';
} elseif (isset($page_label) && $page_label == "view") {
	$page_title = 'View category';
} else {
	$page_label = "add";
	$page_title = 'Add category';
	$required = "required";
	$star = "*";
}

$cat_id = isset($category['category_id']) ? $category['category_id'] : '';
$cat_name = isset($category['category_name']) ? $category['category_name'] : set_value('cat_name');
$parent_category_id = isset($category['parent_category_id']) ? $category['parent_category_id'] : '';
$meta_keyword = isset($category['meta_keyword']) ? $category['meta_keyword'] : '';
$meta_description = isset($category['meta_description']) ? $category['meta_description'] : '';
$create_date = isset($category['create_date']) ? convert_to_user_date($category['create_date']) : '';
$update_date = isset($category['update_date']) ? convert_to_user_date($category['update_date']) : '';

//categoty input type
$cat_name_data = array(
    'name' => 'cat_name',
    'class' => 'form-control',
    'placeholder' => 'Enter category name',
    'value' => $cat_name,
	'required' => $required
);
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Category<small><?= ucfirst($page_label) ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('category') ?>">Category Management</a></li>
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
				    <div class="box-header">
				        <?php if ($page_label == "view") { ?>
					        <div class="box-footer" align="right">
					            <a href='<?= base_url("category") ?>' title='Back'><i class="fa fa-undo" aria-hidden="true"></i></a>&nbsp;
					            <a href='<?= base_url("editCategory/$cat_id/edit") ?>' title='Edit'><i class='fa fa-edit'></i></a>&nbsp;
					            <a href='<?= base_url("deleteCategory/$cat_id") ?>' onclick='return confirm("Are you sure?")'title='Delete'><i class='fa fa-trash-o'></i></a>
					        </div>
					    <?php } ?>
				    </div><!-- /.box-header -->

				    <!-- form start -->
				    <?php if ($page_label == "view") { ?>
				    	<div class="box-body">
				    		<div class="row form-group">
				    			<div class="col-sm-2">
				    				<label>Category:</label>	
				    			</div>
				    			<div class="col-sm-10">
				    				<?= $cat_name ?>
				    			</div>
				            </div>
				        
	    	 				<!-- select category -->
	                        <div class="row form-group">
	                        	<div class="col-sm-2">
	                            	<label>Parent Category:</label>
	                            </div>
	                            <div class="col-sm-10">
		                   		 	<?php
		                   		 	$par_cat_name = '-';
						    		if ($status) 
						    		{
						    			foreach ($categories as $cat_value) 
					    				{
					    					if ($cat_value['category_id'] == $parent_category_id) 
					    					{
					    						$par_cat_name = $cat_value['category_name'];
					    						break;
					    					}
					    				}
						    		}

						    		echo $par_cat_name;
						    		?>
						    	</div>
						    </div>

						    <div class="row form-group">
						    	<div class="col-sm-2">
	                            	<label>Category Images:</label>
	                            </div>
	                            <div class="col-sm-10">
		                    		<?php 
			                        if (!empty($images)) 
			                        {
			                        	foreach ($images as $img_value) 
			                        	{
			                        		$img_src = $category_images_dir.'/'.$img_value['atch_url'];
			                        		
			                        		echo '<div class="thumbnail" style="padding:10px;">
			                        				<figure>
														<img src="'.$img_src.'" class="img-rounded">
												    </figure>
												</div>';
			                        	}
			                        }
			                        else
			                        	echo "Not available";
			                        ?>
			                    </div>
	                        </div>
	                        
                        	<div class="row form-group">
						    	<div class="col-sm-2">
									<label>HTML File(s):</label>
								</div>
								<div class="col-sm-10">
									<span class="bigcheck">
										<?php
										for ( $i = 1, $j = 0; $i <= 5; $i++, $j++ )
			                        	{
			                        		$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';
											
											if ($link) 
												echo $this->config->item('site_url').HTML_FILES_PATH.$link."<br />";
			                        	}
	                                	?>	                                    
	                                </span>
								</div>
							</div>

							<div class="row form-group">
						    	<div class="col-sm-2">
									<label>Attributes:</label>
								</div>
								<div class="col-sm-10">
									<span class="bigcheck">
										<?php
										if ($attributes) 
			    						{
			    							$count = 1;
			    							$att_name = '';

			    							foreach ($attributes as $att_value)
			    							{
			    								$mp_id = isset($att_value['mp_id']) ? $att_value['mp_id'] : '';

			    								if ($mp_id != '') 
												{
													echo $att_name = $att_value['att_name'];

													if (sizeof($attributes)>$count)
														echo ", ";
												}
												
												$count++;
			    							}
			    						}

			    						if (empty($att_name)) 
			    							echo "Not available";
	                                	?>
	                                </span>
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
				    <?php } else {
						if ($cat_id) {
							$formAttributes = ['onsubmit' => 'return confirmSave(\'' . UPDATE_MSG . '\');'];
						} else {
							$formAttributes = ['onsubmit' => 'return confirmSave(\'' . SAVE_MSG . '\');'];
						}
				    	echo form_open_multipart('addCategory', $formAttributes); 
				    ?>
				        	<div class="box-body">
					    		<div class="row">
									<div class="col-sm-6">
		                            	<label>Parent Category</label>
			                   		 	<?php
							    		echo '<select class="form-control" name="parent_cat_id">';
							    		
										if ($status) {
							    		
											echo "<option value='0'>Select parent category</option>";

							    			foreach ($categories as $cat_value) {

							    				$selected = $cat_value['category_id'] == $parent_category_id ? 'selected' : '';

							    				echo "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
							    			}
							    		} else {
											echo "<option value='0'>No parent category available!</option>";
										}
							    		echo "</select>";
							    		?>
							    	</div>

					    			<div class="col-sm-6">
					    				<label>Category Name *</label>
					    				<input type="hidden" name="cat_id" value="<?= $cat_id ?>">
					    				<?= form_input($cat_name_data) ?>
					    				<?= form_error('cat_name') ?>
					    			</div>
					            </div>

								<div class="row">
									<div class="col-sm-12">
										<div class="table-responsive editTable">
											<table class="table table-bordered dataTable">
												<thead>
													<tr>
													<th>
														<div style="display:flex; justify-content:space-between; align-items:center;">
															<span>
																Attributes
																<i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#attributes_tableBody" style="cursor:pointer;"></i>
															</span>
															<span class="attributes-header-right"></span>
														</div>
													</th>
													</tr>
												</thead>
												<tbody id="attributes_tableBody" class="collapse in">
													<tr>
														<td class="tags-cell">
															<?php if ($attributes) {
																foreach ($attributes as $att_value) {
																	$mp_id = isset($att_value['mp_id']) ? $att_value['mp_id'] : '';
																	$checked = ($mp_id != '') ? 'checked' : '';
																	$attName = htmlspecialchars($att_value['att_name'], ENT_QUOTES);

																	echo '<label class="bigcheck tag-label" title="'.$attName.'">
																	<input type="checkbox" class="bigcheck" name="selected_att_ids[]" value="'.$att_value['att_id'].'" '.$checked.' />
																	<span class="bigcheck-target"></span>
																	<span class="tag-text">'.$attName.'</span>
																	</label>';
																}
															} ?>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<?php if ($cat_id): ?>
									<!-- Toggle button/link -->
									<a data-toggle="collapse" href="#additionalDetails" aria-expanded="false" aria-controls="additionalDetails">+ Show Advanced Options</a>
					
									<!-- Collapsible content -->
									<div class="collapse" id="additionalDetails">
										<div class="well">
											<div class="row">
												<div class="col-sm-12">
													<div class="table-responsive editTable">
														<table class="table table-bordered dataTable">
															<thead>
																<tr>
																	<th class="text-align-center" colspan="6">
																		Category Images
																		<i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#categoryImages_tableBody" style="cursor:pointer;"></i>
																	</th>
																</tr>
															</thead>
															<tbody style="height: auto;" id="categoryImages_tableBody" class="collapse in">
																<tr>
																	<?php echo renderImages($images, $category_images_dir, $cat_id, 'editCategory', 6); ?>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											
											<div class="row nextFormLine">
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
														<table class="table table-bordered table-striped">
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
																		<a href='".base_url("deleteLink/$link_id/$cat_id/CATEGORY")."' onclick='return confirm(\"Are you sure?\")'><i class='fa fa-trash-o'></i></a>";
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
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>

								<div class="box-footer" align="right">
						            <a href='<?= base_url("category") ?>' class='btn btn-default'>Cancel</a>
						            <button type="submit" class="btn btn-primary">Submit</button>
						        </div>
					        </div><!-- /.box-body -->
					    <?php 
					    	echo form_close(); 
					    }
					    ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
		</section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<script>
$(document).ready(function() {
    $('.dataTable').each(function() {
        var $table = $(this);
        var headerCols = $table.find('thead tr:last th').length;
        var valid = true;

        $table.find('tbody tr').each(function() {
            var cells = $(this).children('td, th').length;
            if (cells > 0 && cells !== headerCols) {
                valid = false;
                return false; // break loop
            }
        });

        if (valid) {
            var table = $table.DataTable({
                paging: false,
                info: false,
                ordering: false,
                searching: true
            });

            // Safe filter box move
            var $filter = $(table.table().container()).find('.dataTables_filter');
            if ($filter.length > 0) {
                $filter.appendTo($table.find('.attributes-header-right'));
                var $filterInput = $filter.find('input');
                if ($filterInput.length > 0) {
                    $filterInput.off('keyup').on('keyup', function() {
                        var searchTerm = this.value.toLowerCase();
                        $table.find(".tags-cell label").each(function() {
                            var text = $(this).text().toLowerCase();
                            $(this).toggle(text.indexOf(searchTerm) > -1);
                        });
                    });
                }
            }
        } else {
            console.warn("Skipped DataTable init: column mismatch in table", $table.attr('class'));
        }
    });
});
</script>