<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->
<?php
$selected = 'etat';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Etat
        <small>Etats des Crédits</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Etat</li>
        <li class="active">Crédit</li>
    </ol>
</section>


<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Etat des Crédits</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form action="index.php?module=etat&amp;action=dynamyCtrl" method="post" id="imp" role="form">   
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12 border-right">
                                <!-- Type bonus etat Radio -->
                                <div class="form-group">
                                    <label class="control-label">Type de crédit</label>
                                    <div class="">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_1" id="" value="0" class="flat-blue" checked="">
                                                Non Remboursé
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_1" id="" value="1" class="flat-blue">
                                                Remboursé
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 border-right">
                                <!-- Type bonus mode de paiement Radio -->
                                <div class="form-group">
                                    <label class="control-label">Type de remboursement</label>
                                    <div class="">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_2" id="" value="0" class="flat-blue" checked="">
                                                Aucun
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_2" id="" value="1" class="flat-blue">
                                                Normal
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_2" id="" value="2" class="flat-blue">
                                                Régularisé
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <!-- Date and time range -->
                                <div class="form-group">
                                    <label class="control-label">Date et Période :</label>

                                    <div class="input-group">
                                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                            <span>
                                                <i class="fa fa-calendar"></i> <input type="text" name="periode" id="Periode" value="" required="" placeholder="Interval de Date"/>
                                            </span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lrg ajax" title="Voir etat">
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
