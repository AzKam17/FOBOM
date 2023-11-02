<?php
$selected = 'transac';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Virement
        <small>Liste des virements internationaux en cours</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Transaction</li>
        <li class="active"><a href="index.php?module=virement&action=virecourchoix">Virement en cours</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Cumul des Virements Internationaux en cours</h3>

                    <form action="index.php?module=virement&amp;action=downviretrangCtrl" method="post" id="" role="form">
                        <button type="submit" class="btn btn-success btn-lrg pull-left" title="Exporter fichier banquaire">
                            <i class="fa fa-download"></i>&nbsp; Ficher Banque
                        </button>
                    </form>
                    <form action="index.php?module=virement&amp;action=validviretrangCtrl" method="post" id="imp" role="form">
                        <button type="submit" class="btn btn-warning btn-lrg pull-right" title="Valider virements">
                            <i class="fa fa-arrow-circle-o-right"></i>&nbsp; Valider
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
                    <table id="datatable-buttons_12" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 25px;">
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
                                <td align="center" colspan="7">Chargement de la liste des virements internationaux en cours...</td>
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
