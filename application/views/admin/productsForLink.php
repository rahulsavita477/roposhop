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
                echo '<li><a href="'.base_url('sellers/sellersList').'">Sellers</a></li>';
            if (isset($_GET['list_new_product'])) 
            {
                echo '<li><a href="'.base_url('getAllProducts/0').'">Product Listing</a></li>
                    <li class="active">List New Productdd</li>';
            } 
            else
                echo '<li class="active">Product Listing</li>';
            ?>
        </ol>
    </section>

    <section class="content">
    <!-- Main content -->
        <?php if (isset($_GET['list_new_product']) || $_COOKIE['site_code'] == 'admin'): ?>
            <div class="box box-primary">
                <!-- select available product for linking -->
                <div class="box-body">
                    <?php if (isset($_GET['list_new_product'])) { ?>
                        <?php if ($_COOKIE['site_code'] == 'seller'): ?>
                            <input type="hidden" id="loggedinSellerId" value="<?= isset($_COOKIE['merchant_id']) ? $_COOKIE['merchant_id'] : ''; ?>" />
                        <?php endif; ?>

                        <div class="row">
                            <form action="../getAllProducts/<?= $sel_id ?>" method="get">
                                <input type="hidden" name="list_new_product" value="Yes" />
                                <div class="col-sm-3 input-field" style="padding-right: 5px;">
                                    <label>Category</label>
                                    <select class="form-control" name="category_id" id="">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories['result'] as $category) {

                                            if ($category['category_id'] == $_GET['category_id']) {
                                                $selected = "selected='selected'";
                                            } else {
                                                $selected = '';
                                            }

                                            echo "<option value='".$category['category_id']."' ".$selected.">".$category['category_name']."</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-3 input-field" style="padding-left: 0px; padding-right: 5px;">
                                    <label value="">Brand</label>
                                    <select class="form-control" name="brand_id">
                                        <option value="">Select Brand</option>
                                        <?php foreach ($brands['result'] as $brand) {

                                            if ($brand['brand_id'] == $_GET['brand_id']) {
                                                $selected = "selected='selected'";
                                            } else {
                                                $selected = '';
                                            }

                                            echo "<option value='".$brand['brand_id']."' ".$selected.">".$brand['name']."</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-3" style="padding-left: 0px;">
                                    <label class="label_hide">make space equal to label</label><br />
                                    <button class="btn btn-primary" type="submit">Find</button>
                                    <a href="<?= base_url('../getAllProducts/'.$sel_id.'?list_new_product=Yes') ?>" title="Reset Filter">
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-filter fa-stack-1x"></i>
                                            <i class="fa fa-times fa-stack-1x text-danger" style="margin-top: 6px; margin-left: 6px; font-size: 0.6em;"></i>
                                        </span>
                                    </a>
                                </div>
                            <form>
                        </div>
                    <?php } ?>

                    
                    <?php if ($_COOKIE['site_code'] == 'admin' && !isset($_GET['list_new_product'])): ?>
                        <div class="row">
                            <div class="col-sm-3 input-field" style="padding-right: 5px;">
                                <label>Merchant</label>
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
                            <div class="col-sm-3" style="padding-left: 0px;">
                                <label class="label_hide">make space equal to label</label><br />
                                <button class="btn btn-primary" onclick="getListing()">Find</button>
                                <a href="<?= base_url('../getAllProducts/0') ?>" title="Reset Filter">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-filter fa-stack-1x"></i>
                                        <i class="fa fa-times fa-stack-1x text-danger" style="margin-top: 6px; margin-left: 6px; font-size: 0.6em;"></i>
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-6 input-field">
                                <label class="label_hide">make space equal to label</label><br />
                                <a href="<?= base_url('getAllProducts/0?list_new_product=Yes') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> List New Product</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['list_new_product'])): ?>
            <div class="box">

            <?php if ($_COOKIE['site_code'] == 'admin'): ?>
                <div class="row" style="margin: 10px 0px 0px 0px;">
                    <div class="col-sm-3" style="padding-left: 10px;">
                        <select class="form-control" onchange="changeURL(this)">
                            <option value="0">Select Seller</option>
                            <?php
                            foreach ($merchants as $merchant) 
                            {
                                if (!$merchant['establishment_name'])
                                    continue;

                                if ($sel_id == $merchant['merchant_id'])
                                    $selected = "selected='selected'";
                                else
                                    $selected = '';

                                echo "<option value='".$merchant['merchant_id']."' ".$selected.">".$merchant['establishment_name']."</option>";
                            }
                            ?>
                        </select>''''
                    </div>
                </div>
            <?php endif; ?>
            
                <!-- select requested product for linking -->
                <?php if ($req_products && isset($_GET['list_new_product']) && $_COOKIE['site_code'] == "seller") { ?>
                    <div class="box-body" style="padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>Link Requested Products:</label>
                            </div>
                            <div class="col-sm-3" style="padding-left: 0px;">
                                <select class="form-control" id="req_prd_id">
                                    <?php
                                    $count = 0;
                                    foreach ($req_products as $req_prd_value) {

                                        if (!$req_prd_value['isLinked'] && $req_prd_value['merchant_id'] !== $_COOKIE['merchant_id'] && $req_prd_value['linkedMerchantId'] !== $_COOKIE['merchant_id']) {

                                            $count++;

                                            if ($count == 1) {
                                                echo "<option value=''>Select Requested Product</option>";
                                            }

                                            echo "<option value='".$req_prd_value['req_prd_id']."'>".$req_prd_value['product_name']."</option>";
                                        }
                                    }

                                    if($count == 0) {
                                        echo "<option value=''>No Requested Product</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php if ($count > 0) { ?>
                                <div class="col-sm-2">
                                    <button class='btn btn-primary'
                                        onclick="fillListingDetailOfRequestedProduct();">Next</button>
                                </div>
                            <?php }
                    echo "</div>
                </div>";
                } ?>
                
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <table class="table table-bordered table-striped data-pagination-table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Status</th>
                                <!-- <th>Product image</th> -->
                                <th>Product name</th>
                                <th>MRP</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($products) {

                                // <td>".$count++."</td>
                                // <td><img src='".$image."' height='50px' /></td>
                                // $count = 1;
                                foreach ($products as $prd_value) {

                                    if ($prd_value['merchant_id'] != $sel_id) {

                                        $prd_id = $prd_value['product_id'];
                                        // $image = base_url(PRODUCT_ATTATCHMENTS_PATH.$prd_id.'/'.$prd_value['atch_url']);
                                        
                                        if ($prd_value['isEnabled']) {

                                            $status = "<span class='label label-success'>Enabled</span>";
                                            $newStatus = 0;
                                        
                                        } else {

                                            $status = "<span class='label label-danger'>Disabled</span>";
                                            $newStatus = 1;
                                        }
                                        
                                        echo "<tr>";
                                        if ($sel_id) {

                                            echo "<td>
                                                    <a href='".base_url("getProductDetail/$prd_id/$sel_id/0/false")."'>Link</a>
                                                </td>";
                                        } else {
                                            echo "<td>
                                                <button type='button' class='btn-custom btn-primary'>Select seller to link</button>
                                            </td>";
                                        }

                                        echo "<td class='statusLabel'>".$status."</td>
                                            <td>".$prd_value['product_name']."</td>
                                            <td>".$prd_value['mrp_price']."</td>
                                            <td>".$prd_value['category_name']."</td>
                                            <td>".$prd_value['brand_name']."</td>
                                            <td>".convert_to_user_date($prd_value['create_date'])."</td>
                                            <td>".convert_to_user_date($prd_value['update_date'])."</td>
                                        </tr>";
                                    }
                                }
                            } ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        <?php endif; ?>

        <?php if (!isset($_GET['list_new_product'])): ?>
            <div class="box">
                <?php
                echo '<div class="row">';
                    
                    if($_COOKIE['site_code'] == "seller") {
                        
                        echo '<a href="'.base_url('getAllProducts/'.$_COOKIE['merchant_id'].'?list_new_product=Yes').'" class="btn btn-primary pull-right" style="margin: 10px 25px 0px 0px;"><i class="fa fa-plus"></i> List New Product</a>';
                    }
                echo "</div>"; 
                ?>

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
                                <th>Visibility Status</th>
                                <th>Product Name</th>
                                <?php if ($_COOKIE['site_code'] == 'admin') {
                                    echo "<th>Merchant Name</th>";
                                } ?>
                                <th>Brand</th>
                                <th>MRP</th>
                                <th>Listing Price</th>
                                <th>In Stock</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $available = false;
                            
                            if ($products) {

                                // $count = 1;
                                // <td>".$count."</td>
                                // <td>".$prd_value['listing_id']."</td>
                                // ".$merchant_id_td."
                                // <td>".$prd_id."</td>
                                // ".$verifyBtn."
                                // <td>".$isVerified."</td>

                                foreach ($products as $prd_value) {

                                    if ($_COOKIE['site_code'] == 'admin') {
                                        // $merchant_id_td = "<td>".$prd_value['merchant_id']."</td>";
                                        $merchant_name_td = "<td>".$prd_value['merchant_name']."</td>";
                                    } else {
                                        // $merchant_id_td = "";
                                        $merchant_name_td = "";
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
                                            $isEnabled = "<span class='label label-success'>Enabled</span>";
                                            // $verifyBtn = "";
                                        } else {
                                            $isEnabled = "<span class='label label-danger'>Disabled</span>";
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
                                            <td>".$isEnabled."</td>
                                            <td>".$prd_value['product_name']."</td>
                                            ".$merchant_name_td."
                                            <td>".$prd_value['brand_name']."</td>
                                            <td>".$prd_value['mrp_price']."</td>
                                            <td>".$prd_value['price']."</td>
                                            <td>".$in_stock."</td>
                                            <td>".$prd_value['create_date']."</td>
                                            <td>".$prd_value['update_date']."</td>
                                        </tr>";

                                        // $count++;
                                    }
                                }
                            } ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        <?php endif; ?>
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

function getListing() {
    //for selected category
    var merchant_id = $('[name="merchant_id"]').val();
    if (merchant_id)
        window.location = "<?= base_url('getAllProducts/') ?>" + merchant_id;
    else
        alert('select merchant');
}

function changeURL(seller_id) {
    let a = "<?= base_url('getAllProducts/') ?>";
    window.location.href = a + seller_id.value + '?list_new_product=Yes';
}
</script>