<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

<script type="text/javascript">
$(document).ready(function() {
    //auto search for product
    $("#autosearch_product").keyup(function() {
        var ProductList = JSON.parse('<?= $products ?>');
        var msg = 'This product is already available, please enter new product';
        autocomplete('#autosearch_product', msg, ProductList);
    });

    //auto search for brand
    $("#autosearch_brand").keyup(function() {
        var BrandList = JSON.parse('<?= $autosearch_brands_list ?>');
        var msg = 'This brand is already available, please enter new brand';
        autocomplete('#autosearch_brand', msg, BrandList);
    });
});

function autocomplete(id, msg, data) 
{
    $(id).each(function(i, el) {
        var that = $(el);
        that.autocomplete({
            source: data,
            display: function(event , ui) {
                return ui.label
            }, 
            select: function(event , ui) {
                if (ui.item.id) 
                {
                    alert(msg);
                    setTimeout(function(){ 
                        $(id).val('');
                    }, 500);
                }
            }
        });
    });
}

//check product already exist or not
function checkProductExistance(prd_id, prd_name) 
{
    var ProductList = JSON.parse('<?= $products ?>');
    
    for(var i=0; i<ProductList.length; i++)
    {
        var product_id = ProductList[i]['id'];
        var product_name = ProductList[i]['label'];
        
        if(
            (prd_name && !prd_id && prd_name == product_name) ||
            (prd_name && prd_id && prd_name == product_name && prd_id != product_id)
        )
            return true;
    }

    return false;
}

//check brand already exist or not
function checkBrandExistance(brd_name) 
{
    var BrandList = JSON.parse('<?= $autosearch_brands_list ?>');
    
    for(var i=0; i<BrandList.length; i++)
    {
        var brand_name = BrandList[i]['label'];
        
        if(brd_name.toLowerCase() == brand_name.toLowerCase())
            return true;
    }

    return false;
}

//check for decimal validation
function floatValidation(f_num)
{
    if (isNaN(f_num)) 
        return false;

    var n = parseFloat(f_num);
    return Number(n) === n && n % 1 !== 0;
}

//check for mobile number validation
function mobileValidation(value) 
{
    phone = value.replace(/[^0-9]/g,'');
    if (phone.length != 10)
        return false;
    else
        return true;
}

//check for file validation
function fileValidation(fileName, isFile=false) 
{
    var fileExtention = fileName.substr((fileName.lastIndexOf('.') + 1));
    var validExtentions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (isFile) {
        validExtentions.push("pdf");
    }

    var isFile = validExtentions.includes(fileExtention.toLowerCase());
    if (isFile) return true;
    else {

        let msg = "Allowed File: "+validExtentions.join(', ');
        alert(msg);
        return false;
    }
}
</script>