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
$restricted = array("production_admin", "system_administrator","warehouse_officer");

if (in_array($position, $restricted)) {
} else {
    header('Location:../restricted_access/restricted_access.php');
}

// else if($position !="warehouse_officer" || $position !="production_admin" || $position !="ADMIN"){
     
//         header('Location:javascript://history.go(-1)');

// }

?>

<head>
    <title>Mega Able bootstrap admin template by codedthemes </title>
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

            const loaded = "1";

$.post('get_products.php', {
        loaded: loaded
       
    }, data => {
        $('#select_crop').html(data);



    });


            $("#creditor_search").on("input", function() {

                var data = $('#creditor_source').find(':selected');

                if (data.val() == "source_not_selected") {

                    alert("please select source first ");
                } else {

                    var result_value = $('#creditor_search').val();
                    var select = $('#creditor_source').find(':selected');
                    var data = select.val();
                    $.post('get_creditors.php', {
                        data: data,
                        result_value: result_value
                    }, function(data) {
                        $('#search_result').html(data);

                    })
                }




            });



            $("#farm_search").on("input", function() {

                var farm_value = $('#farm_search').val();
                var grower_value = $('#search_result').find(':selected');
                var grower_data = grower_value.val();

                $.post('get_creditors.php', {
                    farm_value: farm_value,
                    grower_data: grower_data
                }, function(data) {
                    $('#search_farm_result').html(data);





                })

            });


            $("#search_certificate").on("input", function() {


                var stockIn_quantity = $('#external_quantity').val();
                var stockIn_certificate = $('#search_certificate').val();
                var crop_value = $('#select_crop').val();
                var variety_value = $('#select_variety').val();
                var class_value = $('#select_class').val();


               



                $.post('get_creditors.php', {
                    stockIn_certificate: stockIn_certificate,
                    stockIn_quantity: stockIn_quantity,
                    crop_value: crop_value,
                    variety_value: variety_value,
                    class_value: class_value
                }, function(data) {
                    $('#certificate').html(data);



                });

            });

            $('#select_crop').change(function() {

               
                let crop_value = $('#select_crop').val();
               
               $.post('get_products.php', {
                   crop_value: crop_value
                  
               }, data => {
                   $('#select_variety').html(data);



               });




            });


            $('#creditor_source').change(function() {


                var data = $('#creditor_source').find(':selected');

                if (data.val() == "source_not_selected") {
                    alert("please select source ");
                } else if (data.val() == "MUSECO") {

                    document.getElementById('creditor_name').readOnly = true;
                    document.getElementById('creditor_email').readOnly = true;
                    document.getElementById('creditor_phone').readOnly = true;
                    document.getElementById('creditor_description').readOnly = true;

                    var search_value = data.val();

                    $.post('get_creditors.php', {
                        search_value: search_value,
                        data: data
                    }, function(data) {

                        $('#search_result').html(data);

                    })

                } else if (data.val() == "External") {

                    document.getElementById('creditor_name').readOnly = false;
                    document.getElementById('creditor_email').readOnly = false;
                    document.getElementById('creditor_phone').readOnly = false;
                    document.getElementById('creditor_description').readOnly = false;

                }

            });




            $('#search_farm_result').change(function() {

                var data = $('#search_farm_result').find(':selected');
                var search_farm_result = data.val();

                $.post('get_creditors.php', {
                    search_farm_result: search_farm_result
                }, function(data) {



                    fetch("farm_data.json")

                        .then(response => response.json())
                        .then(data => {

                            $('#farm_crop').empty();
                            $('#farm_crop').append(new Option(data.crop, data.crop_id));

                            $('#farm_variety').empty();
                            $('#farm_variety').append(new Option(data.variety, data.variety_id));
                            $('#farm_class').empty();
                            $('#farm_class').append(new Option(data.farm_class, data.farm_class));

                            $('#farm_physical_address').empty();

                            $('#farm_physical_address').val(data.address);

                        })





                    // $('#farm_crop').html(data)


                    // $('#farm_crop').empty();
                    // $('#farm_crop').append(new Option(crop, crop_id));


                    // $('#farm_variety').empty();
                    // $('#farm_variety').append(new Option(variety, variety_id));
                    // $('#farm_class').empty();
                    // $('#farm_class').append(new Option(class_value, class_value));

                    // $('#farm_physical_address').empty();

                    // ('#farm_physical_address').append(new text("working"));

                })








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
                        <a href="index.html">
                            <span>Production</span>
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
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <i class="ti-bell"></i>
                                    <span class="badge bg-c-red"></span>
                                </a>
                                <ul class="show-notification">
                                    <li>
                                        <h6>Notifications</h6>
                                        <label class="label label-danger">New</label>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <div class="media">
                                            <img class="d-flex align-self-center img-radius" src="assets/images/avatar-2.jpg" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user"></h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <div class="media">
                                            <img class="d-flex align-self-center img-radius" src="assets/images/avatar-4.jpg" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user">Joseph William</h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <div class="media">
                                            <img class="d-flex align-self-center img-radius" src="assets/images/avatar-3.jpg" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user">Sara Soudein</h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="user-profile header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <img src="assets/images/user.jpg" class="img-radius" alt="User-Profile-Image">
                                    <span><?php echo $_SESSION['fullname'] ?></span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    <li class="waves-effect waves-light">
                                        <a href="#!">
                                            <i class="ti-settings"></i> Settings
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="user-profile.html">
                                            <i class="ti-user"></i> Profile
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="email-inbox.html">
                                            <i class="ti-email"></i> My Messages
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="auth-lock-screen.html">
                                            <i class="ti-lock"></i> Lock Screen
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

                            </div>
                            <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Home</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="">
                                    <a href="marketing_dashboard.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                            </ul>
                            <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Stock</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="active">
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
                                    <a href="view_pending_orders.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-clipboard"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">inventory</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>




                            </ul>

                            <div class="pcoded-navigation-label" data-i18n="nav.category.forms">certificate</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="">
                                    <a href="add_certificate.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-agenda"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Add certificate </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="available_certificates.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-files"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">available certificates</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                <li>
                                    <a href="used_certificates.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-na"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">used certificates</span>
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

                            <div class="pcoded-navigation-label" data-i18n="nav.category.other">Grower </div>
                            <ul class="pcoded-item pcoded-left-item">

                               
                            <li class="">
                                    <a href="grower.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-id-badge"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Grower </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
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
                                            <h5 class="m-b-10">Stock In </h5>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">Home</a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">Stock in</a>
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
                                    <div class="page-body">

                                        <div class="card">
                                            <div class="card-header">

                                                <button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal">Add new creditor </button>

                                                <!-- Modal -->
                                                <div id="myModal" class="modal fade" role="dialog">
                                                    <div class="modal-dialog modal-lg">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h5 class="modal-title">Register new creditor </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="stock_in.php" method="POST" enctype="multipart/form-data">

                                                                    <div class="form-group row">

                                                                        <div class="col-sm-12">
                                                                            <input id="creditor_name" type="text" class="form-control" name="creditor_name" placeholder="Name" require="">
                                                                        </div>


                                                                    </div>



                                                                    <div class="form-group row">

                                                                        <div class="col-sm-12">
                                                                            <input id="creditor_phone" type="text" class="form-control" name="creditor_phone" placeholder="Phone number" require="">
                                                                        </div>


                                                                    </div>


                                                                    <div class="form-group row">

                                                                        <div class="col-sm-12">
                                                                            <input id="creditor_email" type="text" class="form-control" name="creditor_email" placeholder="Email (optional)" require="">
                                                                        </div>


                                                                    </div>



                                                                    <div class="form-group row">

                                                                        <div class="col-sm-12">
                                                                            <input id="creditor_description" type="text" class="form-control" name="creditor_description" placeholder="Description" require="">
                                                                        </div>


                                                                    </div>

                                                                    <div class="col-sm-6">

                                                                        <input type="submit" name="add_creditor" value="save " class="btn btn-success" />

                                                                    </div>








                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Creditor </h5>

                                                        <div ">
                                                         

                                                        </div>
                                                        
                                                        <div class=" card-block">



                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <select id="creditor_source" name="creditor_source" class="form-control" required="">




                                                                        <option value="source_not_selected">Select source</option>
                                                                        <option value="MUSECO">MUSECO</option>
                                                                        <option value="External">External</option>




                                                                    </select>
                                                                </div>

                                                            </div>




                                                            <div class="form-group row">

                                                                <span class="pcoded-mcaret"></span>

                                                                <div class="col-sm-6">


                                                                    <select id="search_result" name="search_result" class="form-control">

                                                                        <option value="0">Select Creditor</option>







                                                                    </select>

                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <input id="creditor_search" type="text" class="form-control" name="creditor_search" placeholder="Search  by name" require="">
                                                                </div>


                                                            </div>



                                                        </div>




                                                    </div>

                                                </div>





                                                .

                                            </div>
                                        </div>
                                    </div>

                                   
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 id="heading">Select farm ( Source internal )</h5>


                                        </div>
                                        <div class="card-block">

                                            <div class="form-group row">

                                            

                                                <div class="col-sm-6">


                                                    <select id="search_farm_result" name="search_farm_result" class="form-control">

                                                        <option value="0">Select farm ID</option>







                                                    </select>

                                                </div>

                                                <div class="col-sm-6">
                                                    <input id="farm_search" type="text" class="form-control" name="farm_search" placeholder="Search farm by ID" require="">
                                                </div>





                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label>Crop :</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <select id="farm_crop" name="farm_crop" class="form-control">

                                                        <option value="0">-</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label>Variety:</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <select id="farm_variety" name="farm_variety" class="form-control">

                                                        <option value="0">-</option>



                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label>Class :</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <select id="farm_class" name="farm_class" class="form-control">

                                                        <option value="0">-</option>


                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">


                                                <div class="col-sm-12">

                                                    <input id="farm_quantity" type="text" class="form-control" name="farm_quantity" placeholder="Enter Quantity" require="">



                                                </div>



                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label>Physical address :</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" id="farm_physical_address">
                                                                                </textarea>
                                                </div>
                                            </div>
                                        </div>






                                    </div>

                                    <!-- Basic Form Inputs card end -->
                                    <!-- Input Grid card start -->


                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Select seed details ( Source external )</h5>


                                        </div>
                                        <div class="card-block">






                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select id="select_crop" name="crop" class="form-control" required="">
                                                        




                                                    </select>
                                                </div>


                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select id="select_variety" name="variety" class="form-control" required="">
                                                        <option value="variety_not_selected">Select Variety</option>



                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select id="select_class" name="select_class" class="form-control" required="">
                                                        <option value="0">Select class</option>
                                                        <option value="basic">Basic</option>
                                                        <option value="pre_basic">Pre-Basic</option>
                                                        <option value="certified">Certified</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">


                                                <div class="col-sm-12">

                                                    <input id="external_quantity" type="text" class="form-control" name="external_quantity" placeholder="Enter Quantity" require="">



                                                </div>



                                            </div>


                                            <div class="form-group row">


                                                <span class="pcoded-mcaret"></span>


                                                <div class="col-sm-6">

                                                    <select id="certificate" name="certificate" class="form-control" required="">
                                                        <option value="no_certificate_selected">Select Certificate</option>
                                                        <option value="no_certificate_selected">-</option>






                                                    </select>

                                                </div>

                                                <div class="col-sm-6">

                                                    <input id="search_certificate" type="text" class="form-control" name="search_certificate" placeholder="Search certificate" require="">



                                                </div>


                                            </div>


                                            <div class="form-group row">

                                                <div class="col-sm-12">

                                                    <a href="add_certificate.php" class="btn btn-success">
                                                        Add New certificate

                                                    </a>

                                                </div>


                                            </div>
                                        </div>

                                    </div>







                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Item to stock</h5>


                                        </div>
                                        <div class="card-block">











                                            
                                           

                                            <div class="form-group row">

                                                <div class="col-sm-12">
                                                    <input id="description" type="text" class="form-control" name="description" placeholder="description" require="">
                                                </div>


                                            </div>








                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label>Seed Receive Note #:</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <input type="text" id="srn" class="form-control" name="srn" placeholder="-" require="">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label>Bin card #:</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <input type="text" id="bin_card " class="form-control" name="bin_card" placeholder="-" require="">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label>number of bags :</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <input type="text" id="number_of_bags" class="form-control" name="number_of_bags" placeholder="-" require="">
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label> Supporting Document:</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <input type="file" class="form-control" name="image" id="image">
                                                </div class="form-group row" require="">






                                                </br></br></br>


                                                <div>

                                                </div>

                                                <br>
                                                .
                                                <div class="form-group">


                                                    <input type="submit" name="add_to_stock" value="Add to stock" class="btn waves-effect waves-light btn-success btn-block" />
                                                    <input type="submit" name="cancle_stock_in" value="cancle" class="btn waves-effect waves-light btn-danger  btn-block" />

                                                </div>





                                                </form>



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





//upload PDF file for supporting documents 


if (isset($_FILES['image'])) {
    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];

    $newfilename = date('dmYHis') . str_replace(" ", "", basename($_FILES["image"]["name"]));


    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

    $extensions = array("pdf");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 2 MB';
    }

    if (empty($errors) == true) {
        move_uploaded_file($_FILES["image"]["tmp_name"], "stock_in_documents/" . $newfilename);
        echo "Success";
    } else {
        print_r($errors);
    }
}
//add stock in call function 

