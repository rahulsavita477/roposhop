<?php 
$product_id = isset($req_prds['req_prd_id']) ? $req_prds['req_prd_id'] : '';
$request_id = isset($req_prds['request_id']) ? $req_prds['request_id'] : '';
$merchant_id = isset($req_prds['merchant_id']) ? $req_prds['merchant_id'] : '';
$listing_id = isset($req_prds['req_lst_id']) ? $req_prds['req_lst_id'] : '';
$product_name = isset($req_prds['product_name']) ? $req_prds['product_name'] : '';
$description = isset($req_prds['description']) ? $req_prds['description'] : '';
$mrp_price = isset($req_prds['prd_price']) ? $req_prds['prd_price'] : '';
$product_images_dir = isset($product_images_dir) ? $product_images_dir : PRODUCT_ATTATCHMENTS_PATH.$product_id.'/';
$images = isset($req_prds['images']) ? $req_prds['images'] : '';
$category_name = isset($category_name) ? $category_name : '';
$brand_name = isset($req_prds['brand_name']) ? $req_prds['brand_name'] : '';
$brand_id = isset($req_prds['brand_id']) ? $req_prds['brand_id'] : '';
$page_label = isset($page_label) ? $page_label : 'Add Product';
$cat_id = isset($req_prds['category_id']) ? $req_prds['category_id'] : '';
$in_the_box = isset($req_prds['in_the_box']) ? $req_prds['in_the_box'] : '';
$meta_description = isset($req_prds['meta_description']) ? $req_prds['meta_description'] : '';
$meta_keyword = isset($req_prds['meta_keyword']) ? $req_prds['meta_keyword'] : '';
$notes = isset($req_prds['notes']) ? $req_prds['notes'] : '';
$amazon_prd_id = isset($req_prds['amazon_prd_id']) ? $req_prds['amazon_prd_id'] : '';
$flipkart_prd_id = isset($req_prds['flipkart_prd_id']) ? $req_prds['flipkart_prd_id'] : '';
$sell_price = isset($req_prds['sell_price']) ? $req_prds['sell_price'] : set_value('sell_price'); 
$finance_terms = isset($req_prds['finance_terms']) ? $req_prds['finance_terms'] : set_value('finance_terms'); 
$installation_terms = isset($req_prds['installation_terms']) ? $req_prds['installation_terms'] : set_value('installation_terms'); 
$will_back_in_stock_on = isset($req_prds['will_back_in_stock_on']) ? $req_prds['will_back_in_stock_on'] : set_value('back_in_stock'); 
$replacement_terms = isset($req_prds['replacement_terms']) ? $req_prds['replacement_terms'] : set_value('replacement_terms'); 
$return_policy = isset($req_prds['return_policy']) ? $req_prds['return_policy'] : set_value('return_policy'); 
$seller_offering = isset($req_prds['seller_offering']) ? $req_prds['seller_offering'] : set_value('seller_offering'); 
$home_delivery_terms = isset($req_prds['home_delivery_terms']) ? $req_prds['home_delivery_terms'] : set_value('delievery_terms'); 
$page_label = "add";
$page_title = 'Add requested product';
?>

