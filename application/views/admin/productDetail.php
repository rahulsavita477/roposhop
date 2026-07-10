<?php
//product detail
$product_id = isset($product_id) ? $product_id : false;
$product_name = isset($product_name) ? $product_name : '';
$description = isset($description) ? $description : '';
$in_the_box = isset($in_the_box) ? $in_the_box : '';
$mrp_price = isset($mrp_price) ? $mrp_price : '';
$product_images_dir = isset($product_images_dir) ? $product_images_dir : '';
$images = isset($images) ? $images : '';
$category_name = isset($category_name) ? $category_name : '';
$brand_name = isset($brand_name) ? $brand_name : '';
$prd_varients = isset($product_varients) ? $product_varients : false;

//listing detail
$listing_id = isset($product_listing[0]['listing_id']) ? $product_listing[0]['listing_id'] : '';
$sell_price = isset($product_listing[0]['sell_price']) ? $product_listing[0]['sell_price'] : '';

if ($listing_id) 
{
    $page_title = "Edit Listing";

    $finance_available = isset($product_listing[0]['finance_available']) ? $product_listing[0]['finance_available'] : '';
    $finance_terms = isset($product_listing[0]['finance_terms']) ? $product_listing[0]['finance_terms'] : '';
    $home_delivery_available = isset($product_listing[0]['home_delivery_available']) ? $product_listing[0]['home_delivery_available'] : '';
    $home_delivery_terms = isset($product_listing[0]['home_delivery_terms']) ? $product_listing[0]['home_delivery_terms'] : '';
    $installation_available = isset($product_listing[0]['installation_available']) ? $product_listing[0]['installation_available'] : '';
    $installation_terms = isset($product_listing[0]['installation_terms']) ? $product_listing[0]['installation_terms'] : '';
    $replacement_available = isset($product_listing[0]['replacement_available']) ? $product_listing[0]['replacement_available'] : '';
    $replacement_terms = isset($product_listing[0]['replacement_terms']) ? $product_listing[0]['replacement_terms'] : '';
    $return_available = isset($product_listing[0]['return_available']) ? $product_listing[0]['return_available'] : '';
    $return_policy = isset($product_listing[0]['return_policy']) ? $product_listing[0]['return_policy'] : '';
    $seller_offering = isset($product_listing[0]['seller_offering']) ? $product_listing[0]['seller_offering'] : '';
    $meta_keywords = isset($product_listing[0]['meta_keyword']) ? $product_listing[0]['meta_keyword'] : '';
    $meta_description = isset($product_listing[0]['meta_description']) ? $product_listing[0]['meta_description'] : '';
}
else
{
    $page_title = "Add Listing";

    $finance_available = isset($seller_default_values['finance_available']) ? $seller_default_values['finance_available'] : '';
    $finance_terms = isset($seller_default_values['finance_terms']) ? $seller_default_values['finance_terms'] : '';
    $home_delivery_available = isset($seller_default_values['home_delivery_available']) ? $seller_default_values['home_delivery_available'] : '';
    $home_delivery_terms = isset($seller_default_values['home_delivery_terms']) ? $seller_default_values['home_delivery_terms'] : '';
    $installation_available = isset($seller_default_values['installation_available']) ? $seller_default_values['installation_available'] : '';
    $installation_terms = isset($seller_default_values['installation_terms']) ? $seller_default_values['installation_terms'] : '';
    $replacement_available = isset($seller_default_values['replacement_available']) ? $seller_default_values['replacement_available'] : '';
    $replacement_terms = isset($seller_default_values['replacement_terms']) ? $seller_default_values['replacement_terms'] : '';
    $return_available = isset($seller_default_values['return_available']) ? $seller_default_values['return_available'] : '';
    $return_policy = isset($seller_default_values['return_policy']) ? $seller_default_values['return_policy'] : '';
    $seller_offering = isset($seller_default_values['seller_offering']) ? $seller_default_values['seller_offering'] : '';
    $meta_keywords = isset($seller_default_values['meta_keyword']) ? $seller_default_values['meta_keyword'] : '';
    $meta_description = isset($seller_default_values['meta_description']) ? $seller_default_values['meta_description'] : '';
}

