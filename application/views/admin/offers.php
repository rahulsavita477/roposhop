<?php if ($data) {

    $seller_name_options = '<option value="">Select Seller</option>';
    
    foreach ($data as $sel_value) {

        $selected_seller_name = '';
        
        if (isset($_GET['seller']) && ($_GET['seller'] == $sel_value['merchant_id'])) {
            $selected_seller_name = 'selected';
        }

        $seller_name_options .= "<option value='".$sel_value['merchant_id']."' ".$selected_seller_name.">".$sel_value['establishment_name']."(".$sel_value['first_name'].")</option>";
    }
} else {
    $seller_name_options = '<option value="">Seller not available</option>';
} ?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Offer<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Offer Management</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3 input-field" style="padding-right: 5px;">
                                <label for="seller_name">Seller</label>
                                <select class="form-control" id="seller_name">
                                    <?= $seller_name_options ?>
                                </select>
                            </div>
                            <div class="col-sm-3 input-field" style="padding-left: 0px; padding-right: 5px;">
                                <label for="offer_status">Status</label>
                                <select class="form-control" id="offer_status">
                                    <option value="">Select Status</option>
                                    <?php
                                    $is_active_selected = "";
                                    $is_not_active_selected = "";
                                    
                                    if (isset($_GET['status'])) {
                                        if ($_GET['status']) {
                                            $is_active_selected = "selected";
                                        } else {
                                            $is_not_active_selected = "selected";
                                        }
                                    } ?>

                                    <option value="1" <?= $is_active_selected ?> >ACTIVE</option>
                                    <option value="0" <?= $is_not_active_selected ?> >NOT ACTIVE</option>
                                </select>
                            </div>
                            <div class="col-sm-3" style="padding-left: 0px;">
                                <label class="label_hide" for="">make space equal to label</label><br />
                                <button class="btn btn-primary" onclick="searchOffer();">Find</button>
                                <a href="<?= base_url('sellers/offers') ?>" title="Reset Filter">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-filter fa-stack-1x"></i>
                                        <i class="fa fa-times fa-stack-1x text-danger" style="margin-top: 6px; margin-left: 6px; font-size: 0.6em;"></i>
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-3 input-field">
                                <label class="label_hide" for="">make space equal to label</label><br />
                                <a href="<?= base_url('page/addOffer') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Offer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped data-pagination-table">
                    <thead>
                        <tr>
                            <!-- <th>S.NO.</th>
                            <th>Offer ID</th> -->
                            <th>Action</th>
                            <th>Status</th>
                            <th>Title</th>
                            <th>Seller Name</th>
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
                        <?php if (isset($merchant_offers) && $merchant_offers) {

                            // $count = 1;
                            // <td>".$count."</td>
                            // <td>".$offer_id."</td>

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
                                                        <a href='".base_url("editOffer/$offer_id/edit")."' title='Edit'><i class='fa fa-edit'></i>Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href='".base_url("deleteOffer/$offer_id")."'  onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class='statusLabel'>".$current_status."</td>
                                    <td><a href='".base_url("editOffer/$offer_id/view")."'>".$offer_value['offer_title']."</a></td>
                                    <td>".$offer_value['establishment_name']."</td>
                                    <td>".convert_to_user_date($offer_value['start_date'])."</td>
                                    <td>".convert_to_user_date($offer_value['end_date'])."</td>
                                    <td>".$offer_value['source']."</td>
                                    <td>".$offer_value['created_by']."</td>
                                    <td>".convert_to_user_date($offer_value['create_date'])."</td>
                                    <td>".$offer_value['updated_by']."</td>
                                    <td>".convert_to_user_date($offer_value['update_date'])."</td>
                                </tr>";

                                // $count++;
                            }
                        } ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script>
function searchOffer() 
{
    offer_status = $('#offer_status').val();
    seller_name = $('#seller_name').val();

    if ( !offer_status && !seller_name )
        alert('Error: please select seller or status');
    else
    {
        if ( offer_status && !seller_name )
            query_string = 'sellers/offers?status='+offer_status;
        else if ( seller_name && !offer_status ) 
            query_string = 'sellers/offers?seller='+seller_name;
        else if ( offer_status && seller_name )
            query_string = 'sellers/offers?status='+offer_status+'&seller='+seller_name;

        window.location = "<?= base_url() ?>"+query_string;
    }
}
</script>
