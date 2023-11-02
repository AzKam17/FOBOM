<?php
$selected = 'credit';
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
        <small>Détails du crédit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Crédit</li>
        <li class=""><a href="index.php?module=credit&action=listecredit">Liste Crédit</a></li>
        <li class="active">Détails Crédit</li>
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
                    <?php
                    if (!empty($cheque_info)) {

                        foreach ($cheque_info as $c) {

                            $idcheq = $c['numcheque'];
                            $mtcheq = $c['mtcheque'];
                            $typecheq = $c['typecheque'];
                            $dad22 = $c['datcheq'];
                            $etatc = $c['etat'];
                            ?>
                            <tr>
                                <td><?php echo $idcheq; ?></td>
                                <td><?php echo $typecheq; ?></td>
                                <td><?php
                                    if ($etatc == 0) {
                                        echo 'non encaissé';
                                    } elseif ($etatc == 1) {
                                        echo 'encaissé';
                                    } elseif ($etatc == 2) {
                                        echo 'en attente';
                                    } else {
                                        echo 'impayé';
                                    }
                                    ?>
                                </td> 
                                <td><?php echo $dad22; ?></td>
                                <td><?php echo number_format($mtcheq, 0, ',', ' '); ?> F</td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<div class="clearfix"></div>