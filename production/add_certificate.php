<!DOCTYPE html>
<html lang="en">
<?php

Ob_start();
include('../class/main.php');
session_start();

$test = $_SESSION['fullname'];
$position= $_SESSION['position'];

if (empty($test)) {

    header('Location:../index.php');
}

$restricted = array("production_admin", "system_administrator", "lab_technician", "field_officer");

if (in_array($position, $restricted)) {
} else {
    header('Location:../restricted_access/restricted_access.php');
}


?>

<head>
    <title>STTS </title>
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
    <link rel="stylesheet" type="text/css" href="assets/css/style_.css">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">

    <script type="text/javascript" src="../jquery/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jsHandle/add_certificate___.js"></script>
   


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
                            
                        </div>
                        <a href="">
                            <span>PRODUCTION</span>
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
                                    <img src="../files/user_profile/<?php  if ($_SESSION["profile"] =="") {
                                                                                $profile = "user.jpg";
                                                                            } else {
                                                                                $profile = $_SESSION["profile"];
                                                                            }echo $profile;?>" class="img-radius" alt="User-Profile-Image">
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
                                    <img class="img-80 img-radius" src="../files/user_profile/<?php  if ($_SESSION["profile"] =="") {
                                                                                $profile = "user.jpg";
                                                                            } else {
                                                                                $profile = $_SESSION["profile"];
                                                                            }echo $profile;?>" alt="User-Profile-Image">
                                    <div class="user-details">
                                        <span id="more-details"><?php echo $_SESSION['fullname'] ?><i class="fa fa-caret-down"></i></span>
                                    </div>
                                </div>

                                
                            </div>
                            <div class="p-15 p-b-0">

                            </div>
                            <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Home</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="">
                                    <a href="production_dashboard.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                            </ul>
                            <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Stock</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="">
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
                                    <a href="view_stock_in.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Stock out</span>
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

                            <li class="">
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


                            <li class="pcoded-hasmenu active pcoded-trigger">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-book"></i></span>
                                        <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Seed Certificates </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        
                                    <li class="active">
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

                                <li>
                                    <a href="used_certificates.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-na"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Used Certificates</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                <li>
                                    <a href="expired_certificates.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-trash"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Expired Certificates</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                       
                            
                                    </ul>
                                </li>
                                

                            </ul>

                            <div class="pcoded-navigation-label" data-i18n="nav.category.other">Grower</div>
                            <ul class="pcoded-item pcoded-left-item">


                                
                            <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
                                        <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Growers</span>
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

                                <li >
                                    <a href="registered_farms.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-gallery"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Registered farms</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                <li>
                                    <a href="available_certificates.php" class="waves-effect waves-dark">
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

                                <li class="">
                                    <a href="active_test.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-reload"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Active lab test </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
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
                                            <h5 class="m-b-10">New certificate </h5>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="production_dashboard.php"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            
                                            <li class="breadcrumb-item"><a href="php_certificate.php">Add certificate</a>
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
                                            <h5>Register Certificate </h5>


                                        </div>
                                        <div class="card-block">

                                            <!-- <form action="add_certificate.php" method="POST" enctype="multipart/form-data"> -->



                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select id="select_crop" name="select_crop" class="form-control" required="">
                                                            <option value="0">Select crop</option>
                                                            <option value="CP001">Maize</option>
                                                            <option value="CP002">Ground nuts -shelled-</option>
                                                            <option value="CP003">Ground nuts -unshelled-</option>
                                                            <option value="CP009">Soyabean </option>
                                                            <option value="CP005">Rice</option>
                                                            <option value="CP004">Sorgum</option>
                                                            <option value="CP006">Cowpea</option>
                                                            <option value="CP007">Pigeonpea</option>
                                                            <option value="CP008">Beans</option>




                                                        </select>
                                                        <label id="warning_crop" class="warning_text"> <span>Please select crop<i class="icofont icofont-warning"></i></span></label>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select id="select_variety" name="select_variety" class="form-control" required="">
                                                            <option value="not_selected">Select Variety</option>



                                                        </select>
                                                        <label id="warning_variety" class="warning_text"> <span>Please select seed variety<i class="icofont icofont-warning"></i></span></label>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select id="select_class" name="class" class="form-control" required="">
                                                            <option value="0">Select class</option>
                                                            <option value="breeder">Breeder</option>
                                                            <option value="pre_basic">Pre-Basic</option>
                                                            <option value="basic">Basic</option>
                                                            <option value="certified">Certified</option>
                                                         

                                                        </select>
                                                        <label id="warning_class" class="warning_text"> <span>Please select seed class<i class="icofont icofont-warning"></i></span></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select id="certificate_type" name="certificate_type" class="form-control" required="">
                                                            <option value="0">Select type</option>
                                                            <option value="parent">certificate </option>
                                                            <option value="male">male certificate</option>
                                                            <option value="female">female certificate</option>

                                                        </select>
                                                        <label id="warning_certificate_type" class="warning_text"> <span>Please select Certificate type<i class="icofont icofont-warning"></i></span></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">






                                                </div>


                                                <div class="form-group row">

                                                    <div class="col-sm-12">
                                                        <input id="lot_number" type="text" class="form-control" name="lot_number" placeholder="Lot number" require="">
                                                        <label id="warning_lot_number" class="warning_text"> <span>Please enter Lot Number<i class="icofont icofont-warning"></i></span></label>
                                                    </div>


                                                </div>

                                                <div class="form-group row">

                                                    <div class="col-sm-12">
                                                        <input id="quantity" type="number" class="form-control" name="quantity" placeholder="Quantity" require="">
                                                        <label id="warning_quantity" class="warning_text"> <span>Please enter Quantity<i class="icofont icofont-warning"></i></span></label>
                                                    </div>


                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <select id="source" name="source" class="form-control" required="">
                                                            <option value="source_not_selected">Select Source</option>
                                                            <option value="internal">internal</option>
                                                            <option value="external">external</option>




                                                        </select>
                                                        <label id="warning_source" class="warning_text"> <span>Please select seed source<i class="icofont icofont-warning"></i></span></label>
                                                    </div>

                                                </div>

                                                <div class="form-group row">

                                                    <div class="col-sm-12">
                                                        <input id="source_name" type="text" class="form-control" name="source_name" placeholder="Source Name" require="">
                                                        <label id="warning_source_name" class="warning_text"> <span>Please enter source name <i class="icofont icofont-warning"></i></span></label>
                                                    </div>


                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label>Tested date :</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="date" id="date_tested" class="form-control" name="date_tested" require="">
                                                        <label id="warning_test_date" class="warning_text"> <span>Please select tested date<i class="icofont icofont-warning"></i></span></label>
                                                    </div>
                                                    
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label>Expire date:</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="date" id="expire_date" class="form-control" name="Expire_date" placeholder="-" require="">
                                                        <label id="warning_expire_date" class="warning_text"> <span>Please select expire date<i class="icofont icofont-warning"></i></span></label>
                                                    </div>
                                                   
                                                </div>



                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label>upload certificate (PDF only):</label>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <input type="file" class="form-control" name="file_directory" id="file_directory" >
                                                        <input type="hidden" class="form-control" name="user" id="user" value="<?php echo $_SESSION['user']?>" >
                                                        <input type="hidden" class="form-control" name="tempFile" id="tempFile" >

                                                        <label id="warning_file" class="warning_text"> <span>Please upload required files<i class="icofont icofont-warning"></i></span></label>

                                                    </div class="form-group row" require="">



                                                    <!-- </form> -->


                                                    </br></br></br>


                                                    <div>

                                                    </div>

                                                    <br>
                                                    .
                                                    <div class="form-group">
                                                    <div class="col-sm-12">


                                                    <button id="save_certificate" class="btn waves-effect waves-light btn-success  btn-mat">
                                                        <i class="icofont icofont-save"></i>
                                                       Save
                                                    </button>

                                                    </div>

                                                    

    </br>

                                                    <div class="col-sm-12">

                                                    <a href="add_certificate.php" class="btn waves-effect waves-light btn-danger  btn-mat">  <i class="icofont icofont-"></i> Cancel</a>

                                                    
                                                    </div>


                                                        <!-- <input type="submit" name="add_certificate" value="Save Certificate" class="btn waves-effect waves-light btn-success btn-block" />
                                                        <input type="submit" name="place_order" value="Cancle" class="btn waves-effect waves-light btn-danger  btn-block" /> -->

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





?>

</html>