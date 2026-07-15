<?php
$clmd_id = isset($data['clmd_id']) ? $data['clmd_id'] : '';
$merchant_id = isset($data['merchant_id']) ? $data['merchant_id'] : '';
$user_id = isset($data['userId']) ? $data['userId'] : '';
$clmd_email = isset($data['clmd_email']) ? $data['clmd_email'] : '';
$clmd_name = isset($data['clmd_name']) ? $data['clmd_name'] : '';
$clmd_contact = isset($data['clmd_contact']) ? $data['clmd_contact'] : '';
$clmd_message = isset($data['clmd_message']) ? $data['clmd_message'] : '';
$notes = isset($data['notes']) ? $data['notes'] : '';
$clmd_business_proof = isset($data['clmd_business_proof']) ? $data['clmd_business_proof'] : '';
$establishment_name = isset($data['establishment_name']) ? $data['establishment_name'] : '';
$create_date = isset($data['create_date']) ? $data['create_date'] : '';
$update_date = isset($data['update_date']) ? $data['update_date'] : '';
$status = isset($data['status']) ? $data['status'] : '';
$attachmentPath = $this->config->item('site_url').TEMP_FOLDER_PATH;
$clmd_id = isset($data['clmd_id']) ? $data['clmd_id'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Claimed Requests
            <small>View Requests</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('page/claimedRequest') ?>"><i class="fa fa-dashboard"></i> Claimed Requests</a></li>
            <li class="active">View Request</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
		
			<?php if ($this->session->flashdata('errors')): ?>
				<div class="col-md-12 pageErrorDiv">
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5><i class="fa fa-exclamation-triangle"></i> <strong>Unable to approve this claim request. Please review the errors below.</strong></h5>
						<ul style="padding-left: 20px;">
							<?php foreach ($this->session->flashdata('errors') as $error) {
								echo "<li>".$error."</li>";
							}
							$this->session->unset_userdata('errors');
							?>
						</ul>
					</div>
				</div>
			<?php endif; ?>

            <!-- left column -->
            <div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
				    <div class="box-body">
			        	<div class="row">
                    		<div class="col-sm-3">
                    			<label for="">User Name</label>
								<input type="text" class="form-control" value="<?= $clmd_name ?>" id="" readonly />
                    		</div>
							<div class="col-sm-3">
			            		<label for="">Email</label>
								<input type="text" class="form-control" value="<?= $clmd_email ?>" id="" readonly />
			            	</div>
			            	<div class="col-sm-3">
			            		<label for="">Contact Number</label>
								<input type="text" class="form-control" value="<?= $clmd_contact ?>" id="" readonly />
			            	</div>
							<div class="col-sm-3">
			            		<label for="">Establishment (Shop) Name</label>
								<input type="text" class="form-control" value="<?= $establishment_name ?>" id="" readonly />
			            	</div>
                    	</div>

			            <div class="row nextFormLine">
							<div class="col-sm-3">
								<div class="table-responsive editTable">
									<table class="table table-bordered dataTable">
										<thead>
											<tr>
												<th class="text-align-center">
													Business Proof
												</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<?php echo renderSingleImage($clmd_business_proof, $attachmentPath, '', '', 'Business Proof', ''); ?>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-sm-4">
			            		<label for="">Message</label>
								<textarea class="form-control" rows="8" id="" readonly><?= $clmd_message ?></textarea>
			            	</div>
			            	<div class="col-sm-5">
			            		<label for="">Notes</label>
								<textarea class="form-control" rows="6" id="" name="notes"><?= $notes ?></textarea>

								<?php 
								$formAttributes = ['onsubmit' => 'return confirmSave(\'' . SAVE_MSG . '\');'];
								echo form_open('actionOnclaimRequest', $formAttributes);
								?>
									<input type="hidden" name="claimed_id" value="<?= $clmd_id ?>" />
									<input type="hidden" name="claimed_id" value="<?= $clmd_id ?>" />
									<input type="hidden" name="user_id" value="<?= $user_id ?>" />
									<input type="hidden" name="contact" value="<?= $clmd_contact ?>" />
									<input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />
									<input type="hidden" name="name" value="<?= $clmd_name ?>" />
									<input type="hidden" name="email" value="<?= $clmd_email ?>" />
									<input type="hidden" name="establishment_name" value="<?= $establishment_name ?>" />
									<input type="hidden" name="clmd_business_proof" value="<?= $clmd_business_proof ?>" />
									
									<div class="box-footer">
										<a href='<?= base_url("page/claimedRequest") ?>' class='btn btn-default'>Cancel</a>
										
										<?php if ($status != "REJECTED"): ?>
											<button type="submit" name="reject" class="btn btn-danger">Reject</button>
										<?php endif; ?>

										<?php if ($status != "APPROVED"): ?>
											<button type="submit" name="submit" class="btn btn-primary">Approve</button>
										<?php endif; ?>
									</div>
								<?php echo form_close(); ?>
			            	</div>
			            </div>
			        </div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

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

input[type="file"] {
  display: block;
}
</style>
