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
            <div class="col-sm-12" style="margin-top: 10px;">
                <a href="<?= base_url('page/requestProduct') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New</a> 
            </div>

            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped data-pagination-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th>MRP</th>
                            <th>Price</th>
                            <th>In Stock</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $available = false;
                        if ($req_products) 
                        {
                            $count = 1;
                            foreach ($req_products as $req_product) 
                            {
                                if ($req_product['merchant_id'] == $_COOKIE['merchant_id'] && !$req_product['isLinked']) 
                                {
                                    $available = true;
                                    if ( $req_product['in_stock'] )
                                        $in_stock = "<span class='label label-success'>Yes</span>";
                                    else
                                        $in_stock = "<span class='label label-danger'>No</span>";

                                    echo "<tr>
                                            <td>".$count."</td>
                                            <td>".$req_product['product_name']."</td>
                                            <td>".$req_product['brand_name']."</td>
                                            <td>".$req_product['prd_price']."</td>
                                            <td>".$req_product['sell_price']."</td>
                                            <td>".$in_stock."</td>
                                            <td><span class='label label-warning'>Pending</span></td>
                                            <td>
                                                <a href='".base_url("editRequestedProduct").'/'.$req_product['request_id']."' class='btn btn-primary'>Edit</a>
                                                <a href='".base_url("deleteRequestProduct").'/'.$req_product['request_id']."' class='btn btn-danger'>Delete</a>
                                            </td>
                                        </tr>";

                                    $count++;
                                }
                            }
                        }

                        if (!$products || !$available) 
                            echo "<tr><td colspan='8' align='center'>No Record found.</td></tr>";
                        ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->