<?php
//default values
$finance_available = isset($result[0]['finance_available']) ? $result[0]['finance_available'] : '';
$finance_terms = isset($result[0]['finance_terms']) ? $result[0]['finance_terms'] : set_value('finance_terms');
$home_delivery_available = isset($result[0]['home_delivery_available']) ? $result[0]['home_delivery_available'] : '';
$home_delivery_terms = isset($result[0]['home_delivery_terms']) ? $result[0]['home_delivery_terms'] : set_value('delievery_terms');
$installation_available = isset($result[0]['installation_available']) ? $result[0]['installation_available'] : '';
$installation_terms = isset($result[0]['installation_terms']) ? $result[0]['installation_terms'] : set_value('installation_terms');
$replacement_available = isset($result[0]['replacement_available']) ? $result[0]['replacement_available'] : '';
$replacement_terms = isset($result[0]['replacement_terms']) ? $result[0]['replacement_terms'] : set_value('replacement_terms');
$return_available = isset($result[0]['return_available']) ? $result[0]['return_available'] : '';
$return_policy = isset($result[0]['return_policy']) ? $result[0]['return_policy'] : set_value('return_policy');
$seller_offering = isset($result[0]['seller_offering']) ? $result[0]['seller_offering'] : set_value('seller_offering');
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller
            <small>Service & Policy</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Service & Policy</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
				    <!-- form start -->
					<?php
					$formAttributes = ['onsubmit' => 'return confirmSave(\'' . UPDATE_MSG . '\');'];
					echo form_open('updateSellerServicePolicy', $formAttributes);
					?>
				    	<div class="box-body">
				    		<div class="row">
                        		<div class="col-sm-1 termsMainLabel">
									<label>Finance Available:</label>
								</div>
								<div class="col-sm-1 termsAvailabilitySelectBox">
                        			<select class="form-control" name="finance_available" id="">
                        				<?php 
                        				if ($finance_available == 0)
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
                                    <textarea class="form-control" rows="3" name="finance_terms" placeholder="Enter Finance Terms" id=""><?= $finance_terms ?></textarea>
                                </div>
                            </div>

	                        <div class="row nextFormLine">
								<div class="col-sm-1 termsMainLabel">
									<label>Home Delievery:</label>
								</div>
								<div class="col-sm-1 termsAvailabilitySelectBox">
                        			<select class="form-control" name="home_delievery" id="">
                        				<?php 
                        				if ($home_delivery_available == 0)
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
                        			<textarea class="form-control" rows="3" name="delievery_terms" placeholder="Enter Delivery Terms" id=""><?= $home_delivery_terms ?></textarea>
                        		</div>
                        	</div>

                        	<div class="row nextFormLine">
								<div class="col-sm-1 termsMainLabel">
									<label>Installation Available:</label>
								</div>
								<div class="col-sm-1 termsAvailabilitySelectBox">
                        			<select class="form-control" name="installation_available" id="">
                        				<?php 
                        				if ($installation_available == 0)
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
                        			<textarea class="form-control" rows="3" name="installation_terms" placeholder="Enter Installation Terms" id=""><?= $installation_terms ?></textarea>
                        		</div>
                        	</div>

                        	<div class="row nextFormLine">
								<div class="col-sm-1 termsMainLabel">
									<label>Replacement Available:</label>
								</div>
								<div class="col-sm-1 termsAvailabilitySelectBox">
                        			<select class="form-control" name="replacement_available" id="">
                        				<?php 
                        				if ($replacement_available == 0)
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
                        			<textarea class="form-control" rows="3" name="replacement_terms" placeholder="Enter Replacement Terms" id=""><?= $replacement_terms ?></textarea>
                        		</div>
                        	</div>

                        	<div class="row nextFormLine">
								<div class="col-sm-1 termsMainLabel">
									<label>Return Available:</label>
								</div>
								<div class="col-sm-1 termsAvailabilitySelectBox">
                        			<select class="form-control" name="return_available" id="">
                        				<?php 
                        				if ($return_available == 0)
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
                        			<textarea class="form-control" rows="3" name="return_policy" placeholder="Enter Return Terms" id=""><?= $return_policy ?></textarea>
                        		</div>
                        	</div>

                            <!-- <div class="row">
                                <div class="col-sm-3">
                                    <label>Seller Offerings:</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="3" name="seller_offering" placeholder="Please enter offering..." id=""><?= $seller_offering ?></textarea>
                                </div>
                            </div> -->

                            <div class="box-footer text-right">
								<a href='<?= base_url("dashboard") ?>' class='btn btn-default'>Cancel</a>
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    </div>
				    <?= form_close() ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->