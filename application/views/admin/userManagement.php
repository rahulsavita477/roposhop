<?php 
$usr_type = isset($_GET['user_type']) ? $_GET['user_type'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            User
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="row" style="margin: 10px 0px 0px 10px;">
                        <div class="col-sm-1" style="padding-left: 0px;">
                            <label>Filter user:</label>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" id="user_type">
                                <option value="ALL">ALL USERS</option>
                                <option value="ADMIN" <?php if($usr_type == "ADMIN"){ echo 'selected="selected"'; } ?> >ADMIN</option>
                                <option value="BUYER" <?php if($usr_type == "BUYER"){ echo 'selected="selected"'; } ?> >CONSUMER</option>
                                <option value="SELLER" <?php if($usr_type == "SELLER"){ echo 'selected="selected"'; } ?> >SELLER</option>
                                <option value="TEST USER" <?php if($usr_type == "TEST USER"){ echo 'selected="selected"'; } ?> >TEST USER</option>
                                <option value="1" <?php if($usr_type == "1"){ echo 'selected="selected"'; } ?> >ACTIVE USER</option>
                                <option value="0" <?php if($usr_type == "0"){ echo 'selected="selected"'; } ?> >DEACTIVE USER</option>
                            </select>
                        </div>
                        <div class="col-sm-9">
                            <button class="btn btn-default" onclick="getFilteredUsers() ">Search</button>
                            <a href="<?= base_url('page/addUser') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New User</a> 
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <!-- <th>S.No.</th>
                                    <th>User ID</th> -->
                                    <th>Action</th>
                                    <th>status</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role(s)</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                                if ($users) 
                            	{
                                    $count=0;
                                    foreach ($users as $user) 
                            		{
                                        $usr_id = $user['userId'];
                                        $name = $user['first_name'];
                                        if ($user['status'])
                                        {
                                            $status = "<span class='label label-success'>Active</span>";
                                            $newStatus = 0;
                                        }
                                        else
                                        {
                                            $status = "<span class='label label-danger'>Not active</span>";
                                            $newStatus = 1;
                                        }
                                        
                                        $showAddressManagementButton = false;
                                        if ($user['roles']) 
                                        {
                                            $roles = "";
                                            $i = 0;

                                            foreach ($user['roles'] as $role) 
                                            {
                                                if ( $i > 0 )
                                                    $roles .= ",&nbsp;&nbsp;";

                                                $roles .= $role['type_name'];

                                                if ($role['type_name'] == "SELLER")
                                                    $showAddressManagementButton = true;

                                                $i++;
                                            }
                                        }
                                        else
                                            $roles = "-";

                                        if ($user['profile_image'])
                                            $profile_image = $user['profile_image'];
                                        else
                                            $profile_image = $this->config->item('site_url').'assets/admin/img/avatar3.png';

                                        // <td>".++$count."</td>
                                        // <td>".$usr_id."</td>
                                        // <img src=".$profile_image." width='60px' />
                                        echo "<tr>
                            					<td>
                                                    <div class='input-group input-group'>
                                                        <div class='input-group-btn'>
                                                            <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                            <ul class='dropdown-menu'>
                                                                <li>
                                                                    <a href='".base_url("changeUserStatus/$usr_id/$newStatus")."' onclick='return confirm(\"Are you sure?\")' title='Change Status'><i class='fa fa-check-circle'></i>Change status</a>
                                                                </li>
                                                                <li>
                                                                    <a href='".base_url("editUser/$usr_id?edit")."'title='Edit'><i class='fa fa-edit'></i>Edit</a>
                                                                </li>";

                                                                if ($usr_id != $_COOKIE['user_id']) {

                                                                    echo "<li>
                                                                        <a href='".base_url("deleteUser/$usr_id")."' onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>
                                                                    </li>";
                                                                }
                                                        echo "</ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>".$status."</td>
                                                <td>
                                                    <a href='".base_url("editUser/$usr_id?view")."'>".$name."</a>
                                                </td>
                                                <td>".$user['email']."</td>
                                                <td>".$roles."</td>
                                                <td>".convert_to_user_date($user['create_date'])."</td>
                                                <td>".convert_to_user_date($user['update_date'])."</td>
                            				</tr>";
                            		}
                            	} ?>
                            </tbody>
                        </table>
                        <?= form_close(); ?>
                    </div><!-- /.box-body -->
                </div>
            </div><!-- /.box -->
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script>
function getFilteredUsers() 
{
    type = document.getElementById('user_type');
    user_type = type.value;

    if (user_type) 
    {
        url = "<?= base_url('page/userManagement?user_type=') ?>"+user_type;
        location.href = url;
    }
}
</script>
