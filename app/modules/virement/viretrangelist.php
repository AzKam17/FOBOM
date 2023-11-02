<?php
$selected = 'transac';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Virement
        <small>Liste des virements internationaux</small>
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
                    <h3 class="box-title">Virements Internationaux Cumul</h3>
                    
                    <form action="index.php?module=virement&amp;action=effectuervirCtrl" method="post" id="imp" role="form">
                        <div class="col-md-4 col-sm-4 col-xs-8 pull-right">
                            <div class="form-group">
                                <label for="charge">Charge Unique Transfert *</label>
                                <input type="text" class="form-control" name="charge" id="charge" required="" placeholder="Entrer le montant du transfert">
                            </div>
                            <button type="submit" class="btn btn-warning btn-lrg" title="Ordonner virements">
                                <i class="fa fa-arrow-circle-o-right"></i>&nbsp; Ordonner
                            </button>
                        </div>
                    </form>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable-buttons_8" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 22px;">
                        <thead>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom complet</th>
                                <th>Numero de compte</th>
                                <th>Swift code</th>
                                <th>Montant à payer</th>
                                <th>Pays</th>
                                <th>Période</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gradeA">
                                <td align="center" colspan="6">Chargement de la liste des virements étrangers ...</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Code distrib</th>
                                <th>Nom complet</th>
                                <th>Numero de compte</th>
                                <th>Swift code</th>
                                <th>Montant à payer</th>
                                <th>Pays</th>
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
