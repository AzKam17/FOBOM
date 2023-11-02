<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>FoBom'S | FBO Management</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body onload="window.print();">
        <div class="wrapper">
            <?php
            /*
             * Projet de developpement@Copyright Forever Living
             * Application de gestion des bonus des FBO
             * Maitre d'ouvrage : KAM Corporate and Exchange Group
             * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
             */

            $nom_distrib = $_GET['nom_distrib'];
            $code_distrib = $_GET['code_distrib'];
            $idcred = $_GET['idcred'];
            $mtcred = $_GET['mtcred'];
            $dad11 = $_GET['dad11'];
            $motif = $_GET['motif'];
            ?>
            <!--
            Projet de developpement@Copyright Forever Living
            Application de gestion des bonus des FBO
            Maitre d'ouvrage : KAM Corporate and Exchange Group
            Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
            -->

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Crédit
                    <small>Confirmation de crédit</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="">Crédit</li>
                    <li class="active">Crédit sans chèque</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> Bordereau de Crédit, Fbo.
                            <small class="pull-right"><?php echo date('d/m/Y'); ?></small>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        De
                        <address>
                            <strong>Forever Living Products, SA.</strong><br>
                            Abidjan Treichville, Boulevard VGE<br>
                            01 BPV 5487, ABJ 01<br>
                            Phone: (225) 22-2332-45<br>
                            Email: info@foreverliving.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        A
                        <address>
                            <strong><?php echo $nom_distrib; ?></strong><br>
                            <?php echo $code_distrib; ?><br>
                            <?php echo 'Adresse:'; ?><br>
                            <?php echo 'Phone:'; ?><br>
                            <?php echo 'Statut:'; ?>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Credit #<?php echo $idcred; ?></b><br>
                        <br>
                        <b>Montant:</b> <?php echo number_format($mtcred, 0, ',', ' '); ?> F<br>
                        <b>Date:</b> <?php echo $dad11; ?><br>
                        <b>Motif:</b> <?php echo $motif; ?>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Serial #</th>
                                    <th>Type</th>
                                    <th>Etat</th>
                                    <th>Date délivrée</th>
                                    <th>Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php //echo $idcheq;  ?></td>
                                    <td><?php //echo $typecheq;  ?></td>
                                    <td><?php //echo 'non impayé';  ?></td>
                                    <td><?php //echo $dad22;  ?></td>
                                    <td><?php //echo number_format($mtcheq, 0, ',', ' ');  ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-6">
                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                            Vous ne pouvez qu'autoriser un seul chèque à la fois pour un crédit. En cas de retour impayé du chèque,
                            les charges sont ajoutées à votre crédit.
                        </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <p class="lead">Date du Bordereau <?php echo date('d/m/Y'); ?></p>

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Sous-total:</th>
                                    <td><?php echo number_format($mtcred, 0, ',', ' '); ?> F CFA</td>
                                </tr>
                                <tr>
                                    <th>TVA (8.3%)</th>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <th>Charge extra:</th>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td><?php echo number_format($mtcred, 0, ',', ' '); ?> F CFA</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-muted well well-lg no-shadow" style="margin-top: 20px;">
                            <b>MENTIONS</b>
                            </br></br></br></br></br></br></br></br></br> 
                        </p>
                    </div>
                    <!-- accepted payments column -->
                    <div class="col-xs-8">
                        <p class=""><u>Signature du client</u></p>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <p class=""><u>Cachet et Signature du Comptable</u></p>
                    </div>
                    <!-- /.col -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- ./wrapper -->
    </body>
</html>


