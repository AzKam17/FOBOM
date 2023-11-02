<?php
$selected = 'transac';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Virement
        <small>Liste des virements nationaux</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Transaction</li>
        <li class="active">Virement</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Virements Nationaux Cumul</h3>

                    <form action="index.php?module=virement&amp;action=effectvirCtrl" method="post" id="imp" role="form">
                        <button type="submit" class="btn btn-warning btn-lrg pull-right" title="Ordonner virements">
                            <i class="fa fa-arrow-circle-o-right"></i>&nbsp; Ordonner
                        </button>
                    </form>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons_6" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 180px;">
                        <thead>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom complet</th>
                                <th>Numero de compte</th>
                                <th>Montant à payer</th>
                                <th>Période</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="6">Chargement de la liste des virements nationaux ...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom complet</th>
                                <th>Numero de compte</th>
                                <th>Montant à payer</th>
                                <th>Période</th>
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
