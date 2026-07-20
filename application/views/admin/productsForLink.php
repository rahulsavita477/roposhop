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
            <?php if($_COOKIE['site_code'] == "admin") {
                echo '<li class="active">Seller</li>';
            } else {
                echo '<li><a href="'.base_url('listings').'">Product Listing</a></li>';
            } ?>
            <li class="active">List New Product</li>
        </ol>
    </section>

    <section class="content">
    <!-- Main content -->
        <?php if ($_COOKIE['site_code'] == 'admin' && isset($unassignedProducts)): ?>
            <div class="box box-primary">
                <!-- select available product for linking -->
                <div class="box-body">
                    <?php if ($_COOKIE['site_code'] == 'seller'): ?>
                        <input type="hidden" id="loggedinSellerId" value="<?= isset($_COOKIE['merchant_id']) ? $_COOKIE['merchant_id'] : ''; ?>" />
                    <?php endif; ?>

                    <div class="row">
                        <form action="<?= base_url('listings/add') ?>" method="get">
                            <input type="hidden" name="merchant_id" value="<?= $sel_id ?>" />
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
                            <div class="col-sm-3 input-field" style="padding-right: 5px;">
                                <label for="" value="">Brand</label>
                                <select class="form-control" name="brand_id" id="">
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
                                <a href="<?= base_url('listings/add?merchant_id='.$sel_id) ?>" title="Reset Filter">
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
            <?php if ($_COOKIE['site_code'] == 'admin'): ?>
                <div class="row" style="margin: 10px 0px 10px 0px;">
                    <form action="<?= base_url('listings/add') ?>" method="get">
                        <div class="col-sm-3" style="padding-left: 10px;">
                            <select class="form-control" id="" name="merchant_id" required>
                                <option value="">Select Seller</option>
                                <?php foreach ($merchants as $merchant) {

                                    if (!$merchant['establishment_name']) {
                                        continue;
                                    }

                                    if ($sel_id == $merchant['merchant_id']) {
                                        $selected = "selected='selected'";
                                    } else {
                                        $selected = '';
                                    }

                                    echo "<option value='".$merchant['merchant_id']."' ".$selected.">".$merchant['establishment_name']."</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-3" style="padding-left: 0px;">
                            <button class="btn btn-primary" type="submit">Go</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <?php if (isset($unassignedProducts)): ?>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped data-pagination-table">
                    <thead>
                        <tr>
                            <th>Action&nbsp;&nbsp;&nbsp;</th>
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
                        <?php if($unassignedProducts) {

                            foreach ($unassignedProducts as $prd_value) {

                                $prd_id = $prd_value['product_id'];
                                // $image = base_url(PRODUCT_ATTATCHMENTS_PATH.$prd_id.'/'.$prd_value['atch_url']);
                                
                                if ($prd_value['isEnabled']) {

                                    $status = "<span class='label label-success'>ENABLED</span>";
                                    $newStatus = 0;
                                
                                } else {

                                    $status = "<span class='label label-danger'>DISABLED</span>";
                                    $newStatus = 1;
                                }
                                
                                if ($prd_value['verification_status'] == "VERIFIED") {

                                    $verificationStatus = "<span class='label label-success'>".$prd_value['verification_status']."</span>";
                                    
                                } elseif ($prd_value['verification_status'] == "REJECTED") {

                                    $verificationStatus = "<span class='label label-danger'>".$prd_value['verification_status']."</span>";

                                } elseif ($prd_value['verification_status'] == "PENDING")  {

                                    $verificationStatus = "<span class='label label-warning'>".$prd_value['verification_status']."</span>";
                                }
                                
                                echo "<tr>";
                                if ($sel_id) {

                                    echo "<form method='post' action='".base_url('listings/product')."'>
                                        <input type='hidden' name='product_id' value='{$prd_id}'>
                                        <input type='hidden' name='merchant_id' value='{$sel_id}'>

                                        <td>
                                            <button type='submit' class='btn-custom btn-primary'>Link</button>
                                        </td>
                                    </form>";
                                } else {
                                    echo "<td>
                                        <button type='button' class='btn-custom btn-primary'>Select seller to link</button>
                                    </td>";
                                }

                                echo "<td class='statusLabel'>".$status."</td>
                                    <td class='statusLabel'>".$verificationStatus."</td>
                                    <td>".$prd_value['product_name']."</td>
                                    <td>".format_inr_price($prd_value['mrp_price'])."</td>
                                    <td>".$prd_value['category_name']."</td>
                                    <td>".$prd_value['brand_name']."</td>
                                    <td>".convert_to_user_date($prd_value['create_date'])."</td>
                                    <td>".convert_to_user_date($prd_value['update_date'])."</td>
                                </tr>";
                            }
                        }?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <?php else: ?>
                <br />
            <?php endif; ?>
        </div>
    </section><!-- /.content -->
</aside><!-- ./wrapper -->