$in_stock = isset($product_listing[0]['in_stock']) ? $product_listing[0]['in_stock'] : '';
$will_back_in_stock_on = isset($product_listing[0]['will_back_in_stock_on']) ? $product_listing[0]['will_back_in_stock_on'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Seller<small>Product Listing</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php if ($_COOKIE['site_code'] == 'admin') {  ?>
                <li><a href="<?= base_url('sellers/sellersList') ?>">Sellers</a></li>
            <?php } ?>
            <li><a href="<?= base_url('getAllProducts/'.$seller_id) ?>">Linked/Requested Products</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <i class="fa fa-chevron-down toggle-icon" data-toggle="collapse" data-target="#sellingInformationDiv" style="cursor:pointer;"></i>&nbsp;
                            <b>Selling Information</b>
                        </h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form method="post" action="<?= base_url('insertListingInfo') ?>" enctype="multipart/form-data" onsubmit="return validateForm()" id="sellingInformationDiv" class="collapse in">
                        
                        <input type="hidden" name="prd_id" value="<?= $product_id; ?>" />
                        <input type="hidden" name="merchant_id" value="<?= $seller_id; ?>" />
                        <input type="hidden" name="listing_id" value="<?= $listing_id; ?>" />
                        <input type="hidden" name="prd_id" value="<?= $product_id ?>">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-1">
                                    <label>Selling Price *:</label>
                                </div>
                                <div class="col-sm-2" style="padding-left: 0px;">
                                    <input type="number" class="form-control" placeholder="Enter Selling Price" name="sell_price" value="<?= $sell_price ?>" id="" required />
                                </div>
                            </div>

                            <div class="row nextFormLine">
                                <div class="col-sm-1" termsMainLabel>
                                    <label>In Stock:</label>
                                </div>
                                <div class="col-sm-1 termsAvailabilitySelectBox">
                                    <select class="form-control" name="in_stock" id="">
                                        <?php if ($page_title == "Edit Listing") {

                                            if ($in_stock == 0) {
                                                $value0 = 'selected="selected"';
                                                $value1 = '';
                                            } else {
                                                $value0 = '';
                                                $value1 = 'selected="selected"';
                                            }
                                        } else {
                                            $value0 = '';
                                            $value1 = 'selected="selected"';
                                        } ?>
                                        <option value="1" <?= $value1 ?> >Yes</option>
                                        <option value="0" <?= $value0 ?> >No</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 termsLabel">
                                    <label>Return On:</label>
                                </div>
                                <div class="col-sm-2 termsTextArea">
                                    <input type="date" class="form-control" name="back_in_stock" value="<?= $will_back_in_stock_on ?>" id="" />
                                </div>
                                <div class="col-sm-1" style="text-align: right; padding-right: 0px;">
                                    <label>Seller Offerings:</label>
                                </div>
                                <div class="col-sm-6">
                                    <textarea class="form-control" rows="2" name="seller_offering" placeholder="Enter Offering" id=""><?= $seller_offering ?></textarea>
                                </div>
                            </div>
                            
                            <a data-toggle="collapse" href="#service_Policy" aria-expanded="false" aria-controls="service_Policy">+ Service & Policy Options</a>
						
                            <!-- Collapsible content -->
                            <div class="collapse in" id="service_Policy">
                                <div class="well" style="padding: 5px 10px;">
                                    <div class="row nextFormLine">
                                        <div class="col-sm-1 termsMainLabel">
                                            <label>Finance Available:</label>
                                        </div>
                                        <div class="col-sm-1 termsAvailabilitySelectBox">
                                            <select class="form-control" name="finance_available" id="">
                                                <?php if ($finance_available == 0) {
                                                    $value0 = "selected";
                                                    $value1 = '';
                                                } else {
                                                    $value0 = '';
                                                    $value1 = "selected";
                                                } ?>
                                                <option value="0" <?= $value0 ?> >No</option>
                                                <option value="1" <?= $value1 ?> >Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 termsLabel">
                                            <label>Terms:</label>
                                        </div>
                                        <div class="col-sm-9 termsTextArea">
                                            <textarea class="form-control" rows="2" name="finance_terms" placeholder="Enter Finance Terms" id=""><?= $finance_terms ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row nextFormLine">
                                        <div class="col-sm-1 termsMainLabel">
                                            <label>Home Delivery:</label>
                                        </div>
                                        <div class="col-sm-1 termsAvailabilitySelectBox">
                                            <select class="form-control" name="home_delievery" id="">
                                                <?php if ($home_delivery_available == 0) {
                                                    $value0 = "selected";
                                                    $value1 = '';
                                                } else {
                                                    $value0 = '';
                                                    $value1 = "selected";
                                                } ?>
                                                <option value="0" <?= $value0 ?> >No</option>
                                                <option value="1" <?= $value1 ?> >Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 termsLabel">
                                            <label>Terms:</label>
                                        </div>
                                        <div class="col-sm-9 termsTextArea">
                                            <textarea class="form-control" rows="2" name="delievery_terms" placeholder="Enter Delivery Terms" id=""><?= $home_delivery_terms ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row nextFormLine">
                                        <div class="col-sm-1" termsMainLabel>
                                            <label>Installation Available:</label>
                                        </div>
                                        <div class="col-sm-1 termsAvailabilitySelectBox">
                                            <select class="form-control" name="installation_available" id="">
                                                <?php if ($installation_available == 0) {
                                                    $value0 = "selected";
                                                    $value1 = '';
                                                } else {
                                                    $value0 = '';
                                                    $value1 = "selected";
                                                } ?>
                                                <option value="0" <?= $value0 ?> >No</option>
                                                <option value="1" <?= $value1 ?> >Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 termsLabel">
                                            <label>Terms:</label>
                                        </div>
                                        <div class="col-sm-9 termsTextArea">
                                            <textarea class="form-control" rows="2" name="installation_terms" placeholder="Enter Installation Terms" id=""><?= $installation_terms ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row nextFormLine">
                                        <div class="col-sm-1" termsMainLabel>
                                            <label>Replacement Available:</label>
                                        </div>
                                        <div class="col-sm-1 termsAvailabilitySelectBox">
                                            <select class="form-control" name="replacement_available" id="">
                                                <?php if ($replacement_available == 0) {
                                                    $value0 = "selected";
                                                    $value1 = '';
                                                } else {
                                                    $value0 = '';
                                                    $value1 = "selected";
                                                } ?>
                                                <option value="0" <?= $value0 ?> >No</option>
                                                <option value="1" <?= $value1 ?> >Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 termsLabel">
                                            <label>Terms:</label>
                                        </div>
                                        <div class="col-sm-9 termsTextArea">
                                            <textarea class="form-control" rows="2" name="replacement_terms" id="" placeholder="Enter Replacement Terms"><?= $replacement_terms ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row nextFormLine">
                                        <div class="col-sm-1 termsMainLabel">
                                            <label>Return Available:</label>
                                        </div>
                                        <div class="col-sm-1 termsAvailabilitySelectBox">
                                            <select class="form-control" name="return_available" id="">
                                                <?php if ($return_available == 0) {
                                                    $value0 = "selected";
                                                    $value1 = '';
                                                } else {
                                                    $value0 = '';
                                                    $value1 = "selected";
                                                } ?>
                                                <option value="0" <?= $value0 ?> >No</option>
                                                <option value="1" <?= $value1 ?> >Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 termsLabel">
                                            <label>Terms:</label>
                                        </div>
                                        <div class="col-sm-9 termsTextArea">
                                            <textarea class="form-control" rows="2" name="return_policy" placeholder="Enter Return Terms" id=""><?= $return_policy ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($_COOKIE['site_code'] == 'admin') { ?>
                                <div class="row nextFormLine">
                                    <div class="col-sm-6">
                                        <label>Meta Keywords</label>
                                        <textarea class="form-control" rows="2" name="meta_keyword" placeholder="Meta Keywords" id=""><?= $meta_keywords ?></textarea>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <label>Meta Description</label>
                                        <textarea class="form-control" rows="2" name="meta_description" placeholder="Enter Seller Offering" id=""><?= $meta_description ?></textarea>
                                    </div>
                                </div>
                            <?php } ?>
                            
                            <div class="box-footer">
                                <a href='<?= base_url("getAllProducts/$seller_id") ?>' class='btn btn-default'>Cancel</a>
                                <button type="submit" class="btn btn-primary">Complete Linking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><b>Product Information</b></h3>
                    </div><!-- /.box-header -->
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Category</label>
                                <input class="form-control" value="<?= $category_name ?>" id="" readonly />
                            </div>
                            <div class="col-sm-3">
                                <label>Brand</label>
                                <input class="form-control" value="<?= $brand_name ?>" id="" readonly />
                            </div>
                            <div class="col-sm-3">
                                <label>Product Name</label>
                                <input class="form-control" value="<?= $product_name ?>" id="" readonly />
                            </div>
                            <div class="col-sm-3">
                                <label>Product MRP</label>
                                <input class="form-control" value="<?= $mrp_price ?>" id="" readonly />
                            </div>
                        </div>
                        
                        <div class="row nextFormLine">
                            <div class="col-sm-6">
                                <label>Product Description</label> 
                                <textarea class="form-control" rows="2" placeholder="Description Not Available" readonly id=""><?= $description ?></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label>In The Box</label>
                                <textarea class="form-control" rows="2" placeholder="In The Box Not Available" id="" readonly><?= $in_the_box ?></textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive editTable">
                                    <table class="table table-bordered dataTable">
                                        <thead>
                                            <tr>
                                                <th class="text-align-center" colspan="6">
                                                    Product Images
                                                    <i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#productImages_tableBody" style="cursor:pointer;"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody style="height: auto;" id="productImages_tableBody" class="collapse in">
                                            <tr>
                                            <?php echo renderImagesReadonly($images, $product_images_dir, $product_id); ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive editTable">
                                    <table class="table table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th colspan=2 class="text-align-center">
                                                    Product Attributes
                                                    <i class="fa fa-chevron-down toggle-icon" data-toggle="collapse" data-target="#att_fields" style="cursor:pointer;"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="collapse in" id="att_fields">
                                            <tr>
                                                <td>No Attribute Found</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="table-responsive editTable">
                                    <table class="table table-bordered dataTable">
                                        <thead>
                                            <tr>
                                                <th colspan="3" class="text-align-center">
                                                    Product varients
                                                    <i class="fa fa-chevron-down toggle-icon" data-toggle="collapse" data-target="#productVarients_tableBody" style="cursor:pointer;"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="productVarients_tableBody" class="collapse in">
                                            <?php if (isset($prd_varients) && $prd_varients) {
                                                foreach ($product_varients as $prd_vrnt_key => $prd_vrnt_values) {

                                                    echo "<tr>
                                                            <td>".$prd_vrnt_key."</td><td>";

                                                            foreach ($prd_vrnt_values as $vrnt_key => $vrnt_value) {

                                                                if ($vrnt_key != 0) {
                                                                    echo ", ";
                                                                }

                                                                echo $vrnt_value['att_value'];
                                                            }

                                                    echo "</td></tr>";
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="table-responsive editTable">
                                    <table class="table table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-align-center">
                                                    Product Features
                                                    <i class="fa fa-chevron-down toggle-icon"  data-toggle="collapse" data-target="#productFeatures_tableBody" style="cursor:pointer;"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="productFeatures_tableBody" class="collapse in">
                                            <?php
                                            if ($key_features) {

                                                foreach ($key_features['result'] as $feature_value) {

                                                    echo "<tr>
                                                        <td>
                                                            ".$feature_value['feature']."
                                                        </td>
                                                    </tr>";
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<script>
function getCategoryAttribtes(cat_id, prd_id) {

	$('#att_fields').empty();
	$('#divLoading').show();
    
    if (cat_id && prd_id) {

        $.ajax({
            type: "GET",
            url: '<?= base_url("categoryAttributes");?>/'+cat_id+'/'+prd_id,
            success: function(data){
                if (data) {

                    resp = JSON.parse(data);
                    fields = '';
                    
                    if(prd_id) {
                        
                        // remove not linked attributes from category
                        resp = resp.filter(function(item) {
                            return item.att_value !== "";
                        });
                    }

                    if (resp.length > 0) {

	    				for (var i = 0; i < resp.length; i += 4) {
                            fields += '<tr>';

                            // First attribute cell
                            if (resp[i] && resp[i].mp_id != null && resp[i].att_value) {
                                fields += '<td>' + resp[i].att_name +
                                        '<input type="text" class="form-control att_values" ' +
                                        'name="' + resp[i].att_id + '" ' +
                                        'placeholder="Enter ' + resp[i].att_name + ' value" ' +
                                        'value="' + resp[i].att_value + '" readonly /></td>';
                            } else {
                                fields += '<td></td>';
                            }

                            // Second attribute cell
                            if (resp[i+1] && resp[i+1].mp_id != null && resp[i+1].att_value) {
                                fields += '<td>' + resp[i+1].att_name +
                                        '<input type="text" class="form-control att_values" ' +
                                        'name="' + resp[i+1].att_id + '" ' +
                                        'placeholder="Enter ' + resp[i+1].att_name + ' value" ' +
                                        'value="' + resp[i+1].att_value + '" readonly /></td>';
                            } else {
                                fields += '<td></td>';
                            }

                            // Third attribute cell
                            if (resp[i+2] && resp[i+2].mp_id != null && resp[i+2].att_value) {
                                fields += '<td>' + resp[i+2].att_name +
                                        '<input type="text" class="form-control att_values" ' +
                                        'name="' + resp[i+2].att_id + '" ' +
                                        'placeholder="Enter ' + resp[i+2].att_name + ' value" ' +
                                        'value="' + resp[i+2].att_value + '" readonly /></td>';
                            } else {
                                fields += '<td></td>';
                            }

                            // Fourth attribute cell
                            if (resp[i+3] && resp[i+3].mp_id != null && resp[i+3].att_value) {
                                fields += '<td>' + resp[i+3].att_name +
                                        '<input type="text" class="form-control att_values" ' +
                                        'name="' + resp[i+3].att_id + '" ' +
                                        'placeholder="Enter ' + resp[i+3].att_name + ' value" ' +
                                        'value="' + resp[i+3].att_value + '" readonly /></td>';
                            } else {
                                fields += '<td></td>';
                            }

                            fields += '</tr>';
                        }

	    			}

					$('#att_fields').html(fields);
                }
            },
        });
    } else if(!cat_id) {
        alert('Could not found category id!');
        $('#divLoading').hide();
    } else if(!prd_id) {
        alert('Could not found product id!');
        $('#divLoading').hide();
    }
}

$(document).ready(function() {
    
    $('#divLoading').show();
    
    setTimeout(function(){
        $('#divLoading').hide();
    }, 3000);

    prd_id = <?= (!empty($product_id) ? json_encode($product_id) : '""'); ?>;
    cat_id = <?= (!empty($category_id) ? json_encode($category_id) : '""'); ?>;

    getCategoryAttribtes(cat_id, prd_id);
});

//check form validation
function validateForm() {

    //for sell price
    var sell_price = $('[name="sell_price"]').val();
    var prd_price = <?= $mrp_price ?>;
    var isValid = isNaN(sell_price);
    
    if(isValid) {

        alert('seller price must be in digit');
        return false;
    }

    if (parseInt(sell_price) > parseInt(prd_price)) {

        alert('seller price could not more then product price');
        return false;
    }
}
</script>

<style>
.thumbnail img {
    height:80px;
    float: left;
    margin: 10px;
}

.thumbnail {
    border: none;
    float: left;
    padding: 20px;
}
</style>
