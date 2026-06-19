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
                                <th>S.No.</th>
                                <th>Requested ID</th>
                                <th>Product Name</th>
                                <th>New Brand Name</th>
                                <th>Seller Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($req_prds) 
                            {
                                $count = 1;
                                foreach ($req_prds as $req_prd) 
                                {
                                    $req_prd_id = $req_prd['request_id'];
                                    $list_id = '';

                                    if ($req_prd['isLinked'] == 1)
                                        $isLinked = "LINKED";
                                    else 
                                        $isLinked = "NOT LINKED";
                                    
                                    $approveRequestedProductBtn = "<a href='".base_url()."addProduct?req_prd_id=".$req_prd_id."' class='btn btn-success'>Approve</a>";
                                    $rejectRequestedProductBtn = "<a href='".base_url()."rejectRequestedProduct/".$req_prd['request_id']."' class='btn btn-danger'>Reject</a>";
                                    $deleteRequestedProductBtn = "<a href='".base_url("deleteRequestProduct").'/'.$req_prd['request_id']."' class='btn btn-danger'>Delete</a>";

                                    if ($req_prd['isLinked'] == 1)
                                    {
                                        $status = "<span class='label label-success'>CREATED</span>";
                                        $rejectRequestedProductBtn = '';
                                        $approveRequestedProductBtn = '';
                                        $deleteRequestedProductBtn = '';

                                    } elseif ($req_prd['requestProductStatus'] == "PENDING")
                                    {
                                        $status = "<span class='label label-warning'>".$req_prd['requestProductStatus']."</span>";

                                    } elseif ($req_prd['requestProductStatus'] == "REJECTED")
                                    {
                                        $rejectRequestedProductBtn = '';
                                        $status = "<span class='label label-danger'>".$req_prd['requestProductStatus']."</span>";
                                    }
                                    
                                    echo "<tr>
                                            <td>".$count++."</td>
                                            <td>".$req_prd_id."</td>
                                            <td>".$req_prd['product_name']."</td>
                                            <td>".$req_prd['brand_name']."</td>
                                            <td>".$req_prd['sell_price']."</td>
                                            <td>".$status."</td>

                                            <td>
                                                ".$approveRequestedProductBtn."
                                                ".$rejectRequestedProductBtn."
                                                ".$deleteRequestedProductBtn."
                                            </td>
                                        </tr>";
                                }
                            }

                            if ( !$req_prds )
                                echo "<tr><td colspan='7' align='center'>No Record found.</td></tr>";
                            ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
