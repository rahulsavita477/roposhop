<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Requested Product<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Requested Product Management</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped data-pagination-table">
                        <thead>
                            <tr>
                                <!-- <th>S.No.</th>
                                <th>Requested ID</th> -->
                                <th>Action</th>
                                <th>Admin Review</th>
                                <th>Merchant Name</th>
                                <th>Product Name</th>
                                <th>Category Name</th>
                                <th>Suggested Brand</th>
                                <th>Seller Price</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($req_prds) {

                                // $count = 1;
                                // <td>".$count++."</td>
                                // <td>".$req_prd_id."</td>

                                foreach ($req_prds as $req_prd) {

                                    $req_prd_id = $req_prd['request_id'];
                                    $prd_id = $req_prd['req_prd_id'];
                                    $list_id = $req_prd['listing_id'];
                                    $merchant_id = $req_prd['merchant_id'];
                                                                        
                                    $approveRequestedProductBtn = "<li><a href='".base_url()."addProduct?req_prd_id=".$req_prd_id."' title='Approve Product'><i class='fa fa-check'></i>Approve</a></li>";
                                    // $approveRequestedProductBtn = "<li><a href='".base_url()."changeRequestedProductStatus/".$req_prd['request_id']."/APPROVED' title='Approve Product' onclick='return confirm(\"Do you want to approve the requested product?\")'><i class='fa fa-check'></i>Approve</a></li>";
                                    $editListingBtn = "<li><a href='".base_url()."getProductDetail/".$prd_id."/".$merchant_id."/".$list_id."/true' title='Update Listing' target='_blank'><i class='fa fa-list-alt text-primary'></i>Manage Listing</a></li>";
                                    $editProductBtn = "<li><a href='".base_url()."editProduct/".$prd_id."/edit' title='Update Product Info' target='_blank'><i class='fa fa-gears'></i>Manage Product</a></li>";
                                    $rejectRequestedProductBtn = "<li><a href='".base_url()."changeRequestedProductStatus/".$req_prd['request_id']."/REJECTED' title='Reject Product' onclick='return confirm(\"This requested product will remain in catalogue and seller listing, but marked as Rejected. Do you want to continue?\")'><i class='fa fa-ban text-danger'></i>Reject</a></li>";
                                    $deleteRequestedProductBtn = "<li><a href='".base_url("deleteRequestProduct").'/'.$req_prd['request_id']."' title='Delete Product' onclick='return confirm(\"This product will stay in the main catalogue and merchant listing. Do you still want to delete this request entry?\")'><i class='fa fa-trash-o'></i>Delete</a></li>";

                                    if ($req_prd['requestProductStatus'] == "APPROVED") {

                                        $status = "<span class='label label-success'>".$req_prd['requestProductStatus']."</span>";
                                        $approveRequestedProductBtn = '';

                                    } elseif ($req_prd['requestProductStatus'] == "PENDING") {

                                        $status = "<span class='label label-warning'>".$req_prd['requestProductStatus']."</span>";

                                    } elseif ($req_prd['requestProductStatus'] == "REJECTED") {

                                        $rejectRequestedProductBtn = '';
                                        $status = "<span class='label label-danger'>".$req_prd['requestProductStatus']."</span>";
                                    }
                                    
                                    if ($rejectRequestedProductBtn != '' || $editListingBtn != '' ||$deleteRequestedProductBtn != '' || $editProductBtn != '') {
                                        $action = "<td>
                                            <div class='input-group input-group'>
                                                <div class='input-group-btn'>
                                                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                    <ul class='dropdown-menu'>
                                                        ".$editListingBtn."
                                                        ".$editProductBtn."
                                                        ".$approveRequestedProductBtn."
                                                        ".$rejectRequestedProductBtn."
                                                        ".$deleteRequestedProductBtn."
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>";
                                    } else {
                                        $action = "";
                                    }

                                    $brand_name = '';
                                    if($req_prd['brand_name']) {
                                        $brand_name = "<i class='fa fa-exclamation-triangle' title='New Brand Suggestion'></i>&nbsp;".$req_prd['brand_name'];
                                    }

                                    echo "<tr>
                                        ".$action."
                                        <td class='statusLabel'>".$status."</td>
                                        <td>".$req_prd['merchant_name']."</td>
                                        <td>".$req_prd['product_name']."</td>
                                        <td>".$req_prd['category_name']."</td>
                                        <td>".$brand_name."</td>
                                        <td>".format_inr_price($req_prd['sell_price'])."</td>
                                        <td>".convert_to_user_date($req_prd['create_date'])."</td>
                                        <td>".convert_to_user_date($req_prd['update_date'])."</td>
                                    </tr>";
                                }
                            } ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
