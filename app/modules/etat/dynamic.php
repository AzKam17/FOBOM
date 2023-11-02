<?php
$selected = 'etat';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Etat
        <small>Etats des Bonus</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Etat</li>
        <li class="active"><a href="index.php?module=etat&action=choix">Bonus</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Etat des bonus <?php
                        if ($type == 0) {
                            echo 'non encaissés';
                        } elseif ($type == 1) {
                            echo 'encaissés';
                        } elseif ($type == 2) {
                            echo 'encaissés partiel';
                        } else {
                            echo 'en attente';
                        }
                        ?> par  <?php
                        if ($typepaie == 0) {
                            echo 'aucun';
                        } elseif ($typepaie == 1) {
                            echo 'caisse';
                        } elseif ($typepaie == 2) {
                            echo 'virement';
                        } else {
                            echo 'régularisation de crédit';
                        }
                        ?> de la periode du ( <?php echo $moisbonusdep . '/' . $anneebonusdep; ?> ) au ( <?php echo $moisbonusfin . '/' . $anneebonusfin; ?> )</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons_14" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 220px;">
                        <thead>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom complet</th>
                                <th>Montant à payer</th>
                                <th>Montant payer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="6">Chargement des états des bonus ...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom complet</th>
                                <th>Montant à payer</th>
                                <th>Montant payer</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer-->
                <input type="hidden" name="anneed" id="Anneed" value="<?php echo $anneebonusdep; ?>" />
                <input type="hidden" name="moisd" id="Moisd" value="<?php echo $moisbonusdep; ?>" />
                <input type="hidden" name="anneef" id="Anneef" value="<?php echo $anneebonusfin; ?>" />
                <input type="hidden" name="moisf" id="Moisf" value="<?php echo $moisbonusfin; ?>" />
                <input type="hidden" name="encaiss" id="Encaiss" value="<?php echo $type; ?>" />
                <input type="hidden" name="typepai" id="Typepai" value="<?php echo $typepaie; ?>" />
                <input type="hidden" name="typevir" id="Typevire" value="<?php echo $typevire; ?>" />
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->

    <!-- =========================================================== -->

</section>
<!-- /.content -->
