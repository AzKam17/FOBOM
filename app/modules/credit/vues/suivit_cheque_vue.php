<?php
$selected = 'credit';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Crédit
        <small>Suivit de Chèque</small> ( <?php echo utf8_encode(number_format(total_cheque_liste($code) + total_liste_encaisse($code) + total_liste_impaye($code) + total_liste_depot($code), 0, ',', ' ')); ?> )
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Credit</li>
        <li class="active">Suivit de Chèque</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Chèque du Portefeuil</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#bonus" data-toggle="tab">Ré&ccedil;u non deposé&nbsp;&nbsp;&nbsp;&nbsp;<?php if (total_cheque_liste($code) != NULL) { ?>  <span class="label label-info"><?php echo utf8_encode(number_format(total_cheque_liste($code), 0, ',', ' ')); ?></span> <?php } ?> </a></li>
                            <li><a href="#Credit" data-toggle="tab">Retour Encaissé&nbsp;&nbsp;&nbsp;&nbsp;<?php if (total_liste_encaisse($code) != NULL) { ?>  <span class="label label-success"><?php echo utf8_encode(number_format(total_liste_encaisse($code), 0, ',', ' ')); ?></span> <?php } ?> </a></li>
                            <li><a href="#settings" data-toggle="tab">Retour Impayé&nbsp;&nbsp;&nbsp;&nbsp;<?php if (total_liste_impaye($code) != NULL) { ?>  <span class="label label-danger"><?php echo utf8_encode(number_format(total_liste_impaye($code), 0, ',', ' ')); ?></span> <?php } ?> </a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="bonus">
                                <div class="box box-info">
                                    <div class="box-header">
                                        <h3 class="box-title">Chèques entrants non deposé</h3>

                                        <div class="box-tools">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tr>
                                                <th># cheque</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Etat</th>
                                                <th>Distributeur</th>
                                                <th>Options</th>
                                            </tr>
                                            <?php foreach ($cheque_listes as $b) { ?>

                                                <tr>
                                                    <td><?php echo utf8_encode($b['numcheque']); ?></td>
                                                    <td><?php echo utf8_encode(number_format($b['mtcheque'], 0, ',', ' ')); ?></td>
                                                    <td><?php echo utf8_encode($b['datecheq']); ?></td>
                                                    <td><?php if (utf8_encode($b['typecheque']) == 'CHÈQUE NON BARRÉ') { ?>
                                                            <span class="label label-info">Chèque non barré</span>
                                                        <?php } elseif (utf8_encode($b['typecheque']) == 'CHÈQUE BARRÉ') { ?>
                                                            <span class="label label-success">Chèque barré</span>            
                                                        <?php } else { ?>
                                                            <span class="label label-warning">Billet à ordre</span>            
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php if ($b['etat'] == 0) { ?>
                                                            <span class="label label-primary">Ré&ccedil;u</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo utf8_encode($b['nom_complet']); ?></td>
                                                    <td><a href="modules/credit/ModalAjaxCheDep.php" data-toggle="modal_2" id="<?php echo utf8_encode($b['numcheque']); ?>" mt="<?php echo utf8_encode($b['mtcheque']); ?>" nomfbo="<?php echo utf8_encode($b['nom_complet']); ?>" fbo="<?php echo utf8_encode($b['code_distrib']); ?>" data-target="#" class="btn btn-info btn-sm" title="Depot"><i class="fa fa-hand-o-right"></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="Credit">
                                <div class="box box-success">
                                    <div class="box-header">
                                        <h3 class="box-title">Chèques retours de banque encaissés</h3>

                                        <div class="box-tools">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tr>
                                                <th># cheque</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Etat</th>
                                                <th>Distributeur</th>
                                            </tr>
                                            <?php foreach ($cheque_liste_encaisses as $d) { ?>

                                                <tr>
                                                    <td><?php echo utf8_encode($d['numcheque']); ?></td>
                                                    <td><?php echo utf8_encode(number_format($d['mtcheque'], 0, ',', ' ')); ?></td>
                                                    <td><?php echo utf8_encode($d['datecheq']); ?></td>
                                                    <td><?php if (utf8_encode($d['typecheque']) == 'CHÈQUE NON BARRÉ') { ?>
                                                            <span class="label label-info">Chèque non barré</span>
                                                        <?php } elseif (utf8_encode($d['typecheque']) == 'CHÈQUE BARRÉ') { ?>
                                                            <span class="label label-success">Chèque barré</span>            
                                                        <?php } else { ?>
                                                            <span class="label label-warning">Billet à ordre</span>            
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php if ($d['etat'] == 1) { ?>
                                                            <span class="label label-success">Encaissé</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo utf8_encode($d['nom_complet']); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="settings"> 
                                <div class="box box-danger">
                                    <div class="box-header">
                                        <h3 class="box-title">Chèques retours de banque impayés</h3>

                                        <div class="box-tools">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tr>
                                                <th># cheq</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Etat</th>
                                                <th>Motif</th>
                                                <th>Distributeur</th>
                                                <th>Options</th>
                                            </tr>
                                            <?php foreach ($cheque_liste_impayes as $e) { ?>

                                                <tr>
                                                    <td><?php echo utf8_encode($e['numcheque']); ?></td>
                                                    <td><?php echo utf8_encode(number_format($e['mtcheque'], 0, ',', ' ')); ?></td>
                                                    <td><?php echo utf8_encode($e['datecheq']); ?></td>
                                                    <td><?php if (utf8_encode($e['typecheque']) == 'CHÈQUE NON BARRÉ') { ?>
                                                            <span class="label label-info">Chèque non barré</span>
                                                        <?php } elseif (utf8_encode($e['typecheque']) == 'CHÈQUE BARRÉ') { ?>
                                                            <span class="label label-success">Chèque barré</span>            
                                                        <?php } else { ?>
                                                            <span class="label label-warning">Billet à ordre</span>            
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php if ($e['etat'] == 3) { ?>
                                                            <span class="label label-danger">Impayé</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo utf8_encode($e['motif']); ?></td>
                                                    <td><?php echo utf8_encode($e['nom_complet']); ?></td>
                                                    <td><a href="modules/credit/ModalAjaxCheDep.php" data-toggle="modal_2" id="<?php echo utf8_encode($e['numcheque']); ?>" mt="<?php echo utf8_encode($e['mtcheque']); ?>" nomfbo="<?php echo utf8_encode($e['nom_complet']); ?>" fbo="<?php echo utf8_encode($e['code_distrib']); ?>" data-target="#" class="btn btn-warning btn-sm" title="Depot"><i class="fa fa-hand-o-right"></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer-->
                <input type="hidden" name="idetat" id="Idetat" value="<?php echo $_SESSION['pays'] ?>" />
            </div>
        </div>
        <!-- /.box -->
        <div class="col-md-5">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Chèques hors portefeuil</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Chèques à la banque&nbsp;&nbsp;&nbsp;&nbsp;<?php if (total_liste_depot($code) != NULL) { ?>  <span class="label label-info"><?php echo utf8_encode(number_format(total_liste_depot($code), 0, ',', ' ')); ?></span> <?php } ?> </h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th># cheque</th>
                                    <th>Montant</th>
                                    <th>Date dépot</th>
                                    <th>Etat</th>
                                    <th>Options</th>
                                </tr>
                                <?php foreach ($cheque_liste_depots as $f) { ?>

                                    <tr>
                                        <td><?php echo utf8_encode($f['numcheque']); ?></td>
                                        <td><?php echo utf8_encode(number_format($f['mtcheque'], 0, ',', ' ')); ?></td>
                                        <td><?php echo utf8_encode($f['datecheq']); ?></td>
                                        <td><?php if ($f['etat'] == 2 AND datealerte(utf8_encode($f['datecheq'])) == 0203) { ?>
                                                <span class="label label-info">En attente</span>
                                            <?php } else { ?>
                                                <span class="label label-warning">Retard</span>       
                                            <?php } ?>
                                        </td>
                                        <td><a href="modules/credit/ModalAjaxCheRet.php" data-toggle="modal_2" id="<?php echo utf8_encode($f['numcheque']); ?>" mt="<?php echo utf8_encode($f['mtcheque']); ?>" nomfbo="<?php echo utf8_encode($f['nom_complet']); ?>" fbo="<?php echo utf8_encode($f['credit_idcredit']); ?>" data-target="#" class="btn btn-info btn-sm" title="Retour"><i class="fa fa-hand-o-left"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer-->
                <input type="hidden" name="idetat" id="Idetat" value="<?php echo $_SESSION['pays'] ?>" />
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->

    <!-- =========================================================== -->

</section>
<!-- /.content -->
