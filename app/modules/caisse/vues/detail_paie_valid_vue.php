<?php
$selected = 'transac';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Paiement
        <small>Détails du paiement</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Paiement</li>
        <li class="active"><a href="index.php?module=caisse&action=paievalidlist">Paiement validé</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <?php
                    if (is_file($fichier1)) {
                        echo ' <img class="profile-user-img img-responsive img-circle" src="' . $fichier1 . '" alt="Photo de Profil du FBO"> ';
                    } elseif (is_file($fichier2)) {
                        echo ' <img style="width: 90%; height: 75px" src="' . $fichier2 . '" alt="photo">  ';
                    } elseif (is_file($fichier3)) {
                        echo ' <img style="width: 90%; height: 75px" src="' . $fichier3 . '" alt="photo">  ';
                    } else {
                        echo ' <img src="img/fbo/avatar.jpg" alt="Photo de Profil" class="profile-user-img img-responsive img-circle" > ';
                    }
                    ?>

                    <h3 class="profile-username text-center"><?php echo $nom; ?></h3>

                    <p class="text-muted text-center"><?php echo $code; ?> </p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <u><strong>Bonus # :</strong> <?php echo $bonus; ?></u><br><br>
                        <address>
                            Montant : <strong><?php echo number_format($mtbonus, 0, ',', ' '); ?> F CFA</strong><br>
                            Période : <strong><?php echo $periode; ?></strong><br>
                            Etat : <?php if ($etatbon == 0) { ?>
                                <span class="label label-danger">Non Encaissé</span>
                            <?php } elseif ($etatbon == 1) { ?>
                                <span class="label label-success">Encaissé</span>            
                            <?php } elseif ($etatbon == 2) { ?>
                                <span class="label label-default">Partiel</span>
                            <?php } else { ?>
                                <span class="label label-warning">En Attente</span>
                            <?php } ?><br>
                            Type d'encaissement : <?php if ($typencaisse == 0) { ?>
                                <span class="label label-danger">Aucun</span>
                            <?php } elseif ($typencaisse == 1) { ?>
                                <span class="label label-success">Caisse</span>            
                            <?php } elseif ($typencaisse == 2) { ?>
                                <span class="label label-default">Virement</span>            
                            <?php } else { ?>
                                <span class="label label-primary">Régularisé</span>           
                            <?php } ?><br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <u><strong>Ordonné par</strong></u><br><br>
                        <address>
                            <?php echo $operateur; ?><br>
                            <?php echo $titre; ?><br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <u><strong>Paiement # : </strong><b><?php echo $paie; ?></b></u><br>
                        <br>
                        <b>Montant à payer :</b> <?php echo number_format($mtpaie, 0, ',', ' '); ?> F CFA<br>
                        <b>Date:</b> <?php echo utf8_decode($datordonne); ?><br>
                        <b>Type de paiment:</b> <?php
                        if ($caisse == 1) {
                            echo 'Caisse';
                        } else {
                            echo 'Virement';
                        }
                        ?>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            <a href="index.php?module=caisse&action=paievalidlist" class="btn btn-default"><i class="fa fa-backward"></i> Retour aux paiements</a>
        </div>
    </div>

    <!-- =========================================================== -->

</section>
<!-- /.content -->
