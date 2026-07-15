<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Claimed Requests
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Claimed Requests</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <!-- <th>S.NO.</th>
                                    <th>Claimed ID</th>
                                    <th>Merchant ID</th> -->
                                    <th>Action</th>
                                    <th>Verification Status</th>
                                    <th>Shop Name</th>
                                    <th>Claimed Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php if ($claimedRequests) {

                                    // <td>".$count++."</td>
                                    // <td>".$req_id."</td>
                                    // <td>".$claimedRequest['merchant_id']."</td>
                                    // $count = 1;

                            		foreach ($claimedRequests as $claimedRequest) {

                                        $req_id = $claimedRequest['clmd_id'];

                                        $approveClaimRequestBtn = "<li><a href='".base_url()."viewClaimRequest/".$req_id."' title='Approve Claimed Request'><i class='fa fa-check'></i>Verify Request</a></li>";
                                        $deleteClaimRequestBtn = "<li><a href='".base_url("deleteClaimedRequest").'/'.$req_id."' title='Delete Claimed Request' onclick='return confirm(\"Are you sure?\")'><i class='fa fa-trash-o'></i>Delete</a></li>";

                                        if ($claimedRequest['status'] == "APPROVED") {
                                            $is_approved = "<span class='label label-success'>APPROVED</span>";
                                        } elseif ($claimedRequest['status'] == "REJECTED") {
                                            $is_approved = "<span class='label label-danger'>REJECTED</span>";
                                        } else {
                                            $is_approved = "<span class='label label-warning'>PENDING</span>";
                                        }

                                        echo "<tr>
                                            <td>
                                                <div class='input-group input-group'>
                                                    <div class='input-group-btn'>
                                                        <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                        <ul class='dropdown-menu'>
                                                            ".$approveClaimRequestBtn.
                                                            $deleteClaimRequestBtn.
                                                        "</ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>".$is_approved."</td>
                                            <td>".$claimedRequest['establishment_name']."</td>
                                            <td>".$claimedRequest['clmd_name']."</td>
                                            <td>".$claimedRequest['clmd_contact']."</td>
                                            <td>".$claimedRequest['clmd_email']."</td>
                                            <td>".convert_to_user_date($claimedRequest['create_date'])."</td>
                                            <td>".convert_to_user_date($claimedRequest['update_date'])."</td>
                                        </tr>";
                                    }
                            	} ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
