<?php 
if ($data) 
{
    $seller_name_options = '<option value="">-- select seller --</option>';
    foreach ($data as $sel_value) 
    {
        $selected_seller_name = '';
        
        if ( isset($_GET['seller']) && ($_GET['seller'] == $sel_value['merchant_id']) ) 
            $selected_seller_name = 'selected';

        $seller_name_options .= "<option value='".$sel_value['merchant_id']."' ".$selected_seller_name.">".$sel_value['establishment_name']."(".$sel_value['first_name'].")</option>";
    }
}
else
    $seller_name_options = '<option value="">Seller not available</option>';
?>

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
            <div class="col-xs-12">
                <div class="box">
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" id="seller_name">
                                        <?= $seller_name_options ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" id="offer_status">
                                        <option value="">-- select offer status --</option>
                                        <?php 
                                        $is_active_selected = "";
                                        $is_not_active_selected = "";
                                        
                                        if (isset($_GET['status'])) 
                                        { 
                                            if ($_GET['status']) 
                                                $is_active_selected = "selected";
                                            else
                                                $is_not_active_selected = "selected";
                                        } ?>

                                        <option value="1" <?= $is_active_selected ?> >ACTIVE</option>
                                        <option value="0" <?= $is_not_active_selected ?> >NOT ACTIVE</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-primary" onclick="searchOffer();">Find offer</button>
                                    <a href="<?= base_url('sellers/offers') ?>" class='btn btn-default'>Remove filter</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4" align="right">
                            <!-- <a href="<?= base_url('sellers/offerManagement') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Offer</a> --> 
                            <a href="<?= base_url('page/addOffer') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Offer</a>
                        </div>
                    </div>

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
                                                <a href='".base_url("editOffer/$offer_id/edit")."' class='btn btn-primary'>Edit</a>
                                                <a href='".base_url("deleteOffer/$offer_id")."' class='btn btn-danger'>Delete</a>
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
            </div>
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
