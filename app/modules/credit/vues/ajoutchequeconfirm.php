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
        <small>Confirmation de crédit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Crédit</li>
        <li class="active">Crédit avec chèque</li>
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
            <b>Motif:</b> <?php echo utf8_encode(quelmotif($motif)); ?>
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
                        <td><?php echo $idcheq; ?></td>
                        <td><?php echo utf8_encode($typecheq); ?></td>
                        <td><?php echo 'non encaissé'; ?></td>
                        <td><?php echo $dad22; ?></td>
                        <td><?php echo number_format($mtcheq, 0, ',', ' '); ?> F</td>
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
            <p class="lead">Clause de Payement:</p>
            <img src="img/logo.png" alt="Visa" style="width: 50px;">

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
        <!-- accepted payments column -->
        <div class="col-xs-8">
            <p class="lead"><u>Signature du client</u></p>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <p class="lead"><u>Cachet et Signature du Comptable</u></p>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            <a href="index.php?module=credit&action=bordereau&nom_distrib=<?php echo $nom_distrib; ?>&code_distrib=<?php echo $code_distrib; ?>&idcred=<?php echo $idcred; ?>&mtcred=<?php echo $mtcred; ?>&dad11=<?php echo $dad11; ?>&motif=<?php echo utf8_encode(quelmotif($motif)); ?>&idcheq=<?php echo $idcheq; ?>&typecheq=<?php echo utf8_encode($typecheq); ?>&dad22=<?php echo $dad22; ?>&mtcheq=<?php echo $mtcheq; ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> 
        </div>
    </div>
</section>
<!-- /.content -->
<div class="clearfix"></div>