<style type="text/css">
.vrnt_values{
	margin-bottom: 10px;
}
</style>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Requested Product
            <small><?= $page_label ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('page/requestedProducts') ?>">Requested product Management</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<!-- Attribute Modal -->
						<div class="modal fade" id="attributeModal">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Add varients</h4>
									</div>

									<div class="modal-body">
									<!-- select box for all attributes -->
									<?php
									echo 
									form_open('addProductVarient').
                                	 	"<input type='hidden' value='".$product_id."' name='prd_id'>
                                		<input type='hidden' value='".$cat_id."' name='cat_id'>
                                		<input type='hidden' value='".$page_label."' name='page_label'>
                                		<input type='hidden' value='".$request_id."' name='request_id'>
                                    	<select class='form-control' id='att_id' name='att_id'>";

											if (isset($attributes)) 
											{
			                                    echo "<option value='0'>Select an attribute to make varients!!</option>";

												foreach ($attributes as $att_value)
			                                        echo "<option value='".$att_value['att_id']."'>".$att_value['att_name']."</option>";
		                                    }
		                                    else
		                                        echo "<option value='0'>No attribute available!</option>";
		                                    
		                                echo "</select>";

		                            	echo '<div class="form-group" id="input_field_div"></div>';
		                                ?>
			                        </div>

			                        <div class="modal-footer">
			                        	<button type="button" class="btn btn-primary" id="createVarientFieldBtn" disabled><i class="fa fa-plus"></i> Create verient field</button>
			                        	<button class="btn btn-default" data-dismiss="modal">Close</button>
			                        	<button type="submit" class="btn btn-primary" id="varientSubmitBtn" disabled>Submit</button>
			                        </div>
			                        <?= form_close() ?>			
			                    </div>
			               	</div>
			            </div>

				    	<!-- Key Feature Modal -->
                        <div class="modal fade" id="keyFeatureModal">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Feature</h4>
                                    </div>

                                    <?= form_open('addKeyFeature') ?>
                                        <div class="modal-body">
                                            <input type='hidden' name='feature_id' id='feature_id'>
                                            <input type='hidden' name='product_id' id='product_id'>

                                            <div class='row form-group'>
                                                <div class='col-sm-3'>
                                                    <label>Key Feature:</label>    
                                                </div>
                                                <div class='col-sm-9'>
                                                    <input type='text' name='feature' id='feature' class='form-control' required>
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

                        <div class="box-header">
                        	<h3 class="box-title">Product Detail</h3>
                      	</div><!-- /.box-header -->

					    <!-- form start -->
					    <?= form_open_multipart('insertProduct') ?>
					    	<input type="hidden" name="prd_id" value="<?= $product_id ?>" />
					    	<input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />
					    	<input type="hidden" name="request_id" value="<?= $request_id ?>" />
					    	<input type="hidden" name="listing_id" value="<?= $listing_id ?>" />

					    	<div class="box-body">
					    		<!-- select category -->
		                        <div class="row form-group">
	                        		<div class="col-sm-3">
	                        			<label>Category*:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<?php
	                        			if ($page_label == 'add') 
	                        				$page_label = "'add'";
	                        			else
	                        				$page_label = "'edit'";

										echo '<select class="form-control" name="parent_cat_id" onchange="getCategoryAttribtes(this.value, '.$product_id.', '.$page_label.');" required>';

								    		if ($status) 
								    		{
								    			echo "<option value=''>Please select an category!!</option>";

								    			foreach ($req_prds['categories'] as $cat_key => $cat_value) 
								    			{
								 					$selected = $cat_value['category_id'] == $cat_id ? 'selected' : '';

								    				echo "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
								    			}
								    		}
								    		else
								    			echo "<option>No parent category available!</option>";
							    		
							    		echo "</select>";
							    		?>			
	                        		</div>
		                        </div>

		                        <!-- select brand -->
		                        <div class="row form-group">
	                        		<div class="col-sm-3">
	                        			<label>Brand*:</label>
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<?php
							    		echo '<select class="form-control" name="brand_id" required>';
								    		if ($status) 
								    		{
								    			echo "<option value=''>Please select a brand!!</option>";

								    			foreach ($req_prds['brands'] as $brands_value)
								    			{
								    				$selected = $brands_value['brand_id'] == $brand_id ? 'selected' : '';

								    				echo "<option value='".$brands_value['brand_id']."' ".$selected.">".$brands_value['name']."</option>";
								    			}
								    		}
								    		else
								    			echo "<option>No brand available!</option>";
							    		
							    		echo "</select>";

							    		if($brand_name)
							    			echo "(".$brand_name.")";
							    		?>
							    	</div>
							    </div>

						    	<div class="row form-group">
	                        		<div class="col-sm-3">
	                        			<label>Product Name*:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<input type="text" class="form-control" placeholder="Enter product name..." name="prd_name" value="<?= $product_name ?>" required/>
	                        		</div>
	                        	</div>

	                        	<div class="row form-group">
	                        		<div class="col-sm-3">
	                        			<label>Amazon Product ID:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<input type="text" class="form-control" placeholder="Enter amazon product id..." name="amazon_prd_id" value="<?= $amazon_prd_id ?>" />
	                        		</div>
	                        	</div>

	                        	<div class="row form-group">
	                        		<div class="col-sm-3">
	                        			<label>Flipkart Product ID:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<input type="text" class="form-control" placeholder="Enter flipkart product id..." name="flipkart_prd_id" value="<?= $flipkart_prd_id ?>" />
	                        		</div>
	                        	</div>

		                        <div class="row form-group">
	                        		<div class="col-sm-3">
	                        			<label>Product Price*:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<input type="text" class="form-control" placeholder="Enter product price..." name="prd_price" value="<?= $mrp_price; ?>" required/>
	                        		</div>
	                        	</div>
							    
		                        <div class="row form-group" style="clear: both;">
	                        		<div class="col-sm-3">
	                        			<label>Product Description*:</label>	
	                        		</div>
	                        		<div class="col-sm-8">
	                        			<textarea class="form-control" rows="5" name="prd_desc" placeholder="Please enter product description..." required><?= $description ?></textarea>
	                        		</div>
	                        	</div>

	                        	<div class="row form-group" style="clear: both;">
	                        		<div class="col-sm-3">
	                        			<label>In The Box:</label>	
	                        		</div>
	                        		<div class="col-sm-8">
	                        			<textarea class="form-control" rows="5" name="in_the_box" placeholder="What you have provided in the product box..."><?= $in_the_box ?></textarea>
	                        		</div>
	                        	</div>
								
								<div class="row form-group">
							    	<div class="col-sm-3">
										<label>Tags:</label>
									</div>
									<div class="col-sm-8">
										<span class="bigcheck">
											<?php
		                                	if (count($req_prds['tags'])>0) 
				    						{
				    							function array_value_exist($product_tags, $value)
												{
													if (count($product_tags)>0) 
				    								{
													    foreach ($product_tags as $prd_tag_value) 
													    {
					    									if ( $prd_tag_value['tag_id'] == $value ) 
					    									{
					    										return "checked";
					    										break;
					    									}
					    								}
					    							}

				    								return "";
												}

				    							foreach ($req_prds['tags'] as $tag_value)
				    							{
				    								$checked = array_value_exist($req_prds['product_tags'], $tag_value['tag_id']);

				    								echo '<div> <label class="bigcheck">
													    	<input type="checkbox" class="bigcheck" name="selected_tag_ids[]" value="'.$tag_value['tag_id'].'"'.$checked.' />
													    	<span class="bigcheck-target"></span>&nbsp;&nbsp;
													    	'.$tag_value['tag_name'].'
													  	</label></div>';
				    							}
				    						}
		                                	?>	   
		                                </span>
									</div>
								</div>

								<div class="box-body table-responsive">
				                    <table class="table table-bordered table-striped">
				                        <thead>
				                            <tr>
				                                <th colspan="3"><center>Product Images</center></th>
				                            </tr>
				                        </thead>
				                        <tbody>
					                        <?php for ($i = 1, $j = 0; $i < 7; $i++, $j++) { ?>
					                        	<tr>
					                        		<td>
					                        			<div class="btn btn-success btn-file">
						                                    <i class="fa fa-paperclip"></i> Image<?= $i ?>
						                                    <input type="file" name="file<?= $i ?>" id="file<?= $i ?>" />
						                                </div>
						                            </td>
					                        		<?php 
					                        		echo "<td>";
					                        			if (isset($images[$j]))
						                        		{
						                        			$img_src = $product_images_dir.'/'.$images[$j]['atch_url'];
							                        		
							                        		echo '<div class="thumbnail">
							                        				<figure>
																		<img src="'.$img_src.'">
																		<center>
																    		<figcaption><a href="'.base_url('deleteAttactchment/'.$images[$j]['atch_url'].'/addProduct/'.$request_id.'-'.$product_id).'" class="btn btn-danger">DELETE</a></figcaption>
																    	</center>
																    </figure>
																</div>

																<input type="hidden" name="remove_img'.$i.'" value="'.$images[$j]['atch_url'].'" />';
							                        	}
							                        echo "</td>";
							                        ?>
					                        		<td><div class="file<?= $i ?>"></div></td>
					                        	</tr>
					                        <?php } ?>
				                    	</tbody>
				                    </table>
				                </div>
					            
					            <div class="box-body table-responsive" id="att_fields" style="display: none;"></div>

				            	<div style="margin-bottom: 20px;">
	                        		<div class="box-body table-responsive">
					                    <table class="table table-bordered table-striped data-pagination-table">
					                        <thead>
					                        	<tr>
		                                            <th colspan="3">Product varients
		                                            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#attributeModal" id="addVarientBtn"><i class="fa fa-plus"></i> Add Varient</button></th>
		                                        </tr>
					                            <tr>
					                                <th>Varient name </th>
					                                <th>Varient value</th>
					                                <th>Delete</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php	
					                        	if (isset($req_prds['product_varients']) && $req_prds['product_varients']) {
						                        	echo '<input type="hidden" value="'.$product_id.'" name="prd_id">';

						                        	$i = 1;
					                        		foreach ($req_prds['product_varients'] as $prd_vrnt_key => $prd_vrnt_values) 
					                        		{
					                        			$rowspan = count($prd_vrnt_values)+1;
					                        			echo "<tr>
					                        					<td rowspan=".$rowspan.">".$prd_vrnt_key."</td></tr>";

					                        			foreach ($prd_vrnt_values as $vrnt_value) 
					                        			{
					                        				$vrnt_id = $vrnt_value['vrnt_id'];
							                            	$vrnt_del_link = base_url('deleteProductVarientValue/'.$vrnt_id.'/'.$product_id.'?req_prd_id='.$request_id);

					                        				echo "<tr>
					                        						<td>".
							                            				"<input type='hidden' value='".$vrnt_id."' name='vrnt_ids[]'>
						                                            	<input type='text' class='vrnt_values' placeholder='Enter attibute value...' name='vrnt_values[]' value='".$vrnt_value['att_value']."' />"
								                            		."</td>
								                            		<td>
						                                                <a href='".$vrnt_del_link."' class='btn btn-danger'>Delete</a>
						                                            </td>
							                            		</tr>";
					                        			}
					                                }
					                            }
					                            else
					                            	echo "<tr><td colspan=3><center>Not available</center></td>";
					                        	?>
					                        </tbody>
					                    </table>
					                </div><!-- /.box-body -->
					            </div>
								
								<div class="box-body table-responsive">
	                                <table class="table table-bordered table-striped">
	                                    <thead>
	                                        <tr>
	                                            <th colspan="2">
	                                                Product Key Features
	                                                <button type="button" class="btn btn-warning pull-right" id="createKeyFeatureFieldBtn"><i class="fa fa-plus"></i> Add product Key Feature</button>
	                                            </th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    	<tr>
	                                    		<td>
	                                    			<div class="row form-group">
						                                <div class="col-sm-8" id="key_feature_input_field_div"></div>
						                            </div>
	                                    		</td>
	                                    	</tr>
	                                        <?php
	                                        if ($key_features) 
	                                        {
	                                            foreach ($key_features['result'] as $feature_value) 
	                                            {
	                                                $feature_id = $feature_value['feature_id'];
	                                                $feature = $feature_value['feature'];
	                                                $params = $feature_id.', "'.$feature.'", '.$product_id;

	                                                echo "<tr>
	                                                        <td>".$feature."</td>
	                                                        <td>
	                                                            <button type='button' class='btn btn-warning' onclick='open_key_feature_modal($params)'>Edit</button>
	                                                            <a href='".base_url('deleteFeature/'.$feature_id.'/'.$product_id.'?request_id='.$request_id)."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
	                                                        </td>
	                                                    </tr>";
	                                            }
	                                        }
	                                        else
	                                            echo "<tr><td colspan='3' align='center'>No Record found.</td></tr>";
	                                        ?>
	                                    </tbody>
	                                </table>
	                            </div><!-- /.box-body -->

	                            <div class="box-body table-responsive">
				                    <table class="table table-bordered table-striped data-pagination-table">
				                        <thead>
				                        	<tr>
				                        		<th colspan="4">
				                        			<center>HTML FILES FOR CATEGORY</center>
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

												if ($link) 
												{
													$buttons = "<a href='".base_url("deleteLink/$link_id/$product_id/PRODUCT")."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
			                                                <a href='".$this->config->item('site_url').HTML_FILES_PATH.$link."' class='btn btn-success' target='_blank'>Preview</a>";
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

				                <div class="row form-group">
							    	<div class="col-sm-2">
										<label>Meta Keywords:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter meta keyword(s)" name="meta_keyword"><?= $meta_keyword ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Meta Description:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter meta description" name="meta_description"><?= $meta_description ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Notes:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter notes" name="notes"><?= $notes ?></textarea>
									</div>
								</div>
						    </div>
					</div><!-- /.box -->
				</div>   <!-- /.row -->
			</div>

			<!-- left column -->
            <div class="col-md-6">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Listing Detail</h3>
					</div><!-- /.box-header -->

					<div class="box-body">
						<div class="row form-group">
							<div class="col-sm-3">
								<label>Seller Price*:</label>
							</div>
							<div class="col-sm-5">
								<input type="text" class="form-control" placeholder="Enter price..." name="sell_price" value="<?= $sell_price ?>" required/>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-12">
								<div class="alert alert-warning">Price should be in digit</div>
							</div>
						</div>

                        <div class="row form-group">
                        	<div class="col-sm-3">
                        		<label>Finance Available:</label>  
                        	</div>
                        	<div class="col-sm-5">
                        		<select class="form-control" name="finance_available" required>
									<?php 
									if ($req_prds['finance_available'] == 0)
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
									<option value="0" <?= $value0 ?>>No</option>
									<option value="1" <?= $value1 ?>>Yes</option>
								</select>       
							</div>
						</div>

						<div class="row form-group">
						    <div class="col-sm-3">
						    	<label>Finance Terms:</label>    
						    </div>
						    <div class="col-sm-8">
						    	<textarea class="form-control" rows="5" name="finance_terms" placeholder="Please enter finance terms..."><?= $finance_terms ?></textarea>
						    </div>
						</div>

						<div class="row form-group">
							<div class="col-sm-3">
								<label>Home Delievery:</label> 
							</div>
							<div class="col-sm-5">
								<select class="form-control" name="home_delievery" required>
									<?php 
									if ($req_prds['home_delivery_available'] == 0)
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
									<option value="0" <?= $value0 ?>>No</option>
									<option value="1" <?= $value1 ?>>Yes</option>
								</select>       
							</div>
						</div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                            	<label>Home Delievery Terms:</label>
                            </div>
                          	<div class="col-sm-8">
                                <textarea class="form-control" rows="5" name="delievery_terms" placeholder="Please enter delievery terms..."><?= $home_delivery_terms ?></textarea>
                          	</div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>Installation Available:</label> 
                          	</div>
                          	<div class="col-sm-5">
                                <select class="form-control" name="installation_available" required>
									<?php 
									if ($req_prds['installation_available'] == 0)
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
									<option value="0" <?= $value0 ?>>No</option>
									<option value="1" <?= $value1 ?>>Yes</option>
                                </select>       
                          	</div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>Installation Terms:</label>  
                          	</div>
                          	<div class="col-sm-8">
                          		<textarea class="form-control" rows="5" name="installation_terms" placeholder="Please enter installation terms..."><?= $installation_terms ?></textarea>
                          	</div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>In Stock*:</label>   
                          	</div>
                          	<div class="col-sm-5">
                                <select class="form-control" name="in_stock">
									<?php 
									if ($page_label != "Add") 
									{
									    if ($req_prds['in_stock'] == 0)
									    {
									          $value0 = 'selected="selected"';
									          $value1 = '';
									    }
									    else
									    {
									          $value0 = '';
									          $value1 = 'selected="selected"';
									    }
									}
									else
									{
									    $value0 = '';
									    $value1 = 'selected="selected"';
									}
									?>
									<option value="0" <?= $value0 ?>>No</option>
									<option value="1" <?= $value1 ?>>Yes</option>
                                </select>       
                            </div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>Available Back in stock on:</label>   
                          	</div>
                          	<div class="col-sm-5">
                          		<input type="date" class="form-control" name="back_in_stock" value="<?= $will_back_in_stock_on ?>" />
                          	</div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>Replacement Available:</label>  
                          	</div>
                          	<div class="col-sm-5">
                                <select class="form-control" name="replacement_available" required>
									<?php 
									if ($req_prds['replacement_available'] == 0)
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
									<option value="0" <?= $value0 ?>>No</option>
									<option value="1" <?= $value1 ?>>Yes</option>
                                </select>       
                          	</div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>Replacement Terms:</label>   
                          	</div>
                          	<div class="col-sm-8">
                          		<textarea class="form-control" rows="5" name="replacement_terms" placeholder="Please enter replacement terms..."><?= $replacement_terms ?></textarea>
                          	</div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>Return Available:</label>   
                          	</div>
                          	<div class="col-sm-5">
                                <select class="form-control" name="return_available" required>
									<?php 
									if ($req_prds['return_available'] == 0)
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
									<option value="0" <?= $value0 ?>>No</option>
									<option value="1" <?= $value1 ?>>Yes</option>
                                </select>       
                          	</div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>Return Terms:</label>
                          	</div>
                          	<div class="col-sm-8">
                          		<textarea class="form-control" rows="5" name="return_policy" placeholder="Please enter return terms..."><?= $return_policy ?></textarea>
                          	</div>
                        </div>

                        <div class="row form-group">
                          	<div class="col-sm-3">
                                <label>Seller Offerings:</label>    
                          	</div>
                          	<div class="col-sm-8">
                                <textarea class="form-control" rows="5" name="seller_offering" placeholder="Please enter offering..."><?= $seller_offering ?></textarea>
                          	</div>
                        </div>

                        <div class="box-footer" align="right">
							<?php 
							echo "<a href='".base_url("page/requestedProducts")."' class='btn btn-default'>Cancel</a>";
							?>

				            <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
				        </div>
                    <?= form_close() ?>
                  	</div>
		      	</div><!-- /.box -->
	      	</div>   <!-- /.row -->
	    </div>
	</section><!-- /.content -->
</aside><!-- /.right-side -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
function getCategoryAttribtes(cat_id, prd_id=0, page_label)
{
	$('#open_att_modal').prop('disabled', true);
	$('#submit_btn').prop('disabled', false);
	$('#att_fields').empty();
	$('#divLoading').show();

	if (cat_id) 
	{
		$.ajax({
	        type: "GET",
	        url: '<?= base_url("categoryAttributes") ?>/'+cat_id+'/'+prd_id,
	        success: function(data){
	            if (data) 
	            {
	            	resp = JSON.parse(data);
	            	fields = '';
	            	
	            	if (resp.length > 0) 
	    			{
	    				fields += '<table class="table table-bordered table-striped dataTable"><tr><th colspan=2><center>Product attributes</center></th></tr>';

	    				for (var i = 0; i < resp.length; i++) 
		            	{
		            		if (resp[i].mp_id != null) 
		            		{
		            			$('#open_att_modal').prop('disabled', false);
	            			
		            			att_id = resp[i].att_id;
		            			att_name_label = resp[i].att_name;
		            			att_val = '';
		            			if (page_label != "add") 
		            			{
		            				att_val = resp[i].att_value;
		            				if (att_val == null)
		            					att_val = '';
		            			}

		            			fields += '<tr><td>'+att_name_label+'</td>';

		                		if (page_label == "view") 
		                			fields += '<td>'+att_val+'</td>';
		                		else
		                			fields += '<td>'+
			                    					'<input type="text" name="'+att_id+'" class="form-control att_values" placeholder="Enter '+att_name_label+'..." value="'+att_val+'" />'+
			                    				'</td><tr>';
		            		}
						}

						fields += '</table>'
	    			}

	            	$('#att_fields').append(fields);
	            	$('#att_fields').show();
	            }

	            $('#divLoading').hide();
	        },
	    });	
	}
	else
	{
		alert('Could not found category id!');
		$('#divLoading').hide();
	}
}	

$(document).ready(function() {
	prd_id = <?= (!empty($product_id) ? json_encode($product_id) : '""'); ?>;
	page_label = <?= (!empty($page_label) ? json_encode($page_label) : '""'); ?>;
	
	if (prd_id) 
	{
		if (page_label == "view") 
			cat_id = parseInt($("#par_cat_id").val());
		else
			cat_id = $("[name='parent_cat_id'] option:selected").val();

		if (cat_id && cat_id != 0) 
		{
			setTimeout(function(){ 
				getCategoryAttribtes(cat_id, prd_id, page_label);
			}, 2000);
		}
	}
});
</script>

<style type="text/css">
label{
	float: left;
	margin-right: 20px;
}

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
    margin-bottom: 0px;
}
</style>

