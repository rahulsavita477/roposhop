<?php
$add_id = $add_con = $add_bus_day = $add_bus_hou = $add_line1 = $add_line2 = $add_land = $add_local = $add_pin = $add_state_id = $add_cnt_id = $add_lat = $add_lon = $add_city_id = '';

if (isset($user['address']) && is_array($user['address']) && count($user['address']) >0) 
{
    $add_id = $user['address']['address_id'];
    $add_con = $user['address']['contact'];
    $add_bus_day = $user['address']['business_days'];
    $add_bus_hou = $user['address']['business_hours'];
    $add_line1 = $user['address']['address_line_1'];
    $add_line2 = $user['address']['address_line_2'];
    $add_land = $user['address']['landmark'];
    $add_local = $user['address']['locality'];
    $add_pin = $user['address']['pin'];
    $add_state_id = $user['address']['state_id'];
    $add_cnt_id = $user['address']['country_id'];
    $add_lat = $user['address']['latitude'];
    $add_lon = $user['address']['longitude'];
    $add_city_id = $user['address']['city_id'];
}

$shop_name = $user['establishment_name'] ? $user['establishment_name'] : set_value('shop_name');
$shop_description = $user['description'] ? $user['description'] : set_value('description');
$business_days = $add_bus_day ? $add_bus_day : set_value('business_days');
$business_hours = $add_bus_hou ? $add_bus_hou : set_value('business_hours');
$add_line1 = $add_line1 ? $add_line1 : set_value('line1');
$add_line2 = $add_line2 ? $add_line2 : set_value('line2');
$add_land = $add_land ? $add_land : set_value('landmark');
$add_pin = $add_pin ? $add_pin : set_value('pin');
$add_lat = $add_lat ? $add_lat : set_value('lat');
$add_lon = $add_lon ? $add_lon : set_value('long');
$shop_contact = $add_con ? $add_con : set_value('contact');
$own_name = $user['first_name'] ? $user['first_name'] : set_value('first_name');
$own_contact = $user['contact'] ? $user['contact'] : set_value('own_contact');
?>

