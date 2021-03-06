<?php
include 'errors.php';
require 'connect.php';
require 'session.php';
require 'mail-configuration.php';


if (isset($_REQUEST['login'])) {
    $user_login_email = $_POST['login_username'];
    $user_login_password = $_POST['login_password'];

    if (empty($user_login_email)) {
        array_push($loginErrors, 'Email is required');
    }
    if (empty($user_login_password)) {
        array_push($loginErrors, 'Password is required');
    }
    if (count($loginErrors) == 0) {
        $encyrpted_login_password = md5($user_login_password);
        $query = $db->prepare("SELECT * FROM member WHERE member_email = ? AND member_password = ?");
        $query->execute([
            $user_login_email, $encyrpted_login_password
        ]);

        $member = $query->fetch(PDO::FETCH_ASSOC);
        if ($member) {

            $logged = true;
            $_SESSION['user_name'] = $member['member_name'];
            $_SESSION['logged'] = $logged;
            $_SESSION['user_role'] = $member['member_role_id'];
            header('Location: index.php');
        } else {
            array_push($loginErrors, 'Wrong username/password combination');
        }
    }
}
?>
<?php if ($_SESSION['logged'] == false): ?>
<!doctype html>
<html class="no-js" lang="tr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Conff | Homepage</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
       ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/conff.ico" />
    <!-- Google Fonts
       ============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,800" rel="stylesheet"
          type="text/css">
    <!-- Bootstrap CSS
       ============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Slider -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Fontawsome CSS
       ============================================ -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- owl.carousel CSS
       ============================================ -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <!-- jquery-ui CSS
       ============================================ -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <!-- meanmenu CSS
       ============================================ -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- animate CSS
       ============================================ -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- nivo slider CSS
       ============================================ -->
    <link rel="stylesheet" href="lib/nivo-slider/css/nivo-slider.css" type="text/css"/>
    <link rel="stylesheet" href="lib/nivo-slider/css/preview.css" type="text/css" media="screen"/>
    <!-- style CSS
       ============================================ -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
       ============================================ -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr JS
       ============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.
</p>
<![endif]-->
<!--Header Area Start-->
<header class="header-three list">
    <div class="header-top">
    </div>
    <style>
        #nav li {
            float: left;
        }

        .header-nav {
            float: right !important;
        }
    </style>
    <!--Logo Mainmenu Start-->
    <div class="header-logo-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12" style="text-align:center;">
                            <div class="logo">
                                <a href="index.php"><img src="img/logo/conff-color.png" alt="ADVENTURES"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Logo Mainmenu-->
</header>
<!--End of Header Area-->

