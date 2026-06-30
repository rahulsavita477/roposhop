<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Category<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Categories</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <form method="post" action="<?= base_url('changeParentCategory') ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <!-- select sub category -->
                        <div class="row Category_search_add_div">
                            <div class="col-sm-8">
                                <div class="form-inline">
                                <label style="margin-right:10px;">Bulk Actions:</label>
                                <select class="form-control" name="parent_cat_id" style="margin-right:10px;">
                                    <?php if ($success) {
                                    echo "<option value='0'>Move selected to parent category</option>";
                                    foreach ($categories as $cat_value) {
                                        echo "<option value='".$cat_value['category_id']."'>".$cat_value['category_name']."</option>";
                                    }
                                    } else {
                                    echo "<option value='0'>No parent category available!</option>";
                                    } ?>
                                </select>
                                <button type="submit" class="btn btn-primary">Apply</button>
                                </div>
                            </div>

                            <div class="col-sm-4 text-right">
                                <a href="<?= base_url('page/addCategory');?>" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add New Category
                                </a>
                            </div>
                        </div>

                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped data-pagination-table">
                                <thead>
                                    <tr>
                                        <th>Bulk Action</th>
                                        <th>S.No.</th>
                                        <th>Category ID</th>
                                        <th>Category</th>
                                        <th>Parent Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($success) 
                                    {
                                        $count = 1;
                                        foreach ($categories as $cat_key => $cat_value) 
                                        {
                                            $cat_id = $cat_value['category_id'];
                                            echo "<tr>
                                                    <td>
                                                        <input type='checkbox' value='".$cat_id."' name='selected_sub_category_ids[]'>
                                                    </td>
                                                    <td>".$count++."</td>
                                                    <td>".$cat_value['category_id']."</td>
                                                    <td><a href='".base_url("editCategory/$cat_id/view")."'>".$cat_value['category_name']."</a></td>
                                                    <td>".$cat_value['parent_cat']."</td>
                                                    <td>
                                                        <a href='".base_url("editCategory/$cat_id/edit")."' title='Edit'><i class='fa fa-edit'></i></a>&nbsp;
                                                        <a href='".base_url("deleteCategory/$cat_id")."' onclick='return confirm(\"Are you sure?\")'title='Delete'><i class='fa fa-trash-o'></i></a>
                                                    </td>
                                                </tr>";
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    <form>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script type="text/javascript">
function validateForm() 
{
    //for sell price
    var parent_cat_id = $('[name="parent_cat_id"]').val();
    if(parent_cat_id == 0)
    {
        alert('please selct parent category');
        return false;
    }

    var isSelected = false;
    $('input[type=checkbox]:checked').each(function() {
        isSelected = true;
    });

    if (!isSelected) 
    {
        alert('please selct category');
        return false;
    }
}
</script>
