<?php 
if ($category) 
{
    $category_options = '<option value="">-- select category --</option>';
    
    foreach ($category['result'] as $cat_value) 
    {
        $selected = '';
        
        if (isset($_GET['category_id']) && ($_GET['category_id'] == $cat_value['category_id'])) 
            $selected = 'selected';

        $category_options .= "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
    }
}
else
    $category_options = '<option value="">Category not available</option>';

if ($brands) 
{
    $brand_options = '<option value="">-- select brand --</option>';
    foreach ($brands['result'] as $brand_value) 
    {
        $selected = '';

        if( isset($_GET['brand_id']) && ($_GET['brand_id'] == $brand_value['brand_id']) )
            $selected = 'selected';

        $brand_options .= "<option value='".$brand_value['brand_id']."' ".$selected.">".$brand_value['name']."</option>";
    }
}
else
    $brand_options = '<option value="">Brand not available</option>';   
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Product
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Products</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="row" style="margin: 10px 0 10px 0;">
                        <div class="col-sm-11 Products_search_add_div">
                            <form method="get" action="<?= base_url('products') ?>" onsubmit="return validateForm()">
                                <div class="col-sm-3">
                                    <select class="form-control" name="category_id">
                                        <?= $category_options ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control" name="brand_id">
                                        <?= $brand_options ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary">Find product</button>
                                    <a href="<?= base_url('products') ?>" class='btn btn-default'>Remove filter</a>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-1">
                            <a href="<?= base_url('addProduct') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Product</a>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Status</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if ($data)
                            	{
                                    $count = 1;
                            		foreach ($data as $prd_value)
                            		{
                                        if ($prd_value['isEnabled'])
                                        {
                                            $status = "<span class='label label-success'>Enabled</span>";
                                            $newStatus = 0;
                                        }
                                        else
                                        {
                                            $status = "<span class='label label-danger'>Disabled</span>";
                                            $newStatus = 1;
                                        }

                                        $prd_id = $prd_value['product_id'];
                                        $cat_id = $prd_value['category_id'];
                                        
                                        // Below is the URL for product view in read only mode. But design need to be improve
                                        // <td><a href='".base_url("editProduct/$prd_id/view")."'>".$prd_value['product_name']."</a></td>
                                        
                                        echo "<tr>
                                                <td>".$prd_id."</td>
                            					<td class='statusLabel'>".$status."</td>
                                                <td>".$prd_value['product_name']."</td>
                                                <td>".$prd_value['category_name']."</td>
                                                <td>".$prd_value['brand_name']."</td>
                                                <td>".$prd_value['mrp_price']."</td>
                                                <td>
                                                    <a href='".base_url("editProduct/$prd_id/edit")."' title='Edit'><i class='fa fa-edit'></i></a>&nbsp;
                                                    <a href='".base_url("editProduct/$prd_id/duplicate")."' title='Create Duplicate Product'><i class='fa fa-copy'></i></a>&nbsp;
                                                    <a href='".base_url("changeProductStatus/$prd_id/$newStatus")."' onclick='return confirm(\"Do you want to change the product status?\")'title='Change Status'><i class='fa fa-check-circle'></i></a>&nbsp;
                                                    <a href='".base_url("deleteProduct/$prd_id")."' onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i></a>
                                                </td>
                            				</tr>";
                            		}
                            	} ?>
                            </tbody>
                        </table>
                        <?= form_close(); ?>
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    <!-- </div> -->
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script type="text/javascript">
function validateForm() 
{
    //for selected category
    var category_id = $('[name="category_id"]').val();
    var brand_id = $('[name="brand_id"]').val();
    if(category_id == '' && brand_id == '')
    {
        alert('please select category or brand');
        return false;
    }
}
</script>