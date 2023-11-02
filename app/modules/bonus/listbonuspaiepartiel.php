<?php
$selected = 'bonusfichier';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Bonus
        <small>Liste des bonus payés partiellement</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Acceuil</a></li>
        <li class="">Bonus</li>
        <li class="active">Liste Bonus Payés Partiellement</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Liste des Bonus soldés</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons_20" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 210px;">
                        <thead>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom Complet</th> 
                                <th>Soldé</th>
                                <th>Reste à payer</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="6">Chargement de la liste des bonus soldé en cours...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom Complet</th> 
                                <th>Soldé</th>
                                <th>Reste à payer</th>
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
