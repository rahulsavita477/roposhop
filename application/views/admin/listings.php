<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller
            <small>Product Listing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php 
            if ($_COOKIE['site_code'] == 'admin') 
                echo '<li><a href="'.base_url('sellers/sellersList').'">Product Listings</a></li>';
            else
                echo '<li class="active">Product Listing</li>';
            ?>
        </ol>
    </section>

    <section class="content">
    <!-- Main content -->
        <?php if ($_COOKIE['site_code'] == 'admin'): ?>
            <div class="box box-primary">
                <!-- select available product for linking -->
                <div class="box-body">
                    <div class="row">
                        <form method="get" action="<?= base_url('listings') ?>">
                            <div class="col-sm-3 input-field" style="padding-right: 5px;">
                                <label for="">Merchant</label>
                                <select class="form-control" name="merchant_id" id="">
                                    <?php
                                    echo '<option value="">Select Merchant</option>';

                                    foreach ($merchants as $merchant) {

                                        if (!$merchant['establishment_name']) {
                                            continue;
                                        }

                                        $selected = '';
                                        
                                        if ($sel_id == $merchant['merchant_id']) {
                                            $selected = 'selected';
                                        }

                                        echo "<option value='".$merchant['merchant_id']."' ".$selected.">".$merchant['establishment_name']."</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="col-sm-3 input-field" style="padding-right: 5px;">
                                <label for="">Product</label>
                                <select class="form-control" name="product" id="">
                                    <?php
                                    echo '<option value="">Select Product</option>';

                                    foreach ($products as $product) {
                                        
                                        $selected = '';
                                        
                                        if ($product_id == $product['product_id']) {
                                            $selected = 'selected';
                                        }

                                        echo "<option value='".$product['product_id']."' ".$selected.">".$product['product_name']."</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="col-sm-3" style="padding-left: 0px;">
                                <label for="" class="label_hide">make space equal to label</label><br />
                                <button class="btn btn-primary" type="submit">Find</button>
                                <a href="<?= base_url('listings') ?>" title="Reset Filter">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-filter fa-stack-1x"></i>
                                        <i class="fa fa-times fa-stack-1x text-danger" style="margin-top: 6px; margin-left: 6px; font-size: 0.6em;"></i>
                                    </span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="box">
            <?php if($_COOKIE['site_code'] == "seller") {
                
                echo '<div class="row"><a href="'.base_url('listings/add').'" class="btn btn-primary pull-right" style="margin: 10px 25px 0px 0px;"><i class="fa fa-plus"></i> List New Product</a></div>';
            } ?>

            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped data-pagination-table">
                    <thead>
                        <tr>
                            <!-- <th>S.No.</th>
                            <th>Listing ID</th> -->
                            <?php
                            // if ($_COOKIE['site_code'] == 'admin') {
                            //     echo "<th>Merchant ID</th>";
                            // }
                            ?>
                            <!-- <th>Product ID</th> -->
                            <th>Action</th>
                            <!-- <th>Is Verified</th> -->
                            <th>
                                Visibility
                                <i class="fa fa-info-circle text-primary"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="Product Visibility On User Website"
                                ></i>&nbsp;&nbsp;&nbsp;
                            </th>
                            <th>
                                Verification
                                <i class="fa fa-info-circle text-primary"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="Admin Verification On Product"
                                ></i>&nbsp;&nbsp;&nbsp;
                            </th>
                            <th>Product Name</th>
                            <?php if ($_COOKIE['site_code'] == 'admin') {
                                echo "<th>Merchant Name</th>";
                            } ?>
                            <th>Brand</th>
                            <th>MRP</th>
                            <th>Listing Price&nbsp;&nbsp;&nbsp;</th>
                            <th>In Stock&nbsp;&nbsp;&nbsp;</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $available = false;
                        
                        if ($listingProducts) {

                            // $count = 1;
                            // <td>".$count."</td>
                            // <td>".$prd_value['listing_id']."</td>
                            // ".$merchant_id_td."
                            // <td>".$prd_id."</td>
                            // ".$verifyBtn."
                            // <td>".$isVerified."</td>

                            foreach ($listingProducts as $prd_value) {

                                if ($_COOKIE['site_code'] == 'admin') {
                                    // $merchant_id_td = "<td>".$prd_value['merchant_id']."</td>";
                                    $merchant_name_td = "<td>".$prd_value['merchant_name']."</td>";
                                } else {
                                    // $merchant_id_td = "";
                                    $merchant_name_td = "";
                                }

                                if ($prd_value['verification_status'] == "VERIFIED") {

                                    $verificationStatus = "<span class='label label-success'>".$prd_value['verification_status']."</span>";
                                    
                                } elseif ($prd_value['verification_status'] == "REJECTED") {

                                    $verificationStatus = "<span class='label label-danger'>".$prd_value['verification_status']."</span>";

                                } elseif ($prd_value['verification_status'] == "PENDING")  {

                                    $verificationStatus = "<span class='label label-warning'>".$prd_value['verification_status']."</span>";
                                }
                                
                                if ($prd_value['listing_id']) {

                                    $available = true;
                                    $prd_id = $prd_value['product_id'];
                                    $list_id = $prd_value['listing_id'];
                                    
                                    if ($prd_value['in_stock']) {
                                        $in_stock = "<span class='label label-success'>Yes</span>";
                                    } else {
                                        $in_stock = "<span class='label label-danger'>No</span>";
                                    }

                                    if ($prd_value['isEnabled']) {
                                        $isEnabled = "<span class='label label-success'>ENABLED</span>";
                                        // $verifyBtn = "";
                                    } else {
                                        $isEnabled = "<span class='label label-danger'>DISABLED</span>";
                                        // $verifyBtn = "<li><a href='".base_url()."verifyListing/".$list_id."/1/".$prd_value['merchant_id']."' class='btn btn-warning'>Do Verify</a></li>";
                                    }

                                    echo "<tr>
                                        <td>
                                            <div class='input-group input-group'>
                                                <div class='input-group-btn'>
                                                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                    <ul class='dropdown-menu'>
                                                        <li>
                                                            <a href='".base_url()."getProductDetail/".$prd_id."/".$sel_id."/".$list_id."/false' title='Edit'><i class='fa fa-edit'></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href='".base_url()."deleteListing/".$list_id."/".$sel_id."' onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td class='statusLabel'>".$isEnabled."</td>
                                        <td class='statusLabel'>".$verificationStatus."</td>
                                        <td>".$prd_value['product_name']."</td>
                                        ".$merchant_name_td."
                                        <td>".$prd_value['brand_name']."</td>
                                        <td>".format_inr_price($prd_value['mrp_price'])."</td>
                                        <td>".format_inr_price($prd_value['price'])."</td>
                                        <td class='statusLabel'>".$in_stock."</td>
                                        <td>".convert_to_user_date($prd_value['create_date'])."</td>
                                        <td>".convert_to_user_date($prd_value['update_date'])."</td>
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
</aside><!-- ./wrapper -->

<script type="text/javascript">
function fillListingDetailOfRequestedProduct() {
    
    let req_prd_id = $('#req_prd_id').val();
    let sellerId = $('#loggedinSellerId').val();   // from PHP
    let listingId = 0;

    if (req_prd_id && sellerId) {
    
        // window.location = "<?= base_url('fillListingDetailOfRequestedProduct') ?>/" + req_prd_id;
        window.location.href = "<?= base_url('getProductDetail'); ?>/" + req_prd_id + "/" + sellerId + "/" + listingId+"/true";
    
    } else if (!req_prd_id) alert('Error: please select requested product');
    else if (!sellerId) alert('Error: seller not found');
}

function changeURL(seller_id) {
    let a = "<?= base_url('getAllProducts/') ?>";
    window.location.href = a + seller_id.value + '?list_new_product=Yes';
}
</script>