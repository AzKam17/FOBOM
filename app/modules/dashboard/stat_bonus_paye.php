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
        <li class=""><a href="index.php?module=dashboard&action=stat_bonus">Tableau de bord - Bonus</a></li>
        <li class="active">Tableau de bord - Bonus Payé</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <section class="content">
        <!-- Info boxes 1 -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=bonus&action=listbonussoldecaisse">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">A la Caisse</span>
                            <span class="info-box-number"><?php echo number_format(nbre_total_fichier_bonus(), 0, ',', ' '); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=dashboard&action=stat_bonus_paye">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Par Virement</span>
                            <span class="info-box-number"><?php echo number_format(nbre_total_fichier_bonus(), 0, ',', ' '); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=fbo&action=fbolist">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Restant à Payer</span>
                            <span class="info-box-number"><?php echo number_format(nbre_total_fbo(), 0, ',', ' '); ?></span>
                            <p></p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>

</section>
<!-- /.content -->

