<!-- <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" /> -->

<script type="text/javascript">
$(document).ready(function() {
    //set default location
    if (getCookie('location') == '') 
        getCurrentLocation();
});

function url_title(name) 
{
    return name
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}

function sleep(ms) {
    // alert(ms);
    return new Promise(resolve => setTimeout(resolve, ms));
}

//get product detail
function getProduct(product_id) 
{
    let url = 'api/v1/product/'+product_id;

    return $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+url,
        success: function(data){
        },
    });
}

//all products of merchant (listing products)
function getProducts(n_page) 
{
    let n_limit = 15;
    let s_url = 'api/v1/products?limit='+n_limit+'&page='+n_page;

    //get selected values
    let s_searchText = $("#search_text").val();

    //sort order
    let s_orderby = $('#orderby').val();

    //check brands filter
    let brand = [];
    $.each($("input[name='brand_filter']:checked"), function(){
        brand.push($(this).val());
    });

    //check categories filter
    let category = [];
    $.each($("input[name='category_filter']:checked"), function(){
        category.push($(this).val());
    });

    if (category.length==0) 
        category = '<?= isset($a_child_category) ? json_encode($a_child_category) : json_encode(array()) ?>';
    else
        category = JSON.stringify(category);

    return $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+s_url,
        data: {
            search: s_searchText,
            orderby: s_orderby,
            categoryIds: category,
            brandIds: JSON.stringify(brand)
        },
        success: function(data){
        },
    });
}

//all products of merchant (listing products)
function getMerchantProducts(n_merchant_id, n_page) 
{
    let n_limit = 15;
    let s_url = 'api/v1/merchant/'+n_merchant_id+'/listings?limit='+n_limit+'&page='+n_page;

    //get selected values
    let s_searchText = $("#search_text").val();

    //sort order
    let s_orderby = $('#orderby').val();

    //check brands filter
    let brand = [];
    $.each($("input[name='brand_filter']:checked"), function(){
        brand.push($(this).val());
    });

    //check categories filter
    let category = [];
    $.each($("input[name='category_filter']:checked"), function(){
        category.push($(this).val());
    });

    return $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+s_url,
        data: {
            search: s_searchText,
            orderby: s_orderby,
            categoryIds: JSON.stringify(category),
            brandIds: JSON.stringify(brand)
        },
        success: function(data){
        },
    });
}

//all products of merchant (listing products)
function getMerchantAddress(n_merchant_id, n_page) 
{
    let n_limit = 15;
    let s_url = 'api/v1/merchants/'+n_merchant_id+'/address?limit='+n_limit+'&page='+n_page;
    let n_state_id = $('#state_id').val();
    let n_city_id = $('#state_cities').val();

    return $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+s_url,
        data: {
            cityId: n_city_id,
            stateId: n_state_id
        },
        success: function(data){
        },
    });
}

//get city of state
function setCities(state_id)
{
    $('#state_cities').empty();

    $.ajax({
        type: "POST",
        url: '<?= base_url("cities/") ?>'+state_id,
        success: function(data){
            if (data == 'null') 
            {
                $('#state_cities').css('display', 'none');
                return;
            }

            let city_data = JSON.parse(data);
            let city_options = "<option value='0'>--select city--</option>";

            for (var i = 0; i < city_data.length; i++) 
            {
                city_name = city_data[i].name;
                city_id = city_data[i].city_id;

                if (city_data[i].status == 1) 
                {
                    city_options += "<option value='"+city_id+"'>"+city_name+"</option>";
                }
            }

            $('#state_cities').append(city_options);
            $('#state_cities').css('display', 'block');
        },
    });
}

//get city of state
function getCity(city_id)
{
    if (city_id != 'null') 
    {
        return $.ajax({
            type: "POST",
            url: '<?= base_url("api/v1/city/") ?>'+city_id,
            success: function(data){
            },
        });
    }
}

function saveLocation()
{
    let n_state_id = $('#state_id').val();
    let n_city_id = $('#state_cities').val();
    let s_city_name = $( "#state_cities option:selected" ).text();

    if (n_state_id == 0 || n_city_id == 0 || n_city_id == 'null') 
    {
        alert("select state and city");
        return;
    }

    //set city detail
    $.when(getCity($("#state_cities").val())).done(function(city){        
        resp = JSON.parse(city);

        document.cookie = "latitude="+resp.result[0].latitude+";path=/";
        document.cookie = "longitude="+resp.result[0].longitude+";path=/";

        /*if (resp.result == null || resp.result == 'undefined' || resp.result.length == 0)
        {

        }*/
    });

    document.cookie = "city_id="+n_city_id+";path=/";
    document.cookie = "state_id="+n_state_id+";path=/";
    document.cookie = "location="+s_city_name+";path=/";
    document.cookie = "location_selection=manual;path=/";
    
    $("#location").html('<i class="fa fa-map-marker"></i> &nbsp; '+s_city_name);

    alert("location changed");
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');

    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];

        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function getCurrentLocation() 
{
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            let s_city_name = getCityName(latitude, longitude);

            document.cookie = "latitude="+latitude+";path=/";
            document.cookie = "longitude="+longitude+";path=/";
        });
    } 
}

function getCityName(lat, lng) {
    var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&key=AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI';

    $.getJSON(GEOCODING).done(function(location) {
        s_city_name = location.results[0].address_components[0].long_name;
        document.cookie = "location="+s_city_name+";path=/";
        document.cookie = "location_selection=default;path=/";

        $("#location").html('<i class="fa fa-map-marker"></i> &nbsp; '+s_city_name);

        // alert("location changed");
    })
}
</script>