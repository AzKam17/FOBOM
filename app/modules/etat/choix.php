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
        <small>Etats des Bonus</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Etat</li>
        <li class="active">Bonus</li>
    </ol>
</section>


<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Etat des Bonus</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form action="index.php?module=etat&amp;action=dynamiCtrl" method="post" id="imp" role="form">   
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12 border-right">
                                <!-- Type bonus etat Radio -->
                                <div class="form-group">
                                    <label class="control-label">Type de bonus</label>
                                    <div class="">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_1" id="" value="0" class="flat-blue" checked="">
                                                Non Encaissé
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_1" id="" value="1" class="flat-blue">
                                                Encaissé
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_1" id="" value="2" class="flat-blue">
                                                Partiel
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_1" id="" value="3" class="flat-blue">
                                                En Attente
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 border-right">
                                <!-- Type bonus mode de paiement Radio -->
                                <div class="form-group">
                                    <label class="control-label">Type de paiement</label>
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
                                                Caisse
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_2" id="" value="2" class="flat-blue">
                                                Virement
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_2" id="" value="3" class="flat-blue">
                                                Régularisé
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 border-right">
                              <!-- Date and time range -->
                                <div class="form-group">
                                    <label class="control-label">Période du bonus :</label>

                                    <div class="input-group">
                                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                            <span>
                                                <i class="fa fa-calendar"></i> <input type="text" name="periode" id="Periode" value="" placeholder="Interval de Periode"/>
                                            </span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.form group -->
                                <p><strong><h5>OU (un seul critère à la fois)</h5></strong></p>
                                <!-- Date range -->
                                <div class="form-group">
                                    <label class="control-label">Date de paiement :</label>

                                    <div class="input-group">
                                        <button type="button" class="btn btn-default pull-right" id="daterange-btn2">
                                            <span>
                                                <i class="fa fa-calendar"></i> <input type="text" name="paiement" id="Paiement" value="" placeholder="Date de paiement"/>
                                            </span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <!-- Type virement bonus Radio -->
                                <div class="form-group">
                                    <label class="control-label">Type de virement</label>
                                    <div class="">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_3" id="" value="0" class="flat-blue" checked="">
                                                Aucun
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_3" id="" value="1" class="flat-blue">
                                                National
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_3" id="" value="2" class="flat-blue">
                                                Etranger
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
