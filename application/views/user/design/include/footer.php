<?php 
$seller_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://").'seller.'.str_replace("seller.", "", $_SERVER['HTTP_HOST']); 
$seller_url = str_replace("www.", "", $seller_url); 
$site_url = str_replace("seller.", "", $seller_url);

$site_code = isset($_COOKIE['site_code']) ? $_COOKIE['site_code'] : "";
?>

<!-- contact form in modal ================================================================== -->
<!-- <div class="container"> -->
    <!-- Modal -->
    <div class="modal fade" id="resetPassword">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    Recover Password
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Please enter the email id you used to signup, we will send the instructions to recover your password if provided email id exists in our record.
                
                    <input type="hidden" id="site_code" value="<?= $site_code ?>" />

                    <div class="form-group-inline">
                        <input class="form-control" type="email" placeholder="email*" id="email" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn-custom btn-default" data-dismiss="modal" style="border: none;">Close</button>
                    <button type="button" class="btn-custom btn-primary" onclick="resetPasswordMail()">Submit</button>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->

<footer class="footer">
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-md-9">
                    <div class="widget widget-newsletter">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="widget-title">Subscribe newsletter</h4>
                                <p>Get all the latest information on Events, Sales and Offers. Sign up for newsletter today</p>
                            </div><!-- End .col-lg-6 -->

                            <div class="col-lg-6">
                                <form action="#">
                                    <input type="email" class="form-control" placeholder="Email address" required>

                                    <input type="submit" class="btn" value="Subscribe">
                                </form>
                            </div><!-- End .col-lg-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .widget -->
                </div><!-- End .col-md-9 -->

                <div class="col-md-3 widget-social">
                    <div class="social-icons">
                        <a href="https://www.facebook.com/RopoShop" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                        <a href="https://twitter.com/RopoShop" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/RopoShop/" class="social-icon" target="_blank"><i class="icon-linkedin"></i></a>
                    </div><!-- End .social-icons -->
                </div><!-- End .col-md-3 -->
            </div><!-- End .row -->
        </div><!-- End .footer-top -->
    </div><!-- End .container -->

    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Contact Us</h4>
                        <ul class="contact-info">
                           
                            <li>
                                <span class="contact-info-label">Phone:</span>+91-73891-02962</a>
                            </li>
                            <li>
                                <span class="contact-info-label">Email:</span> <a href="mailto:RopoShop.app@gmail.com">RopoShop.app@gmail.com</a>
                            </li>
                        </ul>
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-3 -->

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4>

                                <div class="row">
                                    <div class="col-sm-6 col-md-5">
                                        <ul class="links">
                                            <li><a href="<?= $seller_url.'/merchantLoginSignup' ?>">Become a Seller</a></li>

                                            <?php
                                            if (isset($_COOKIE['user_id'])) 
                                                echo '<li><a href="'.$site_url.'/userProfile?profile=view">Your Account</a></li>';
                                            else
                                                echo '<li><a href="'.$site_url.'/login">Login</a></li>';
                                            ?>
                                        </ul>
                                    </div><!-- End .col-sm-6 -->
                                    <div class="col-sm-6 col-md-5">
                                        <ul class="links">
                                            
                                            <!-- <li><a href="#" class="login-link">Login</a></li> -->
                                        </ul>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-md-5 -->

                        <div class="col-md-7">
                            <div class="widget">
                                <h4 class="widget-title">Main Features</h4>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul class="links">
                                            <li><a href="<?= $site_url ?>/aboutus/#contactus">Contact us</a></li>
                                            <li><a href="<?= $site_url ?>/aboutus/#help&support">Help and support</a></li>
                                            <li><a href="<?= $site_url ?>/aboutus/#t&c">Terms and conditions
                                            <li><a href="<?= $site_url ?>/aboutus/#faq">Faq</a></li>
                                            <li><a href="<?= $site_url ?>/privacypolicy">Privacy Policy</a></li>
                                        </ul>
                                    </div><!-- End .col-sm-6 -->
                                    <div class="col-sm-6">
                                        <ul class="links">
                                            <li><a href="#">Products</a></li>
                                            <li><a href="<?= $site_url ?>/merchants">Top Sellers</a></li>
                                            <li><a href="<?= $site_url ?>/brands">Brands</a></li>
                                            <li><a href="<?= $site_url ?>/categories">Categories</a></li>
                                        </ul>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-md-7 -->
                    </div><!-- End .row -->

                    <div class="footer-bottom">
                        <p class="footer-copyright">RopoShop &copy;  2020.  All Rights Reserved</p>
                    </div><!-- End .footer-bottom -->
                </div><!-- End .col-lg-9 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .footer-middle -->
