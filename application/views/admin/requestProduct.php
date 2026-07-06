<?php
$autosearch_brands_list = json_encode($brands['result']);
$request_id = isset($request_id) ? $request_id : '';
$product_id = isset($req_prd_id) ? $req_prd_id : '';
$listing_id = isset($req_lst_id) ? $req_lst_id : '';
$product_name = isset($product_name) ? $product_name : set_value('prd_name');
$brand_id = isset($brand_id) ? $brand_id : '';
$brand_name = isset($brand_name) ? $brand_name : set_value('brand_name');
$description = isset($description) ? $description : set_value('prd_desc');
$referance_link = isset($refer_link) ? $refer_link : set_value('referance_link');
$prd_mrp = isset($prd_price) ? $prd_price : set_value('prd_mrp');
$in_the_box = isset($in_the_box) ? $in_the_box : set_value('in_the_box');
$sell_price = isset($sell_price) ? $sell_price : set_value('sell_price');
$referance_link = isset($refer_link) ? $refer_link : set_value('referance_link');
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
                  
                  <form method="post" action="<?= base_url('addRequestedProduct') ?>" enctype="multipart/form-data" onsubmit="return validateForm()">

                        <input type="hidden" name="request_id" value="<?= $request_id ?>" />
                        <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                        <input type="hidden" name="listing_id" value="<?= $listing_id ?>" />
                        
                        <!-- left column -->
                        <div class="col-md-6">
                              <!-- general form elements -->
                              <div class="box box-primary">
                                    <div class="box-body">
                                          <!-- select category -->
                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Category*:</label>
                                                </div>
                                                <div class="col-sm-5">
                                                      <?php
                                                      if ($page_label == 'Add') 
                                                      {
                                                            $product_id = 0;
                                                            $page_label = "'add'";
                                                      }
                                                      else
                                                            $page_label = "'edit'";

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
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Product Name*:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                      <input class="form-control" name="prd_name" id="autosearch_product" placeholder="Enter product name..." type="text" value="<?= $product_name ?>" <?= ($disableProductDetailFrom ? 'disabled' : '') ?> required />
                                                      <?= MC_error_label('prd_name') ?>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-12">
                                                      <div class="alert alert-warning">Product name must be unique</div>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Brand Name*:</label>
                                                </div>
                                                <div class="col-sm-5">
                                                      <?php
                                                      if ($page_label == "'add'" || $brand_id) 
                                                      {
                                                            $other_div_style = 'style="display: none;"';
                                                            $brand_id_div_style = '';
                                                      }
                                                      else
                                                      {
                                                            $other_div_style = '';
                                                            $brand_id_div_style = 'style="display: none;"';
                                                      }

                                                      echo '<select class="form-control" name="brand_id" '.$brand_id_div_style.' '.($disableProductDetailFrom ? 'disabled' : '').'>
                                                            <option value="">select brand</option>
                                                            <option value="other">Not Available</option>';
                                                            
                                                            foreach ($brands['result'] as $brands_value) 
                                                            {
                                                                  $selected = $brands_value['id'] == $brand_id ? 'selected' : '';

                                                                  echo "<option value='".$brands_value['id']."' ".$selected.">".$brands_value['label']."</option>";
                                                            }
                                                      
                                                      echo "</select>";
                                                      ?>
                                                </div>

                                                <div class="other" <?= $other_div_style ?>>
                                                      <div class="col-sm-5">
                                                            <input type="text" id="autosearch_brand" name="brand_name" class="form-control" placeholder="Please enter brand name..." value="<?= $brand_name ?>" <?= ($disableProductDetailFrom ? 'disabled' : '') ?> />
                                                            <?= MC_error_label('brand_name') ?>
                                                      </div>
                                                      <?php if (!$disableProductDetailFrom): ?>
                                                      <div class="col-sm-4">
                                                            <button onclick="remove_brand_text_box()" class="btn btn-default" type="button">Show list</button>
                                                      </div>
                                                      <?php endif; ?>
                                                </div>
                                          </div>

                                          <div class="row form-group other" <?= $other_div_style ?>>
                                                <div class="col-sm-12">
                                                      <div class="alert alert-warning">Brand name must be unique</div>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Description:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                      <textarea class="form-control" rows="1" name="prd_desc" placeholder="Please enter product description ..." <?= ($disableProductDetailFrom ? 'disabled' : '') ?>><?= $description ?></textarea>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Reference Link:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                      <input type="text" name="referance_link" class="form-control" placeholder="Please enter reference link..."  value="<?= $referance_link ?>" <?= ($disableProductDetailFrom ? 'disabled' : '') ?> />
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Product MRP*:</label>
                                                </div>
                                                <div class="col-sm-5">
                                                      <input type="text" name="prd_price" class="form-control" placeholder="Please enter product price..." value="<?= $prd_mrp ?>" <?= ($disableProductDetailFrom ? 'disabled' : '') ?> required />
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-12">
                                                      <div class="alert alert-warning">Price should be in digit</div>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>In The Box:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                      <textarea class="form-control" rows="1" name="in_the_box" placeholder="What you have provided in the product box..." <?= ($disableProductDetailFrom ? 'disabled' : '') ?>><?= $in_the_box ?></textarea>
                                                </div>
                                          </div>

                                          <div class="box-body table-responsive">
                                                <table class="table table-bordered table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th colspan="3"><center>Product Images</center></th>
                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            <?php for ($i = 1, $j = 0; $i < 7; $i++, $j++) { ?>
                                                                  <tr>
                                                                        <?php if (!$disableProductDetailFrom): ?>
                                                                        <td>
                                                                              <div class="btn btn-primary btn-file">
                                                                                    <i class="fa fa-paperclip"></i> Image<?= $i ?>
                                                                                    <input type="file" name="file<?= $i ?>" id="file<?= $i ?>" accept="image/*" />
                                                                              </div>
                                                                        </td>
                                                                        <?php if ($page_label == "'edit'") {

                                                                              echo "<td>";
                                                                              if (isset($images[$j]))
                                                                              {
                                                                                    $img_src = $product_images_dir.'/'.$images[$j]['atch_url'];
                                                                                    
                                                                                    echo '<div class="thumbnail">
                                                                                                <figure>
                                                                                                      <img src="'.$img_src.'" />
                                                                                                      <center>
                                                                                                            <figcaption><a href="'.base_url().'deleteAttactchment/'.$images[$j]['atch_url'].'/editRequestedProduct/'.$request_id.'" class="btn btn-danger">DELETE</a></figcaption>
                                                                                                      </center>
                                                                                                </figure>
                                                                                          </div>

                                                                                          <input type="hidden" name="remove_img'.$i.'" value="'.$images[$j]['atch_url'].'" />';
                                                                              }
                                                                              echo "</td>";
                                                                        } ?>
                                                                        <td><div class="file<?= $i ?> thumbnail"></div></td>
                                                                        <?php endif; ?>

                                                                        <?php if ($page_label == "'edit'" && $disableProductDetailFrom) {

                                                                              echo "<td>";
                                                                              if (isset($images[$j]))
                                                                              {
                                                                                    $img_src = $product_images_dir.'/'.$images[$j]['atch_url'];
                                                                                    
                                                                                    echo '<div class="thumbnail">
                                                                                                <figure>
                                                                                                      <img src="'.$img_src.'" />
                                                                                                </figure>
                                                                                          </div>';
                                                                              }
                                                                              echo "</td>";
                                                                        } ?>
                                                                  </tr>
                                                            <?php } ?>
                                                      </tbody>
                                                </table>
                                          </div>

                                          <div class="form-group" id="att_fields" style="display: none;"></div>
                                    </div>
                              </div><!-- /.box -->
                        </div>   <!-- /.row -->

                        <!-- left column -->
                        <div class="col-md-6">
                              <!-- general form elements -->
                              <div class="box box-primary">
                                    <div class="box-header">
                                          <h3 class="box-title">Listing Detail</h3>
                                    </div><!-- /.box-header -->
                                          
                                    <div class="box-body">
                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Seller Price*:</label>
                                                </div>
                                                <div class="col-sm-5">
                                                      <input type="text" class="form-control" placeholder="Enter price..." name="sell_price" value="<?= $sell_price ?>" required/>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-12">
                                                      <div class="alert alert-warning">Price should be in digit and could not more over than product price</div>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Finance Available:</label>  
                                                </div>
                                                <div class="col-sm-5">
                                                      <select class="form-control" name="finance_available" required>
                                                            <?php 
                                                            if ($finance_available == 0)
                                                            {
                                                                  $value0 = "selected";
                                                                  $value1 = '';
                                                            }
                                                            else
                                                            {
                                                                  $value0 = '';
                                                                  $value1 = "selected";
                                                            }
                                                            ?>
                                                      <option value="0" <?= $value0 ?>>No</option>
                                                      <option value="1" <?= $value1 ?>>Yes</option>
                                                      </select>       
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Finance Terms:</label>    
                                                </div>
                                                <div class="col-sm-8">
                                                      <textarea class="form-control" rows="1" name="finance_terms" placeholder="Please enter finance terms..."><?= $finance_terms ?></textarea>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Home Delievery:</label> 
                                                </div>
                                                <div class="col-sm-5">
                                                      <select class="form-control" name="home_delievery" required>
                                                            <?php 
                                                            if ($home_delivery_available == 0)
                                                            {
                                                                  $value0 = "selected";
                                                                  $value1 = '';
                                                            }
                                                            else
                                                            {
                                                                  $value0 = '';
                                                                  $value1 = "selected";
                                                            }
                                                            ?>
                                                            <option value="0" <?= $value0 ?>>No</option>
                                                            <option value="1" <?= $value1 ?>>Yes</option>
                                                      </select>       
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Home Delievery Terms:</label>    
                                                </div>
                                                <div class="col-sm-8">
                                                      <textarea class="form-control" rows="1" name="delievery_terms" placeholder="Please enter delievery terms..."><?= $home_delivery_terms ?></textarea>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Installation Available:</label> 
                                                </div>
                                                <div class="col-sm-5">
                                                      <select class="form-control" name="installation_available" required>
                                                            <?php 
                                                            if ($installation_available == 0)
                                                            {
                                                                  $value0 = "selected";
                                                                  $value1 = '';
                                                            }
                                                            else
                                                            {
                                                                  $value0 = '';
                                                                  $value1 = "selected";
                                                            }
                                                            ?>
                                                            <option value="0" <?= $value0 ?>>No</option>
                                                            <option value="1" <?= $value1 ?>>Yes</option>
                                                      </select>       
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Installation Terms:</label>  
                                                </div>
                                                <div class="col-sm-8">
                                                      <textarea class="form-control" rows="1" name="installation_terms" placeholder="Please enter installation terms..."><?= $installation_terms ?></textarea>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>In Stock*:</label>   
                                                </div>
                                                <div class="col-sm-5">
                                                      <select class="form-control" name="in_stock">
                                                            <?php 
                                                            if ($page_label == "Edit") 
                                                            {
                                                                  if ($in_stock == 0)
                                                                  {
                                                                        $value0 = 'selected="selected"';
                                                                        $value1 = '';
                                                                  }
                                                                  else
                                                                  {
                                                                        $value0 = '';
                                                                        $value1 = 'selected="selected"';
                                                                  }
                                                            }
                                                            else
                                                            {
                                                                  $value0 = '';
                                                                  $value1 = 'selected="selected"';
                                                            }
                                                            ?>
                                                            <option value="0" <?= $value0 ?>>No</option>
                                                            <option value="1" <?= $value1 ?>>Yes</option>
                                                      </select>       
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Available Back in stock on:</label>   
                                                </div>
                                                <div class="col-sm-5">
                                                      <input type="date" class="form-control" name="back_in_stock" value="<?= $will_back_in_stock_on ?>" />
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Replacement Available:</label>  
                                                </div>
                                                <div class="col-sm-5">
                                                      <select class="form-control" name="replacement_available" required>
                                                            <?php 
                                                            if ($replacement_available == 0)
                                                            {
                                                                  $value0 = "selected";
                                                                  $value1 = '';
                                                            }
                                                            else
                                                            {
                                                                  $value0 = '';
                                                                  $value1 = "selected";
                                                            }
                                                            ?>
                                                            <option value="0" <?= $value0 ?>>No</option>
                                                            <option value="1" <?= $value1 ?>>Yes</option>
                                                      </select>       
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Replacement Terms:</label>   
                                                </div>
                                                <div class="col-sm-8">
                                                      <textarea class="form-control" rows="1" name="replacement_terms" placeholder="Please enter replacement terms..."><?= $replacement_terms ?></textarea>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Return Available:</label>   
                                                </div>
                                                <div class="col-sm-5">
                                                      <select class="form-control" name="return_available" required>
                                                            <?php 
                                                            if ($return_available == 0)
                                                            {
                                                                  $value0 = "selected";
                                                                  $value1 = '';
                                                            }
                                                            else
                                                            {
                                                                  $value0 = '';
                                                                  $value1 = "selected";
                                                            }
                                                            ?>
                                                            <option value="0" <?= $value0 ?>>No</option>
                                                            <option value="1" <?= $value1 ?>>Yes</option>
                                                      </select>       
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Return Terms:</label>    
                                                </div>
                                                <div class="col-sm-8">
                                                      <textarea class="form-control" rows="1" name="return_policy" placeholder="Please enter return terms..."><?= $return_policy ?></textarea>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Seller Offerings:</label>    
                                                </div>
                                                <div class="col-sm-8">
                                                      <textarea class="form-control" rows="1" name="seller_offering" placeholder="Please enter offering..."><?= $seller_offering ?></textarea>
                                                </div>
                                          </div>

                                          <div class="box-footer" align="right" style="clear: both;">
                                                <a href="<?= base_url('page/merchantRequestedProducts') ?>" class="btn btn-default">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                          </div>
                                    </div>
                              </div><!-- /.box -->
                        </div>   <!-- /.row -->
                  </form>
            </section><!-- /.content -->
      </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
	prd_id = <?= (!empty($product_id) ? json_encode($product_id) : '""'); ?>;
      page_label = <?= (!empty($page_label) ? json_encode($page_label) : '""'); ?>;
	disableProductDetailFrom = <?= (!empty($disableProductDetailFrom) ? json_encode($disableProductDetailFrom) : '""'); ?>;

      if (prd_id) 
      {
            if (page_label == "view") 
                  cat_id = parseInt($("#par_cat_id").val());
            else
                  cat_id = $("[name='parent_cat_id'] option:selected").val();

            if (cat_id && cat_id != 0)
            {
                  setTimeout(function(){
                        getCategoryAttribtes(cat_id, prd_id, page_label, disableProductDetailFrom);
                  }, 2000);
            }
      }

      $('[name="brand_id"]').change(function() {
            $('.other').css('display', ($(this).val() == 'other') ? 'block' : 'none');
            $('[name="brand_id"]').css('display', ($(this).val() == 'other') ? 'none' : 'block');
      });
});

