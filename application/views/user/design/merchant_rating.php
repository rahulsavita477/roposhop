<?php 
$avg_rating = ($merchant['rating_info']['avg_rating']) ? $merchant['rating_info']['avg_rating'] : 0;
$rating_count = ($merchant['rating_info']['rating_count']) ? $merchant['rating_info']['rating_count'] : 0;
$one_star = $merchant['rating_info']['rating_count_1_star'];
$two_star = $merchant['rating_info']['rating_count_2_star'];
$three_star = $merchant['rating_info']['rating_count_3_star'];
$four_star = $merchant['rating_info']['rating_count_4_star'];
$five_star = $merchant['rating_info']['rating_count_5_star'];

if ($rating_count) 
{
    $five_star_width = ($five_star*100)/$rating_count;
    $four_star_width = ($four_star*100)/$rating_count;
    $three_star_width = ($three_star*100)/$rating_count;
    $two_star_width = ($two_star*100)/$rating_count;
    $one_star_width = ($one_star*100)/$rating_count;
}
else
    $five_star_width = $four_star_width = $three_star_width = $two_star_width = $one_star_width = 0;

$usr_rating = 0;
$usr_review = '';
$usr_review_title = '';
if (isset($_COOKIE['consumer_id']) && $merchant['login_user_review']) 
{
    $usr_rating = $merchant['login_user_review']['rating'];
    $usr_review = $merchant['login_user_review']['review'];
    $usr_review_title = $merchant['login_user_review']['review_title'];
}

switch ($usr_rating) 
{
    case 1:
        $rating_text = 'Very Bad';
        break;
    
    case 2:
        $rating_text = 'Not Good';
        break;

    case 3:
        $rating_text = 'Quite OK';
        break;

    case 4:
        $rating_text = 'Very Good';
        break;

    case 5:
        $rating_text = 'Excellent';
        break;

    default:
        $rating_text = 'Select Rating';
        break;
}
?>

<script type="text/javascript">
$(document).ready(function() {
    $('[name="orderby"]').change(function() {
        window.location.replace('<?= base_url("merchant/rating/".$merchant['merchant_id']."?orderby=") ?>'+$('[name="orderby"]').val());
    });

    //set default rating (user given rating) on page load
    $('#rating-'+'<?= $usr_rating ?>').prop('checked', true);
    $('[name="rating"]').val('<?= $usr_rating ?>');

    //set user clicked rating in input box for save/update
    $('.rating input[name="rating"]').click(function(){
        let count=1;
        let rating_text = '';

        $('.rating input[name="rating"]').each(function(){ 
            if ($('#rating-'+count).is(':checked')) 
            {
                $('[name="rating"]').val(count);

                switch(count) 
                {
                    case 1:
                        rating_text = 'Very Bad';
                        break;
                    
                    case 2:
                        rating_text = 'Not Good';
                        break;
                    
                    case 3:
                        rating_text = 'Quite OK';
                        break;

                    case 4:
                        rating_text = 'Very Good';
                        break;

                    case 5:
                        rating_text = 'Excellent';
                        break;
                }

                $('#rating_text').text(rating_text);
                $('[name="title"]').val(rating_text);

                return false;     
            }

            count++;
        });
    })

    //change text on click rating (star)

});
</script>
<style type="text/css">
#rating_text{
    color: #08c;  
    text-decoration: none; 
    pointer-events: none;
}

