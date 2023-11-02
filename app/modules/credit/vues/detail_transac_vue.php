<?php
$selected = 'credit';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Crédit
        <small>Transaction d'un Crédit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Crédit</li>
        <li class=""><a href="index.php?module=credit&action=listecredit">Liste crédit</a></li>
        <li class="active">Transaction crédit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Transaction du crédit Numero : <strong><?php echo $idcredit; ?></strong></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <p>Détails des transactions du crédit Numero : <strong><?php echo $idcredit; ?></strong>&nbsp;&nbsp; d'un montant de : <strong><?php echo utf8_encode(number_format($mtcredit, 0, ',', ' ')); ?> F CFA</strong></strong> </p>
                    <hr></hr>
                    <p>FBO : <strong><?php echo $code . '  -  ' . $nom; ?></strong></p>
                    <div class="box-body table-responsive no-padding">
                        <h4>Détails des transactions du crédit</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Etat</th>
                                <th>Type Transac</th>
                                <th>Ordonné par</th>
                                <th>Caissier(e)</th>
                                <th>Montant</th>
                            </tr>
                            <?php 
                            $totalremb = 0 ;
                            foreach ($remb_infos as $r) { ?>
                                <tr>
                                    <td><?php echo utf8_encode($r['0']); ?></td>
                                    <td><?php echo utf8_encode(dateFr($r['2'])); ?></td>
                                    <td><span class="label label-success">Rembourser</span></td>
                                    <td><?php if ($r['4'] == 1) { ?>
                                            <span class="label label-success">Espèce</span>
                                        <?php } else { ?>
                                            <span class="label label-primary">Regularisé</span>            
                                        <?php } ?>
                                    </td>
                                    <td><?php echo utf8_encode($r['7'] . ' ' . $r['8'] . ' ' . $r['9']); ?></td>
                                    <td><?php echo ''; ?></td>
                                    <td><?php echo utf8_encode(number_format($r['5'], 0, ',', ' ')); ?></td>
                                </tr>
                                <?php
                                $totalremb += $r['5'];
                            }
                            ?>
                            <tr>
                                <td colspan="6"><strong>TOTAL</strong></td>
                                <td><strong><?php echo utf8_encode(number_format($totalremb, 0, ',', ' ')); ?> F<strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</section>
<!-- /.content -->
