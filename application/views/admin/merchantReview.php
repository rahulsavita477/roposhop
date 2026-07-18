<style type="text/css">
.btn-grey{
    background-color:#D8D8D8;
	color:#FFF;
}
.rating-block{
	background-color:#FAFAFA;
	border:1px solid #EFEFEF;
	padding:15px 15px 20px 15px;
	border-radius:3px;
}
.bold{
	font-weight:700;
}
.padding-bottom-7{
	padding-bottom:7px;
}

.review-block{
	background-color:#FAFAFA;
	border:1px solid #EFEFEF;
	padding:15px;
	border-radius:3px;
	margin-bottom:15px;
}
.review-block-name{
	font-size:12px;
	margin:10px 0;
}
.review-block-date{
	font-size:12px;
}
.review-block-rate{
	font-size:13px;
	margin-bottom:15px;
}
.review-block-title{
	font-size:15px;
	font-weight:700;
	margin-bottom:10px;
}
.review-block-description{
	font-size:13px;
}
</style>

<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Review</h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reviews</li>
        </ol>
    </section>

	<?php if ($merchant_review) {  ?>
		<div class="row">
			<?php
			// Total reviews aur percentage calculation logic wahi rahega
			$total_reviews = $rating_info['rating_count_5_star'] + 
							$rating_info['rating_count_4_star'] + 
							$rating_info['rating_count_3_star'] + 
							$rating_info['rating_count_2_star'] + 
							$rating_info['rating_count_1_star'];

			$total_reviews = ($total_reviews > 0) ? $total_reviews : 1;

			$pct_5 = ($rating_info['rating_count_5_star'] / $total_reviews) * 100;
			$pct_4 = ($rating_info['rating_count_4_star'] / $total_reviews) * 100;
			$pct_3 = ($rating_info['rating_count_3_star'] / $total_reviews) * 100;
			$pct_2 = ($rating_info['rating_count_2_star'] / $total_reviews) * 100;
			$pct_1 = ($rating_info['rating_count_1_star'] / $total_reviews) * 100;
			?>

			<!-- Parent wrapper mein standard layout padding aur Flex display lagaya hai -->
			<div class="row" style="display: flex; flex-wrap: wrap; margin-bottom: 20px; padding-left: 30px;">
				
				<!-- LEFT BOX: Average Rating -->
				<div class="col-sm-3" style="display: flex;">
					<div class="rating-block" style="padding: 20px; background: #fff; border: 1px solid #e3e3e3; border-radius: 4px; width: 100%; display: flex; flex-direction: column; justify-content: space-between;">
						<div>
							<h4 style="margin-top: 0; color: #444; font-size: 16px; font-weight: 600;">Average rating</h4>
							<h2 class="bold" style="margin: 15px 0 5px 0; font-size: 36px; color: #333; line-height: 1;">
								<?= number_format($rating_info['avg_rating'], 1) ?> <small style="font-size: 18px; color: #999;">/ 5</small>
							</h2>
						</div>
						<div style="margin-top: auto; padding-top: 15px;">
							<?php printRatingStars($rating_info['avg_rating']); ?>
						</div>
					</div>
				</div>

				<!-- RIGHT BOX: Rating Breakdown -->
				<div class="col-sm-5" style="display: flex;">
					<div class="breakdown-block" style="padding: 20px; background: #fff; border: 1px solid #e3e3e3; border-radius: 4px; width: 100%;">
						<h4 style="margin-top: 0; margin-bottom: 18px; color: #444; font-size: 16px; font-weight: 600;">Rating breakdown</h4>
						
						<!-- 5 Star Row -->
						<div style="display: flex; align-items: center; margin-bottom: 8px;">
							<div style="width: 35px; color: #444; font-size: 13px;">
								5 <span class="glyphicon glyphicon-star" style="color: #f39c12;"></span>
							</div>
							<div style="flex-grow: 1; margin: 0 12px; max-width: 220px;">
								<div class="progress" style="height: 10px; margin: 0; background-color: #f5f5f5; border-radius: 4px; box-shadow: none;">
									<div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $pct_5 ?>%; box-shadow: none;"></div>
								</div>
							</div>
							<div style="width: 20px; text-align: right; color: #777; font-size: 13px;">
								<?= $rating_info['rating_count_5_star'] ?>
							</div>
						</div>

						<!-- 4 Star Row -->
						<div style="display: flex; align-items: center; margin-bottom: 8px;">
							<div style="width: 35px; color: #444; font-size: 13px;">
								4 <span class="glyphicon glyphicon-star" style="color: #f39c12;"></span>
							</div>
							<div style="flex-grow: 1; margin: 0 12px; max-width: 220px;">
								<div class="progress" style="height: 10px; margin: 0; background-color: #f5f5f5; border-radius: 4px; box-shadow: none;">
									<div class="progress-bar progress-bar-primary" role="progressbar" style="width: <?= $pct_4 ?>%; box-shadow: none;"></div>
								</div>
							</div>
							<div style="width: 20px; text-align: right; color: #777; font-size: 13px;">
								<?= $rating_info['rating_count_4_star'] ?>
							</div>
						</div>

						<!-- 3 Star Row -->
						<div style="display: flex; align-items: center; margin-bottom: 8px;">
							<div style="width: 35px; color: #444; font-size: 13px;">
								3 <span class="glyphicon glyphicon-star" style="color: #f39c12;"></span>
							</div>
							<div style="flex-grow: 1; margin: 0 12px; max-width: 220px;">
								<div class="progress" style="height: 10px; margin: 0; background-color: #f5f5f5; border-radius: 4px; box-shadow: none;">
									<div class="progress-bar progress-bar-info" role="progressbar" style="width: <?= $pct_3 ?>%; box-shadow: none;"></div>
								</div>
							</div>
							<div style="width: 20px; text-align: right; color: #777; font-size: 13px;">
								<?= $rating_info['rating_count_3_star'] ?>
							</div>
						</div>

						<!-- 2 Star Row -->
						<div style="display: flex; align-items: center; margin-bottom: 8px;">
							<div style="width: 35px; color: #444; font-size: 13px;">
								2 <span class="glyphicon glyphicon-star" style="color: #f39c12;"></span>
							</div>
							<div style="flex-grow: 1; margin: 0 12px; max-width: 220px;">
								<div class="progress" style="height: 10px; margin: 0; background-color: #f5f5f5; border-radius: 4px; box-shadow: none;">
									<div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?= $pct_2 ?>%; box-shadow: none;"></div>
								</div>
							</div>
							<div style="width: 20px; text-align: right; color: #777; font-size: 13px;">
								<?= $rating_info['rating_count_2_star'] ?>
							</div>
						</div>

						<!-- 1 Star Row -->
						<div style="display: flex; align-items: center;">
							<div style="width: 35px; color: #444; font-size: 13px;">
								1 <span class="glyphicon glyphicon-star" style="color: #f39c12;"></span>
							</div>
							<div style="flex-grow: 1; margin: 0 12px; max-width: 220px;">
								<div class="progress" style="height: 10px; margin: 0; background-color: #f5f5f5; border-radius: 4px; box-shadow: none;">
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $pct_1 ?>%; box-shadow: none;"></div>
								</div>
							</div>
							<div style="width: 20px; text-align: right; color: #777; font-size: 13px;">
								<?= $rating_info['rating_count_1_star'] ?>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		<?php foreach ($merchant_review as $review) {  ?>
			<div class="row">
				<div class="col-sm-12" style="padding-left: 30px;">
					<div class="review-block">
						<div class="row" style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f1f1f1;">
							<!-- Left Profile Side: Increased to col-sm-2 for proper breathing space -->
							<div class="col-sm-2 text-center" style="border-right: 1px solid #f1f1f1;">
								<?php $consumer_pic = $this->config->item('site_url').PROFILE_PIC_PATH.$review['picture']; ?>
								<img src="<?= $consumer_pic ?>" class="img-rounded" width="60px" style="object-fit: cover; height: 60px; margin-bottom: 8px;" />
								
								<div class="review-block-name" style="font-weight: bold; font-size: 14px; word-break: break-word;">
									<a href="#" style="color: #337ab7; text-decoration: none;"><?= $review['consumer_name'] ?></a>
								</div>
								
								<div class="review-block-date" style="font-size: 12px; color: #777; margin-top: 4px;">
									<?= date('F d, Y', strtotime($review['review_date'])) ?>
								</div>
							</div>
							
							<!-- Right Review Content Side: Adjusted to col-sm-10 -->
							<div class="col-sm-10" style="padding-left: 20px;">
								<div class="review-block-rate" style="margin-bottom: 5px;">
									<?php printRatingStars($review['rating']); ?>
								</div>
								
								<?php if(!empty($review['review_title'])): ?>
									<div class="review-block-title" style="font-weight: bold; font-size: 15px; margin-bottom: 8px; color: #333;">
										<?= $review['review_title'] ?>
									</div>
								<?php endif; ?>
								
								<!-- Review Description with Ellipsis Wrapper -->
								<div class="review-block-description" style="line-height: 1.6; color: #555;">
									<?php if (strlen($review['review']) > 800): ?>
										<span class="short-text"><?= substr($review['review'], 0, 800) ?>...</span>
										<span class="full-text" style="display:none;"><?= $review['review'] ?></span>
										<a href="javascript:void(0);" class="toggle-review-text" style="color: #337ab7; font-weight: bold; margin-left: 5px; text-decoration: none; font-size: 13px;">Show More</a>
									<?php else: ?>
										<?= $review['review'] ?>
									<?php endif; ?>
								</div>
								
								<!-- Optional: Future Merchant Reply Button Placeholder -->
								<!-- <div style="margin-top: 15px; text-align: right;">
									<button class="btn btn-xs btn-default"><i class="fa fa-reply"></i> Reply</button>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php } 
		} 
		else 
			echo "Review not available";
	?>
</aside>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('.toggle-review-text').on('click', function(){
        var parent = $(this).closest('.review-block-description');
        var isWordLimit = parent.find('.full-text').is(':visible');
        
        if(isWordLimit){
            parent.find('.full-text').hide();
            parent.find('.short-text').show();
            $(this).text('Show More');
        } else {
            parent.find('.short-text').hide();
            parent.find('.full-text').show();
            $(this).text('Show Less');
        }
    });
});
</script>