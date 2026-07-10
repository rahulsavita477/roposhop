<?php
$autosearch_brands_list = json_encode($brands['result']);
$request_id = isset($request_id) ? $request_id : '';
$product_id = isset($req_prd_id) ? $req_prd_id : '';
$listing_id = isset($req_lst_id) ? $req_lst_id : '';
$product_name = isset($product_name) ? $product_name : set_value('prd_name');
$brand_id = isset($brand_id) ? $brand_id : '';
$brand_name = isset($brand_name) ? $brand_name : set_value('brand_name');
$description = isset($description) ? $description : set_value('prd_desc');
$referance_link = isset($refer_link) ? $refer_link : set_value('refer_link');
$prd_mrp = isset($prd_price) ? $prd_price : set_value('prd_mrp');
$in_the_box = isset($in_the_box) ? $in_the_box : set_value('in_the_box');
$notes = isset($notes) ? $notes : set_value('notes');
$sell_price = isset($sell_price) ? $sell_price : set_value('sell_price');
$finance_terms = isset($finance_terms) ? $finance_terms : set_value('finance_terms');
$installation_terms = isset($installation_terms) ? $installation_terms : set_value('installation_terms');
$will_back_in_stock_on = isset($will_back_in_stock_on) ? $will_back_in_stock_on : set_value('back_in_stock');
$replacement_terms = isset($replacement_terms) ? $replacement_terms : set_value('replacement_terms');
$return_policy = isset($return_policy) ? $return_policy : set_value('return_policy');
$seller_offering = isset($seller_offering) ? $seller_offering : set_value('seller_offering');
$home_delivery_terms = isset($home_delivery_terms) ? $home_delivery_terms : set_value('delievery_terms');
$page_label = $request_id ? 'Edit' : 'Add';
$product_images_dir = $this->config->item('site_url').PRODUCT_ATTATCHMENTS_PATH.$product_id;

