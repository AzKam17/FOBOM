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
        <li class="active"><a href="index.php?module=caisse&action=paielist">Paiement en cours</a></li>
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
            <a href="index.php?module=caisse&action=paielist" class="btn btn-default"><i class="fa fa-backward"></i> Retour aux ordres</a>
            <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-success"><i class="fa fa-credit-card"></i> Submit Payment
            </button>
        </div>
    </div>

    <!-- =========================================================== -->

    <div class="modal modal-success fade" id="modal-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmer le paiement</h4>
                </div>
                <form class="form-horizontal form-label-left" id="form" role="form" method="post" autocomplete="off" action="index.php?module=caisse&amp;action=newpayment">
                    <div class="modal-body">
                        <p>Veuillez entrer le numero du bordereau de paiement remis au FBO/Client</p>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="charge">Numero du bordereau <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="charge" id="charge" placeholder="Entrer le numero du recu" required="required">
                            </div>  
                        </div>
                        <input type="hidden" name="idpaie" id="idpaie" value="<?php echo $paie; ?>" />
                        <input type="hidden" name="idbonus" id="idbonus" value="<?php echo $bonus; ?>" />
                        <input type="hidden" name="mtbonus" id="mtbonus" value="<?php echo $mtbonus; ?>" />
                        <input type="hidden" name="mtfacture" id="mtfacture" value="<?php echo $mtpaie; ?>" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-outline">Valider</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</section>
<!-- /.content -->
