<?php
$selected = 'transac';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Paiement
        <small>Liste des paiements validés</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Transaction</li>
        <li class="active">Paiement validé</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Paiements validés</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons_5" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 210px;">
                        <thead>
                            <tr>
                                <th>idpaiement</th>
                                <th>Montant à payer</th>
                                <th>Période bonus</th>
                                <th>date paie</th>
                                <th>Caissier(e)</th>
                                <!-- <th>Numero du re&ccedil;u</th> -->
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="7">Chargement de la liste des paiements validés...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>idpaiement</th>
                                <th>Montant à payer</th>
                                <th>Période bonus</th>
                                <th>date paie</th>
                                <th>Caissier(e)</th>
                                <!-- <th>Numero du re&ccedil;u</th> -->
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