function getCategoryAttribtes(cat_id, prd_id=0, page_label, disableProductDetailFrom=false)
{
      $('#open_att_modal').prop('disabled', true);
      $('#submit_btn').prop('disabled', false);
      $('#att_fields').empty();
      $('#divLoading').show();

      if (cat_id)
      {
            $.ajax({
              type: "GET",
              url: '<?= base_url("categoryAttributes") ?>/'+cat_id+'/'+prd_id,
              success: function(data){
                  if (data)
                  {
                        resp = JSON.parse(data);
                        fields = '';
                        
                        if (resp.length > 0)
                        {
                              fields += '<table class="table table-bordered table-striped dataTable"><tr><th colspan=2><center>Product attributes</center></th></tr>';

                              for (var i = 0; i < resp.length; i++)
                              {
                                    if (resp[i].mp_id != null)
                                    {
                                          $('#open_att_modal').prop('disabled', false);
                                    
                                          att_id = resp[i].att_id;
                                          att_name_label = resp[i].att_name;
                                          att_val = '';
                                          if (page_label != "add") 
                                          {
                                                att_val = resp[i].att_value;
                                                if (att_val == null)
                                                      att_val = '';
                                          }

                                          fields += '<tr><td>'+att_name_label+'</td>';

                                    if (page_label == "view")
                                          fields += '<td>'+att_val+'</td>';
                                    else
                                          fields += '<td>'+
                                                      '<input type="text" name="'+att_id+'" class="form-control att_values" placeholder="Enter '+att_name_label+'..." value="'+att_val+'" '+(disableProductDetailFrom ? 'disabled' : '')+' />'+
                                                '</td><tr>';
                                    }
                              }

                              fields += '</table>'
                        }

                        $('#att_fields').append(fields);
                        $('#att_fields').show();
                  }

                  $('#divLoading').hide();
              },
          });     
      }
      else
      {
            alert('Could not found category id!');
            $('#divLoading').hide();
      }
}  

