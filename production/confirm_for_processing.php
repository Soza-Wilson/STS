<!DOCTYPE html>
<html lang="en">
<?php

Ob_start();
include('../class/main.php');
session_start();

$test = $_SESSION['fullname'];
$stock_in = $_GET['stock_in'];
$grade_ID = $_GET['grade_id'];
$crop = $_GET['crop'];
$variety = $_GET['variety'];
$class = $_GET['class'];
$quantity = $_GET['quantity'];
$received_ID = $_GET['user_ID'];
$received_name = $_GET['user_name'];


if (empty($test)) {

    header('Location:../login.php');
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
    <link rel="icon" href="assets/images/main_icon.png" type="image/x-icon">
    <!-- Google font-->

    <!-- waves.css -->
    <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style_.css">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">

    <script type="text/javascript" src="../jquery/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jsHandle/confirm_for_processing_.js">

    </script>

</head>

<body>
    <!-- Pre-loader start -->
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
                        <a href="">Production</a>

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
                                    <img src="../files/user_profile/<?php if ($_SESSION["profile"] == "") {
                                                                        $profile = "user.jpg";
                                                                    } else {
                                                                        $profile = $_SESSION["profile"];
                                                                    }
                                                                    echo $profile; ?>" class="img-radius" alt="User-Profile-Image">
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
                                    <img class="img-80 img-radius" src="../files/user_profile/<?php if ($_SESSION["profile"] == "") {
                                                                                                    $profile = "user.jpg";
                                                                                                } else {
                                                                                                    $profile = $_SESSION["profile"];
                                                                                                }
                                                                                                echo $profile; ?>" alt="User-Profile-Image">
                                    <div class="user-details">
                                        <span id="more-details"><?php echo $_SESSION['fullname'] ?></i></span>
                                    </div>
                                </div>

                                <div class="main-menu-content">
                                    <ul>
                                        <li class="more-details">
                                            <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                                            <a href="#!"><i class="ti-settings"></i>Settings</a>
                                            <a href="auth-normal-sign-in.html"><i class="ti-layout-sidebar-left"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-15 p-b-0">



                            </div>
                            <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Admin control </div>
                            <ul class="pcoded-item pcoded-left-item">

                                <li class="pcoded-hasmenu">

                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="">
                                            <a href="production_dashboard.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>






                                        </li>


                                    </ul>

                                    <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Stock</div>
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li>
                                            <a href="stock_in.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-write"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Add Stock </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="view_stock_in.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-import"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">view Stock In </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="grading.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-brush-alt"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Grading </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="stock_out.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Stock out</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="view_stock_out.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-export"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">view Stock out</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="inventory.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-clipboard"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">inventory</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>




                                    </ul>

                                    <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Seed processing</div>
                                    <ul class="pcoded-item pcoded-left-item">

                                        <li class="active">
                                            <a href="process_seed.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-settings"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Process seed </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="view_processed_seed.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-bookmark-alt"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">View Processed seed </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="labels.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-receipt"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Generate Labels</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="pcoded-navigation-label" data-i18n="nav.category.forms">certificate</div>
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-book"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Seed Certificates </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">

                                                <li>
                                                    <a href="add_certificate.php" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-agenda"></i><b>FC</b></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Register Certificate </span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="available_certificates.php" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-files"></i><b>FC</b></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Available Certificates</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="used_certificates.php" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-na"></i><b>FC</b></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Used Certificates</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="expired_certificates.php" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-trash"></i><b>FC</b></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Expired Certificates</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>



                                            </ul>
                                        </li>
                                    </ul>

                                    <div class="pcoded-navigation-label" data-i18n="nav.category.other">Grower </div>
                                    <ul class="pcoded-item pcoded-left-item">



                                        <li class="pcoded-hasmenu ">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                                                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Growers</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">

                                                <li class="">
                                                    <a href="active_growers.php" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-id-badge"></i><b>FC</b></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Active Growers</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="inactive_growers.php" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-id-badge"></i><b>FC</b></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Inactive Growers</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>



                                            </ul>
                                        </li>
                                        <li>
                                            <a href="register_farm.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-map-alt"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Register Farm</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="registered_farms.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-gallery"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Registered farms</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-car"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Inspection</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>


                                    </ul>

                                    <div class="pcoded-navigation-label" data-i18n="nav.category.other">Lab test</div>

                                    <ul class="pcoded-item pcoded-left-item">


                                        <li class="">
                                            <a href="new_test.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-paint-bucket"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main"> New lab test </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="active_test.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-reload"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Active lab test </span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="test_history.php" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-book"></i><b>FC</b></span>
                                                <span class="pcoded-mtext" data-i18n="nav.form-components.main">Test History</span>
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
                                            <h5 class="m-b-10">Grade seed </h5>
                                            <p class="m-b-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="production_dashboard.php"> <i class="fa fa-home"></i> </a>
                                            </li>

                                            <li class="breadcrumb-item"><a href="admin_pending_orders.php">Grade seed </a>

                                            </li>
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
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <!-- Basic table card start -->
                                        <!-- Basic table card end -->
                                        <!-- Inverse table card start -->

                                        <!-- Inverse table card end -->
                                        <!-- Hover table card start -->

                                        <!-- Hover table card end -->
                                        <!-- Contextual classes table starts -->


                                        <!-- Contextual classes table ends -->
                                        <!-- Background Utilities table start -->

                                        <div class="card">
                                          
                                                <!-- // " -->
                                                <div class="card-header">
                                                    <h5>Seed details </h5>

                                                    <div class="card-header-right">
                                                        <ul class="list-unstyled card-option">
                                                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                                            <li><i class="fa fa-trash close-card"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="form-group row">


                                                        <span class="pcoded-mcaret"></span>

                                                        <div class="col-sm-2">
                                                            <label class="badge badge-success ">stock in ID</label>
                                                            <select class="form-control" name="grade_id">
                                                                <option value="<?php echo $grade_ID; ?>"><?php echo $grade_ID; ?></option>
                                                            </select>



                                                        </div>


                                                        <div class="col-sm-2">

                                                            <label class="badge badge-success ">Crop</label>
                                                            <select class="form-control" name="crop">
                                                                <option value="<?php echo $crop; ?>"><?php echo $crop; ?></option>
                                                            </select>



                                                        </div>



                                                        <div class="col-sm-2">

                                                            <label class="badge badge-success ">Variety</label>
                                                            <select class="form-control" name="variety">
                                                                <option value="<?php echo $variety; ?>"><?php echo $variety; ?></option>
                                                            </select>



                                                        </div>

                                                        <div class="col-sm-2">
                                                            <label class="badge badge-success ">Class</label>
                                                            <select class="form-control" name="class">
                                                                <option value="<?php echo $class; ?>"><?php echo $class; ?></option>
                                                            </select>



                                                        </div>

                                                        <div class="col-sm-2">
                                                            <label class="badge badge-success ">Quantity</label>
                                                            <select class="form-control" name="quantity">
                                                                <option value="<?php echo $quantity; ?>"><?php echo $quantity; ?></option>
                                                            </select>



                                                        </div>



                                                        <div class="col-sm-2">
                                                            <label class="badge badge-success ">Stock In Date</label>
                                                            <select class="form-control" name="">
                                                                <option value="<?php echo $quantity; ?>"><?php echo $quantity; ?></option>
                                                            </select>



                                                        </div>







                                                        <div class="card-block">






                                                        </div>



                                                    </div>




                                                </div>
                                        </div>



                                        <!-- Background Utilities table end -->
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Confirm received seed</h5>

                                            <div class="card-header-right">
                                                <ul class="list-unstyled card-option">
                                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                                    <li><i class="fa fa-trash close-card"></i></li>
                                                </ul>
                                            </div>


                                        </div>

                                        <div class="card-block">




















                                            <form action="file_upload.php" method="POST" enctype="multipart/form-data">


                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label> Conformation Document:</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="file" class="form-control" name="fileDirectory" accept=".pdf" id="fileDirectory">
                                                        <input type="hidden" class="form-control" name="tempFile" id="tempFile">




                                                        <label id="warning_dir" class="warning_text"> <span>Please upload supporting documents <i class="icofont icofont-warning"></i></span></label>
                                                    </div class="form-group row" require="">






                                                    </br></br></br>

                                                    <div>


                                                    </div>









                                                </div>

                                            </form>



                                           
                                                   
                                                    <input type="hidden" id="grade_id" name="grade" value="<?php echo $grade_ID; ?>">
                                                    <input type="hidden" id="receive_id" name="receive_id" value="<?php echo $received_ID; ?>">
                                                    <input type="hidden" id="receive_name" name="receive_name" value="<?php echo $received_name; ?>">
                                                    <input type="hidden" id="passed_quantity" value="<?php echo $quantity; ?>">
                                                    <input type="hidden" id="stock_in_id" value="<?php echo $stock_in; ?>">

                                             
                                        








                                            <div class="form-group row">







                                                </br></br></br>


                                                <div>

                                                </div>

                                                <br>
                                                .
                                                <div class="form-group">

                                                    <button id="confirm" class="btn btn-success btn-mat"> <i class="ti ti-thumb-up"></i>confirm</button>
                                                    <button id="deny" class="btn btn-danger btn-mat"> <i class="ti ti-thumb-down"></i>deny</button>


                                                </div>
                                                </br></br></br>


                                                <div>

                                                </div>







                                              



                                            </div>

                                        </div>
                                        <!-- Input Grid card end -->
                                        <!-- Input Validation card start -->

                                        <!-- Input Validation card end -->
                                        <!-- Input Alignment card start -->

                                        <!-- Input Alignment card end -->
                                    </div>

                                    <div class="card">

                                        <div class="card-block">
                                            <div class="form-group">



                                                <button class="btn waves-effect waves-light btn-info btn-mat" id="back"><i class="ti-back-left"></i>Back</button>




                                            </div>


                                        </div>

                                    </div>





                                    <!-- Background Utilities table end -->
                                </div>
                                <!-- Page-body end -->
                            </div>
                        </div>
                        <!-- Main-body end -->

                        <div id="styleSelector">

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
        <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
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
    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js "></script>
    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="assets/js/modernizr/modernizr.js "></script>
    <!-- Custom js -->
    <script src="assets/js/pcoded.min.js"></script>
    <script src="assets/js/vertical-layout.min.js "></script>
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>
<?php

