<body id="page-details" class="loaded">
    <div class="page-wrapper">
        <main class="main">
            <div class="container">
                <ol class="breadcrumb mt-0 mb-2">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-active">Brands</a></li>
                </ol>

                <div class="header-center merchant_search">
                    <div class="header-search">
                        <a href="#" class="search-toggle"><i class="icon-magnifier"></i></a>
                        <form action="<?= base_url('brands') ?>" method="get">
                            <div class="header-search-wrapper">
                                <input type="search" class="form-control merchant_search_tearm" name="search_tearm" placeholder="Search: Brand" value="<?= isset($_GET['search_tearm']) ? $_GET['search_tearm'] : '' ?>" required>
                            
                                <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                            </div><!-- End .header-search-wrapper -->
                        </form>
                    </div><!-- End .header-search -->
                </div><!-- End .headeer-center -->

                <div class="container mt-3 mb-3">
                    <div class="row row-sm">
                        <?php
                        if (isset($result)) 
                        {
                            foreach ($result as $brand) 
                            {
                                if ($brand['brand_logo']) 
                                {
                                    $brand_logo_text = '<img src="'.base_url(BRAND_ATTATCHMENTS_PATH.$brand['brand_id'].'/'.$brand['brand_logo']).'" alt="'.$brand['name'].'" style="min-width: 100%;min-height: auto;"><h4>'.$brand['name'].'</h4>';
                                }
                                else
                                {

                                    $brand_logo_text = '<img src="'.base_url('assets/user/assets2/images/brand.png').'" alt="'.$brand['name'].'" style="min-width: 100%;min-height: auto;"><h4>'.$brand['name'].'</h4>';
                                }

                                echo '<div class="col-md-2 text-center mb-3">
                                        <a href="'.base_url('brands/'.url_title($brand['name'], '-', true).'?brand_id=').$brand['brand_id'].'">
                                            <div class="img-text" style="height: 150px; position: relative;">
                                                '.$brand_logo_text.'
                                            </div>
                                        </a>
                                    </div>';
                            }
                        }
                        else
                            echo "Not available";
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>