<div class="container">
    <div class="row" style="margin-top:200px;">
        <div class="col-lg-6 brdr">
            <h2 style="text-align:center; margin-top:30px;"> Üye Ol</h2>
            <div class="col">
                <ul class="event-details-inner-nav" role="tablist">
                    <li role="presentation" class="active"><a href="#person" aria-controls="person"
                                                              onclick="setMainActiveTab('person')"
                                                              role="tab" data-toggle="tab">Bireysel</a>
                    </li>
                    <li role="presentation"><a href="#organization" onclick="setMainActiveTab('organization')"
                                               aria-controls="organization" role="tab"
                                               data-toggle="tab">Kurumsal</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" style="padding: 20px;">
                <div role="tabpanel" class="tab-pane active" id="person">
                    <form method="post" action="main-register.php" id="user_register_form" name="user_register_form">

                        <select name="user_title">
                            <option value="title1">Title1</option>
                            <option value="title2">Title2</option>
                            <option value="title3">Title3</option>
                            <option value="title4">Title4</option>
                        </select>
                        <br>
                        <br>
                        <input type="text" class="form-control" name="user_name" placeholder="Name" required>
                        <br>
                        <input type="text" class="form-control" name="user_surname" placeholder="Surname" required>
                        <br>
                        <input type="text" class="tarih"  name="user_date_of_birth" placeholder="Date Of Birth" required>
                        <br><br>
                        <input type="text" class="form-control" name="user_telephone" id="user_telephone" placeholder="Telephone" required><h4 id="user_telephone_error" style="color: #FF4933;"></h4>
                        <br>
                        <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email" required><h4 id="user_email_error" style="color: #FF4933;"></h4>
                        <br>
                        <input type="password" class="form-control" name="user_password" placeholder="Password" required>
                        <br>
                        <input type="password" class="form-control" name="user_re_password" placeholder="Re-Enter Password" required>
                        <br>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-12" style="display: flex">
                                <label class="checkbox-container" style="font-size:14px;">TERMS AND CONDITIONAL
                                    <input type="checkbox" id="accept_terms" name="accept_terms">
                                    <span class="checkbox-checkmark"></span>
                                </label>
                            </div>
                                <h4 id="accept_terms_error" style="color: #FF4933;"></h4>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="display: flex">
                                <input type="hidden" name="user_register" value="1">
                                <input type="hidden" id="code" name="code">
                                <input type="hidden" id="csrf_nonce" name="csrf_nonce">
                            </div>
                        </div>
                    </form>
                    <button onclick="loginWithSMS();" class="continue-button  btn-lg btn-block">Devam Et</button>
                </div>
                <div role="tabpanel" class="tab-pane" id="organization">
                    <form method="post">
                        <br>
                        <input type="text" class="form-control" name="firm_name" placeholder="Kurum Adı">
                        <br>
                        <input type="text" class="form-control" name="firm_user_name" placeholder="Name">
                        <br>
                        <input type="text" class="form-control" name="firm_user_surname" placeholder="Surname">
                        <br>
                        <input type="tel" class="form-control" name="firm_tel_no" placeholder="Telephone Number">
                        <br>
                        <input type="email" class="form-control" name="firm_email" placeholder="Email">
                        <br>
                        <input type="password" class="form-control" name="firm_password" placeholder="Password">
                        <br>
                        <input type="password" class="form-control" name="firm_re_password" placeholder="Re-Enter Password">
                        <br>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-12" style="display: flex">
                                <label class="checkbox-container" style="font-size:14px;">TERMS AND CONDITIONAL
                                    <input type="checkbox" checked>
                                    <span class="checkbox-checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="display: flex">
                                <input type="hidden" name="company_register" value="1">
                                <button type="submit" class="continue-button  btn-lg btn-block">Devam Et</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <h2 style="text-align:center;"> Üye Girişi</h2>
            <br>
            <br>
            <br>
            <br>
            <form method="post" action="">
                <?php loginError($loginErrors) ?>
                <br>
                <input type="email" class="form-control" id="user_email_login" name="login_username"
                       placeholder="Email">
                <input type="password" class="form-control" id="user_password_login" name="login_password"
                       placeholder="Password">
                <br>
                <input type="hidden" name="login" value="1">
                <button type="submit" class="red-button btn-lg btn-block"
                        style="font-size: 30px; display: inline-block">Giriş
                </button>
                <br>
                <br>
                <a href="forgot-password.php">Forgot password?</a>
            </form>
        </div>

    </div>
</div>


