<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<?php
$selected = 'dashboard';

include 'modeles/dashboard.inc.php';
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Bonus
        <small>Tableau de bord</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Acceuil</a></li>
        <li class=""><a href="index.php?module=dashboard&action=dashboard">Tableau de bord</a></li>
        <li class="active">Tableau de bord - Bonus</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <section class="content">
        <!-- Info boxes 1 -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=dashboard&action=stat_bonus_paye">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><u>Total Bonus Payé</u></span>
                            <span class="info-box-number"><?php echo number_format(sum_total_bonus_paye(), 0, ',', ' '); ?> F CFA</span>
                            <p><?php echo number_format(nbre_total_bonus_paye(), 0, ',', ' '); ?> Bonus</p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=bonus&action=listbonussolde">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Payé Entier</span>
                            <span class="info-box-number"><?php echo number_format(sum_total_bonus_solde(), 0, ',', ' '); ?> F CFA</span>
                            <p><?php echo number_format(nbre_total_bonus_solde(), 0, ',', ' '); ?> Bonus</p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=bonus&action=listbonuspaiepartiel">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-more-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Payé Partiel</span>
                            <span class="info-box-number"><?php echo number_format(sum_total_bonus_paye_partiel(), 0, ',', ' '); ?> F CFA</span>
                            <p><?php echo number_format(nbre_total_bonus_paye_partiel(), 0, ',', ' '); ?> Bonus</p>
                        </div>
                        <!-- /.info-box-content -->
                    </div> 
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-cash"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Impayé</span>
                        <span class="info-box-number"><?php echo number_format(sum_total_bonus_impaye(), 0, ',', ' '); ?> <small>F</small></span>
                        <p><?php echo number_format(nbre_total_bonus_impaye(), 0, ',', ' '); ?> <small>Bonus</small></p>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>

</section>
<!-- /.content -->

