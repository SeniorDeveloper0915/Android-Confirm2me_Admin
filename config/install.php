<?php
    include 'config.php';

    // SELECT MATCH FROM THE DATABASE
  $query = "CREATE TABLE `admin` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(32) NOT NULL,
    `username` varchar(50) DEFAULT NULL,
    `password` varchar(40) NOT NULL,
    `email` varchar(50) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `lastlogin_at` timestamp DEFAULT '2014-11-25 10:57:28',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `email`, `created_at`, `lastlogin_at`)
VALUES
  (1,'Admin','admin','admin','admin@admin.com','2014-11-25 10:57:28','2014-12-08 10:23:20'),
  (2,'Admin','admin','d033e22ae348aeb5660fc2140aec35850c4da997','admin@admin.com','2014-11-25 10:57:28','2014-12-08 10:23:20')";



    $statement = $db->prepare($query);
try {
    $statement->execute();
    $output['type'] = 'success';
    $output['msg']  = 'Installation successfully completed';
} catch (Exception $e) {

    $output['type'] = 'danger';
    $output['msg']  = 'Table already created';
}
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

    <title>Installation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!---CSS FILES -->

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="assets/css/login.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="assets/css/components-md.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="assets/css/plugins-md.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->

    <link href="assets/plugins/froiden-helper/helper.css" rel="stylesheet" type="text/css" />

</head>

<body class="login">

<!-- BEGIN LOGO -->
<div class="logo">
    <a href="javascript:;">
        <img src="assets/img/logos/logo-big.png" alt="" /> </a>
</div>
<!-- END LOGO -->
<div class="content login-form" style="width: 60%;">
    <h3 class="form-title font-green">Installation</h3>
    <div id="msg" class="<?php echo $output['type'] == 'success' ? 'alert alert-success' : 'alert alert-danger'; ?>"><?php echo $output['msg'];?></div>
    <a href="index.php" class="btn green btn-outline">Click here to login </a>

    <!-- JS FILES    -->
    <script src="assets/global/plugins/respond.min.js"></script>
    <script src="assets/global/plugins/excanvas.min.js"></script>
    <script src="assets/global/plugins/ie8.fix.min.js"></script>
    <![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="assets/global/app.min.js" type="text/javascript"></script>
    <script src="assets/plugins/froiden-helper/helper.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->

</body>
</html>
