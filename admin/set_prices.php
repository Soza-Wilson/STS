<!DOCTYPE html>
<html lang="en">
<?php

Ob_start();
include('../class/main.php');
session_start();

$test = $_SESSION['fullname'];
$position = $_SESSION['position'];

if (empty($test)) {

    header('Location:../index.php');
}
$restricted = array("system_administrator");

if (in_array($position, $restricted)) {
} else {
    header('Location:../restricted_access/restricted_access.php');
}
?>


<head>
    <title>STTS</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Mega Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="codedthemes" />
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">

    <script type="text/javascript" src="../jquery/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {




            $("#quantity").on("input", function() {
                var quantity = $("#quantity").val();
                var price_per_kg = $("#quantity").val();
                var total = result * price_per_kg;


                alert(total);
                // Print entered value in a div box
                //$("#result").text($(this).val());
            });

            const loaded = "1";

            $.post('../production/get_products.php', {
                loaded: loaded

            }, data => {
                $('#select_crop').html(data);




            });

            $('#select_crop').change(() => {

                let data = $('#select_crop').find(':selected');

                if (data.val() == "0") {
                    alert("please select Crop ");
                } else {


                    let crop_value = $('#select_crop').val();

                    $.post('../production/get_products.php', {
                        crop_value: crop_value

                    }, data => {
                        $('#select_variety').html(data);

                    });
                }

            });


            $('#select_variety').change(() => {




                let crop_value = $('#select_crop').val();
                let variety_value = $('#select_variety').val();

                $.post('get_price.php', {
                    crop_value: crop_value,
                    variety_value: variety_value

                }, data => {
                    $('#pre_basic').html(data);

                });


            });





        });
    </script>


</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search waves-effect waves-light">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="">
                            <span>Admin</span>
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="ti-more"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                            </li>

                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">

                            <li class="user-profile header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <img src="assets/images/user.jpg" class="img-radius" alt="User-Profile-Image">
                                    <span><?php echo $_SESSION['fullname'] ?></span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">

                                    <li class="waves-effect waves-light">
                                        <a href="../other/user_profile.php">
                                            <i class="ti-user"></i> Profile
                                        </a>
                                    </li>

                                    <li class="waves-effect waves-light">
                                        <a href="../logout.php">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="">
                                <div class="main-menu-header">
                                    <img class="img-80 img-radius" src="assets/images/user.jpg" alt="User-Profile-Image">
                                    <div class="user-details">
                                        <span id="more-details"><?php echo $_SESSION['fullname'] ?><i class="fa fa-caret-down"></i></span>
                                    </div>
                                </div>

                                <div class="main-menu-content">
                                    <ul>
                                        <li class="more-details">
                                            <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                                            <a href="#!"><i class="ti-settings"></i>Settings</a>
                                            <a href="../logout.php"><i class="ti-layout-sidebar-left"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-15 p-b-0">
                                <form class="form-material">

                                </form>
                            </div>

                            <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Admin control </div>
                            <ul class="pcoded-item pcoded-left-item">

                                <li class="pcoded-hasmenu">

                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="">
                                            <a href="admin_dashboard.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>






                                        </li>





                                    </ul>

                                    <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Setup</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="setup.php" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-settings"></i><b>FC</b></span>
                                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Quick Setup </span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    

                                </ul>
                                    <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Users &amp; Registration</div>
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="">
                                            <a href="add_user.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-user"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Register User</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="view_registered_users.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-id-badge"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">View Users</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>


                                    </ul>
                                    <div class="pcoded-navigation-label" data-i18n="nav.category.forms"> Products &amp; Pricing</div>
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="">
                                            <a href="view_all_prices.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-notepad"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Products & Prices</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="add_product.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-plus"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Register Product</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="set_prices.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-write"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Set Sell Prices</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="set_buy_prices.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-write"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Set Buyback Prices</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                    </ul>




                                    <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Order &amp; Sales</div>
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li>
                                            <a href="admin_pending_orders.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-reload"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Pending Orders</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin_processed_orders.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-thumb-up"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Processed Orders</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admin_denied_orders.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-thumb-down"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Denied Orders</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="admin_all_orders.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-write"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">All Orders</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                    </ul>

                                    <div class="pcoded-navigation-label" data-i18n="nav.category.other">Finacial Statemets</div>
                                    <ul class="pcoded-item pcoded-left-item">

                                        <li class="">
                                            <a href="view_ledger.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-list-ol"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Ledger</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>

                                    </ul>

                                    <div class="pcoded-navigation-label" data-i18n="nav.category.other">Grant Access</div>
                                    <ul class="pcoded-item pcoded-left-item">

                                        <li class="">
                                            <a href="grant_access_pending.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-lock"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Pending Requests</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                            <a href="grant_access_approved.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-unlock"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Approved Requests</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>

                                        </li>

                                    </ul>

                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Set sell prices</h5>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="admin_dashboard.php"> <i class="fa fa-home"></i> </a>

                                            <li class="breadcrumb-item"><a href="set_price.php">Set Sell Prices</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <!-- Page body start -->

                                    <!-- Basic Form Inputs card end -->
                                    <!-- Input Grid card start -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>set prices</h5>


                                        </div>
                                        <div class="card-block">

                                            <form action="set_prices.php" method="POST">

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select id="select_crop" name="crop" class="form-control" required="">




                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select id="select_variety" name="variety" class="form-control" required="">
                                                            <option value="0">Select Variety</option>



                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="form-group row">




                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label>Pre-Basic Seed Price </label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" name="pre_basic" id="pre_basic" placeholder="Price per kg" require="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label>Basic Seed Price </label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input id="basic" type="text" class="form-control" name="basic" placeholder="Price per kg" require="">
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label>Certified:</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" name="certified" id="certified" placeholder="Price per kg" require="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">


                                                    </br></br></br>
                                                    <div>

                                                    </div>

                                                    <br>

                                                    <div class="col-sm-12">

                                                        <Input type="submit" class="btn btn-success" name="set_prices" value="Set new price">

                                                        <a href='view_all_prices.php' class='btn btn-primary'>View all</a>


                                                    </div>





                                            </form>
                                            <div id="test_one">


                                            </div>


                                        </div>

                                    </div>
                                    <!-- Input Grid card end -->
                                    <!-- Input Validation card start -->

                                    <!-- Input Validation card end -->
                                    <!-- Input Alignment card start -->

                                    <!-- Input Alignment card end -->
                                </div>
                            </div>
                        </div>
                        <!-- Page body end -->
                    </div>
                </div>
                <!-- Main-body end -->
                <div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js "></script>
    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>

    <!-- modernizr js -->
    <script type="text/javascript" src="assets/js/SmoothScroll.js"></script>
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js "></script>
    <!-- Custom js -->
    <script src="assets/js/pcoded.min.js"></script>
    <script src="assets/js/vertical-layout.min.js "></script>
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>
<?php


if (isset($_POST['set_prices'])) {



    $object = new main();
    $object->set_sell_prices($_POST['crop'], $_POST['variety'], $_POST['pre_basic'], $_POST['basic'], $_POST['certified']);
}

?>

</html>