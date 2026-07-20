<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Offer<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Offers Management</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-sm-12" style="margin-top: 10px; padding-right: 10px;">
                        <a href="<?= base_url('page/addOffer') ?>" class="btn btn-primary pull-right">
                            <i class="fa fa-plus"></i> Add New Offer</a>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <!-- <th>S.NO.</th> -->
                                    <th>Action</th>
                                    <th>Status&nbsp;&nbsp;&nbsp;</th>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Source&nbsp;&nbsp;&nbsp;</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Updated By&nbsp;&nbsp;&nbsp;</th>
                                    <th>Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php if ($merchant_offers) {

                                    // $count = 1;
                                    // <td>".$count++."</td>

                            		foreach ($merchant_offers as $offer_value) {

                                        $offer_id = $offer_value['offer_id'];

                                        if ($offer_value['current_status']) {
                                            $current_status = "<span class='label label-success'>Active</span>";
                                        } else {
                                            $current_status = "<span class='label label-danger'>Not active</span>";
                                        }

                                        echo "<tr>
                                            <td>
                                                <div class='input-group input-group'>
                                                    <div class='input-group-btn'>
                                                        <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                        <ul class='dropdown-menu'>
                                                            <li>
                                                                <form id='offer/edit".$offer_id."' method='post' action='".base_url('offer/edit')."' style='display:none;'>
                                                                    <input type='hidden' name='offer_id' value='".$offer_id."' />
                                                                </form>

                                                                <a href='javascript:void(0)' onclick='document.getElementById(\"offer/edit".$offer_id."\").submit();' title='Edit'><i class='fa fa-edit'></i> Edit</a>
                                                            </li>
                                                            <li>
                                                                <a href='".base_url("deleteOffer/$offer_id")."'  onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class='statusLabel'>".$current_status."</td>
                                            <td>
                                                <form id='offer/view".$offer_id."' method='post' action='".base_url('offer/view')."' style='display:none;'>
                                                    <input type='hidden' name='offer_id' value='".$offer_id."' />
                                                </form>
                                                <a href='javascript:void(0)' onclick='document.getElementById(\"offer/view".$offer_id."\").submit();' title='".$offer_value['offer_title']."'>".$offer_value['offer_title']."</a>
                                            </td>
                                            <td>".convert_to_user_date($offer_value['start_date'])."</td>
                                            <td>".convert_to_user_date($offer_value['end_date'])."</td>
                                            <td>".$offer_value['source']."</td>
                                            <td>".$offer_value['created_by']."</td>
                                            <td>".convert_to_user_date($offer_value['create_date'])."</td>
                                            <td>".$offer_value['updated_by']."</td>
                                            <td>".convert_to_user_date($offer_value['update_date'])."</td>
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
