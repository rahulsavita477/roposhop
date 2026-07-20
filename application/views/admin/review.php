<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1><?= ucfirst($page_label) ?> Review<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= ucfirst($page_label) ?> Review Management</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped data-pagination-table">
                            <thead>
                                <tr>
                                    <!-- <th>S.No.</th>
                                    <th>Review ID</th> -->
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Review Description</th>
                                    <th>Rating</th>
                                    <th>Consumer Name&nbsp;&nbsp;&nbsp;</th>
                                    <?php if ($page_label == 'merchant') {
                                        echo "<th>Merchant Name</th>";
                                    } else {
                                        echo "<th>Product Name</th>";
                                    } ?>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php if ($reviews) {

                                    // $count = 0;
                            		// <td>".++$count."</td>
                                    // <td>".$review_id."</td>
                                    
                                    foreach ($reviews['result'] as $review_value) {

                                        $review_id = $review_value['review_id'];

                                        if ($page_label == 'merchant') {
                                            $name = $review_value['shop_name'];
                                        } else {
                                            $name = $review_value['product_name'];
                                        }
                                        
                                        if ($review_value['enabled']) {

                                            $current_status = "<span class='label label-danger'>HIDDEN</span>";
                                            $change_status = 0;

                                        } else {

                                            $current_status = "<span class='label label-success'>PUBLISHED</span>";
                                            $change_status = 1;
                                        }

                                        $stars = "";
                                        $rating_count = (int)$review_value['rating']; // Number safe karne ke liye integer cast kiya

                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating_count) {
                                                // Filled star (FontAwesome 4.0.3 format)
                                                $stars .= "<i class='fa fa-star' style='color: #f39c12; margin-right: 2px;'></i>";
                                            } else {
                                                // Empty star (Taaki total 5 stars ka frame hamesha dikhe)
                                                $stars .= "<i class='fa fa-star-o' style='color: #ccc; margin-right: 2px;'></i>";
                                            }
                                        }

                                        echo "<tr>
                                            <td>
                                                <div class='input-group input-group'>
                                                    <div class='input-group-btn'>
                                                        <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                        <ul class='dropdown-menu'>
                                                            <li>
                                                                <a href='".base_url("changeReviewStatus/$review_id/$change_status/$page_label")."' onclick='return confirm(\"Do you want to change the review status?\")' title='Change Status'><i class='fa fa-check-circle'></i>Change Status</a>
                                                            </li>
                                                            <li>
                                                                <a href='".base_url("editReview/$review_id/$page_label")."'title='Edit'><i class='fa fa-edit'></i>Edit</a>
                                                            </li>
                                                            <li>
                                                                <a href='".base_url("deleteReview/$review_id/$page_label")."'  onclick='return confirm(\"Are you sure?\")' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class='statusLabel'>".$current_status."</td>
                                            <td style='max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>
                                                <a href='".base_url("viewReview/$review_id/$page_label")."' title='".htmlspecialchars($review_value['review'])."'>".$review_value['review']."</a>
                                            </td>
                                            <td>".$stars."</td>
                                            <td>".$review_value['consumer_name']."</td>
                                            <td>".$name."</td>
                                            <td>".convert_to_user_date($review_value['create_date'])."</td>
                                            <td>".convert_to_user_date($review_value['update_date'])."</td>
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
