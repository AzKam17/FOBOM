<?php
$selected = 'credit';
?>

<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Crédit
        <small>Suivit de Cheque</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Crédit</li>
        <li class="active">Crédit avec chèque</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Créer un suivit de cheque</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- Smart Wizard -->
                    <p>Accorder un nouveau crédit suivit de depot de cheque. Les champs en asterix sont obligatoires (*)</p>
                    <form class="form-horizontal form-label-left" id="form" role="form" method="post" autocomplete="off" action="index.php?module=credit&amp;action=newcredit1">
                        <div id="wizard" class="form_wizard wizard_horizontal">
                            <ul class="wizard_steps">
                                <li>
                                    <a href="#step-1">
                                        <span class="step_no">1</span>
                                        <span class="step_descr">
                                            Le Crédit<br />
                                            <small>Détail du crédit</small>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step-2">
                                        <span class="step_no">2</span>
                                        <span class="step_descr">
                                            Le Chèque<br />
                                            <small>Détail du chèque</small>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <div id="step-1">
                                <h2 class="StepTitle">LE CREDIT</h2>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nomEleve">FBO <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="outputID" name="element_2" type="hidden" value="">
                                        <input id="inputID" name="element_5" type="hidden" value="<?php echo $_SESSION['pays']; ?>">
                                        <input id="nomEleve" name="element_3" type="text" placeholder="Entrez le nom complet du FBO OU Entrez son numéro identifiant" class="form-control col-md-7 col-xs-12" maxlength="255" value="" required="">
                                        <div class="suggestionsBoxele" id="suggestionsele" style="display: none;"> <!-- bloc contenant les eventuelles suggestions -->
                                          <!-- <img src="image/upArrow.png" style="position: relative; top: -12px; left: 3px;" alt="upArrow" />  image de la fleche vers le haut -->
                                            <div class="suggestionListele" id="autoSuggestionsListele"><!-- liste contenant les suggestions -->
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="infomationBoxele" id="infomationBox" style="display: none;"> <!-- bloc contenant les eventuelles informations de l''eleve -->
                                            <div class="informationListele" id="autoInformationListele"><!-- liste contenant les informations -->
                                                &nbsp;
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Montant <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="element_4" name="element_4" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" data-date-start-view="2" data-date-language="fr" class="form-control pull-right" name="datepicker" id="datepicker" maxlength="255" value="<?php echo date('d/m/Y'); ?>" required="">

                                        </div>
                                    </div>
                                </div>  
                                <?php
                                $result = array();
                                $pdo = PDO2::getInstance();
                                $requete = $pdo->prepare(" SELECT idmotif, libelle FROM motif ");
                                $requete->execute();
                                echo '<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Motif du crédit</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">';
                                while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<div class="radio">
                                            <label>
                                                <input type="radio" name="element_5" id="" value="' . utf8_encode($result['idmotif']) . '" class="flat-blue" checked>
                                                ' . utf8_encode($result['libelle']) . '
                                            </label>
                                        </div>';
                                }
                                echo '</div>
                                </div>';
                                $requete->closeCursor();
                                ?>
                            </div>
                            <div id="step-2">
                                <h2 class="StepTitle">LE CHEQUE</h2>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Numero du Chèque <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="element_6" name="element_6" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Montant du Chèque<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="element_7" name="element_7" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date delivrée<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" data-date-start-view="2" data-date-language="fr" class="form-control pull-right" name="datepickerr" id="datepickerr" maxlength="255" value="<?php echo date('d/m/Y'); ?>" required="">

                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Type de chèque</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_8" id="element_8" value="Chèque non barré" class="flat-blue1" checked>
                                                Chèque non barré
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_8" id="element_8" value="Chèque barré" class="flat-blue1">
                                                Chèque barré
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="element_8" id="element_8" value="Billet à ordre" class="flat-blue1">
                                                Billet à ordre
                                            </label>
                                        </div>
                                    </div>
                                </div>  
                            </div>

                        </div>
                        <!-- End SmartWizard Content -->
                    </form>
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

</section>
<!-- /.content -->