//upload conformation document

if (isset($_FILES['conformation_file'])) {
    $errors = array();
    $file_name = $_FILES['conformation_file']['name'];
    $file_size = $_FILES['conformation_file']['size'];
    $file_tmp = $_FILES['conformation_file']['tmp_name'];
    $file_type = $_FILES['conformation_file']['type'];

    $newfilename = date('dmYHis') . str_replace(" ", "", basename($_FILES["conformation_file"]["name"]));


    $file_ext = strtolower(end(explode('.', $_FILES['conformation_file']['name'])));

    $extensions = array("pdf");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 2 MB';
    }

    if (empty($errors) == true) {
        move_uploaded_file($_FILES["conformation_file"]["tmp_name"], "../files/production/handover_conformation_documents/" . $newfilename);
        echo "Success";
    } else {
        $error = implode($errors);
        echo ("<script> alert('$error');
            window.location.href = 'process_seed.php';
        </script>");
    }
}

if (isset($_POST['confirm'])) {

    $object = new main();
    $grade_id = $_POST['grade'];
    $id = $_POST['receive_id'];
    $name = $_POST['receive_name'];
    $passed_quantity = $_POST['passed_quantity'];
    $stock_in = $_POST['stock_in_ID'];
    $object->handover_conformation($id, $name, $newfilename, $grade_id, $passed_quantity, $stock_in);
}



?>

</html>