if(isset($_POST['add_creditor'])){

    echo ("<script> alert('certificate added!');
                                </script>");

    $object = new main();
    $object->add_creditor("External",$_POST['creditor_name'],$_POST['creditor_phone'], $_POST['creditor_email'],$_POST['creditor_description'],"dir");
     

}

if (isset($_POST['add_to_stock'])) {

    $source = $_POST['creditor_source'];
    $creditor = $_POST['search_result'];
    $srn =$_POST['srn'];
    $bincard = $_POST['bin_card'];
    $bags = $_POST['number_of_bags'];
    $quantity = "";
    $description =$_POST['description'];
    $crop = "";
    $variety = "";
    $class = "";
    $farm_ID ="";
    $certificate ="";
    $status ="";

    if ($source == "MUSECO") {

        $crop = $_POST['farm_crop'];
        $variety = $_POST['farm_variety'];
        $class = $_POST['farm_class'];
        $farm_ID = $_POST['search_farm_result'];
        $certificate ="";
        $quantity = $_POST['farm_quantity'];
        $status = "ungraded";

    } else if ($source == "External") {

        $crop = $_POST['crop'];
        $variety = $_POST['variety'];
        $class = $_POST['select_class'];
        $quantity = $_POST['external_quantity'];
        $certificate = $_POST['certificate'];
        $status = "certified";
    }
    else{
        echo ("<script> alert('please add information first');
    </script>");
    }
   

    $object = new main();
    $object->stock_in($creditor, $certificate, $farm_ID, $status, $crop, $variety, $class, $source, $srn, $bincard, $bags, $quantity, $description, $newfilename);

    
}

?>

</html>