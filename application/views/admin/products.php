<?php 
if ($category) 
{
    $category_options = '<option value="">select category</option>';
    
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
    $brand_options = '<option value="">select brand</option>';
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
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <form method="get" action="<?= base_url('products') ?>" onsubmit="return validateForm()">
                                <div class="col-sm-3 input-field" style="padding-right: 5px;">
                                    <label>Category</label>
                                    <select class="form-control" name="category_id">
                                        <?= $category_options ?>
                                    </select>
                                </div>
                                
                                <div class="col-sm-3 input-field" style="padding-left: 0px; padding-right: 5px;">
                                    <label>Brand</label>
                                    <select class="form-control" name="brand_id">
                                        <?= $brand_options ?>
                                    </select>
                                </div> 

                                <div class="col-sm-3" style="padding-left: 0px;">
                                    <label class="label_hide">make space equal to label</label><br />
                                    <button class="btn btn-primary" type="submit">Find</button>
                                    <a href="<?= base_url('products') ?>" title="Reset Filter">
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-filter fa-stack-1x"></i>
                                            <i class="fa fa-times fa-stack-1x text-danger" style="margin-top: 6px; margin-left: 6px; font-size: 0.6em;"></i>
                                        </span>
                                    </a>
                                </div>
                            </form>

                            <div class="col-sm-3 input-field">
                                <label class="label_hide">make space equal to label</label><br />
                                <a href="<?= base_url('addProduct') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Product</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped data-pagination-table">
                    <thead>
                        <tr>
                            <!-- <th>Product ID</th> -->
                            <th>Action</th>
                            <th>Visibility Status</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data) {

                            // $count = 1;
                            // <td>".$prd_id."</td>

                            foreach ($data as $prd_value) {

                                if ($prd_value['isEnabled']) {

                                    $status = "<span class='label label-success'>ENABLED</span>";
                                    $newStatus = 0;
                                
                                } else {

                                    $status = "<span class='label label-danger'>DISABLED</span>";
                                    $newStatus = 1;
                                }

                                $prd_id = $prd_value['product_id'];
                                $cat_id = $prd_value['category_id'];
                                
                                // Below is the URL for product view in read only mode. But design need to be improve
                                
                                echo "<tr>
                                        <td>
                                            <div class='input-group input-group'>
                                                <div class='input-group-btn'>
                                                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                    <ul class='dropdown-menu'>
                                                        <li>
                                                            <a href='".base_url("changeProductStatus/$prd_id/$newStatus")."' onclick='return confirm(\"Do you want to change the product status?\")' title='Change Status'><i class='fa fa-check-circle'></i>Change Visibility</a>
                                                        </li>
                                                        <li>
                                                            <a href='".base_url("editProduct/$prd_id/duplicate")."' title='Create Duplicate Product'><i class='fa fa-copy'></i>Duplicate</a>
                                                        </li>
                                                        <li>
                                                            <a href='".base_url("editProduct/$prd_id/edit")."' title='Edit'><i class='fa fa-edit'></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href='".base_url("deleteProduct/$prd_id")."'  onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>
                                                        </li>";
                                                echo "</ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td class='statusLabel'>".$status."</td>
                                        <td><a href='".base_url("editProduct/$prd_id/view")."'>".$prd_value['product_name']."</a></td>
                                        <td>".$prd_value['category_name']."</td>
                                        <td>".$prd_value['brand_name']."</td>
                                        <td>".$prd_value['mrp_price']."</td>
                                        <td>".convert_to_user_date($prd_value['create_date'])."</td>
                                        <td>".convert_to_user_date($prd_value['update_date'])."</td>
                                    </tr>";
                            }
                        } ?>
                    </tbody>
                </table>
                <?= form_close(); ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</aside><!-- ./wrapper -->

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