<div class="red-divider" style="margin-top: 60px;"></div>
<!--Footer Widget Area Start-->
<div class="footer-widget-area footer-widget-three">
    <div class="container">
        <div class="row" style="margin-bottom: 60px;">
            <div class="col-md-12"
                 style="display: flex; flex-direction: row; align-items: center; justify-items: center">
                <h4 style="color:#444; font-size:20px; margin-right: 25px;font-weight: 700;line-height: 16px;">
                    Bizden Haberdar Olmak İçin:
                </h4>
                <input type="email" class="brdr search-input"
                       placeholder="E-Mail Adresiniz">
                <a class="red-button"
                   style="font-size: 30px; display: inline-block"
                   aria-hidden="true">Abone Ol!</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-4">
                <div class="single-footer-widget">
                    <h4>About Conff</h4>
                    <div class="footer-widget-list">
                        <ul class="widget-lists">
                            <li><a href="#">About SXSW</a></li>
                            <li><a href="#">History</a></li>
                            <li><a href="#">Community</a></li>
                            <li><a href="#">Sustainability</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Newsletters</a></li>
                            <li><a href="#">Merch</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <div class="single-footer-widget">
                    <h4>Social Media</h4>
                    <div class="col-md-6">
                        <div class="footer-link-small">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-vimeo"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 hidden-sm">
                <div class="single-footer-widget">
                    <h4>Sales & Sponsorship</h4>
                    <div class="footer-widget-list">
                        <ul class="widget-lists">
                            <li><a href="#">Marketing at SXSW</a></li>
                            <li><a href="#">Sponsorship Opportunities</a></li>
                            <li><a href="#">Exhibitions Opportunities</a></li>
                            <li><a href="#">Advertising Opportunities</a></li>
                            <li><a href="#">Custom Opportunities</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 hidden-md hidden-sm">
                <div class="single-footer-widget">
                    <h4>Press</h4>
                    <div class="footer-widget-list">
                        <ul class="widget-lists">
                            <li><a href="#">Press Center</a></li>
                            <li><a href="#">Accreditation</a></li>
                            <li><a href="#">Press Releases</a></li>
                            <li><a href="#">Photo & Video Policies</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3">
                <div class="single-footer-widget">
                    <h4>Attending Conff</h4>
                    <div class="footer-widget-list">
                        <ul class="widget-lists">
                            <li><a href="#">Registration Info</a></li>
                            <li><a href="#">Hotel Info</a></li>
                            <li><a href="#">Attendee Services Hub</a></li>
                            <li><a href="#">Accessibility</a></li>
                            <li><a href="#">Registration Terms</a></li>
                            <li><a href="#">RFID Policy</a></li>
                            <li><a href="#">Code of Conduct</a></li>
                            <li><a href="#">Registration FAQ</a></li>
                            <li><a href="#">Housing & Travel FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 100px; margin-bottom: 60px;">
            <div class="col-md-8 col-md-offset-2" style="text-align: center">
                ©2017-2018 SXSW, LLC. SXSW®, SXSW EDU®, SXSW Eco®, and South by Southwest® are trademarks owned by SXSW,
                LLC. Any unauthorized use of these names, or variations of these names, is a violation of state,
                federal, and international trademark laws.
                <br>
                <br>
                Privacy Policy | Trademark Guidelines | Terms of Use | Copyright Notice
            </div>
        </div>
    </div>
</div>
<!--End of Footer Widget Area-->
<!-- jquery
   ============================================ -->
<script src="js/vendor/jquery-1.11.3.min.js"></script>
<!-- bootstrap JS
   ============================================ -->
<script src="js/bootstrap.min.js"></script>
<!-- nivo slider js
   ============================================ -->
<script src="lib/nivo-slider/js/jquery.nivo.slider.js"></script>
<script src="lib/nivo-slider/home.js" type="text/javascript"></script>
<!-- wow JS
   ============================================ -->
<script src="js/wow.min.js"></script>
<!-- meanmenu JS
   ============================================ -->
<script src="js/jquery.meanmenu.js"></script>
<!-- owl.carousel JS
   ============================================ -->
<script src="js/owl.carousel.min.js"></script>
<!-- price-slider JS
   ============================================ -->
<script src="js/jquery-price-slider.js"></script>
<!-- scrollUp JS
   ============================================ -->
<script src="js/jquery.scrollUp.min.js"></script>
<!-- Waypoints JS
   ============================================ -->
<script src="js/waypoints.min.js"></script>
<!-- Counter Up JS
   ============================================ -->
<script src="js/jquery.counterup.min.js"></script>
<!-- plugins JS
   ============================================ -->
