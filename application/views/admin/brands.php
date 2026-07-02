<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Brand
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Brands</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-sm-12" style="margin: 10px 0px;padding-right: 10px;">
                        <a href="<?= base_url('page/addBrand');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Brand</a>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <!-- <th>S.NO.</th>
                                    <th>Brand ID</th> -->
                                    <th>Action</th>
                                    <th>Brand</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                                // <td>".$count++."</td>
                                // <td>".$brand_id."</td>

                            	if ($success) {

                                    // $count = 1;
                            		
                                    foreach ($data as $brand_key => $brand_value) {

                                        $brand_id = $brand_value['brand_id'];

                                        echo "<tr>
                                                <td>
                                                    <div class='input-group input-group'>
                                                        <div class='input-group-btn'>
                                                            <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                            <ul class='dropdown-menu'>
                                                                <li>
                                                                    <a href='".base_url("editBrand/$brand_id/edit")."'title='Edit'><i class='fa fa-edit'></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href='".base_url("deleteBrand/$brand_id")."'  onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>
                                                                </li>";
                                                        echo "</ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href='".base_url("editBrand/$brand_id/view")."'>".$brand_value['name']."</a>
                                                </td>
                                                <td>".convert_to_user_date($brand_value['create_date'])."</td>
                                                <td>".convert_to_user_date($brand_value['update_date'])."</td>
                                            </tr>";
                                    }
                            	} ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
