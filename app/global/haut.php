<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>FoBom'S | FBO Management</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- DataTables -->
        <link href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="bower_components/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- iCheck for checkboxes and radio inputs -->
        <link href="bower_components/iCheck/flat/blue.css" rel="stylesheet" type="text/css"/>
        <!-- Form wizard custom style -->
        <link href="dist/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
        <!-- Pace style -->
        <link rel="stylesheet" href="plugins/pace/pace.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <!-- FLOT CHARTS -->
        <script src="bower_components/Flot/jquery.flot.js"></script>
        <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
        <script src="bower_components/Flot/jquery.flot.resize.js"></script>
        <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
        <script src="bower_components/Flot/jquery.flot.pie.js"></script>
        <!-- FLOT SPARK LINE PLUGIN - Used to draw bar charts -->
        <script src="bower_components/Flot/jquery.flot.spline.js" type="text/javascript"></script>
        <!-- FLOT TIME PLUGIN - Used to draw line time charts -->
        <script src="bower_components/Flot/jquery.flot.time.js" type="text/javascript"></script>
        <!-- FLOT TOOLTIP PLUGIN - Used to draw line tooltip charts -->
        <script src="bower_components/Flot/jquery.flot.tooltip.min.js" type="text/javascript"></script>


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font 
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
    </head>
    <body class="hold-transition skin-blue layout-top-nav <?php
    if (!utilisateur_est_connecte()) {
        echo 'login-page';
    }
    ?>">
              <?php
              if (utilisateur_est_connecte()) {
                  $bonus_paie_notif = bonus_paie_notifiction();
                  $totat_bon_notif = total_bonus_paie_notif();
                  $bonus_encaisse_notif = bonus_encaisse_notifiction();
                  $totat_encaisse_notif = total_bonus_encaisse_notif();
                  ?>
            <div class="wrapper">

                <!-- Main Header -->
                <header class="main-header">
                    <nav class="navbar navbar-static-top">
                        <div class="container">
                            <div class="navbar-header">
                                <a href="#" class="navbar-brand"><b>FOBOM</b>'s</a>
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                    <i class="fa fa-bars"></i>
                                </button>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->   
                            <?php include 'global/menu.php'; ?>

                            <!-- Navbar Right Menu -->
                            <div class="navbar-custom-menu">
                                <ul class="nav navbar-nav">
                                    <!-- Messages: style can be found in dropdown.less-->
                                    <li class="dropdown notifications-menu">
                                        <!-- Menu toggle button -->
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bell-slash"></i>
                                            <?php if ($totat_encaisse_notif > 0) { ?> <span class="label label-success"><?php echo number_format($totat_encaisse_notif, 0, ',', ' '); ?></span> <?php } ?>
                                        </a>
                                        <?php if ($totat_encaisse_notif > 0) { ?>
                                            <ul class="dropdown-menu">
                                                <li class="header">Vous avez <?php echo number_format($totat_encaisse_notif, 0, ',', ' '); ?> nouveau(x) paiement(s)</li>
                                                <li>
                                                    <!-- Inner Menu: contains the notifications -->
                                                    <ul class="menu">
                                                        <?php foreach ($bonus_encaisse_notif as $e) { ?> 

                                                            <li><!-- start notification -->
                                                                <a href="index.php?module=caisse&action=info_paie_valid&id=<?php echo $e['idpaiement'] ?>">
                                                                    <i class="fa fa-users text-aqua"></i> <?php echo '#' . $e['idpaiement'] . ' Montant: ' . number_format($e['mtfacture'], 0, ',', ' '); ?>
                                                                </a>
                                                            </li>
                                                            <!-- end notification -->
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="index.php?module=caisse&action=paievalidlist">Voir tous</a></li>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                    <!-- /.messages-menu -->

                                    <!-- Notifications Menu -->
                                    <li class="dropdown notifications-menu">
                                        <!-- Menu toggle button -->
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bell-o"></i>
                                            <?php if ($totat_bon_notif > 0) { ?> <span class="label label-warning"><?php echo number_format($totat_bon_notif, 0, ',', ' '); ?></span> <?php } ?>
                                        </a>
                                        <?php if ($totat_bon_notif > 0) { ?>
                                            <ul class="dropdown-menu">
                                                <li class="header">Vous avez <?php echo number_format($totat_bon_notif, 0, ',', ' '); ?> paiement(s) en attente</li>
                                                <li>
                                                    <!-- Inner Menu: contains the notifications -->
                                                    <ul class="menu">
                                                        <?php foreach ($bonus_paie_notif as $v) { ?> 

                                                            <li><!-- start notification -->
                                                                <a href="index.php?module=caisse&action=info_paie&id=<?php echo $v['idpaiement'] ?>">
                                                                    <i class="fa fa-users text-aqua"></i> <?php echo '#' . $v['idpaiement'] . ' Montant: ' . number_format($v['mtfacture'], 0, ',', ' '); ?>
                                                                </a>
                                                            </li>
                                                            <!-- end notification -->
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="index.php?module=caisse&action=paielist">Voir tous</a></li>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                    <!-- User Account Menu -->
                                    <li class="dropdown user user-menu">
                                        <!-- Menu Toggle Button -->
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <!-- The user image in the navbar-->
                                            <?php
                                            // Constantes
                                            define('DOSSIER_ADMIN', 'http://localhost/img/admin/');

                                            //dossier photo admin
                                            $nomImage1 = $_SESSION['id'] . '.jpg';
                                            $fichier1 = DOSSIER_ADMIN . $nomImage1;
                                            $nomImage2 = $_SESSION['id'] . '.png';
                                            $fichier2 = DOSSIER_ADMIN . $nomImage2;
                                            $nomImage3 = $_SESSION['id'] . '.jpeg';
                                            $fichier3 = DOSSIER_ADMIN . $nomImage3;

                                            if (is_file($fichier1)) {
                                                echo ' <img class="user-image" src="' . $fichier1 . '" alt="User Image"> ';
                                            } elseif (is_file($fichier2)) {
                                                echo ' <img class="user-image" src="' . $fichier2 . '" alt="User Image">  ';
                                            } elseif (is_file($fichier3)) {
                                                echo ' <img class="user-image" src="' . $fichier3 . '" alt="User Image">  ';
                                            } else {
                                                echo ' <img src="img/admin/avatar.jpg" class="user-image" alt="Photo de Profil" > ';
                                            }
                                            ?>
                                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                            <span class="hidden-xs"><?php echo $_SESSION['nom'] . ' ' . $_SESSION['prenom']; ?></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- The user image in the menu -->
                                            <li class="user-header">
                                                <?php
                                                if (is_file($fichier1)) {
                                                    echo ' <img class="img-circle" src="' . $fichier1 . '" alt="User Image"> ';
                                                } elseif (is_file($fichier2)) {
                                                    echo ' <img class="img-circle" src="' . $fichier2 . '" alt="User Image">  ';
                                                } elseif (is_file($fichier3)) {
                                                    echo ' <img class="img-circle" src="' . $fichier3 . '" alt="User Image">  ';
                                                } else {
                                                    echo ' <img src="img/admin/avatar.jpg" class="img-circle" alt="Photo de Profil" > ';
                                                }
                                                ?>

                                                <p>
                                                    <?php echo $_SESSION['nom'] . ' ' . $_SESSION['prenom']; ?>
                                                    <small><?php echo $_SESSION['titre']; ?></small>
                                                </p>
                                            </li>
                                            <!-- Menu Body -->
                                            <li class="user-body">
                                                <div class="row">
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Paramètre</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Statistiques</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Audit</a>
                                                    </div>
                                                </div>
                                                <!-- /.row -->
                                            </li>
                                            <!-- Menu Footer-->
                                            <li class="user-footer">
                                                <?php if ($_SESSION['niveau'] == 1) { ?>
                                                    <div class="pull-left">
                                                        <a href="index.php?module=profil&amp;action=listeprofil" class="btn btn-default btn-flat">Profile</a>
                                                    </div>
                                                <?php } ?>
                                                <div class="pull-right">
                                                    <a href="index.php?module=connexion&amp;action=deconnexion" class="btn btn-default btn-flat">Sign out</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.navbar-custom-menu -->
                        </div>
                        <!-- /.container-fluid -->
                    </nav>
                </header>
                <!-- Left side column. contains the logo and sidebar -->

                <!-- Content Wrapper. Contains page content -->
                <!-- Full Width Column -->
                <div class="content-wrapper">

                    <div class="container">

                        <div class="row">
                            <div class="col-md-8">
                                <?php if (!empty($erreurs_a)) { ?>

                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-ban"></i> ALERTE!</h4>
                                        <?php echo $erreurs_a; ?>
                                    </div>  

                                <?php } ?>

                                <?php if (!empty($erreurs_b)) { ?>

                                    <div class="alert alert-info alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-info"></i> INFO!</h4>
                                        <?php echo $erreurs_b; ?>
                                    </div>   

                                <?php } ?>

                                <?php if (!empty($erreurs_c)) { ?>
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-warning"></i> ATTENTION!</h4>
                                        <?php echo $erreurs_c; ?>
                                    </div> 

                                <?php } ?>

                                <?php if (!empty($erreurs_d)) { ?>

                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-check"></i> SUCCES!</h4>
                                        <?php echo $erreurs_d; ?>
                                    </div>   

                                <?php } ?>
                            </div>
                        </div>

                        <?php
                    }
            