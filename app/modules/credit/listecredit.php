<?php
$selected = 'credit';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Crédit
        <small>Liste des Crédits</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Crédit</li>
        <li class="active">Liste crédit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Liste des crédits</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons_2" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 10px;">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Montant</th> 
                                <th>Date</th>
                                <th>Motif</th>
                                <th>Etat</th>
                                <th>Rembourser</th>
                                <th>Code distrib</th>
                                <th>Nom distrib</th>
                                <th>Operateur</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="9">Chargement de la liste des credits en cours...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th># </th>
                                <th>Montant</th> 
                                <th>Date</th>
                                <th>Motif</th>
                                <th>Etat</th>
                                <th>Rembourser</th>
                                <th>Code distrib</th>
                                <th>Nom distrib</th>
                                <th>Operateur</th>
                                <th>Options</th>
                            </tr>
                        </tfoot>
                    </table>
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
