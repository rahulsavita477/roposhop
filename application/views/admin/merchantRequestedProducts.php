<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Requested Product<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Requested products</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="col-sm-12" style="margin: 10px 0px 0px 0px; padding-right: 10px;">
                <a href="<?= base_url('page/requestProduct') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Request New Product</a> 
            </div>

            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped data-pagination-table">
                    <thead>
                        <tr>
                            <!-- <th>S.No.</th> -->
                            <th>Action</th>
                            <th>Status</th>
                            <th>Product Name</th>
                            <th>New Brand</th>
                            <th>MRP</th>
                            <th>Price</th>
                            <th>In Stock</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($req_products) {

                            // $count = 1;
                            // <td>".$count."</td>

                            foreach ($req_products as $req_product) {

                                if ($req_product['merchant_id'] == $_COOKIE['merchant_id']) {

                                    $editRequestedProductBtn = "<li>
                                        <form id='editForm".$req_product['request_id']."' method='post' action='".base_url('editRequestedProduct')."' style='display:none;'>
                                            <input type='hidden' name='request_id' value='".$req_product['request_id']."' />
                                        </form>

                                        <a href='javascript:void(0)' onclick='document.getElementById(\"editForm".$req_product['request_id']."\").submit();' title='Edit'><i class='fa fa-edit'></i> Edit</a>
                                    </li>";

                                    $deleteRequestedProductBtn = "<li><a href='".base_url("deleteRequestProduct").'/'.$req_product['request_id']."' onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>";

                                    if ($req_product['requestProductStatus'] == "APPROVED") {

                                        $status = "<span class='label label-success'>".$req_product['requestProductStatus']."</span>";
                                        $editRequestedProductBtn = false;
                                        $deleteRequestedProductBtn = false;

                                    } elseif ($req_product['requestProductStatus'] == "PENDING") {

                                        $status = "<span class='label label-warning'>".$req_product['requestProductStatus']."</span>";

                                    } elseif ($req_product['requestProductStatus'] == "REJECTED") {

                                        $status = "<span class='label label-danger'>".$req_product['requestProductStatus']."</span>";
                                    }

                                    if ($editRequestedProductBtn || $deleteRequestedProductBtn) {
                                        $action = "<td>
                                            <div class='input-group input-group'>
                                                <div class='input-group-btn'>
                                                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                    <ul class='dropdown-menu'>
                                                        ".$editRequestedProductBtn."
                                                        ".$deleteRequestedProductBtn."
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>";
                                    }

                                    if ( $req_product['in_stock'] ) {
                                        $in_stock = "<span class='label label-success'>Yes</span>";
                                    } else {
                                        $in_stock = "<span class='label label-danger'>No</span>";
                                    }

                                    echo "<tr>
                                            ".$action."
                                            <td class='statusLabel'>".$status."</td>
                                            <td>".$req_product['product_name']."</td>
                                            <td>".$req_product['brand_name']."</td>
                                            <td>".format_inr_price($req_product['prd_price'])."</td>
                                            <td>".format_inr_price($req_product['sell_price'])."</td>
                                            <td class='statusLabel'>".$in_stock."</td>
                                            <td>".convert_to_user_date($req_product['create_date'])."</td>
                                            <td>".convert_to_user_date($req_product['update_date'])."</td>
                                        </tr>";

                                    // $count++;
                                }
                            }
                        } ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->