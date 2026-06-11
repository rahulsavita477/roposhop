<style type="text/css">
 .widget .owl-carousel .owl-nav {
 position: absolute;
 top: -40px !important;
 right: 0.6rem !important;
 }
 button.owl-prev, button.owl-next{
 width: 20px !important;
 height: 20px !important;
 background:transparent !important;
 }
 a.text-active {
 color: #08c;
 }
 /*.rotate {
 -moz-transition: all .5s linear;
 -webkit-transition: all .5s linear;
 transition: all .5s linear;
 }*/
 .rotate.down {
 -moz-transform:rotate(180deg);
 -webkit-transform:rotate(180deg);
 transform:rotate(180deg);
 }
 #page-category .product-default img {
 height: 150px;
 width: auto;
 margin: 0 auto;
 }
 .featured-col {
 text-align: left;
 }
 .product-site{
 position: relative;
 }
 .rating-left {
 float: left;
 position: absolute;
 top: 5px;
 left: 5px;
 font-size: 10px;
 color: #fff;
 padding: 2px;
 z-index: 4;
 }
 .product-widget figure{
 margin-top:10px;
 }
 .featured-col a:hover{
 text-decoration: none;
 }
 a.text-deco:hover {
 text-decoration: none;
 }
 .product-site {
 color: #777;
 background: #fff;
 box-shadow: 0px 0px 3px #00000038;
 margin: 5px 10px;
 padding: 0px 4px;
 }
 .color-change {
 color: #08c !important;
 }
 .btn-primaryss {
 border: 1px solid #3364b0;
 height: 29px;
 border-radius: 0px 3px 3px 0px;
 position: absolute;
 right: 4px;
 width: 60px;
 height: 40px;
 background:#3364b0;
 color: #fff;
 }
 input.w-50{
 height: 40px
 }
 a.sorter-btn {
 margin-top: -10px;
 }
 input.w-50:focus{
 border: none;
 }
 select.form-control:not([size]):not([multiple]) {
 height: 40px;
 padding: 5px !important;
 }
</style>

<body id="page-details" class="loaded">
    <div class="page-wrapper">
        <main class="main">
