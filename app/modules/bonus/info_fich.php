<!-- Content Header (Page header) -->
<?php
$selected = 'bonusfichier';
if (!empty($_GET['idfich'])) {
    $fichid = $_GET['idfich'];
    ?>

    <section class="content-header">
        <h1>
            Bonus
            <small>Détails Bonus mensuel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="">Bonus</li>
            <li class="">Bonus Mensuel</li>
            <li class="active">Détail Bonus Mensuel</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <!-- =========================================================== -->

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Liste des Bonus mensuels</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatable-buttons_1" class="table table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Code distributeur</th>
                                    <th>Nom distributeur</th>
                                    <th>Montant</th>
                                    <th>Ajustement</th>
                                    <th>Sous-total</th>
                                    <th>BIC</th>
                                    <th>Bonus</th>
                                    <th>Etat</th>
                                    <th>Encaissement</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="gradeA">
                                    <td align="center" colspan="10">Chargement de la liste des bonus en cours...</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Code distributeur</th>
                                    <th>Nom distributeur</th>
                                    <th>Montant</th>
                                    <th>Ajustement</th>
                                    <th>Sous-total</th>
                                    <th>BIC</th>
                                    <th>Bonus</th>
                                    <th>Etat</th>
                                    <th>Encaissement</th>
                                    <th>Option</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">

                    </div>
                    <!-- /.box-footer-->
                    <input type="hidden" name="idfich" id="Idfich" value="<?php echo $fichid ?>" />
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <!-- =========================================================== -->

    </section>
    <!-- /.content -->

<?php } ?>
