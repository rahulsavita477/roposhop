<?php 
$merchant_id = isset($merchant_id) ? $userId : $_GET['merchant_id'];
$user_id = isset($userId) ? $userId : $_GET['user_id'];
$address_id = isset($address_id) ? $address_id : '';
$lat = isset($latitude) ? $latitude : set_value('lat');
$long = isset($longitude) ? $longitude : set_value('long');
$pin = isset($pin) ? $pin : set_value('long');
$line1 = isset($address_line_1) ? $address_line_1 : set_value('line1');
$line2 = isset($address_line_2) ? $address_line_2 : set_value('line2');
$landmark = isset($landmark) ? $landmark : set_value('landmark');
$cnt_id = isset($country_id) ? $country_id : '';
$state_id = isset($state_id) ? $state_id : '';
$city_id = isset($city_id) ? $city_id : '';
$is_default_address = isset($is_default_address) ? $is_default_address : 0;
$contact = isset($contact) ? $contact : set_value('contact');
$business_days = isset($business_days) ? $business_days : set_value('business_days');
$business_hours = isset($business_hours) ? $business_hours : set_value('business_hours');
$merchant_id = isset($_GET['merchant_id']) ? $_GET['merchant_id'] : $_COOKIE['merchant_id'];

if (isset($page_label) && $page_label == "edit") 
    $page_title = 'Edit address';
else if (isset($page_label) && $page_label == "view") 
    $page_title = 'View address';
else
{
    $page_label = "add";
    $page_title = 'Add Address';
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller Address
            <small><?= ucfirst($page_label) ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php if ($_COOKIE['site_code'] == 'admin') { ?>
                <li><a href="<?= base_url('sellers/sellersTable') ?>">Seller Management</a></li>
            <?php } ?>
            <li><a href="<?= base_url('page/addressManagement?user_id='.$user_id.'&merchant_id='.$merchant_id) ?>">View address</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
				    <!-- form start -->
				    <form method="post" action="<?= base_url('addAddress') ?>" onsubmit="return validateForm()">
				    	<div class="box-body">

					    	<input type="hidden" name="address_id" value="<?= $address_id ?>" />
					    	<input type="hidden" name="user_id" value="<?= $user_id ?>" />
					    	<input type="hidden" name="is_default_address" value="<?= $is_default_address ?>" />
                            <input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />

                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Address Line 1 *</label>
                                    <textarea rows="1" name="line1" class="form-control" placeholder="Line1 Address" required><?= $line1 ?></textarea>
                                </div>

                                <div class="col-sm-4">
                                    <label>Line2 address</label>
                                    <textarea rows="1" name="line2" class="form-control" placeholder="Line2 Address"><?= $line2 ?></textarea>
                                </div>

                                <div class="col-sm-4">
                                    <label>Landmark</label>
                                    <textarea rows="1" name="landmark" class="form-control" placeholder="Landmark"><?= $landmark ?></textarea>
                                </div>
                            </div>
                            
		                    <div class="row nextFormLine">
                                <div class="col-sm-3">
                                    <label>Country *</label>
                                    <select class="form-control" name="country_id" id="cnt_id" onchange="getState(this.value);" required>
                                        <?php if ($countries) {

                                            echo "<option value=''>select country</option>";

                                            foreach ($countries['result'] as $cnt_value) {

                                                if ($cnt_value['country_id'] == $cnt_id) {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = "";
                                                }

                                                echo "<option value='".$cnt_value['country_id']."' ".$selected.">".$cnt_value['name']."</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Country not available</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label>State *</label>
                                    <div class="other" style="display: flex; align-items: center; gap: 8px;">
										<select class="form-control" name="state_id" onchange="getCity(this.value);" id="states" required></select>

										<a href="javascript:void(0);" onclick="getState();" title="Refresh States"><i class="fa fa-undo" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
                                </div>

                                <div class="col-sm-3">
                                    <label>City *</label>
                                    <div class="other" style="display: flex; align-items: center; gap: 8px;">
										<select class="form-control" name="city_id" id="state_cities" required></select>

										<a href="javascript:void(0);" onclick="getCity();" title="Refresh Cities"><i class="fa fa-undo" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
                                </div>

                                <div class="col-sm-3" style="padding-left: 0px;">
                                    <label>Postal Code *</label>
                                    <input type="number" name="pin" value="<?= $pin ?>" class="form-control" placeholder="Postal Code" required/>
                                </div>
		                    </div>

                            <div class="row nextFormLine">
                                <div class="col-sm-4">
                                    <label>Shop Contact Number</label>
                                    <input type="text" name="contact" class="form-control" placeholder="Shop Contact Number" value="<?= $contact ?>" />
                                </div>
                                <div class="col-sm-4">
                                    <label>Address Business Days</label>
                                    <input type="text" name="business_days" class="form-control" placeholder="Enter Company Business Days" value="<?= $business_days ?>" />
                                </div>
                                <div class="col-sm-4">
                                    <label>Address Business Hours</label>
                                    <input type="text" name="business_hours" class="form-control" placeholder="Enter Company Business Hours" value="<?= $business_hours ?>" />
                                </div>
                            </div>

                            <div class="row nextFormLine">
                                <div class="col-sm-2">
                                    <label>Latitude</label>
                                    <input type="number" step="any" name="lat" class="form-control" placeholder="Enter Latitude" onkeyup="initialize();" value="<?= $lat ?>" id="lat" required />
                                </div>
                                <div class="col-sm-2">
                                    <label>Longitude</label>
                                    <input type="number" step="any" name="long" id="long" class="form-control" placeholder="Enter Longitude" onkeyup="initialize();" value="<?= $long ?>" required />
                                </div>
                                <div class="col-sm-8">
                                    <label class="label_hide" style="width: 100%;">make space equal to label</label>
                                    <button type="button" onclick="getLatLongFromAddress();" class="btn btn-primary">Get Coordinates from Address</button>
                                    <span class="text-muted small">
                                        Or click anywhere on the map to select your location and fetch its coordinates.
                                    </span>
                                </div>
                            </div>

                            <!-- google map -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="googleMap" style="height:400px; margin-top: 10px;"></div>
                                </div>
                            </div>

                            <div class="box-footer" align="right">
                                <?php 
                                if ($_COOKIE['site_code'] == 'seller') 
                                    echo "<a href='".base_url().'page/addressManagement?user_id='.$_COOKIE['user_id'].'&merchant_id='.$_COOKIE['merchant_id']."' class='btn btn-default'>Cancel</a>";
                                else
                                    echo "<a href='../page/addressManagement?user_id=$user_id&merchant_id=$merchant_id' class='btn btn-default'>Cancel</a>";
                                ?>
					        	
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    </div>
				    </form>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        <div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<?php require_once('include/imageModel.php'); ?>

<script>
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

function validateForm() 
{
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

<script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAP_API_KEY ?>&callback=initialize"></script>
