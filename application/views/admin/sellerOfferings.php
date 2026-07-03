<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller
            <small>Offerings</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Offerings</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
                    <div class="box-body">
                        <!-- form start -->
                        <?= form_open('updateSellerServicePolicy') ?>                        
                            <button type="button" class="btn btn-warning pull-right" onclick="createSellerOfferingField()">
                                <i class="fa fa-plus"></i> Add seller offering
                            </button>
                            <div class="row form-group">
                                <div class="col-sm-8" id="seller_offering_input_field_div">

                                </div>
                            </div>

                            <div class="box-footer text-right" style="display: none;" id="sellerOfferingsFormButtons">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        <?= form_close() ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>   <!-- /.row -->
        </div>
        
        <div class="row">
            <?php if ($merchant['seller_offering']) {

                foreach ($merchant['seller_offering'] as $seller_offering_value) {

                    $offering_id = $seller_offering_value['offering_id'];
                    $offering = $seller_offering_value['offering'];
                    $params = $offering_id.', "'.$offering.'", '.$merchant['merchant_id']; 
                    ?>
                    <div class="col-sm-3">
                        <div class="box box-primary1">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12 address">
                                        <a href='javascript:void(0)' onclick='open_seller_offering_modal(<?= $params ?>)' title='Edit'><i class='fa fa-edit'></i></a>&nbsp;
                                        <a href='<?= base_url("deleteSellerOffering/$offering_id/".$merchant['merchant_id']) ?>' onclick='return confirm("Are you sure?")' title='Delete'><i class='fa fa-trash-o'></i></a>
                                    </div>
                                    <div class="col-sm-12 address">
                                        <?= $offering ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
			} else {
                echo "No seller offerings found!";
            } ?>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- seller offering Modal -->
<div class="modal fade" id="sellerOfferingModal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Seller Offering</h4>
            </div>

            <?= form_open('addSellerOffering') ?>
                <div class="modal-body">
                    <input type='hidden' name='offering_id' id='offering_id'>
                    <input type='hidden' name='merchant_id' id='merchant_id'>

                    <div class='row form-group'>
                        <div class='col-sm-3'>
                            <label>Seller Offering:</label>
                        </div>
                        <div class='col-sm-9'>
                            <input type='text' name='offering' id='offering' class='form-control' required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<style type="text/css">
.address{
	margin: 5px;
}
</style>

<script>
var count1 = 1;

function createSellerOfferingField() {
    
    $('#seller_offering_input_field_div').append(
        '<div class="row" style="margin-top:10px;" id="con1'+count1+'">'+
            '<div class="col-sm-10">'+
                '<input type="text" class="form-control" name="seller_offering_values[]" placeholder="Enter Seller Offering" required/>' + 
            '</div>'+
            '<div class="col-sm-2">'+
                '<button type="button" class="btn btn-danger" id="btnRemove1'+count1+'" onclick="removeBtn(1'+count1+')">Remove</button>'+
            '</div>'+
        '</div>'
    );

    if (count1 > 0) {
        $('#sellerOfferingsFormButtons').show();
    }
    count1++;
};

function open_seller_offering_modal(offering_id, Offering, merchant_id) 
{
    $('#offering_id').val(offering_id);
    $('#offering').val(Offering);
    $('#merchant_id').val(merchant_id);
    $("#sellerOfferingModal").modal();
}

function removeBtn(id) 
{
    count1--;
	$('#con'+id).remove();
    if (count1 == 1) {
        $('#sellerOfferingsFormButtons').hide();
    }
}
</script>
