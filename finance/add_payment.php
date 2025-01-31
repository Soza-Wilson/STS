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

$restricted = array("system_administrator","finance_admin","cashier");

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
    <link rel="stylesheet" type="text/css" href="assets/css/style_.css">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">

    <script type="text/javascript" src="../jquery/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {



            $('#select_class').change(function() {

                var crop_data = $('#select_crop').val();
                var variety_data = $('#select_variety').val();
                var class_data = $('#select_class').val();

                if (crop_data == 0) {

                    alert('Select crop and variety');


                } else if (variety_data == 0) {

                    alert('Select crop and variety');

                } else {

                    $.post('get_prices.php', {
                        crop_data: crop_data,
                        variety_data: variety_data,
                        class_data: class_data
                    }, function(data) {

                        $('#price_per_kg').val(data);

                    });
                }




            });


            $('#debtor_type').change(function() {

                var type_value = $('#debtor_type').val();

                if (type_value == 'agro_dealer') {

                    $('#customer_name').attr('placeholder', 'Search agro dealer by name');
                    $('#description').attr('placeholder', 'agro dealer phone');


                } else if (type_value == 'b_to_b') {

                    $('#customer_name').attr('placeholder', 'Search Business by name');
                    $('#description').attr('placeholder', 'Business description');



                } else if (type_value == 'customer') {

                    $('#customer_name').attr('placeholder', 'Enter customer name');
                    $('#description').attr('placeholder', 'Enter customer phone number ');


                } else if (type_value == 'grower') {

                    $('#customer_name').attr('placeholder', 'Search grower by name');
                    $('#description').attr('placeholder', 'grower farm crop and variety ');


                }



                $("#search_main_certificate").on("input", function() {


                    var main_certificate_value = $('#search_main_certificate').val();
                    var main_quantity_value = $('#main_quantity').val();
                    var crop_value = $('#select_crop').val();
                    var variety_value = $('#select_variety').val();
                    var class_result = $('#select_class').val();


                    $.post('farm_get_certificate.php', {
                        main_certificate_value: main_certificate_value,
                        main_quantity_value: main_quantity_value,
                        crop_value: crop_value,
                        variety_value: variety_value,
                        class_value: class_value
                    }, function(data) {
                        $('#main_certificate').html(data);


                    })

                });








            });

            $('#customer_name').on("input", function() {


                let type_value = $('#debtor_type').val();
                let search_value = $('#customer_name').val();
                let search_result = $('#search_result').val();

                if (type_value == "type_not_selected") {

                    alert('please select order type');
                } else if (type_value == "agro_dealer") {

                    $.post('../marketing/get_data.php', {
                        type_value: type_value,
                        search_value: search_value,

                    }, function(data) {
                        $('#search_result').html(data);
                        // $('#description').attr('value',$('#search_result').val() + '  ( Agro_dealer phone number )');

                        var data = $('#search_result').val();
                        var test = data.split(',');

                        $('#description').attr('value', test[1]);


                    });

                    $.post('../marketing/get_transactions.php', {
                        type_value: type_value,
                        search_value: search_value,
                        search_result: search_result,
                    }, data => {
                        $('#transaction_table').html(data);
                    });




                } else if (type_value == "b_to_b") {

                    $.post('../marketing/get_data.php', {
                        type_value: type_value,
                        search_value: search_value,
                        search_result: search_result,

                    }, function(data) {
                        $('#search_result').html(data);
                        // $('#description').attr('value',$('#search_result').val() + '  ( Business description )');

                        var data = $('#search_result').val();
                        var test = data.split(',');

                        $('#description').attr('value', test[1] + ' ( Businesss description )');

                    });

                    $.post('../marketing/get_transactions.php', {
                        type_value: type_value,
                        search_value: search_value,
                        search_result: search_result,
                    }, data => {
                        $('#transaction_table').html(data);
                    });




                } else if (type_value == "customer") {


                    $.post('../marketing/get_data.php', {
                        type_value: type_value,
                        search_value: search_value,
                        search_result: search_result,

                    }, function(data) {
                        $('#search_result').html(data);
                        // $('#description').attr('value',$('#search_result').val() + '  ( Business description )');

                        var data = $('#search_result').val();
                        var test = data.split(',');
                        var temp_data = "-";


                        if (test == null) {

                            temp_data = "enter -"
                        } else {

                            temp_data = test[1];
                        }


                        $('#description').attr('placeholder', temp_data + ' (customer phone number) ');


                    });

                    $.post('../marketing/get_transactions.php', {
                        type_value: type_value,
                        search_value: search_value,
                        search_result: search_result,
                    }, data => {
                        $('#transaction_table').html(data);
                    })







                } else if (type_value == "grower") {


                    $.post('../marketing/get_data.php', {
                        type_value: type_value,
                        search_value: search_value,
                        search_result: search_result,

                    }, function(data) {
                        $('#search_result').html(data);
                        // $('#description').attr('value',$('#search_result').val() + '  ( Business description )');

                        var data = $('#search_result').val();
                        var test = data.split(',');

                        $('#description').attr('value', test[1] + ' ( grower phone number )');

                    })

                    $.post('../marketing/get_transactions.php', {
                        type_value: type_value,
                        search_value: search_value,
                        search_result: search_result,
                    }, data => {
                        $('#transaction_table').html(data);
                    });


                }

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
                            <span>Finance</span>
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
                                    <a href="finance_dashboard.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                            </ul>
                            

                            

                            

                            <div class="pcoded-navigation-label" data-i18n="nav.category.other">Debtor Payments</div>
                            <ul class="pcoded-item pcoded-left-item">

                                <li class="active">
                                    <a href="add_payment.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-money"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Add Payment </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="debtor_processed_payment.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-list-ol"></i></span>
                                        <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Processed Payments</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>

                                <li class="">
                                    <a href="debtor_outstanding_payments.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-clip"></i></span>
                                        <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Outstanding Payments</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>

                                <li class="">
                                    <a href="debtor_accounts.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-stats-up"></i></span>
                                        <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Debtor accounts</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>

                                </ul>

                                <div class="pcoded-navigation-label" data-i18n="nav.category.other">Creditor payback</div>
                            <ul class="pcoded-item pcoded-left-item">

                                <li class="">
                                    <a href="add_payback_payment.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-money"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Add Payback Payment </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="creditor_processed_payments.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-list-ol"></i></span>
                                        <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Processed Payments</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>

                                <li class="">
                                    <a href="creditor_outstanding_payments.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-clip"></i></span>
                                        <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Outstanding Payments</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>

                                <li class="">
                                    <a href="creditor_accounts.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-truck"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Creditor accounts</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                







                            </ul>
                            </li>

                            <div class="pcoded-navigation-label" data-i18n="nav.category.other">Finacial Statemets</div>
                            <ul class="pcoded-item pcoded-left-item">

                            <li class="">
                                    <a href="bank_account.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-credit-card"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main"> Bank accounts</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                               
                                <li class="">
                                    <a href="finance_ledger.php" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-list-ol"></i></span>
                                        <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Ledger</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>

                                </li>

                               







                            </ul>
                            </li>
                            
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Add Debtor Payment </h5>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="finance_dashboard.php"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            
                                            <li class="breadcrumb-item"><a href="add_payment.php">Add Debtor Payment</a>
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
                                                    <h5>Select Payment Type</h5>


                                                </div>
                                                <div class="card-block">


                                                    <div class="form-group row">
                                                        <div class="col-sm-6">
                                                            <select id="debtor_type" name="debtor_type" class="form-control" required="">
                                                                <option value="type_not_selected">Select Debtor Type</option>
                                                                <option value="agro_dealer">agro dealer</option>
                                                                <option value="grower">grower</option>
                                                                <option value="b_to_b">B to B</option>
                                                                <option value="customer">Customer</option>



                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Search " require="">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <select id="search_result" name="search_result" class="form-control" required="">
                                                                <option value="not_selected">-</option>



                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="description" name="description" placeholder=" " require="">



                                                            </select>
                                                        </div>

                                                    </div>


                                                </div>

                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Outstanding payments</h5>
                                                            <div class="card-block table-border-style">
                                                                <div class="table-responsive" id="table_test">
                                                                    <table class="table" id="transaction_table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Trans_ID</th>
                                                                                <th>status</th>
                                                                                <th>Time</th>
                                                                                <th>Date</th>
                                                                                <th>amount</th>

                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?php
                                                                        

                                                                               
                                                                            
 

                                                                                $sql = "SELECT * FROM `transaction` WHERE type ='customer' AND trans_status = 'payment_pending' OR trans_status = 'partly_payed'";

                                                                                $result = $con->query($sql);
                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        $trans_ID      = $row["transaction_ID"];
                                                                                        $debtor_id = $row["C_D_ID"];
                                                                                        $status   = $row["trans_status"];
                                                                                        $time = $row["trans_time"];
                                                                                        $date = $row["trans_date"];
                                                                                        $amount = $row['amount'];
                                                                                        $action_id = $row['action_ID'];
                                                                                        $type= $row["type"];
                                                                                        $debtor_id = $row["C_D_ID"];
                                                                                        $status = $row["trans_status"];
                                                                                     



                                                                                        echo "
                                                   <tr class='odd gradeX'>
                                                       <td>$trans_ID</td>
                                                       <td>$status</td>
                                                       <td>$time</td>
                                                       <td>$date</td>
                                                       <td>$amount</td>
                                                    
                                                         
                                                       
                                                       
                                                       <td><a href='view_transaction_details.php? order_id=$action_id&trans_id=$trans_ID&debitor_id=$debtor_id&trans_date=$date&trans_time=$time&trans_amount=$amount&trans_type=$type&debtor_id=$debtor_id&status=$status' class='btn btn-success'>View</a></td>
                                                   </tr>	
                                               ";
                                                                                    }
                                                                                }
                                                                            


                                                                            ?>
                                                                            <tr>
                                                                                <th scope="row">-</th>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>


                                                                            </tr>

                                                                        </tbody>
                                                                    </table>


                                                                </div>
                                                            </div>

                                                           
                                                        </div>

                                                    </div>
            

                    



                    </div>
                </div>
            </div>


            <!-- Basic Form Inputs card end -->
            <!-- Input Grid card start -->

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