function remove_brand_text_box()
{
      $('.other').css('display', 'none');
      $('[name="brand_id"]').css('display', 'block');
      $('[name="brand_id"]').val('');
}

//check form validation
function validateForm() 
{
      //for product price
      var prd_price = $('[name="prd_price"]').val();
      var isValid = isNaN(prd_price);
      if(isValid)
      {
            alert('price must be in digit');
            return false;
      }

      //for sell price
      var sell_price = $('[name="sell_price"]').val();
      var isValid = isNaN(sell_price);
      if(isValid)
      {
            alert('seller price must be in digit');
            return false;
      }

      if (parseInt(sell_price) > parseInt(prd_price)) 
      {
            alert('seller price could not more then product price');
            return false;
      }

      //check product name existance
      var product_id = $('[name="product_id"]').val();
      var product_name = $('[name="prd_name"]').val();
      var isValid = checkProductExistance(product_id, product_name);
      if (isValid)
      {
            alert('product already available');
            return false;
      }

      //check brand is set or not and existance
      var brand_name = $('[name="brand_name"]').val();
      var brand_id = $('[name="brand_id"]').val();

      if (brand_id == '' && brand_name == '')
      {
            alert('brand not found');
            return false;
      }
      else if (brand_id == 'other' && brand_name != '')
      {
            var isValid = checkBrandExistance(brand_name);

            if (isValid)
            {
                  alert('Brand name you typed is already exist, please select it from brand list, or type a different name');
                  return false;
            }
      }
}
</script>

<style type="text/css">
.thumbnail img {
      height:50px;
      float: left;
}

.thumbnail {
      border: none;
      float: left;
      margin-bottom: 0;
}
</style>