<body id="page-details" class="loaded">
<div class="container mb-3">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb mt-0">
                <li class="breadcrumb-item"><a href="<?= base_url('merchantLoginWithoutStep2Completion/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">Shop Info</a></li>
            </ol>
        </div>
        <!-- End .container -->
    </nav>
    <div class="alert alert-warning" role="alert" style="margin-bottom: 0px; padding: 0px;"><b>Warning :</b> Finish your profile to boost buyer confidence</div>
    <form 
        method="post" 
        action="<?= base_url('updateMerchant') ?>" 
        enctype="multipart/form-data" 
        onsubmit="return validateForm()"
    >
        <div class="row row-sm">
            <div class="col-md-6 pt-5 pb-5 pl-5 pr-5 mx-auto" style="padding: 5px !important;">
                <div class="bdr-d" style="padding: 10px;">
                    <div class="text-center">
                        <h3 style="margin-bottom: 0px;">SHOP ADDRESS</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for=""><b>Address Line 1 <sup>*</sup></b></label>
                        <input type="text" class="form-control" name="line1" placeholder="Address Line 1*" value="<?= $add_line1 ?>" id="" required />
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <label for=""><b>Country <sup>*</sup></b></label>
                            <select class="form-control" name="country_id" id="cnt_id" onchange="getState(this.value);" required>
                                <?php if ($countries) {

                                    echo "<option value=''>Please select country!!</option>";

                                    foreach ($countries as $cnt_value) 
                                    {
                                        if ($cnt_value['country_id'] == $add_cnt_id)
                                            $cnt_id_selected = 'selected="selected"';
                                        else
                                            $cnt_id_selected = "";

                                        echo "<option value='".$cnt_value['country_id']."' ".$cnt_id_selected.">".$cnt_value['name']."</option>";
                                    }
                                } else
                                    echo "<option>country not available!</option>";
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for=""><b>State <sup>*</sup></b></label>
                            <select class="form-control" name="state_id" onchange="getCity(this.value);" id="states" required></select>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <label for=""><b>City <sup>*</sup></b></label>
                            <select class="form-control" name="city_id" id="state_cities" required></select>
                        </div>

                        <div class="col-md-6">
                            <label for=""><b>Postal Code<sup>*</sup></b></label>
                            <input type="number" class="form-control" name="pin" placeholder="postal code" value="<?= $add_pin ?>" required />
                        </div>
                    </div>

                    <!-- Toggle button/link -->
                    <a class="btn btn-link" data-toggle="collapse" href="#additionalAddressDetails" aria-expanded="false" aria-controls="additionalAddressDetails">+ Better shop finding (Recommended)</a>
                    
                    <!-- Collapsible content -->
                    <div class="collapse" id="additionalAddressDetails">
                        <div class="well">
                            <div class="form-group">
                                <label for=""><b>Address Line 2</b></label>
                                <input type="text" class="form-control" name="line2" placeholder="Address Line 2" value="<?= $add_line2 ?>" />
                            </div>

                            <div class="form-group">
                                <label for=""><b>Landmark</b></label>
                                <input type="text" class="form-control" name="landmark" placeholder="Landmark" value="<?= $add_land ?>" />
                            </div>

                            <div class="form-group">
                                <label for=""><b>Shop Contact Number (for consumers)</b></label>
                                <input type="text" class="form-control" name="contact" placeholder="Shop contact number" value="<?= $shop_contact ?>" />
                            </div>

                            <div class="form-group">
                                <label for=""><b>Business Days</b></label>
                                <input type="text" class="form-control" name="business_days" placeholder="Business days" value="<?= $business_days ?>" />
                            </div>

                            <div class="form-group">
                                <label for=""><b>Business Hours</b></label>
                                <input type="text" class="form-control" name="business_hours" placeholder="Business hours" value="<?= $business_hours ?>" />
                            </div>  
                        </div>
                    </div>
                </div>
            </div>

            <div 
                class="col-md-6 pt-5 pb-5 pl-5 pr-5 mx-auto"
                style="padding: 5px !important;"
            >
                <div class="bdr-d" style="padding: 10px;">
                    <div class="text-center pb-0 mt-0">
                        <h3 style="margin-bottom: 0px;">SHOP DETAIL</h3>
                    </div>

                    <div class="form-group">
                        <label for=""><b>Establishment (Shop) Name <sup>*</sup></b></label>
                        <input type="text" class="form-control" id="" name="comp_name" value="<?= $shop_name ?>" placeholder="Shop name *" required />
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>
                                        <?php if (!empty($user['business_proof'])): ?>
                                            <a href='<?= $user['business_proof'] ?>' target='_blank'><i class='fa fa-paperclip text-secondary'></i> Click here to view uploaded Business Proof</a>
                                        <?php else: ?>
                                            <b>Business Proof</b>
                                            <!-- Tooltip icon -->
                                            <i class="fa fa-info-circle text-primary"
                                                data-toggle="tooltip"
                                                data-placement="right"
                                                title="Allowed Business proof: GST Certificate, Shop & Establishment License, Udhyog Aadhar, Trade Certificate / License, FSSAI Registration, Current Cheque."
                                            ></i>
                                            <b><sup>*</sup></b>
                                        <?php endif; ?>
                                    </td>

                                    <?php if (empty($user['business_proof'])) {
                                        echo '<td>
                                                <input type="file" name="file8" id="file8" required />
                                            </td>';
                                            // '<td>
                                            //     <img src="" id="srcfile8" />
                                            // </td>';
                                    } ?>
                                </tr>
                            </body>
                        </table>

                        <!-- Toggle button/link -->
                        <a class="btn btn-link" data-toggle="collapse" href="#additionalBrandingDetails" aria-expanded="false" aria-controls="additionalBrandingDetails">+ Improve Customer Trust (Recommended)</a>
                        
                        <!-- Collapsible content -->
                        <div class="collapse" id="additionalBrandingDetails">
                            <div class="well">
                                <table class="table table-striped">
                                    <body>
                                        <tr>
                                            <td>Shop Logo</td>

                                            <?php if ($user['merchant_logo']) {
                                                echo "<td>
                                                        <a href='".$user['merchant_logo']."' target='_blank'><i class='fa fa-paperclip text-secondary'></i></a>
                                                    </td>";
                                            } else {
                                                echo '<td>
                                                    <input type="file" name="file9" id="file9" accept="image/*" />
                                                </td>';
                                                // '<td>
                                                //     <img src="" id="srcfile9" />
                                                // </td>';
                                            } ?>
                                        </tr>

                                        <?php if (
                                            isset($user['shop_image']) && 
                                            is_array($user['shop_image']) && 
                                            count($user['shop_image']) > 0
                                        ) {
                                            $avl_shop_img_cnt = count($user['shop_image']);

                                            for ($i=1; $i <= $avl_shop_img_cnt; $i++) {
                                                
                                                $shop_img = $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$user['merchant_id'].'/'.$user['shop_image'][$i-1]['atch_url'];

                                                echo "<tr>
                                                    <td>Shop image".$i."</td>
                                                    <td>
                                                        <a href='".$shop_img."' target='_blank'><i class='fa fa-paperclip text-secondary'></i></a>
                                                    </td>
                                                </tr>";
                                            }
                                        } else {
                                            $avl_shop_img_cnt = 0;
                                        }

                                        for ($i=1; $i<7-$avl_shop_img_cnt; $i++)
                                        {
                                            $img_cnt = $i+$avl_shop_img_cnt;

                                            echo '<tr>
                                                <td>Shop image'.$img_cnt.'</td>
                                                <td>
                                                    <input type="file" name="file'.$img_cnt.'" id="file'.$img_cnt.'" accept="image/*" />
                                                </td>
                                            </tr>';
                                        } ?>
                                    </tbody>
                                </table>

                                <div class="form-group">
                                    <label for=""><b>Shop Description</b></label>
                                    <textarea class="form-control" style="min-height: auto !important;" name="description" placeholder="shop description" rows="1" id=""><?= $shop_description ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <button type="submit" class="btn btn-primary btn-block mt-1">save & continue</button>
                <div class="d-flex justify-content-center">
                    <a href="<?= base_url('merchantLoginWithoutStep2Completion/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>" class="btn btn-default">Skip for now?</a>
                </div>
            </div>
            
            <input type="hidden" name="user_id" value="<?= $this->uri->segment(2) ?>" />
            <input type="hidden" name="is_default_address" value="1" />
            <input type="hidden" name="merchant_id" value="<?= $this->uri->segment(3) ?>" />
            <input type="hidden" name="address_id" value="<?= $add_id ?>" />
            <input type="hidden" name="first_name" value="<?= $own_name ?>" />
            <input type="hidden" name="own_contact" value="<?= $own_contact ?>" />
            <input type="hidden" name="email" value="<?= $user['email'] ?>" />
        </div>
    </form>
