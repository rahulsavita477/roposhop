<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Attribute
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Attributes</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-sm-12" style="margin: 10px 0px; padding-right: 10px;">
                        <a href="<?= base_url('page/addAttribute') ?>" class="btn btn-primary pull-right">
                            <i class="fa fa-plus"></i> Add New Attribute</a> 
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <!-- <th>S.NO.</th>
                                    <th>Attribute ID</th> -->
                                    <th>Action</th>
                                    <th>Attribute Name</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                                // <td>".$count++."</td>
                                // <td>".$att_value['att_id']."</td>

                            	if ($status) {

                                    // $count = 1;
                            		foreach ($attributes as $att_key => $att_value)
                            		{
                                        $att_id = $att_value['att_id'];

                                        echo "<tr>
                                                <td>
                                                    <div class='input-group input-group'>
                                                        <div class='input-group-btn'>
                                                            <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                            <ul class='dropdown-menu'>
                                                                <li>
                                                                    <a href='".base_url("editAttribute/$att_id")."'title='Edit'><i class='fa fa-edit'></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href='".base_url("deleteAttribute/$att_id")."'  onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>
                                                                </li>";
                                                        echo "</ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>".$att_value['att_name']."</td>
                                                <td>".convert_to_user_date($att_value['create_date'])."</td>
                                                <td>".convert_to_user_date($att_value['update_date'])."</td>
                                            </tr>";
                                    }
                            	} ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->