// Disable Product Detail form if logged in user is diffrent merchant
if(isset($merchant_id) && $merchant_id != $_COOKIE['merchant_id'] && $page_label == 'Edit') {
      $disableProductDetailFrom=true;
} else {
      $disableProductDetailFrom=false;
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Requested Product<small><?= $page_label ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('page/merchantRequestedProducts') ?>">Requested products</a></li>
            <li class="active"><?= $page_label ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <?php if ($this->session->flashdata('errors')): ?>
				<div class="col-md-12 pageErrorDiv">
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5><i class="fa fa-exclamation-triangle"></i> <strong>Your requested product has been saved, but please attention to the following details</strong></h5>
						<ul style="padding-left: 20px;">
							<?php foreach ($this->session->flashdata('errors') as $error) {
								echo "<li>".$error."</li>";
							}
							$this->session->unset_userdata('errors');
							?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
            
            <?php if ($this->session->flashdata('brandNameError')): ?>
				<div class="col-md-12 pageErrorDiv">
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php
                        echo $this->session->flashdata('brandNameError');
                        $this->session->unset_userdata('brandNameError');
                        ?>
					</div>
				</div>
			<?php endif; ?>

            <form method="post" action="<?= base_url('addRequestedProduct') ?>" enctype="multipart/form-data"
                onsubmit="return validateForm()">

                <input type="hidden" name="request_id" value="<?= $request_id ?>" />
                <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                <input type="hidden" name="listing_id" value="<?= $listing_id ?>" />

                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <!-- select category -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Category *</label>
                                    <?php if ($page_label == 'Add') {
										$product_id = 0;
										$page_label = "'add'";
									} else {
										$page_label = "'edit'";
									}

									echo '<select class="form-control" name="parent_cat_id" '.($disableProductDetailFrom ? 'disabled' : '').' onchange="getCategoryAttribtes(this.value, '.$product_id.', '.$page_label.');" required>';

										echo "<option value=''>select category</option>";

										foreach ($categories as $cat_key => $cat_value) 
										{
												$selected = $cat_value['category_id'] == $category_id ? 'selected' : '';

												echo "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
										}
									
									echo "</select>";
									?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Brand Name</label>
                                    <!-- Tooltip icon -->
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip"
                                        data-placement="right" title="Duplicate brand name not allowed"></i>*
                                    <?php if ($page_label == "'add'" || $brand_id) {
                                            $other_div_style = 'style="display: none; align-items: center; gap: 8px;"';
											$brand_id_div_style = '';
										} else {
											$other_div_style = 'style="display: flex; align-items: center; gap: 8px;"';
											$brand_id_div_style = 'style="display: none;"';
										}

									echo '<select class="form-control" name="brand_id" '.$brand_id_div_style.' '.($disableProductDetailFrom ? 'disabled' : '').'>
										<option value="">select brand</option>
										<option value="other">Not Available</option>';
										
										foreach ($brands['result'] as $brands_value) {

											$selected = $brands_value['id'] == $brand_id ? 'selected' : '';

											echo "<option value='".$brands_value['id']."' ".$selected.">".$brands_value['label']."</option>";
										}
									
									echo "</select>";
									?>

                                    <div class="other" <?= $other_div_style ?>>
										<input type="text" id="autosearch_brand" name="brand_name" class="form-control"
											placeholder="Enter Brand Name" value="<?= $brand_name ?>"
											<?= ($disableProductDetailFrom ? 'disabled' : '') ?> />

										<?php if (!$disableProductDetailFrom): ?>
											<a href="javascript:void(0);" onclick="remove_brand_text_box()" style="color:#666;">
												<i class="fa fa-times" title="Remove Input"></i>
											</a>
										<?php endif; ?>
									</div>
									<?= MC_error_label('brand_name') ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Product Name</label>
                                    <!-- Tooltip icon -->
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip"
                                        data-placement="right" title="Duplicate product name not allowed"></i>*
                                    <input class="form-control" name="prd_name" id="autosearch_product"
                                        placeholder="Enter Product Name" type="text" value="<?= $product_name ?>"
                                        <?= ($disableProductDetailFrom ? 'disabled' : '') ?> required />
                                    <?= MC_error_label('prd_name') ?>
                                </div>
                                <div class="col-sm-3">
                                    <label>Product MRP *</label>
                                    <input type="number" name="prd_price" class="form-control"
                                        placeholder="Enter Product Price" value="<?= $prd_mrp ?>"
                                        <?= ($disableProductDetailFrom ? 'disabled' : '') ?> id="" required />
                                </div>
                            </div>

                            <div class="row nextFormLine">
                                <div class="col-sm-3">
                                    <label>Selling Price</label>
                                    <!-- Tooltip icon -->
                                    <i class="fa fa-info-circle text-primary" data-toggle="tooltip"
                                        data-placement="right"
                                        title="Selling Price should not more over than Product MRP"></i>*
                                    <input type="number" class="form-control" placeholder="Enter Selling Price"
                                        name="sell_price" value="<?= $sell_price ?>" id="" required />
                                </div>
                                <div class="col-sm-3">
                                    <label>Product Description *</label>
                                    <textarea class="form-control" rows="1" name="prd_desc"
                                        placeholder="Enter Product Description"
                                        <?= ($disableProductDetailFrom ? 'disabled' : '') ?> id=""
                                        required><?= $description ?></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label>In The Box *</label>
                                    <textarea class="form-control" rows="1" name="in_the_box"
                                        placeholder="What You Are Providing In The Product Box"
                                        <?= ($disableProductDetailFrom ? 'disabled' : '') ?> id=""
                                        required><?= $in_the_box ?></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label>Notes</label>
                                    <textarea class="form-control" rows="1" name="notes"
                                        placeholder="Enter Notes"
                                        <?= ($disableProductDetailFrom ? 'disabled' : '') ?> id=""><?= $notes ?></textarea>
                                </div>
                            </div>

                            <?php if($request_id): ?>
                            <a data-toggle="collapse" href="#logistic_Offering" aria-expanded="false"
                                aria-controls="logistic_Offering">+ Product Logistic & Special Offering</a>

                            <div class="collapse in" id="logistic_Offering">
                                <div class="well" style="padding: 5px 10px;">
                                    <div class="row nextFormLine">
                                        <div class="col-sm-1 termsMainLabel">
                                            <label>In Stock</label>
                                            <select class="form-control" name="in_stock" id="">
                                                <?php if ($in_stock == 0) {
                                                    $value0 = 'selected="selected"';
                                                    $value1 = '';
                                                } else {
                                                    $value0 = '';
                                                    $value1 = 'selected="selected"';
                                                } ?>
                                                <option value="0" <?= $value0 ?>>No</option>
                                                <option value="1" <?= $value1 ?>>Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Return On</label>
                                            <input type="date" class="form-control" name="back_in_stock"
                                                value="<?= $will_back_in_stock_on ?>" id="" />
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Reference Link</label>
                                            <input type="text" name="refer_link" class="form-control"
                                                placeholder="Enter Reference Link" value="<?= $refer_link ?>"
                                                <?= ($disableProductDetailFrom ? 'disabled' : '') ?> id="" />
                                        </div>
                                        <div class="col-sm-5">
                                            <label>Seller Offerings</label>
                                            <textarea class="form-control" rows="1" name="seller_offering"
                                                placeholder="Enter Offering" id=""><?= $seller_offering ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive editTable">
                                        <table class="table table-bordered dataTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-align-center" colspan="6">
                                                        Product Images
                                                        <i class="fa fa-chevron-down toggle-icon" data-toggle="collapse"
                                                            data-target="#productImages_tableBody"
                                                            style="cursor:pointer;"></i>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody style="height: auto;" id="productImages_tableBody"
                                                class="collapse in">
                                                <tr>
                                                    <?php 
													$images = isset($images) ? $images : '';
													echo renderImages($images, $product_images_dir, $request_id, 'editRequestedProduct', 6); 
													?>
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
                                                        <i class="fa fa-chevron-down toggle-icon" data-toggle="collapse"
                                                            data-target="#att_fields" style="cursor:pointer;"></i>
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

                            <?php if($request_id): ?>
								<a data-toggle="collapse" href="#service_policy" aria-expanded="false"
									aria-controls="service_policy">+ Service & Policy Options</a>

								<div class="collapse in" id="service_policy">
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
													<option value="0" <?= $value0 ?>>No</option>
													<option value="1" <?= $value1 ?>>Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="finance_terms"
													placeholder="Enter Finance Terms" id=""><?= $finance_terms ?></textarea>
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
													<option value="0" <?= $value0 ?>>No</option>
													<option value="1" <?= $value1 ?>>Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="delievery_terms"
													placeholder="Enter Delivery Terms"
													id=""><?= $home_delivery_terms ?></textarea>
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
													<option value="0" <?= $value0 ?>>No</option>
													<option value="1" <?= $value1 ?>>Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="installation_terms"
													placeholder="Enter Installation Terms"
													id=""><?= $installation_terms ?></textarea>
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
													<option value="0" <?= $value0 ?>>No</option>
													<option value="1" <?= $value1 ?>>Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="replacement_terms" id=""
													placeholder="Enter Replacement Terms"><?= $replacement_terms ?></textarea>
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
													<option value="0" <?= $value0 ?>>No</option>
													<option value="1" <?= $value1 ?>>Yes</option>
												</select>
											</div>
											<div class="col-sm-1 termsLabel">
												<label>Terms:</label>
											</div>
											<div class="col-sm-9 termsTextArea">
												<textarea class="form-control" rows="2" name="return_policy"
													placeholder="Enter Return Terms" id=""><?= $return_policy ?></textarea>
											</div>
										</div>
									</div>
								</div>
                            <?php endif; ?>
                        </div>

                        <div class="box-footer text-align-right">
                            <a href="<?= base_url('page/merchantRequestedProducts') ?>"
                                class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div><!-- /.box -->
                </div> <!-- /.row -->
            </form>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<?php require_once('include/imageModel.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    prd_id = <?= (!empty($product_id) ? json_encode($product_id) : '""'); ?>;
    page_label = <?= (!empty($page_label) ? json_encode($page_label) : '""'); ?>;
    disableProductDetailFrom =
        <?= (!empty($disableProductDetailFrom) ? json_encode($disableProductDetailFrom) : '""'); ?>;

    if (prd_id) {
        if (page_label == "view")
            cat_id = parseInt($("#par_cat_id").val());
        else
            cat_id = $("[name='parent_cat_id'] option:selected").val();

        if (cat_id && cat_id != 0) {
            setTimeout(function() {
                getCategoryAttribtes(cat_id, prd_id, page_label, disableProductDetailFrom);
            }, 2000);
        }
    }

	$('[name="brand_id"]').change(function() {
        $('.other').css({
			'display': ($(this).val() == 'other') ? 'flex' : 'none',
		});

        $('[name="brand_id"]').css('display', ($(this).val() == 'other') ? 'none' : 'block');
    });
});

