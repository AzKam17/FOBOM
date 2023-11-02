<?php
$selected = 'bonusfichier';
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Bonus
        <small>Bonus mensuel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Bonus</li>
        <li class="active">Bonus Mensuel</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Liste des fichiers de Bonus mensuels</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Nom Fichier</th>
                                <th>Nbre fbo</th>
                                <th>date upload</th>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="6">Chargement de la liste des fichiers en cours...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nom Fichier</th>
                                <th>Nbre fbo</th>
                                <th>date upload</th>
                                <th>Mois</th>
                                <th>Année</th>
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