<script src="js/plugins.js"></script>
<!-- main JS
   ============================================ -->
<script src="js/main.js"></script>
<script type="text/javascript">
    function setActiveTab(tab) {
        let attrsArray = [];
        const getChild = $("ul.payment-nav-tabs").children();
        getChild.each(function (i, v) {
            attrsArray.push([($(v).children(0).attr('aria-controls'))])
        });

        attrsArray.forEach(attr => {
            $("a[aria-controls=" + attr + "]").removeClass('active');
        });
        $("a[aria-controls=" + tab + "]").addClass('active');
    }

    function setMainActiveTab(tab) {
        let attrsArray = [];
        const getChild = $("ul.event-details-inner-nav").children();
        getChild.each(function (i, v) {
            attrsArray.push([($(v).children(0).attr('aria-controls'))])
        });

        attrsArray.forEach(attr => {
            $("a[aria-controls=" + attr + "]").removeClass('active');
        });
        $("a[aria-controls=" + tab + "]").addClass('active');
    }

    $(document).ready(function () {
        $("a[data-toggle = 'dropdown-hotel']").click(function (event) {
            event.preventDefault();
            $(this).parent().parent().parent().children().not("div[data-toggle = 'pinned']").toggleClass('no-display');
        });
    });


</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $('.tarih').datepicker({
        dateFormat: 'yy-mm-dd'
    });
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<!-- Facebook Account Kit
   ============================================ -->

<script src="jquery-3.0.0.min.js"></script>
<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>


<script>
    AccountKit_OnInteractive = function(){
        console.log("{{csrf}}")
        AccountKit.init({
            appId: 2103161540006051,
            state: "{{csrf}}",
            version: "v1.0"
        });
    };

    // login callback
    function loginCallback(response) {
        console.log(response);
        if (response.status === "PARTIALLY_AUTHENTICATED") {
            document.getElementById("code").value = response.code;
            document.getElementById("csrf_nonce").value = response.state;
            document.getElementById("user_register_form").submit();
        }
        else if (response.status === "NOT_AUTHENTICATED") {
            // handle authentication failure
            console.log("NOT_AUTHENTICATED");
        }
        else if (response.status === "BAD_PARAMS") {
            // handle bad parameters
            console.log("BAD_PARAMS");
        }
    }


    function loginWithSMS(){
        var countryCode = "+90";
        var phoneNumber = document.getElementById("user_telephone").value;

        AccountKit.login("PHONE",{countryCode: countryCode, phoneNumber: phoneNumber}, loginCallback);

    }
</script>

<script>
    $(document).ready(function(){
        $("#user_telephone").keyup(function(){
            var user_telephone = $("#user_telephone").val().trim();
            if(user_telephone != ''){
                $("#user_telephone_error").show();
                $.ajax({
                    url: 'user_telephone_checker.php',
                    type: 'post',
                    data: {user_telephone: user_telephone},
                    success: function(response){
                        if(response > 0){
                            $("#user_telephone_error").html("<span class='not-exists'>* Telephone Number Already in use.</span>");
                        }else{
                            $("#user_telephone_error").html("<span class='exists'>Available.</span>");
                        }
                    }
                });
            }else{
                $("#user_telephone_error").hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("#user_email").keyup(function(){
            var user_email = $("#user_email").val().trim();
            if(user_email != ''){
                $("#user_email_error").show();
                $.ajax({
                    url: 'user_telephone_checker.php',
                    type: 'post',
                    data: {user_email: user_email},
                    success: function(response){
                        if(response > 0){
                            $("#user_email_error").html("<span class='not-exists'>* Email Already in use.</span>");
                        }else{
                            $("#user_email_error").html("<span class='exists'>Available.</span>");
                        }
                    }
                });
            }else{
                $("#user_email_error").hide();
            }
        });
    });
</script>
</body>
</html>
<?php else: ?>

<?php header('Location: index.php') ?>

<?php endif; ?>