<?php require_once('include/imageModel.php'); ?>

<script>
function open_key_feature_modal(feature_id, feature, product_id) 
{
    $('#feature_id').val(feature_id);
    $('#feature').val(feature);
    $('#product_id').val(product_id);
    $("#keyFeatureModal").modal();
}

$(document).ready(function() {
    $('.prd_ids').on('change', function(){
        $('#addVarientBtn').prop('disabled', true);

        $.each($(".prd_ids"), function(){            
            if (this.checked)
                $('#addVarientBtn').prop('disabled', false);
        });  
    })

    var count = 1;
    $('#createVarientFieldBtn').click(function () {
        $('#input_field_div').append('<div class="row" style="margin-top:10px;" id="con'+count+'">'+
                                        '<div class="col-sm-9">'+
                                            '<input type="text" class="form-control" name="vrnt_vals[]" placeholder="Varient value" required/>' + 
                                        '</div>'+
                                        '<div class="col-sm-3">'+
                                            '<button type="button" class="btn btn-danger" id="btnRemove'+count+'" onclick="removeBtn('+count+')">Remove</button>'+
                                        '</div>'+
                                    '</div>'
                                    );
        
        count++;
    });

    $("select#att_id").change(function(){
        var att_id = $("#att_id option:selected").val();
        
        if ( att_id > 0 )
        {
            $('#createVarientFieldBtn').prop('disabled', false);
            $('#varientSubmitBtn').prop('disabled', false);
        }
        else
        {
            $('#createVarientFieldBtn').prop('disabled', true);
            $('#varientSubmitBtn').prop('disabled', true); 
			$('#input_field_div').remove();
        }
    });

    var count1 = 1;
    var count2 = 1;
    $('#createKeyFeatureFieldBtn').click(function () {
        $('#key_feature_input_field_div').append('<div class="row" style="margin-top:10px;" id="con1'+count1+'">'+
                                        '<div class="col-sm-9">'+
                                            '<input type="text" class="form-control" name="key_feature_values[]" placeholder="Feature'+count1+'" required/>' + 
                                        '</div>'+
                                        '<div class="col-sm-3">'+
                                            '<button type="button" class="btn btn-danger" id="btnRemove1'+count1+'" onclick="removeBtn(1'+count1+')">Remove</button>'+
                                        '</div>'+
                                    '</div>'
                                    );
        
        count1++;
    });
});

function removeBtn(id) 
{
	$('#con'+id).remove();
}
</script>
