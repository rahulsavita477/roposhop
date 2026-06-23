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
                    <li class="active">List New Product</li>';
            } 
            else
                echo '<li class="active">Product Listing</li>';
            ?>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-sm-12">
                <div class="box">
                    <!-- select available product for linking -->
                    <div class="box-bdy">
                        <?php if (isset($_GET['list_new_product'])) { ?>
                        <?php if ($_COOKIE['site_code'] == 'admin'): ?>
                        <div class="row" style="margin: 10px 0 10px 0;">
                            <div class="col-sm-12">
                                <div class="alert alert-warning" role="alert"><b>Info: </b>Please select seller to link
                                    a product</div>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" onchange="changeURL(this)">
                                    <option value="0">--select seller--</option>
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
                                </select>
                            </div>
                        </div>
                        <?php elseif ($_COOKIE['site_code'] == 'seller'): ?>
                            <input type="hidden" id="loggedinSellerId" value="<?= isset($_COOKIE['merchant_id']) ? $_COOKIE['merchant_id'] : ''; ?>" />
                        
                        <?php endif; ?>

                        <div class="box-body">
                            <!-- select requested product for linking -->
                            <?php if ($req_products && isset($_GET['list_new_product']) && $_COOKIE['site_code'] == "seller") { ?>
                            <div class="row" style="margin-bottom:1%;">
                                <div class="col-sm-3">
                                    <label>Requested products available for link:</label>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" id="req_prd_id">
                                        <?php
                                        $count = 0;
                                        foreach ($req_products as $req_prd_value) 
                                        {
                                            if (!$req_prd_value['isLinked'] && $req_prd_value['merchant_id'] !== $_COOKIE['merchant_id'] && $req_prd_value['linkedMerchantId'] !== $_COOKIE['merchant_id'])
                                            {
                                                $count++;

                                                if ($count == 1)
                                                    echo "<option value=''>Select requested product!!</option>";

                                                echo "<option value='".$req_prd_value['req_prd_id']."'>".$req_prd_value['product_name']."</option>";
                                            }
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
                            echo "</div>";
                            } ?>
                            <div class="row">
                                <form action="getAllProducts/<?= $sel_id ?>" method="get">
                                    <input type="hidden" name="list_new_product" value="Yes" />
                                    <div class="col-sm-3">
                                        <select class="form-control" name="category_id">
                                            <option value="">--select category--</option>
                                            <?php
                                            foreach ($categories['result'] as $category) 
                                            {
                                                if ($category['category_id'] == $_GET['category_id']) 
                                                    $selected = "selected='selected'";
                                                else
                                                    $selected = '';

                                                echo "<option value='".$category['category_id']."' ".$selected.">".$category['category_name']."</option>";    
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="brand_id">
                                            <option value="">--select brand--</option>
                                            <?php
                                            foreach ($brands['result'] as $brand) 
                                            {
                                                if ($brand['brand_id'] == $_GET['brand_id'])
                                                    $selected = "selected='selected'";
                                                else
                                                    $selected = '';

                                                echo "<option value='".$brand['brand_id']."' ".$selected.">".$brand['name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary" onclick="searchProduct();">Find product</button>
                                        <a href="<?= base_url('getAllProducts/'.$sel_id.'?list_new_product=Yes') ?>" class='btn btn-default'>Remove filter</a>
                                    </div>
                                <form>
                            </div>
                        </div>
                        
                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped data-pagination-table">
                                <thead>
                                    <tr>
                                        <th>S.NO.</th>
                                        <th>Product image</th>
                                        <th>Product name</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if ($products) 
                                        {
                                            $count = 1;
                                            foreach ($products as $prd_value)
                                            {
                                                if ($prd_value['merchant_id'] != $sel_id)
                                                {
                                                    $prd_id = $prd_value['product_id'];
                                                    $image = base_url(PRODUCT_ATTATCHMENTS_PATH.$prd_id.'/'.$prd_value['atch_url']);

                                                    echo "<tr>
                                                            <td>".$count++."</td>
                                                            <td><img src='".$image."' height='50px' /></td>
                                                            <td>".$prd_value['product_name']."</td>
                                                            <td>".$prd_value['category_name']."</td>
                                                            <td>".$prd_value['brand_name']."</td>";

                                                    if ($sel_id) 
                                                    {
                                                        echo "<td>
                                                                <a href='".base_url("getProductDetail/$prd_id/$sel_id/0/false")."' class='btn-custom btn-primary'>Link</a>
                                                            </td>";
                                                    }
                                                    else
                                                        echo "<td>
                                                                <button type='button' class='btn-custom btn-primary'>Select seller to link</button>
                                                            </td>";

                                                    echo "</tr>";
                                                }
                                            }
                                        } ?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                        <?php } if (!isset($_GET['list_new_product'])) {

                            if($_COOKIE['site_code'] == "seller") {
                                
                                echo '<a href="'.base_url('getAllProducts/'.$_COOKIE['merchant_id'].'?list_new_product=Yes').'" class="btn btn-primary pull-right" style="margin: 10px 10px 0px 0;"><i class="fa fa-plus"></i> List New Product</a>';
                                
                            } elseif($_COOKIE['site_code'] == "admin") {
                                
                                echo '<a href="'.base_url('getAllProducts/0?list_new_product=Yes').'" class="btn btn-primary pull-right" style="margin: 10px 10px 0px 0;"><i class="fa fa-plus"></i> List New Product</a>';
                            }
                        } ?>
                    </div>

                    <?php if (!isset($_GET['list_new_product'])) { ?>
                    
                    <div class="box-header" style="position:unset; padding-bottom:0px">
                        <h3 class="box-title">Listed Products</h3>
                    </div><!-- /.box-header -->

                    <?php if ($_COOKIE['site_code'] == 'admin'): ?>
                    <div class="row" style="margin: 0px 0 10px -5px;">
                        <div class="col-sm-3">
                            <select class="form-control" name="merchant_id">
                                <?php
                                        echo '<option value="">-- select merchant --</option>';
    
                                        foreach ($merchants as $merchant) 
                                        {
                                            if (!$merchant['establishment_name'])
                                                continue;

                                            $selected = '';
                                            
                                            if ($sel_id == $merchant['merchant_id']) 
                                                $selected = 'selected';

                                            echo "<option value='".$merchant['merchant_id']."' ".$selected.">".$merchant['establishment_name']."</option>";
                                        }
                                        ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" onclick="getListing()" class="btn btn-primary">Find Listing</button>
                            <a href="<?= base_url('getAllProducts/0') ?>" class='btn btn-default'>Remove Filter</a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Listing ID</th>
                                    <?php
                                        if ($_COOKIE['site_code'] == 'admin') {
                                            echo "<th>Merchant ID</th>";
                                        }
                                        ?>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>MRP</th>
                                    <th>Price</th>
                                    <th>In Stock</th>
                                    <th>is Varified</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $available = false;
                                    if ($products) 
                                    {
                                        $count = 1;
                                        foreach ($products as $prd_value) 
                                        {
                                            if ($_COOKIE['site_code'] == 'admin') 
                                                $merchant_id_td = "<td>".$prd_value['merchant_id']."</td>";
                                            else
                                                $merchant_id_td = "";

                                            if ($prd_value['listing_id']) 
                                            {
                                                $available = true;
                                                $prd_id = $prd_value['product_id'];
                                                $list_id = $prd_value['listing_id'];
                                                
                                                if ($prd_value['in_stock'])
                                                    $in_stock = "<span class='label label-success'>Yes</span>";
                                                else
                                                    $in_stock = "<span class='label label-danger'>No</span>";

                                                if ($prd_value['isVerified'])
                                                {
                                                    $isVerified = "<span class='label label-success'>Yes</span>";
                                                    $verifyBtn = "";
                                                }
                                                else
                                                {
                                                    $isVerified = "<span class='label label-danger'>No</span>";
                                                    $verifyBtn = "<a href='".base_url()."verifyListing/".$list_id."/1/".$prd_value['merchant_id']."' class='btn btn-warning'>Do Verify</a>";
                                                }

                                                echo "<tr>
                                                        <td>".$count."</td>
                                                        <td>".$prd_value['listing_id']."</td>
                                                        ".$merchant_id_td."
                                                        <td>".$prd_id."</td>
                                                        <td>".$prd_value['product_name']."</td>
                                                        <td>".$prd_value['brand_name']."</td>
                                                        <td>".$prd_value['mrp_price']."</td>
                                                        <td>".$prd_value['price']."</td>
                                                        <td>".$in_stock."</td>
                                                        <td>".$isVerified."</td>
                                                        <td>
                                                            <a href='".base_url()."getProductDetail/".$prd_id."/".$sel_id."/".$list_id."/false' class='btn btn-primary'>Edit</a>
                                                            <a href='".base_url()."deleteListing/".$list_id."/".$sel_id."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                            ".$verifyBtn."
                                                        </td>
                                                    </tr>";

                                                $count++;
                                            }
                                        }
                                    } ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>

                <!-- <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Listed Requested Products</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Request ID</th>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>MRP</th>
                                    <th>Price</th>
                                    <th>In Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> -->
                                <?php
                                // $available = false;
                                // if ($req_products) 
                                // {
                                //     $count = 1;
                                //     foreach ($req_products as $req_product) 
                                //     {
                                //         if ($req_product['merchant_id'] == $sel_id && !$req_product['isLinked']) 
                                //         {
                                //             $request_id = $req_product['request_id'];
                                //             $available = true;
                                //             if ($req_product['in_stock'])
                                //                 $in_stock = "<span class='label label-success'>Yes</span>";
                                //             else
                                //                 $in_stock = "<span class='label label-danger'>No</span>";

                                //             echo "<tr>
                                //                     <td>".$count."</td>
                                //                     <td>".$request_id."</td>
                                //                     <td>".$req_product['product_name']."</td>
                                //                     <td>".$req_product['brand_name']."</td>
                                //                     <td>".$req_product['prd_price']."</td>
                                //                     <td>".$req_product['sell_price']."</td>
                                //                     <td>".$in_stock."</td>
                                //                     <td><span class='label label-warning'>Pending</span></td>
                                //                     <td>
                                //                         <a href='".base_url('editRequestedProduct').'/'.$request_id."' class='btn btn-primary'>Edit</a>
                                //                     </td>
                                //                 </tr>";

                                //             $count++;
                                //         }
                                //     }
                                // }

                                // if (!$products || !$available) 
                                //     echo "<tr><td colspan='10' align='center'>No Record found.</td></tr>";
                                ?>
                            <!-- </tbody>
                        </table>
                    </div> -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
    </div><!-- ./wrapper -->

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