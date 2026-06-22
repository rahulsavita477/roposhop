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
                                    $name_words = explode(' ', trim($merchant['establishment_name']));
                                    $initials = strtoupper(substr($name_words[0], 0, 1));
                                    if (count($name_words) > 1) {
                                        $initials .= strtoupper(substr(end($name_words), 0, 1));
                                    }
                                    $colors = ['#e74c3c', '#3498db', '#2ecc71', '#9b59b6', '#f39c12', '#1abc9c', '#e67e22', '#16a085'];
                                    $color_index = crc32($merchant['establishment_name']) % count($colors);
                                    $bg_color = $colors[abs($color_index)];

                                    $seller_logo_text = '
                                        <div style="width:80px; height:80px; border-radius:50%; background:'.$bg_color.'; display:flex; align-items:center; justify-content:center; margin:5px auto 8px;">
                                            <span style="color:#fff; font-size:28px; font-weight:700; letter-spacing:1px;">'.$initials.'</span>
                                        </div>
                                        <h3 style="margin:0; font-size:13px; color:#333; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; padding:0 5px;">'.htmlspecialchars($merchant['establishment_name']).'</h3>';
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