function getCategoryAttribtes(cat_id, prd_id = 0, page_label, disableProductDetailFrom = false) {
    // $('#open_att_modal').prop('disabled', true);
    // $('#submit_btn').prop('disabled', false);
    $('#att_fields').empty();
    $('#divLoading').show();

    if (cat_id) {

        $.ajax({
            type: "GET",
            url: '<?= base_url("categoryAttributes") ?>/' + cat_id + '/' + prd_id,
            success: function(data) {

                if (data) {

                    resp = JSON.parse(data);
                    fields = '';

                    // remove not linked attributes from category
                    resp = resp.filter(function(item) {
                        return item.mp_id !== null;
                    });

                    if (resp.length > 0) {

                        for (var i = 0; i < resp.length; i += 4) {
                            fields += '<tr>';

                            // First attribute cell
                            if (resp[i] && resp[i].mp_id != null) {
                                att_id = resp[i].att_id;
                                att_name_label = resp[i].att_name;
                                att_val = (page_label != "add" && resp[i].att_value) ? resp[i].att_value :
                                    '';

                                fields += '<td>' + att_name_label;
                                if (page_label == "view") {
                                    fields += '<br>' + att_val + '</td>';
                                } else {
                                    fields += '<br><input type="text" name="' + att_id +
                                        '" class="form-control att_values" ' +
                                        'placeholder="Enter ' + att_name_label + '..." value="' + att_val +
                                        '" ' +
                                        (disableProductDetailFrom ? 'disabled' : '') + ' /></td>';
                                }
                            } else {
                                fields += '<td></td>';
                            }

                            // Second attribute cell
                            if (resp[i + 1] && resp[i + 1].mp_id != null) {
                                att_id = resp[i + 1].att_id;
                                att_name_label = resp[i + 1].att_name;
                                att_val = (page_label != "add" && resp[i + 1].att_value) ? resp[i + 1]
                                    .att_value : '';

                                fields += '<td>' + att_name_label;
                                if (page_label == "view") {
                                    fields += '<br>' + att_val + '</td>';
                                } else {
                                    fields += '<br><input type="text" name="' + att_id +
                                        '" class="form-control att_values" ' +
                                        'placeholder="Enter ' + att_name_label + '..." value="' + att_val +
                                        '" ' +
                                        (disableProductDetailFrom ? 'disabled' : '') + ' /></td>';
                                }
                            } else {
                                fields += '<td></td>';
                            }

                            // Third attribute cell
                            if (resp[i + 2] && resp[i + 2].mp_id != null) {
                                att_id = resp[i + 2].att_id;
                                att_name_label = resp[i + 2].att_name;
                                att_val = (page_label != "add" && resp[i + 2].att_value) ? resp[i + 2]
                                    .att_value : '';

                                fields += '<td>' + att_name_label;
                                if (page_label == "view") {
                                    fields += '<br>' + att_val + '</td>';
                                } else {
                                    fields += '<br><input type="text" name="' + att_id +
                                        '" class="form-control att_values" ' +
                                        'placeholder="Enter ' + att_name_label + '..." value="' + att_val +
                                        '" ' +
                                        (disableProductDetailFrom ? 'disabled' : '') + ' /></td>';
                                }
                            } else {
                                fields += '<td></td>';
                            }

                            // Fourth attribute cell
                            if (resp[i + 3] && resp[i + 3].mp_id != null) {
                                att_id = resp[i + 3].att_id;
                                att_name_label = resp[i + 3].att_name;
                                att_val = (page_label != "add" && resp[i + 3].att_value) ? resp[i + 3]
                                    .att_value : '';

                                fields += '<td>' + att_name_label;
                                if (page_label == "view") {
                                    fields += '<br>' + att_val + '</td>';
                                } else {
                                    fields += '<br><input type="text" name="' + att_id +
                                        '" class="form-control att_values" ' +
                                        'placeholder="Enter ' + att_name_label + '" value="' + att_val +
                                        '" ' +
                                        (disableProductDetailFrom ? 'disabled' : '') + ' /></td>';
                                }
                            } else {
                                fields += '<td></td>';
                            }

                            fields += '</tr>';
                        }

                        fields += '</table>'
                    }

                    $('#att_fields').html(fields);
                }

                $('#divLoading').hide();
            },
        });
    } else {
        alert('Could not found category id!');
        $('#divLoading').hide();
    }
}

