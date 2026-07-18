<?php 
$review_id = isset($review_data['review_id']) ? $review_data['review_id'] : '';
$review_title = isset($review_data['review_title']) ? $review_data['review_title'] : '';
$rating = isset($review_data['rating']) ? $review_data['rating'] : '';
$review = isset($review_data['review']) ? $review_data['review'] : '';
$create_date = isset($review_data['review_date']) ? convert_to_user_date($review_data['review_date']) : '';
$update_date = isset($review_data['last_updated']) ? convert_to_user_date($review_data['last_updated']) : '';
$consumer_name = isset($review_data['consumer_name']) ? $review_data['consumer_name'] : '';
$shop_name = isset($review_data['shop_name']) ? $review_data['shop_name'] : $review_data['product_name'];
$merchant_or_product_label = ($page_label == 'merchant') ? 'Shop name' : 'Product name';
$page_title = ($page_type == 'view') ? $page_label.' review' : 'Edit '.$page_label.' review';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1><?= ucfirst($page_label) ?> Review<small><?= $page_type ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('review/'.$page_label) ?>"><?= ucfirst($page_label) ?> Review Management</a></li>
            <li class="active"><?= ucwords($page_type.' '.$page_label) ?> Review</li>
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
				    	<?php if ($page_type == "view") { ?>
					        <div class="box-footer" style="margin-right: 10px; text-align: right;"
					            <a href='<?= base_url("review/$page_label") ?>' title='Back'><i class="fa fa-undo" aria-hidden="true"></i></a>&nbsp;
					            <a href='<?= base_url("editReview/$review_id/$page_label") ?>' title='Edit'><i class='fa fa-edit'></i></a>&nbsp;
					            <a href='<?= base_url("deleteReview/$review_id/$page_label") ?>' onclick='return confirm("Are you sure?")'title='Delete'><i class='fa fa-trash-o'></i></a>
					        </div>
					    <?php } ?>
					</div><!-- /.box-header -->

					<?php if ($page_type == 'view') { ?>
						<div class="box-body">
							<div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Consumer Name:</label>
				            	</div>
				            	<div class="col-sm-10">
				            		<?= $consumer_name ?>
				            	</div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-2">
				            		<label><?= $merchant_or_product_label ?>:</label>	
				            	</div>
				            	<div class="col-sm-10">
				            		<?= $shop_name ?>
				            	</div>
				            </div>

							<div class="row form-group">
				            	<div class="col-sm-2">
				            		<label>Title:</label>	
				            	</div>
				            	<div class="col-sm-10">
				            		<?= $review_title ?>
				            	</div>
				            </div>

				            <div class="row form-group">
	                    		<div class="col-sm-2">
	                    			<label>Review:</label>	
	                    		</div>
	                    		<div class="col-sm-10">
	                    			<?= $review ?>
	                    		</div>
	                    	</div>

	                    	<div class="row form-group">
	                    		<div class="col-sm-2">
	                    			<label>Rating:</label>	
	                    		</div>
	                    		<div class="col-sm-10">
	                    			<?= $rating ?>
	                    		</div>
	                    	</div>

	                    	<div class="row form-group">
	                    		<div class="col-sm-2">
	                    			<label>Create Date:</label>	
	                    		</div>
	                    		<div class="col-sm-10">
	                    			<?= $create_date ?>
	                    		</div>
	                    	</div>

	                    	<div class="row form-group">
	                    		<div class="col-sm-2">
	                    			<label>Update Date:</label>	
	                    		</div>
	                    		<div class="col-sm-10">
	                    			<?= $update_date ?>
	                    		</div>
	                    	</div>
	                    </div>
					<?php } else { ?>
						<!-- form start -->
					    <?php
						$formAttributes = ['onsubmit' => 'return confirmSave(\'' . UPDATE_MSG . '\');'];
						echo form_open('addReview', $formAttributes);
						?>

							<input type="hidden" name="review_for" value="<?= $page_label ?>" />
						    <input type="hidden" name="review_id" value="<?= $review_id ?>" />

					        <div class="box-body">
								<!-- 1. CONTEXT INFO: Read-only Consumer and Merchant data -->
								<div class="row form-group" style="margin-bottom: 20px; background: #f9f9f9; padding: 12px; border-radius: 4px; margin-left: 0; margin-right: 0; border-left: 4px solid #3c8dbc;">
									<div class="col-sm-6">
										<strong><i class="fa fa-user"></i> Consumer:</strong> <?= isset($consumer_name) ? $consumer_name : 'Rahul Sharma' ?>
									</div>
									<div class="col-sm-6">
										<?php if($shop_name) {
											echo '<strong><i class="fa fa-store-o"></i> Shop:</strong> '.$shop_name;
										} else {
											echo '<strong><i class="fa fa-store-o"></i> Product:</strong> '.$review_data['product_name'];
										} ?>
									</div>
								</div>

								<!-- 2. FORM FIELDS: Title & Rating side by side correctly -->
								<div class="row form-group">
									<div class="col-sm-6">
										<label for="review_title">Title</label>
										<input type="text" name="review_title" class="form-control" placeholder="Enter Review Title" value="<?= $review_title ?>" id="review_title" />
									</div>
									
									<div class="col-sm-6">
										<label for="rating">Rating *</label>
										<select class="form-control" name="rating" id="rating">
											<?php for ( $i=1; $i <= 5; $i++ ) {
												if ( $i == $rating ) {
													$selected = "selected='selected'";
												} else {
													$selected = '';
												}
												// FontAwesome stars natively cannot be injected inside standard HTML <option> tags, 
												// but we can append text details for clarity.
												echo '<option value="'.$i.'" '.$selected.'>'.$i.' Star'.($i > 1 ? 's' : '').'</option>';
											} ?>
										</select>
									</div>
								</div>

								<!-- 3. REVIEW TEXT: Fixed padding and bottom margin spacing -->
								<div class="row form-group" style="margin-top: 15px; margin-bottom: 25px;">
									<div class="col-sm-12">
										<label for="review">Review *</label>
										<textarea name="review" class="form-control address" placeholder="Enter Review" required id="review" style="padding: 12px; line-height: 1.6; min-height: 120px; resize: vertical;"><?= $review ?></textarea>
									</div>
								</div>

								<!-- 4. FOOTER BUTTONS -->
								<div class="box-footer" align="right" style="background: transparent; padding-top: 15px; border-top: 1px solid #f4f4f4;">
									<?php echo "<a href='../../review/$page_label' class='btn btn-default' style='margin-right: 5px;'>Cancel</a>"; ?>
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div><!-- /.box-body -->
					    <?php echo form_close(); 
					} ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->