a.text-active {
    color: #08c;
}
.rating {
    display: flex;
    width: 100%;
    justify-content: center;
    overflow: hidden;
    flex-direction: row-reverse;
    height: 95px;
    position: relative;
}
.rating-0 {
    filter: grayscale(100%);
}
.rating > input {
    display: none;
}
.rating > label {
    cursor: pointer;
    width: 40px;
    height: 40px;
    margin-top: auto;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23e3e3e3' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 32.399c-1.2 5.101 4.3 9.3 8.9 6.601l29.1-17.101c1.9-1.1 4.2-1.1 6.1 0l29.101 17.101c4.6 2.699 10.1-1.4 8.899-6.601l-7.8-32.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 76%;
    transition: .3s;
}
.rating > input:checked ~ label,
.rating > input:checked ~ label ~ label {
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23fcd93a' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 32.399c-1.2 5.101 4.3 9.3 8.9 6.601l29.1-17.101c1.9-1.1 4.2-1.1 6.1 0l29.101 17.101c4.6 2.699 10.1-1.4 8.899-6.601l-7.8-32.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
}
.rating > input:not(:checked) ~ label:hover,
.rating > input:not(:checked) ~ label:hover ~ label {
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23d8b11e' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 32.399c-1.2 5.101 4.3 9.3 8.9 6.601l29.1-17.101c1.9-1.1 4.2-1.1 6.1 0l29.101 17.101c4.6 2.699 10.1-1.4 8.899-6.601l-7.8-32.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
}
.emoji-wrapper {
    width: 100%;
    text-align: center;
    height: 100px;
    overflow: hidden;
    position: absolute;
    top: 0;
    left: 0;
}
.emoji-wrapper:before,
.emoji-wrapper:after{
    content: "";
    height: 15px;
    width: 100%;
    position: absolute;
    left: 0;
    z-index: 1;
}
.emoji-wrapper:before {
    top: 0;
    background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 35%,rgba(255,255,255,0) 100%);
}
.emoji-wrapper:after{
    bottom: 0;
    background: linear-gradient(to top, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 35%,rgba(255,255,255,0) 100%);
}
.emoji {
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: .3s;
}
.emoji > svg {
    margin: 15px 0; 
    width: 70px;
    height: 70px;
    flex-shrink: 0;
}
#rating-1:checked ~ .emoji-wrapper > .emoji { transform: translateY(-100px); }
#rating-2:checked ~ .emoji-wrapper > .emoji { transform: translateY(-200px); }
#rating-3:checked ~ .emoji-wrapper > .emoji { transform: translateY(-300px); }
#rating-4:checked ~ .emoji-wrapper > .emoji { transform: translateY(-400px); }
#rating-5:checked ~ .emoji-wrapper > .emoji { transform: translateY(-500px); }
.feedback {
    max-width: 360px;
    background-color: #fff;
    width: 100%;
    padding: 30px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    align-items: center;
    box-shadow: 0 4px 30px rgba(0,0,0,.05);
}
figure img {
    height: 110px !important;
    width: auto !important;
    margin: auto;
}
.color-change {
    color: #08c !important;
    padding:3px;
}
.product-default .product-title {
    font: 400 1.5rem "Open Sans", sans-serif;
    letter-spacing: -.01em;
    line-height: 1.35;
    margin-bottom: .72rem;
    text-overflow: ellipsis;
    overflow: hidden;
    padding: 5px;
}
</style>