</footer>

<!-- End .footer -->
</div><!-- End .page-wrapper -->

<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<!--Mobile-menu-container-->
<?php include('mobile-menu.php'); ?>
<!-- End .mobile-menu-container -->

<a id="scroll-top" href="#top" role="button"><i class="icon-angle-up"></i></a>

<?php include('js.php'); ?>

<script>
function myFunction() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btnText = document.getElementById("myBtn");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Read more"; 
        moreText.style.display = "none";
    } 
    else {
        dots.style.display = "none";
        btnText.innerHTML = "Read less"; 
        moreText.style.display = "inline";
    }
}

//get reset password mail
function resetPasswordMail()
{
    email = $('#email').val();
    site_code = $('#site_code').val();

    if (email) 
    {
        $.ajax({
            type: "POST",
            url: '<?= base_url("api/v1/users/merchants/resetPassword") ?>',
            data: {
                email: email,
                site_code: site_code
            },
            success: function(data){
                if (data) 
                {
                    a = JSON.parse(data); 
                    $("#resetPassword").modal("hide");
                    alert(a.msg);
                }
            },
        }); 
    }
    else
        alert('Please provide email');
}

//show limited character
var showChar = 500;
var ellipsestext = "...";
var moretext = "View More";
var lesstext = "View Less";

$(document).ready(function() {
    
    const toggleBtn = document.getElementById('specificationTableToggleBtn');
    const allRows = document.querySelectorAll('#specTableBody .spec-row');

    if (toggleBtn) {
        // Agar rows 4 ya usse kam hain → button hide kar do
        if (allRows.length <= 4) {
            toggleBtn.style.display = 'none';
        }

        toggleBtn.addEventListener('click', function() {
            const hiddenRows = document.querySelectorAll('#specTableBody .spec-row.d-none');

            if (hiddenRows.length > 0) {
                // Show all rows
                hiddenRows.forEach(row => row.classList.remove('d-none'));
                this.innerHTML = '<strong>Show Less</strong>';
            } else {
                // Hide rows after 4
                allRows.forEach((row, index) => {
                    if (index >= 4) row.classList.add('d-none');
                });
                this.innerHTML = '<strong>View More</strong>';
            }
        });
    }


    $('.more').each(function() {

        var content = $(this).html();

        if(content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext+ '</span>'
                + '<span class="morecontent"><span>' + h + '</span> '
                + '<a href="javascript:void(0);" class="morelink"><strong>' + moretext + '</strong></a></span>';

            $(this).html(html);
        }
    });
});

$(document).on('click', '.morelink', function(e) {

    e.preventDefault();
    var $this = $(this);

    if($this.hasClass("less")) {

        $this.removeClass("less");
        $this.html('<strong>' + moretext + '</strong>');
        $this.prev().hide(); // hide extra text
        $this.closest('.morecontent').prev('.moreellipses').show(); // show ellipses

    } else {

        $this.addClass("less");
        $this.html('<strong>' + lesstext + '</strong>');
        $this.prev().show(); // show extra text
        $this.closest('.morecontent').prev('.moreellipses').hide(); // hide ellipses
    }
});

</script>
    
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.15.4/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
https://firebase.google.com/docs/web/setup#available-libraries -->
<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
<script src="https://www.gstatic.com/firebasejs/7.15.4/firebase-analytics.js"></script>

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyB56KWSL4OQPiP5t_sm5Qk1BMAFbqILq5A",
        authDomain: "RopoShop-8b514.firebaseapp.com",
        databaseURL: "https://RopoShop-8b514.firebaseio.com",
        projectId: "RopoShop-8b514",
        storageBucket: "RopoShop-8b514.appspot.com",
        messagingSenderId: "99824770445",
        appId: "1:99824770445:web:c840baa0cb7daa452071c4"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
</script>
<!-- <script src="/__/firebase/init.js"></script> -->

</body>
</html>  