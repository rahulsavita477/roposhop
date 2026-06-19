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

<div class="span12">
    <div class="row">
        <div class="span12">
            <div class="alert alert-warning" role="alert"><b>Warning :</b> Please complete your profile to start using your seller panel.</div>
        </div>
    </div>

    <div class="row">
        <form method="post" action="<?= base_url('updateMerchant') ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="span6">
                <div class="well">
                    <h3>SHOP DETAIL</h3><br/>
                    <input type="hidden" name="user_id" value="<?= $this->uri->segment(2) ?>" />
                    <input type="hidden" name="is_default_address" value="1" />
                    <input type="hidden" name="merchant_id" value="<?= $this->uri->segment(3) ?>" />

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Establishment (Shop) Name <sup>*</sup></b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="comp_name" placeholder="Shop name *" value="<?= $shop_name ?>" required />
                        </div>
                    </div>
                
                    <div class="box-body table-responsive">
                        <table class="table table-striped" style="color: #433f3f;">
                            <tbody>
                                <tr>
                                    <td>
                                        Business proof <sup>*</sup>
                                    </td>

                                    <?php
                                    if (!empty($user['business_proof']))
                                    {
                                        echo 
                                        "<td>
                                            <a href='".$user['business_proof']."' class='btn btn-success' target='_blank'>Preview</a>
                                        </td>";
                                    }
                                    else
                                    {
                                        echo 
                                        '<td>
                                            <input type="file" name="file8" id="file8" required />
                                        </td>
                                        <td>
                                            <img src="" id="srcfile8" />
                                        </td>';
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-warning" role="alert"><b>Allowed Business proof :</b> GST Certificate, Shop & Establishment License, Udhyog Aadhar, Trade Certificate / License, FSSAI Registration, Current Cheque.<br />Allowed File types: PDF, JPG and PNG.</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shop Logo</td>

                                    <?php
                                    if ($user['merchant_logo']) 
                                    {
                                        echo 
                                        "<td>
                                            <a href='".$user['merchant_logo']."' class='btn btn-success' target='_blank'>Preview</a>
                                        </td>";
                                    }
                                    else
                                    {
                                        echo 
                                        '<td>
                                            <input type="file" name="file9" id="file9" accept="image/*" />
                                        </td>
                                        <td>
                                            <img src="" id="srcfile9" />
                                        </td>';
                                    }
                                    ?>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-warning" role="alert"> Allowed file types JPG or PNG only.
                                        </div>
                                    </td>
                                </tr>

                                <?php 
                                if (
                                    isset($user['shop_image']) && 
                                    is_array($user['shop_image']) && 
                                    count($user['shop_image']) > 0
                                ) 
                                {
                                    $avl_shop_img_cnt = count($user['shop_image']);

                                    for ($i=1; $i <= $avl_shop_img_cnt; $i++) 
                                    { 
                                        $shop_img = $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$user['merchant_id'].'/'.$user['shop_image'][$i-1]['atch_url'];

                                        echo 
                                        "<tr>
                                            <td>Shop image".$i."</td>
                                            <td>
                                                <a href='".$shop_img."' class='btn btn-success' target='_blank'>Preview</a>
                                            </td>
                                        </tr>";
                                    }
                                }
                                else
                                    $avl_shop_img_cnt = 0;

                                for ($i=1; $i<7-$avl_shop_img_cnt; $i++)
                                {
                                    $img_cnt = $i+$avl_shop_img_cnt;

                                    echo 
                                    '<tr>
                                        <td>Shop image'.$img_cnt.'</td>
                                        <td>
                                            <input type="file" name="file'.$img_cnt.'" id="file'.$img_cnt.'" accept="image/*" />
                                        </td>
                                        <td>
                                            <img src="" id="srcfile'.$img_cnt.'" />
                                        </td>
                                    </tr>';
                                } ?>
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-warning" role="alert"> Allowed file types JPG or PNG only.
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Shop Description</b></label>
                        </div>
                        <div class="span6">
                            <textarea name="description" placeholder="shop description" cols="75"><?= $shop_description ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="well">
                    <h3>SHOP ADDRESS</h3><br/>
                    <input type="hidden" name="address_id" value="<?= $add_id ?>" />

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Address Line 1 <sup>*</sup></b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="line1" placeholder="Address Line 1*" value="<?= $add_line1 ?>" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Address Line 2</b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="line2" placeholder="Address Line 2" value="<?= $add_line2 ?>" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Landmark</b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="landmark" placeholder="Landmark" value="<?= $add_land ?>" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Country <sup>*</sup></b></label>
                        </div>
                        <div class="span6">
                            <select name="country_id" id="cnt_id" onchange="getState(this.value);" required>
                                <?php
                                if ($countries) 
                                {
                                    echo "<option value=''>Please select country!!</option>";

                                    foreach ($countries as $cnt_value) 
                                    {
                                        if ($cnt_value['country_id'] == $add_cnt_id)
                                            $cnt_id_selected = 'selected="selected"';
                                        else
                                            $cnt_id_selected = "";

                                        echo "<option value='".$cnt_value['country_id']."' ".$cnt_id_selected.">".$cnt_value['name']."</option>";
                                    }
                                }
                                else
                                    echo "<option>country not available!</option>";
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>State <sup>*</sup></b></label>
                        </div>
                        <div class="span6">
                            <select name="state_id" onchange="getCity(this.value);" id="states" required></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>City <sup>*</sup></b></label>
                        </div>
                        <div class="span6">
                            <select name="city_id" id="state_cities" required></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>PIN Code</b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="pin" placeholder="pin code" value="<?= $add_pin ?>"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Shop Contact Number (for consumers)</b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="contact" placeholder="Shop contact number" value="<?= $shop_contact ?>" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Business Days</b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="business_days" placeholder="Business days" value="<?= $business_days ?>" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Business Hours</b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="business_hours" placeholder="Business hours" value="<?= $business_hours ?>" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="span6">
                <div class="well">
                    <h3>OWNER DETAIL</h3><br/>
                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Owner's Full Name <sup>*</sup></b></label>
                        </div>
                        <div class="span6">
                            <input type="text" name="first_name" value="<?= $own_name ?>" placeholder="Full Name *" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Contact (Mobile) Number <sup>*</sup></b></label>
                        </div>
                        <div class="span6">
                            91<input type="text" name="own_contact" value="<?= $own_contact ?>" placeholder="Contact Number" required />
                        </div>
                        <div class="span5 alert alert-warning" role="alert">Mobile Number need to be exact 10 digits.</div>
                    </div>

                    <div class="row">
                        <div class="span6">
                            <label class="control-label"><b>Email</b></label>
                        </div>
                        <div class="span6">
                            <input type="text" value="<?= $user['email'] ?>" name="email" readonly />
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-striped" style="color: #433f3f;">
                            <tbody>
                                <tr>
                                    <td>Profile Picture</td>
                                    <td><input type="file" name="file7" id="file7" /></td>
                                    <td><img src="" id="srcfile7" /></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-warning" role="alert">Allowed file types JPG or PNG only.
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="well">
                    <h3>SHOP MAP LOCATION</h3><br/>
                    <div class="row">
                        <div class="span6">
                            <input type="text" name="lat" placeholder="latitude*" onkeyup="initialize();" value="<?= $add_lat ?>" id="lat" required />
                            <?= UC_error_label('lat') ?>
                        </div>

                        <div class="span6">
                            <input type="text" name="long" id="long"  value="<?= $add_lon ?>" placeholder="longitude*" onkeyup="initialize();" required />
                            <?= UC_error_label('long') ?>
                        </div>

                        <div class="span5">
                            <div class="alert alert-warning" role="alert">Only decimals are allowed for <b>Latitude </b> & <b>Longitude</b>.</div>
                        </div>

                        <div class="span6">
                            <button type="button" onclick="getLatLongFromAddress();" class="btn btn-primary">Get lat-long from address</button>
                            &nbsp;&nbsp;&nbsp; <span style="color: darkgray;">Or Select On Map Below</span><br /><br />
                        </div>
                    </div>
                    
                    <!-- google map -->
                    <center>
                        <div id="googleMap" style="width:90%;height:400px; margin: 20px;"></div>
                    </center>
                </div>

                <div class="row">
                    <div class="span6" align="right">
                        <a href="<?= base_url('merchantLoginSignup') ?>" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>  
</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->

<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <img src="" class="enlargeImageModalSource" style="width: 100%;">
            </div>
        </div>
    </div>
</div>

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

function getLatLongFromAddress() 
{
    geocoder = new google.maps.Geocoder();
    line1 = ($('[name="line1"]').val()) ? $('[name="line1"]').val()+', ' : '';
    line2 = ($('[name="line2"]').val()) ? $('[name="line2"]').val()+', ' : '';
    landmark = ($('[name="landmark"]').val()) ? $('[name="landmark"]').val()+', ' : '';
    country = ($("#cnt_id option:selected").html()) ? $("#cnt_id option:selected").html()+', ' : '';
    state = ($("#states option:selected").html()) ? $("#states option:selected").html()+', ' : '';
    city = ($("#state_cities option:selected").html()) ? $("#state_cities option:selected").html() : '';
    pin = ($('[name="pin"]').val()) ? '-'+$('[name="pin"]').val() : '';
    address = line1+line2+landmark+country+state+city+pin;
    
    //debugger;
    geocoder.geocode({'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            //get lat-long
            latitude = results[0].geometry.location.lat().toFixed(6);
            longitude = results[0].geometry.location.lng().toFixed(6);

            //set lat-long in text fields
            $('[name="lat"]').val(latitude);
            $('[name="long"]').val(longitude);

            //call map for map initialization
            initialize();
        } 
        else
            alert('Shop address fields are not valid, Please check them!');
    }); 
}