<body id="revies-rating" class="loaded">
    <div class="page-wrapper">
        <main class="main">
            <div class="container">
                <ol class="breadcrumb mt-0 mb-2">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('merchants') ?>">sellers</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('merchants/'.url_title($merchant['establishment_name'], '-', true).'?merchant_id='.$merchant['merchant_id']) ?>"><?= $merchant['establishment_name'] ?></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">Review-Rating</a></li>
                </ol>
        
                <div class="row">
                    <div  class="col-md-4">
                        <div class="product-default" style="width:270px">
                            <a href="<?=  base_url('merchants/'.url_title($merchant['establishment_name'], '-', true).'?merchant_id='.$merchant['merchant_id']) ?>">                                
                                <figure>
                                    <img src="<?= base_url(SELLER_ATTATCHMENTS_PATH.$merchant['merchant_id'].'/'.$merchant['merchant_logo']) ?>" alt="<?= $merchant['establishment_name'] ?>">
                                </figure>
                                <div class="product-details text-left">
                                    <h2 class="product-title text-black"><?= $merchant['establishment_name'] ?></h2>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-4">
                                <h4>Rating</h4>
                                <h1 class="rating-num"><?= $avg_rating ?> <i class="fa fa-star text-dark"></i></h1>
                                <div>
                                    <span><?= $rating_count ?></span> Ratings & Reviews
                                </div>
                            </div>            

                            <div class="col-sm-6">
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">5 <span class="fa fa-star"></span></div>
                                    </div>
                                    <div class="pull-left" style="width:320px;">
                                        <div class="progress" style="height:9px; margin:8px 0;">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: <?= $five_star_width ?>%;background:#5cb85c">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-right" style="margin-left:5px;"><?= $five_star ?></div>
                                </div>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">4 <span class="fa fa-star"></span></div>
                                    </div>
                                    <div class="pull-left" style="width:320px;">
                                        <div class="progress" style="height:9px; margin:8px 0;">
                                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?= $four_star_width ?>%;background:#428bca">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-right" style="margin-left:5px;"><?= $four_star ?></div>
                                </div>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">3 <span class="fa fa-star"></span></div>
                                    </div>
                                    <div class="pull-left" style="width:320px;">
                                        <div class="progress" style="height:9px; margin:8px 0;">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: <?= $three_star_width ?>%;background:#5bc0de">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-right" style="margin-left:5px;"><?= $three_star ?></div>
                                </div>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">2 <span class="fa fa-star"></span></div>
                                    </div>
                                    <div class="pull-left" style="width:320px;">
                                        <div class="progress" style="height:9px; margin:8px 0;">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: <?= $two_star_width ?>%;background:#f0ad4e">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-right" style="margin-left:5px;"><?= $two_star ?></div>
                                </div>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">1 <span class="fa fa-star"></span></div>
                                    </div>
                                    <div class="pull-left" style="width:320px;">
                                        <div class="progress" style="height:9px; margin:8px 0;">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: <?= $one_star_width ?>%;background:#d9534f">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-right" style="margin-left:5px;"><?= $one_star ?></div>
                                </div>
                            </div>       
                        </div>     
                    </div>  
                </div>
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h3 class="pl-3">Please Select Star rating and write your review</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="feedback">
                                <h1><a id="rating_text" href="#"><?= $rating_text ?></a></h1>
                                <div class="rating">
                                    <input type="radio" name="rating" id="rating-5">
                                    <label for="rating-5"></label>

                                    <input type="radio" name="rating" id="rating-4">
                                    <label for="rating-4"></label>

                                    <input type="radio" name="rating" id="rating-3">
                                    <label for="rating-3"></label>

                                    <input type="radio" name="rating" id="rating-2">
                                    <label for="rating-2"></label>

                                    <input type="radio" name="rating" id="rating-1">
                                    <label for="rating-1"></label>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-8">
                            <form action="<?= base_url('addReview') ?>" method="post">
                                <input type="hidden" name="review_for" value="merchant" />
                                <input type="hidden" name="title" value="<?= $usr_review_title ?>" />
                                <input type="hidden" name="merchant_id" value="<?= $merchant['merchant_id'] ?>" />
                                <input type="hidden" name="rating" value="0" />
                                <textarea rows="3" name="review" class="form-control form-control-sm" style="min-height: 155px"><?= $usr_review ?></textarea>
                                <input type="submit" class="btn btn-primary" value="Submit Review">
                            </form>  
                        </div> 
                    </div>

                    <div class="row mt-3" style="margin-top: 0px;">
                        <?php 
                        if ($merchant['reviews']) 
                        { 
                        ?>
                            <div class="toolbox-item toolbox-sort">
                                <div class="select-custom" >
                                    <!-- <form action="<?= base_url('merchant/rating/').$merchant['merchant_id'] ?>" method="get" style="display:-webkit-inline-box; margin: 0;"> -->
                                        <select name="orderby" class="form-control">
                                            <option value="update_date_desc" selected="selected" <?= (isset($_GET['orderby']) && $_GET['orderby'] == 'update_date_desc' ? ' selected="selected"' : '') ?>>Newest First</option>
                                            <option value="create_date_asc" <?= (isset($_GET['orderby']) && $_GET['orderby'] == 'create_date_asc' ? ' selected="selected"' : '') ?>>Oldest First</option>
                                            <option value="rating_desc" <?= (isset($_GET['orderby']) && $_GET['orderby'] == 'rating_desc' ? ' selected="selected"' : '') ?>>Positive First</option>
                                            <option value="rating_asc" <?= (isset($_GET['orderby']) && $_GET['orderby'] == 'rating_asc' ? ' selected="selected"' : '') ?>>Negative First</option>
                                        </select>
                                        <!-- &nbsp;
                                        <input type="submit" class="btn btn-primary" value="apply filter">
                                    </form> -->
                                </div>
                            </div>                        

                        <?php 
                            foreach ($merchant['reviews'] as $key => $review) 
                            {
                                if (isset($_COOKIE['consumer_id']) && $review['consumer_id'] == $_COOKIE['consumer_id'])
                                    continue;

                                switch ($review['rating']) 
                                {
                                    case 1:
                                        $rating_text = 'Very Bad';
                                        break;
                                    
                                    case 2:
                                        $rating_text = 'Not Good';
                                        break;

                                    case 3:
                                        $rating_text = 'Quite OK';
                                        break;

                                    case 4:
                                        $rating_text = 'Very Good';
                                        break;

                                    case 5:
                                        $rating_text = 'Excellent';
                                        break;

                                    default:
                                        $rating_text = 'Select Rating';
                                        break;
                                }
                                
                                if($key == 0)
                                    $rating_parent_div = '<div class="entry-body" style="width: 100%">';
                                else
                                    $rating_parent_div = '<div class="entry-body pt-2" style="width: 100%">';

                                echo $rating_parent_div.
                                '<div class="entry-date mr-5" style="background:#28a745;color: #fff;padding: 3px 4px;margin: 0px;width:60px">
                                        '.$review['rating'].'&nbsp;<i class="fa fa-star "></i> 
                                    </div>

                                    <h2 class="entry-title pl-5 ml-5">
                                        <a href="#" id="rating_text">'.$rating_text.'</a>
                                    </h2>

                                    <div class="entry-content">
                                        <p>'.$review['review'].'</p>
                                    </div>
                              
                                    <div class="entry-meta">
                                        <span><i class="icon-calendar"></i>'.time_elapsed_string($review['last_updated']).'</span>
                                        <span><i class="icon-user"></i> '.$review['consumer_name'].'</span>
                                    </div>
                                </div>';
                            }    
                        }    
                        ?>

                        <!-- <div class="col-md-6 offset-md-6">
                            <nav class="toolbox toolbox-pagination mt-2" style="border-top:none">
                                <ul class="pagination float-right">
                                    <li class="page-item disabled">
                                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><span>...</span></li>
                                    <li class="page-item"><a class="page-link" href="#">15</a></li>
                                    <li class="page-item">
                                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                                    </li>
                                </ul>
                            </nav>     
                        </div> -->
                    </div>
                </div> 
            </div>
    </div>  
</main><!-- End .main -->