<?php
if($pageName == "sellersTable")
    $page_title = 'Management';
else if($pageName == "sellersList")
    $page_title = 'Product listing';
else if($pageName == "offerManagement")
    $page_title = 'Offer Management';
?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller
            <small><?= $page_title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php if($pageName == "offerManagement") { ?>
                <li><a href="<?= base_url('sellers/offers') ?>">Offer Management</a></li>
            <?php } ?>
            <li class="active">Sellers</li>
        </ol>
    </section>

    <!-- Open Do - Verify Modal -->
    <div class="modal fade" id="verifyModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Seller Varification</h4>
                </div>
                <?= form_open_multipart('verifySeller') ?>

                    <input type="hidden" name="merchant_id" id="merchant_id" />

                    <input type="hidden" name="user_id" id="user_id" />

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Shop Name <sub>*</sub></label>
                            <div>
                                <input type="text" class="form-control input-sm" id="shop_name" name="establishment_name" required="required" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">E-Mail Address <sub>*</sub></label>
                            <div>
                                <input type="email" class="form-control input-sm" name="email" required="required" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Name <sub>*</sub></label>
                            <div>
                                <input type="text" class="form-control input-sm" name="name" required="required" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Contact No <sub>*</sub></label>
                            <div>
                                <input type="text" class="form-control input-sm" name="contact" required="required" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Business Proof <sub>*</sub></label>
                            <div>
                                <input type="file" class="form-control input-lg" name="file9" required="required" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php if($pageName == "sellersTable"){ ?>
                <div class="col-xs-12">
                    <div class="box">
                        <div class="col-sm-12" style="margin-top: 10px;">
                            <a href="<?= base_url('page/addSeller') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Seller</a>
                        </div>

                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped data-pagination-table">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Seller ID</th>
                                        <th>Business Name</th>
                                        <th>Owner Name</th>
                                        <th>Email</th>
                                        <th>Contact number</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>isVarified</th>
                                        <th>Profile Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($success) 
                                    {
                                        $count = 1;
                                        foreach ($data as $seller_value)
                                        {
                                            $merchant_id = $seller_value['merchant_id'];
                                            $user_id = $seller_value['userId'];
                                            $shop_name = "'".$seller_value['establishment_name']."'";

                                            if ($seller_value['is_verified']) 
                                            {
                                                $isVarified = "<span class='label label-success'>Varified</span>";

                                                $change_verify_status_btn = "";
                                            }
                                            else
                                            {
                                                $isVarified = "<span class='label label-danger'>Not varified</span>";

                                                $change_verify_status_btn = '<button type="button" class="btn btn-warning" data-toggle="modal" onclick="openVerifyModal('.$merchant_id.', '.$user_id.', '.$shop_name.')">Do - varify</button>';
                                            }

                                            $is_completed = ($seller_value['is_completed']) ? "<span class='label label-success'>Completed</span>" : "<span class='label label-danger'>Not Completed</span>";

                                            if ($seller_value['status']) 
                                            {
                                                $current_status = '<span class="label label-success">Enabled</span>';
                                                $status_value = 0;
                                            }
                                            else
                                            {
                                                $current_status = '<span class="label label-danger">Disabled</span>';
                                                $status_value = 1;
                                            }

                                            echo "<tr>
                                                    <td>".$count++."</td>
                                                    <td>".$merchant_id."</td>
                                                    <td><a href='".base_url("seller/$merchant_id/view")."'>".$seller_value['establishment_name']."</a></td>
                                                    <td>".$seller_value['first_name']."</td>
                                                    <td>".$seller_value['email']."</td>
                                                    <td>".$seller_value['contact']."</td>";
                                                    if ($seller_value['address']) 
                                                        echo "<td>".$seller_value['address'][0]['city_name']."</td>
                                                            <td>".$seller_value['address'][0]['state_name']."</td>
                                                            <td>".$seller_value['address'][0]['country_name']."</td>";
                                                    else
                                                        echo "<td></td><td></td><td></td>";
                                                    
                                                echo "<td>".$isVarified."</td>
                                                    <td>".$is_completed."</td>
                                                    <td>".$current_status."</td>
                                                    <td>
                                                        ".$change_verify_status_btn."
                                                        <a href='".base_url("seller/$merchant_id/edit")."' class='btn btn-primary'>Edit</a>
                                                        <a href='".base_url("changeSellerStatus/$merchant_id/$status_value/status")."' class='btn btn-success'>Change status</a>
                                                        <a href='".base_url("deleteMerchant/$merchant_id/$user_id")."' class='btn btn-danger'>Delete</a>
                                                    </td>
                                                </tr>";
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            <?php } else if($pageName == "sellersList" || $pageName == "offerManagement") { ?>
                <!-- left column -->
                <div class="col-md-6 col-md-offset-3">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row form-group">
                                <div class="col-sm-3">
                                    <label>Select Seller:</label>   
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    echo '<select class="form-control" id="sel_id">';

                                        if ($success) 
                                        {
                                            echo "<option value=''>Select a Seller</option>";

                                            foreach ($data as $sel_value) 
                                            {
                                                $merchant_name = $sel_value['first_name'] ? '('.$sel_value['first_name'].')': '';

                                                echo "<option value='".$sel_value['merchant_id']."' ".$selected.">".$sel_value['establishment_name'].$merchant_name."</option>";
                                            }
                                        }
                                        else
                                            echo "<option value=''>No seller available!</option>";
                                    
                                    echo "</select>";
                                    ?>
                                </div>
                            </div>

                            <div class="next-step box-footer" align="right">
                                <?php if ($pageName == 'sellersList') 
                                { ?>
                                    <button class='btn-custom btn-primary' onclick="getAllProducts();">Next</button>
                                <?php } 
                                else if($pageName == "offerManagement") 
                                { ?>
                                    <a href="<?= base_url('sellers/offers') ?>" class="btn btn-default">Back</a>
                                    <button class='btn-custom btn-primary' onclick="setMerchantSession();">Next</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>   <!-- /.row -->
            <?php } ?>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script type="text/javascript">
function getAllProducts() 
{
    sel_id = $('#sel_id').val();
    if (sel_id)
        window.location = "<?= base_url('getAllProducts') ?>/"+sel_id;
    else
        alert('Error: please select the seller');
}

function setMerchantSession() 
{
    sel_id = $('#sel_id').val();
    if (sel_id)
    {
        document.cookie = "merchant_id="+sel_id+";path=/";
        window.location = "<?= base_url('page/addOffer') ?>";
    }
    else
        alert('Error: please select the seller');
}

function openVerifyModal(merchant_id, user_id, shop_name) 
{
    $("#merchant_id").val(merchant_id);
    $("#user_id").val(user_id);
    $("#shop_name").val(shop_name);
    $('#verifyModal').modal('show');
}
</script>