</div>
</div>
<!-----container---->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
//remove image
function removeImage(image_no='')
{
    var output = document.getElementById("srcfile"+image_no);
    output.src = "";
    $("#removeButton"+image_no).remove();
    $("#file"+image_no).val('');
}

$(function() {
    $('img').on('click', function() {
        $('.enlargeImageModalSource').attr('src', $(this).attr('src'));
        $('#enlargeImageModal').modal('show');
    });

    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview, image_no='', isFile='') {
        if (input.files) 
        {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) 
            {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var output = document.getElementById(placeToInsertImagePreview);
                    var fileName = input.files[0]['name'];
                    var fileType = input.files[0]['type'];
                    var isValid = fileValidation(input.files[0]['name'], isFile);

                    var allowedFileTypes = 'JPG and PNG are allowed.';
                    if (isFile)
                        allowedFileTypes = 'PDF, '+allowedFileTypes;

                    if (!isValid)
                    {
                        //alert(fileName+' not allowed.');
                        alert(allowedFileTypes);
                        removeImage(image_no);
                        return;
                    }
                    else if (fileType.includes("image")) //if file type is image
                        output.src = reader.result;
                    else //if file has another extentions
                        output.src = '<?= ATTATCHMENT_LOGO ?>';

                    if(document.getElementById("removeButton"+image_no) == null)
                    {
                        $('<button type="button" class="btn btn-danger" id="removeButton'+image_no+'" onclick="removeImage('+image_no+');">Remove</button>').insertAfter("#"+placeToInsertImagePreview);
                    }
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    $('#file1').on('change', function() {
        $('.file1').empty();
        imagesPreview(this, 'srcfile1', 1);
    });

    $('#file2').on('change', function() {
        $('.file2').empty();
        imagesPreview(this, 'srcfile2', 2);
    });

    $('#file3').on('change', function() {
        $('.file3').empty();
        imagesPreview(this, 'srcfile3', 3);
    });

    $('#file4').on('change', function() {
        $('.file4').empty();
        imagesPreview(this, 'srcfile4', 4);
    });

    $('#file5').on('change', function() {
        $('.file5').empty();
        imagesPreview(this, 'srcfile5', 5);
    });

    $('#file6').on('change', function() {
        $('.file6').empty();
        imagesPreview(this, 'srcfile6', 6);
    });

    $('#file7').on('change', function() {
        $('.file7').empty();
        imagesPreview(this, 'srcfile7', 7);
    });

    $('#file8').on('change', function() {
        $('.file8').empty();
        imagesPreview(this, 'srcfile8', 8, true);
    });

    $('#file9').on('change', function() {
        $('.file9').empty();
        imagesPreview(this, 'srcfile9', 9);
    });
});

//get state of country
function getState(cnt_id)
{
    $('#states').empty();

    if (cnt_id) 
    {
        $.ajax({
            type: "GET",
            url: '<?= base_url("states") ?>/'+cnt_id,
            success: function(data){
                if ( data ) 
                {
                    $('#states').empty();
                    state_data = JSON.parse(data);
                    state_options = "<option value=''>Please select state!!</option>";
                    usr_state_id = <?= (!empty($add_state_id) ? json_encode($add_state_id) : '""'); ?>

                    for (var i = 0; i < state_data.length; i++) 
                    {
                        state_name = state_data[i].name;
                        state_id = state_data[i].state_id;
                        selected = "";

                        if (state_id == usr_state_id)
                            selected = "selected";

                        state_options += "<option value='"+state_id+"' "+selected+">"+state_name+"</option>";
                    }

                    $('#states').append(state_options);

                    state_id = $('#states').val();
                    if (parseInt(state_id)) 
                        getCity(state_id);
                }
            },
        }); 
    }
}

//get city of state
function getCity(state_id)
{
    $('#state_cities').empty();

    if (state_id) 
    {
        $.ajax({
            type: "GET",
            url: '<?= base_url("cities") ?>/'+state_id,
            success: function(data){
                if (data != "null") 
                {
                    $('#state_cities').empty();
                    city_data = JSON.parse(data);
                    city_options = "<option value=''>Please select city!!</option>";
                    usr_city_id = <?= (!empty($add_city_id) ? json_encode($add_city_id) : '""'); ?>

                    for (var i = 0; i < city_data.length; i++) 
                    {
                        city_name = city_data[i].name;
                        city_id = city_data[i].city_id;
                        selected = "";

                        if (usr_city_id == city_id)
                            selected = "selected";

                        city_options += "<option value='"+city_id+"' "+selected+">"+city_name+"</option>";
                    }

                    $('#state_cities').append(city_options);
                }
                else
                    alert('City not available for this state');
            },
        }); 
    }
}

$(document).ready(function() {
    cnt_id = $('#cnt_id').val();
    if (parseInt(cnt_id)) 
        getState(cnt_id);
});
</script>

<style type="text/css">
.file img, .file1 img, .file2 img, .file3 img, .file4 img, .file5 img, .file6 img, .file7 img, .file8 img{
    height: 50px;
    cursor: default;
}

.file img{
    margin: 2px;   
}

.span6 input[type="text"]{
    width: 90%;
    height: 27px;
}

.map input[type="text"]{
    width: 30%;
    height: 27px;
    margin: 10px;
}

.span6 textarea{
    width: 90%;
    height: 150px;
}

select{
    width: 90%;
}
</style>

<?php include dirname(__FILE__).'/../../js_form_validation.php'; ?>