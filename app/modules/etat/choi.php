<?php
$selected = 'etat';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        FBO
        <small>Liste des FBO</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">FBO</li>
        <li class="active">Liste FBO</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Liste des FBO</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons_22" class="table table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom Complet</th> 
                                <th>Statut</th>
                                <th>compte</th>
                                <th>mobile</th> 
                                <th>email</th>
                                <th>ville</th>
                                <th>commune</th> 
                                <th>quartier</th>
                                <th>addresse</th>
                                <th>nationalite</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="11">Chargement de la liste des fbo en cours...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom Complet</th> 
                                <th>Statut</th>
                                <th>compte</th>
                                <th>mobile</th> 
                                <th>email</th>
                                <th>ville</th>
                                <th>commune</th> 
                                <th>quartier</th>
                                <th>addresse</th>
                                <th>nationalite</th>
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