//initialize google map
function initialize() 
{
    var lat = ($('[name="lat"]').val()) ? $('[name="lat"]').val() : 22.7196;
    var long = ($('[name="long"]').val()) ? $('[name="long"]').val() : 75.8577;

    //set location on google map using lat long
    var myLatlng = new google.maps.LatLng(lat, long);
    var mapOptions = {
                        zoom: 15,
                        center: myLatlng,
                        draggable: true
                    }
    var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
    setMarkerOnClickMap(myLatlng, map);

    google.maps.event.addListener(map, 'click', function (e) {
        lat1 = (e.latLng.lat()).toFixed(6);
        long1 = (e.latLng.lng()).toFixed(6);

        $('[name="lat"]').val(lat1);
        $('[name="long"]').val(long1);

        setMarkerOnClickMap(e.latLng, map);
    });
}

var gmarkers = [];

//set marker on click map
function setMarkerOnClickMap(latLng, map) 
{
    //remove old markers from map
    for(i=0; i<gmarkers.length; i++)
        gmarkers[i].setMap(null);

    //set marker on google map
    var marker = new google.maps.Marker({
                    position: latLng
                });

    // To add the marker to the map, call setMap();
    marker.setMap(map);

    //push old marker in array
    gmarkers.push(marker);

    //show info window for address
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    //show address div on click marker
    showFormattedAddress((latLng.lat()), (latLng.lng()));
}

//show address div on click marker
function showFormattedAddress(lat, long) 
{
    infowindow = new google.maps.InfoWindow();
    latlng = new google.maps.LatLng(lat, long);
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) 
            infowindow.setContent(results[0].formatted_address);
    });
}

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

//check form validation
function validateForm() 
{
    //for owner mobile number
    var isValid = mobileValidation($("input[name='own_contact']").val());
    if (!isValid) 
    {
        alert("Contact (Mobile) Number is not valid!");
        return false;
    }

    //for address lat
    var isValid = floatValidation($("input[name='lat']").val());
    if (!isValid) 
    {
        alert("wrong latitude!");
        return false;
    }

    //for address long
    var isValid = floatValidation($("input[name='long']").val());
    if (!isValid) 
    {
        alert("wrong longitude!");
        return false;
    }
}

$(document).ready(function() {
    cnt_id = $('#cnt_id').val();
    if (parseInt(cnt_id)) 
        getState(cnt_id);
});
</script>

<style type="text/css">
img {
    cursor: zoom-in;
}

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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI&callback=initialize"></script>

<?php include dirname(__FILE__).'/../js_form_validation.php'; ?>