<div class="container">
    <ol class="breadcrumb mt-0 mb-2">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('merchants/'.url_title($establishment_name, '-', true).'?merchant_id='.$merchant_id) ?>"><?= $establishment_name ?></a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">Addresses</a></li>
    </ol>

    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-3">
                    <div class="toolbox-item toolbox-sort">
                        <div class="select-custom">
                            <select id="state_id" class="form-control">
                                <option value="0">-- select state --</option>
                                <?php
                                foreach ($states as $state) 
                                {
                                    echo "<option value='".$state['state_id']."'>".$state['name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="toolbox-item toolbox-sort">
                        <div class="select-custom">
                            <select class="form-control" id="state_cities" style="display: none;"></select>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-md-4">
                    <label class="pt-2 float-left">Showing <span class="paging_count"></span> results</label>
                    <div class="layout-modes float-left">
                        <a href="category.php" class="layout-btn btn-grid active" title="Grid">
                            <i class="icon-mode-grid"></i>
                        </a>
                        <a href="category-list.php" class="layout-btn btn-list" title="List">
                            <i class="icon-mode-list"></i>
                        </a>
                    </div>
                </div> -->
            </div>
            
                <?php 
                $n_totalAddress = $totalAddress > 15 ? 15 : $totalAddress;

                for ($i=1; $i<=$n_totalAddress; $i++)
                { 
                    $lat = 0;
                    $long = 0;

                    echo '<div 
                        class="row" 
                        style="padding: 10px; 
                            border-bottom: 1px solid #ddd; 
                            margin-bottom: 35px;" 
                        id="address_div_'.$i.'"
                    >
                        <div class="col-lg-7" id="address'.$i.'"></div> 
                        <div class="col-lg-3" id="distance'.$i.'"></div>
                    </div>';
                } 
                ?>

            <nav class="toolbox toolbox-pagination mt-2">
                <div class="toolbox-item toolbox-show">
                    <label>Showing <span class="paging_count"></span> results</label>
                </div>
                <ul class="pagination" id="pagination">
                    <!-- <li class="page-item disabled">
                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                    </li> 
                    <li class="page-item"><span>...</span></li>
                    <li class="page-item"><a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a></li> -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<script type="text/javascript">
//get and set address listing data (function will call from parent page)
function getAndSetMerchantAddress(page) 
{
    //show loader
    $('#divLoading1').css('display', 'flex');

    for (var i = 1; i < 16; i++) 
        $("#address_div_"+i).css("display", "flex");

    //set data in products page
    $.when(getMerchantAddress("<?= $merchant_id ?>", page)).done(function(addresses){        
        resp = JSON.parse(addresses);
        
        if (resp.addresses == null || resp.addresses == 'undefined' || resp.addresses.length == 0)
        {
            for (var i = 1; i < 16; i++) 
                $("#address_div_"+i).css("display", "none");

            //hide loader
            $('#divLoading1').css('display', 'none');
        }
        else //set data in template (merchant addresses page)
            setMerchantAddressData(resp.addresses, resp.paging);
    });
}

//set merchant address data in address boxes
function setMerchantAddressData(addresses, paging) 
{
    let start_from = eval((paging.limit*paging.page)-paging.limit+1); 

    //set pagignation bar
    $(".paging_count").html(
        start_from 
        + '-' + 
        eval((paging.page*paging.limit)-(paging.limit-addresses.length)) 
        + ' of ' + 
        paging.total_results
    );

    //set li for pagignation
    let pagination_li = '';
    for (var i = 1; i <= paging.total_pages; i++) 
    {
        active_class = (i==paging.page) ? 'active' : '';
        pagination_li += '<li class="page-item '+active_class+'"><a class="page-link" href="javascript:void(0)" onclick="getAndSetMerchantAddress('+i+')">'+i+'</a></li>';
    }

    $("#pagination").html(pagination_li);

    //remove address box if items are below then 15 (15 is default limit)
    if (addresses.length != 15) 
    {
        //remove address box where we do not have addresses for them
        for (var i = addresses.length+1; i < 16; i++) 
            $("#address_div_"+i).css("display", "none");
    } 

    //set addresses
    for (var i=0,j=1; i<addresses.length; i++) 
    {
        let address = addresses[i].address_line_1+"<br />"+addresses[i].address_line_2;

        if (addresses[i].address_line_2)
            address += "<br />";

        address += addresses[i].landmark;

        if (addresses[i].landmark)
            address += "<br />";

        address += addresses[i].city;

        if (addresses[i].pin)
            address += " - "+addresses[i].pin;

        address += "<br />"+addresses[i].state+", "+addresses[i].country;

        if (addresses[i].contact)
            address += "<br /><label>Contact no :</label> "+addresses[i].contact;

        if (addresses[i].business_days)
            address += "<br /><label>Business days :</label> "+addresses[i].business_days;

        if (addresses[i].business_hours)
            address += "<br /><label>Business hours :</label> "+addresses[i].business_hours;

        $("#address"+j).html(address);

        let distance_btn = '<a target="_blank" href="https://www.google.com/maps/place/'+addresses[i].latitude+','+addresses[i].longitude+'" class="btn btn-warning pull-right"><i class="fa fa-walking" aria-hidden="true"></i> _distance_ KM</a>';
        $("#distance"+j).html(distance_btn);

        if (i == addresses.length-1)
            $('#divLoading1').css('display', 'none');

        j++;
    }
}

$(document).ready(function() {
    $("#state_id").change(function() {
        //get and set cities
        let state_id = $('#state_id').val();
        
        if (state_id == 0) 
            $('#state_cities').css('display', 'none');
        else //get and set cities
            setCities(state_id);

        getAndSetMerchantAddress(1);
    });

    $("#state_cities").change(function() {
        getAndSetMerchantAddress(1);
    });

    //get and set product listing data
    getAndSetMerchantAddress(1);
});
</script>