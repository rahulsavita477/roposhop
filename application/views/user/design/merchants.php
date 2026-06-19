<body id="page-details" class="loaded">
    <div class="page-wrapper">
        <main class="main">
            <div class="container">
                <ol class="breadcrumb mt-0 mb-2">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-active">Sellers</a></li>
                </ol>

                <div class="header-center merchant_search">
                    <div class="header-search">
                        <a href="#" class="search-toggle"><i class="icon-magnifier"></i></a>
                        <form action="<?= base_url('merchants') ?>" method="get">
                            <div class="header-search-wrapper">
                                <input type="search" class="form-control merchant_search_tearm" name="search_tearm" placeholder="Search: Seller" value="<?= isset($_GET['search_tearm']) ? $_GET['search_tearm'] : '' ?>" required>
                            
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
                            foreach ($result as $merchant) 
                            {
                                if (!$merchant['establishment_name'])
                                    continue;

                                if ($merchant['merchant_logo']) 
                                {
                                    $seller_logo_text = '<img src="'.base_url(SELLER_ATTATCHMENTS_PATH.$merchant['merchant_id'].'/'.$merchant['merchant_logo']).'" alt="'.$merchant['establishment_name'].'" style="min-width: 100%;min-height: auto;"><h3>'.$merchant['establishment_name'].'</h3>';
                                }
                                else
                                {
                                    $seller_logo_text = '<h3 style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">'.$merchant['establishment_name'].'</h3>';
                                }

                                echo '<div class="col-md-2 text-center mb-3">
                                        <a href="'.base_url('merchants/'.url_title($merchant['establishment_name'], '-', true).'?merchant_id=').$merchant['merchant_id'].'">
                                            <div class="img-text" style="height: 150px; position: relative;">
                                                '.$seller_logo_text.'
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