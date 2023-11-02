<?php
$selected = 'etat';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Etat
        <small>Etats des Crédits</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Etat</li>
        <li class="active"><a href="index.php?module=etat&action=choixx">Crédit</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Etat des Crédits du ( <?php echo $dapdep; ?> ) au ( <?php echo $dapfin; ?> )</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons_15" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 110px;">
                        <thead>
                            <tr>
                                <th># bordereau</th>
                                <th>Montant</th> 
                                <th>Date</th>
                                <th>Motif</th>
                                <th>Code distrib</th>
                                <th>Nom distrib</th>
                                <th>Operateur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="6">Chargement des états des crédits ...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th># bordereau</th>
                                <th>Montant</th> 
                                <th>Date</th>
                                <th>Motif</th>
                                <th>Code distrib</th>
                                <th>Nom distrib</th>
                                <th>Operateur</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer -->
                <input type="hidden" name="datdep" id="datdep" value="<?php echo $anneecredep; ?>" />
                <input type="hidden" name="datfin" id="datfin" value="<?php echo $anneecredfin; ?>" />
                <input type="hidden" name="typecred" id="typecred" value="<?php echo $type; ?>" />
                <input type="hidden" name="typerem" id="typerem" value="<?php echo $typeremb; ?>" />
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->

    <!-- =========================================================== -->

</section>
<!-- /.content -->