function remove_brand_text_box() {
    $('.other').css('display', 'none');
    $('[name="brand_id"]').css('display', 'block');
    $('[name="brand_id"]').val('');
}

//check form validation
function validateForm() {
    //for product price
    var prd_price = $('[name="prd_price"]').val();
    var isValid = isNaN(prd_price);
    if (isValid) {
        alert('price must be in digit');
        return false;
    }

    //for sell price
    var sell_price = $('[name="sell_price"]').val();
    var isValid = isNaN(sell_price);
    if (isValid) {
        alert('seller price must be in digit');
        return false;
    }

    if (parseInt(sell_price) > parseInt(prd_price)) {
        alert('seller price could not more then product price');
        return false;
    }

    //check product name existance
    var product_id = $('[name="product_id"]').val();
    var product_name = $('[name="prd_name"]').val();
    var isValid = checkProductExistance(product_id, product_name);
    if (isValid) {
        alert('product already available');
        return false;
    }

    //check brand is set or not and existance
    var brand_name = $('[name="brand_name"]').val();
    var brand_id = $('[name="brand_id"]').val();

    if (brand_id == '' && brand_name == '') {
        alert('brand not found');
        return false;
    } else if (brand_id == 'other' && brand_name != '') {
        var isValid = checkBrandExistance(brand_name);

        if (isValid) {
            alert('Brand name you typed is already exist, please select it from brand list, or type a different name');
            return false;
        }
    }
}
</script>

<style type="text/css">
.thumbnail img {
    height: 50px;
    float: left;
}

.thumbnail {
    border: none;
    float: left;
    margin-bottom: 0;
}
</style>