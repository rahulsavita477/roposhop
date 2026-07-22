<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
        <nav class="mobile-nav">
            <ul class="mobile-menu">
                <li class="active "><a href="index.php">Home</a></li>

                <?php foreach ($tree_list as $category) {

                    echo '<li>
                        <a href="#" class="sf-with-ul">'.$category['category_name'].'</a>
                        <ul>';

                        foreach ($category['child_category'] as $key => $child_category) {

                            if($key == 0) {
                                echo '<li><a class="sf-with-ul" href="'.base_url('categories/'.url_title($category['category_name'], '-', true).'?category=').$category['category_id'].'">ALL IN '.$category['category_name'].'</a></li>';
                            }

                            echo '<li><a class="sf-with-ul" href="'.base_url('categories/'.url_title($child_category['category_name'], '-', true).'?category=').$child_category['category_id'].'">'.$child_category['category_name'].'</a></li>';
                        }

                    echo '</ul></li>';
                } ?>
                
                <li><a href="<?= $site_url ?>/brands">Brands</a></li>
                <li><a href="<?= $site_url ?>/merchants">Sellers</a></li>
                <li><a href="<?= $seller_url.'/merchantLoginSignup' ?>/brands">Free Listing</a></li>
                <li><a href="#" class="sf-with-ul">Get App</a>
                    <ul>
                        <li><a href="<?= $site_url.'/#app' ?>"><i class="icon-mobile"></i> Download Android App</a></li>
                        <li><a href="#" id="mobileInstallBtn"><i class="icon-desktop"></i> Install Web App</a></li>
                    </ul>
                </li>
            </ul>
        </nav><!-- End .mobile-nav -->

        <div class="social-icons">
            <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
            <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
            <a href="#" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div>