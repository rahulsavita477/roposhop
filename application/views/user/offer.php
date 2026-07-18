<div class="container">
    <!-- Breadcrumb -->
    <ol class="breadcrumb mt-0 mb-2">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
        <?php if (isset($_GET['offer_id'])) { ?>
            <li class="breadcrumb-item active">Offer</li>
        <?php } ?>
    </ol>

	<div class="product-single-container product-single-default">
		<div class="row">
			<div class="col-lg-5 product-single-gallery">
				<div class="sticky-slider">
					<div class="product-slider-container product-item">
						<div class="product-single-carousel owl-carousel">
							<?php if($offers[0]['offer_images']) {
								foreach ($offers[0]['offer_images'] as $key => $imgs) {
									echo '<div class="product-item">
										<img style="width: auto; max-width: 343px; margin-left: auto; margin-right: auto; height: auto; max-height: 400px;" class="product-single-image" src="'.$imgs.'" data-zoom-image="'.$imgs.'" alt="'.$offers[0]['offer_title'].'_'.$key.'" />
									</div>';
								}
							} else {
								$imgs = $this->config->item('site_url').'assets/user/download (1).jpeg';
								echo '<div class="product-item">
									<img style="width: auto; max-width: 343px; margin-left: auto; margin-right: auto; height: auto; max-height: 400px;" class="product-single-image" src="'.$imgs.'" data-zoom-image="'.$imgs.'" alt="'.$offers[0]['offer_title'].'" />
								</div>';
							} ?>
						</div>
						<!-- End .product-single-carousel -->
						<span class="prod-full-screen">
							<i class="icon-plus"></i>
						</span>
					</div>

					<div class="prod-thumbnail row owl-dots transparent-dots" id='carousel-custom-dots'>
						<?php if($offers[0]['offer_images']) {
							foreach ($offers[0]['offer_images']  as $imgs) {
								echo '<div class="owl-dot">
									<img src="'.$imgs.'" alt="'.$offers[0]['offer_title'].'_'.$key.'" />
								</div>';
							}
						} else {
							echo '<div class="owl-dot">
								<img src="'.$imgs.'" alt="'.$offers[0]['offer_title'].'" />
							</div>';
						} ?>
					</div>
				</div>
			</div>

			<div class="col-lg-7">
				<div class="product-single-details">
					<div class="d-flex align-items-center mb-2">
						<h2 class="product mb-0">
							<?= $offers[0]['offer_title']; ?>
						</h2>
					</div>
				</div>

				<p><strong>
                    Valid from <?= convert_to_user_date($offers[0]['start_date']) ?>
                    to <?= convert_to_user_date($offers[0]['end_date']) ?>
                </strong></p>
				<?= "<p class='more'>".$offers[0]['description']."</p>"; ?>
			</div>
		</div>
	</div>
</div>