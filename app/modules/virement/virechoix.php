<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->
<?php
$selected = 'transac';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Virement
        <small>Liste des virements</small>
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
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Virement à Ordonner</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form action="index.php?module=virement&amp;action=virementCtrl" method="post" id="imp" role="form">   
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 text-center">
                                <!-- Type Virement Radio -->
                                <div class="form-group">
                                    <label class="control-label">Type de virement</label>
                                    <div class="">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_1" id="" value="1" class="flat-blue" checked="">
                                                National
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_1" id="" value="2" class="flat-blue">
                                                Etranger
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                 </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-center">
                                <!-- Date -->
                                <div class="form-group">
                                    <label>Période</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" data-date-start-view="2" data-date-language="fr" class="form-control pull-right" name="datepicker" id="datepicker" maxlength="255" value="">

                                    </div>
                                    <!-- /.input group -->
                                    <p class="help-block">Année puis Mois concerné par le bonus.</p>
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lrg ajax" title="Voir virements">
                                    <i class="fa fa-arrow-circle-o-right"></i>&nbsp; Soumettre
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.box-footer-->
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.row -->

    <!-- =========================================================== -->

</section>
<!-- /.content -->
