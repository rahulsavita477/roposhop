<main class="main">
<div class="container mt- mb-3">
    <ol class="breadcrumb mt-0 mb-2">
        <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="#" class="text-active">location setting</a></li>
    </ol>
    <div class="row row-sm">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center pt-5 pb-2 bdr-d">
            <form method="post" accept="#" class="text-center">
                <button type="button" onclick="getCurrentLocation()" class="btn btn-primary">Select current location</button>
                <div class="clearfix"></div>
                <br><h3> Or</h3>

                <div class="form-group ml-2 mt-1">
                    <select class="form-control mx-auto" id="state_id">
                        <option value="0">-- select state --</option>
                        <?php
                        foreach ($states['result'] as $state) 
                        {
                            $selected = '';
                            if (isset($_COOKIE['state_id']) && $_COOKIE['location_selection'] == 'manual') 
                            {
                                $selected = ($_COOKIE['state_id'] == $state['state_id']) ? "selected='selected'" : '';
                            }
                            
                            echo "<option ".$selected." value='".$state['state_id']."'>".$state['name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group ml-2">
                    <select class="form-control mx-auto" id="state_cities" style="display: none;"></select>
                </div>
                
                <button type="button" onclick="saveLocation()" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>  
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#state_id").change(function() {
            //get and set cities
            let state_id = $('#state_id').val();
            
            if (state_id == 0) 
                $('#state_cities').css('display', 'none');
            else //get and set cities
                setCities(state_id);
        });

        //get and set cities
        state_id = $('#state_id').val();

        if (state_id != 0 && getCookie('state_id') != '')
        {
            setCities(getCookie('state_id'));

            setTimeout(function(){
                $('#state_cities').val(getCookie('city_id'));
            }, 2000);
        }
    });
</script>