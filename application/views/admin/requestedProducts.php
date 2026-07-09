<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Requested product<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Requested product Management</li>
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
                                <th>New Brand Name</th>
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

                                foreach ($req_prds as $req_prd) 
                                {
                                    $req_prd_id = $req_prd['request_id'];
                                    $list_id = '';

                                    if ($req_prd['isLinked'] == 1) {
                                        $isLinked = "LINKED";
                                    } else {
                                        $isLinked = "NOT LINKED";
                                    }
                                    
                                    $approveRequestedProductBtn = "<li><a href='".base_url()."addProduct?req_prd_id=".$req_prd_id."' title='Approve Product'><i class='fa fa-check'></i>Approve</a></li>";
                                    $rejectRequestedProductBtn = "<li><a href='".base_url()."rejectRequestedProduct/".$req_prd['request_id']."/".$req_prd['req_prd_id']."' title='Reject Product' onclick='return confirm(\"Do you want to reject the requested product?\")'><i class='fa fa-ban'></i>Reject</a></li>";
                                    $deleteRequestedProductBtn = "<li><a href='".base_url("deleteRequestProduct").'/'.$req_prd['request_id']."' title='Delete Product' onclick='return confirm(\"Do you want to delete the request product?\")'><i class='fa fa-trash-o'></i>Delete</a></li>";

                                    if ($req_prd['isLinked'] == 1) {

                                        $status = "<span class='label label-success'>REVIEWED</span>";
                                        $rejectRequestedProductBtn = '';
                                        $approveRequestedProductBtn = '';
                                        $deleteRequestedProductBtn = '';

                                    } elseif ($req_prd['requestProductStatus'] == "PENDING") {

                                        $status = "<span class='label label-warning'>".$req_prd['requestProductStatus']."</span>";

                                    } elseif ($req_prd['requestProductStatus'] == "REJECTED") {

                                        $rejectRequestedProductBtn = '';
                                        $status = "<span class='label label-danger'>".$req_prd['requestProductStatus']."</span>";
                                    }
                                    
                                    if ($rejectRequestedProductBtn != '' || $approveRequestedProductBtn != '' ||$deleteRequestedProductBtn != '') {
                                        $action = "<td>
                                            <div class='input-group input-group'>
                                                <div class='input-group-btn'>
                                                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                    <ul class='dropdown-menu'>
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

                                    echo "<tr>
                                        ".$action."
                                        <td>".$status."</td>
                                        <td>".$req_prd['merchant_name']."</td>
                                        <td>".$req_prd['product_name']."</td>
                                        <td>".$req_prd['category_name']."</td>
                                        <td>".$req_prd['brand_name']."</td>
                                        <td>".$req_prd['sell_price']."</td>
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
