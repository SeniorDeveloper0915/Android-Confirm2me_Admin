<?php
session_start();
    include "../config/config.php";

    // error_reporting(0);

    // SESSION CHECK SET OR NOT
    if (!isset($_SESSION['admin'])) {
        header('location:../index.php');
    }


    $sql    = "SELECT count(*) FROM `requests`";
    $result = $db->prepare($sql);

    // Get count of active users
    $result->execute(array('enable'));
    $activeUsers = $result->fetchColumn();


    // // Inactive users count
    // $result->execute(array('disable'));
    // $inActiveUsers = $result->fetchColumn();

    // All users count
    $sql    = "SELECT count(*) FROM `users`";
    $result = $db->prepare($sql);
    $result->execute();
    $totalUsers = $result->fetchColumn();

    $sql    = "SELECT count(*) FROM `requests`";
    $result = $db->prepare($sql);
    $result->execute();
    $totalRequests = $result->fetchColumn();

    $sql    = "SELECT count(*) FROM `affidavits`";
    $result = $db->prepare($sql);
    $result->execute();
    $totalAffidavits = $result->fetchColumn();

?>


<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <title>Dashboard - Admin</title>
    <?php include '../include/css/mandatory.php' ?>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <?php include '../include/css/global.php' ?>
</head>
<!-- END PAGE HEAD-->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
<?php include '../include/header.php'; ?>
<div class="page-container">
    <?php include '../include/sidebar.php'; ?>
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="page-head margin-bottom-5">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Dashboard
                        <small>activities &amp; statistics</small>
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- BEGIN PAGE BASE CONTENT -->
            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"><?php echo $totalUsers; ?></span>
                                    </div>
                                    <div class="desc"> Total users </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"><?php echo $totalRequests; ?></span></div>
                                    <div class="desc"> Total Requests </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 red" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-user-times"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"><?php echo $totalAffidavits; ?></span>
                                    </div>
                                    <div class="desc"> Total Affidavits </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN Chart and users detail-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">Registration Stats:</span>
                                        <span class="caption-helper"><?php echo date("F  Y"); ?></span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="line-chart" class="chart-holder"></div>
                                </div>
                            </div>
                            <!-- END Chart and users detail-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--End modal -->
</div>
<!--End page-container-->
<?php include '../include/footer.php' ?>
<?php include '../include/footerjs.php' ?>

<!-- Start of plugins-->

<script src="../assets/plugins/flot/jquery.flot.js"></script>
<script src="../assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="../assets/plugins/flot/jquery.flot.resize.js"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>

<!-- End of plugins-->

<script>
    $(function () {

        var d1, d2, data, chartOptions;

        <?php
        // get array of dateswise signups
        $query = "SELECT date(`created_at`),count(*) as total,EXTRACT(DAY FROM created_at) AS  today
			       
			FROM `users` WHERE
			MONTH(CURDATE()) = MONTH(created_at) AND YEAR(CURDATE()) = YEAR(created_at) 
			GROUP BY date(`created_at`)
			ORDER BY date(`created_at`) ASC;";

        $result = $db->prepare($query);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = "[{$row['today']},{$row['total']}]";

        }
        $date = date('t');

        // Assign to all dates if no date in array then ''
        for ($i = 1; $i <= $date; $i++) {
            if (isset($data[$i])) continue;
            $data[] = "[{$i}]";
        }
        // convert into array
        $d1data = implode(',', $data);
        ?>
        d1 = [
            <?php echo $d1data; ?>
        ];


        data = [{
            label: "Total Registration",
            data: d1
        }];

        chartOptions = {
            xaxis: {
                ticks: <?php echo date('t'); ?>,
                tickDecimals: 0
            },
            yaxis: {
                ticks: 11,
                tickDecimals: 0

            },

            series: {
                lines: {
                    show: true,
                    fill: false,
                    lineWidth: 3
                },
                points: {
                    show: true,
                    radius: 4.5,
                    fill: true,
                    fillColor: "#ffffff",
                    lineWidth: 2.75
                }
            },
            grid: {
                hoverable: true,
                clickable: false,
                borderWidth: 0
            },
            legend: {
                show: true
            },

            tooltip: true,
            tooltipOpts: {
                content: '%s: %y'
            },
            colors: App.chartColors
        };


        var holder = $('#line-chart');

        if (holder.length) {
            $.plot(holder, data, chartOptions);
        }


    });

</script>
</body>
</html>