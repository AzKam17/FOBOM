<?php
$selected = 'fbo';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        FBO
        <small>Détails du FBO</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">FBO</li>
        <li class="active"><a href="index.php?module=fbo&action=fbolist">Liste FBO</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <?php
                    if (is_file($fichier1)) {
                        echo ' <img src="' . $fichier1 . '" alt="Photo de Profil du FBO" class="profile-user-img img-responsive img-circle" > ';
                    } elseif (is_file($fichier2)) {
                        echo ' <img src="' . $fichier2 . '" alt="Photo de Profil du FBO" class="profile-user-img img-responsive img-circle" >  ';
                    } elseif (is_file($fichier3)) {
                        echo ' <img src="' . $fichier3 . '" alt="Photo de Profil du FBO" class="profile-user-img img-responsive img-circle" >  ';
                    } else {
                        echo ' <img src="img/fbo/avatar.jpg" alt="Photo de Profil du FBO" class="profile-user-img img-responsive img-circle" > ';
                    }
                    ?>

                    <h3 class="profile-username text-center"><?php echo $nom; ?></h3>

                    <p class="text-muted text-center"><?php echo $code; ?> , <?php echo $statut; ?></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>CUMUL BONUS</b> <a class="pull-right"><b><?php echo utf8_encode(number_format($bon, 0, ',', ' ')); ?> F CFA</b></a>
                        </li>
                        <li class="list-group-item">
                            <b>CUMUL CREDIT</b> <a class="pull-right"><b><?php echo utf8_encode(number_format($cred, 0, ',', ' ')); ?> F CFA</b></a>
                        </li>
                        <li class="list-group-item">
                            <b>BALANCE</b> <a class="pull-right"><b><?php echo utf8_encode(number_format($balc, 0, ',', ' ')); ?> F CFA</b></a>
                        </li>
                    </ul>
                    
                    <a <?php echo ' href="index.php?module=fbo&action=fichefbo&id=' . $code . '" ';?> target="_blank" class="btn btn-default btn-block"><b>Imprimer</b></a>

                    <a <?php
                    if ($cred === 0 OR $cred == NULL) {
                        echo ' disabled="" ';
                    } else {
                        echo ' href="index.php?module=regulation&action=regAutoFbo&id=' . $code . '" ';
                    }
                    ?> class="btn btn-primary btn-block"><b>Regulariser</b></a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Résumé</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Contact</strong>

                    <p class="text-muted">
                        <?php echo 'Nationalité: ' . $nationalite; ?><br>
                        <?php echo 'Tel: ' . $mobile; ?><br>
                        <?php echo 'Email: ' . $email; ?><br>
                        <?php echo 'Adresse: ' . $addresse; ?>
                    </p>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Localisation</strong>

                    <p class="text-muted"><?php echo $ville; ?>, <?php echo $commune; ?> <?php echo $quartier; ?></p>

                    <hr>

                    <strong><i class="fa fa-pencil margin-r-5"></i> Compte Banquaire</strong>

                    <p>
                        <span class="label label-default"><?php echo $banque; ?></span>
                    </p>

                    <hr>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#bonus" data-toggle="tab">Bonus</a></li>
                    <li><a href="#Credit" data-toggle="tab">Crédit</a></li>
                    <li><a href="#settings" data-toggle="tab">Reglages</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="bonus">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Activité des bonus</h3>

                                <div class="box-tools">

                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Montant</th>
                                        <th>Mois</th>
                                        <th>Année</th>
                                        <th>Etat</th>
                                        <th>Type d'encaissement</th>
                                        <th>Options</th>
                                    </tr>
                                    <?php foreach ($bonus_infos as $b) { ?>

                                        <tr>
                                            <td><?php echo utf8_encode($b['idbonus']); ?></td>
                                            <td><?php echo utf8_encode(number_format($b['montapayer'], 0, ',', ' ')); ?></td>
                                            <td><?php echo utf8_encode($b['mois']); ?></td>
                                            <td><?php echo utf8_encode($b['annee']); ?></td>
                                            <td><?php if ($b['etat'] == 0) { ?>
                                                    <span class="label label-danger">Non Encaissé</span>
                                                <?php } elseif ($b['etat'] == 1) { ?>
                                                    <span class="label label-success">Encaissé</span>            
                                                <?php } elseif ($b['etat'] == 2) { ?>
                                                    <span class="label label-default">Partiel</span>
                                                <?php } else { ?>
                                                    <span class="label label-warning">En Attente</span>
                                                <?php } ?>
                                            </td>
                                            <td><?php if ($b['typencaisse'] == 0) { ?>
                                                    <span class="label label-danger">Aucun</span>
                                                <?php } elseif ($b['typencaisse'] == 1) { ?>
                                                    <span class="label label-success">Caisse</span>            
                                                <?php } elseif ($b['typencaisse'] == 2) { ?>
                                                    <span class="label label-default">Virement</span>            
                                                <?php } else { ?>
                                                    <span class="label label-primary">Régularisé</span>           
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($b['etat'] == 0 OR $b['etat'] == 2) { ?>
                                                    <a href="modules/fbo/ModalAjaxPayAll.php" data-toggle="modal_7" fbo="<?php echo utf8_encode($idfbo); ?>" compte="<?php echo utf8_encode($b['compte_banque']); ?>" data-target="#" class="btn btn-warning btn-sm" title="Pay All"><i class="fa fa-arrow-circle-o-down"></i></a>
                                                    <a href="modules/fbo/ModalAjaxPay.php" data-toggle="modal_3" id="<?php echo utf8_encode($b['idbonus']); ?>" mt="<?php echo utf8_encode($b['montapayer']); ?>" fbo="<?php echo utf8_encode($idfbo); ?>" compte="<?php echo utf8_encode($b['compte_banque']); ?>" nat="<?php echo utf8_encode($b['nationalite']); ?>" data-target="#" class="btn btn-primary btn-sm" title="Paiement"><i class="fa fa-money"></i></a>
                                                <?php } if ($b['etat'] == 2 OR $b['etat'] == 1) { ?>
                                                    <a href="modules/fbo/ModalAjaxAnnul.php" data-toggle="modal_4" id="<?php echo utf8_encode($b['idbonus']); ?>" mt="<?php echo utf8_encode($b['montapayer']); ?>" fbo="<?php echo utf8_encode($idfbo); ?>" nom="<?php echo utf8_encode($b['nom_complet']); ?>" mois="<?php echo utf8_encode($b['mois']); ?>" annee="<?php echo utf8_encode($b['annee']); ?>" data-target="#" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-ban"></i></a>
                                                <?php } if ($b['etat'] == 3) { ?>
                                                    <a href="modules/fbo/ModalAjaxAbort.php" data-toggle="modal_5" id="<?php echo utf8_encode($b['idbonus']); ?>" mt="<?php echo utf8_encode($b['montapayer']); ?>" fbo="<?php echo utf8_encode($idfbo); ?>" nom="<?php echo utf8_encode($b['nom_complet']); ?>" mois="<?php echo utf8_encode($b['mois']); ?>" annee="<?php echo utf8_encode($b['annee']); ?>" data-target="#" class="btn btn-warning btn-sm" title="Annuler"><i class="fa fa-ban"></i></a>
                                                <?php } ?>
                                                <a href="modules/fbo/ModalAjaxTransac.php" data-toggle="modal_6" id="<?php echo utf8_encode($b['idbonus']); ?>" mt="<?php echo utf8_encode($b['montapayer']); ?>" fbo="<?php echo utf8_encode($idfbo); ?>" nom="<?php echo utf8_encode($b['nom_complet']); ?>" mois="<?php echo utf8_encode($b['mois']); ?>" annee="<?php echo utf8_encode($b['annee']); ?>" data-target="#" class="btn btn-success btn-sm" title="Transaction"><i class="fa fa-exchange"></i></a>
                                            </td>   
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="Credit">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Activité des crédits</h3>

                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Montant</th>
                                        <th>Date</th>
                                        <th>Motif</th>
                                        <th>Etat</th>
                                        <th>Rembourser</th>
                                        <th>Operateur</th>
                                        <th>Options</th>
                                    </tr>
                                    <?php foreach ($credit_infos as $c) { ?>

                                        <tr>
                                            <td><?php echo utf8_encode($c['idcredit']); ?></td>
                                            <td><?php echo utf8_encode(number_format($c['mtcredit'], 0, ',', ' ')); ?></td>
                                            <td><?php echo utf8_encode(dateFr($c['date_cred'])); ?></td>
                                            <td><?php echo utf8_encode($c['libelle']); ?></td>
                                            <td><?php if ($c['etat'] == 0) { ?>
                                                    <span class="label label-danger">Non Remboursé</span>
                                                <?php } else { ?>
                                                    <span class="label label-success">Remboursé</span>            
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($c['typerembour'] == 0) { ?>
                                                    <span class="label label-danger">Aucun</span>
                                                <?php } elseif ($c['typerembour'] == 1) { ?>
                                                    <span class="label label-default">Chèque</span>           
                                                <?php } elseif ($c['typerembour'] == 2) { ?>
                                                    <span class="label label-primary">Régularisé</span>
                                                <?php } else { ?>
                                                    <span class="label label-success">Espèce</span>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo utf8_encode($c['operateur']); ?></td>
                                            <td><?php if ($c['etat'] == 0) { ?>
                                                    <a href="modules/fbo/ModalAjaxReg.php" data-toggle="modal_1" id="<?php echo utf8_encode($c['idcredit']); ?>" mt="<?php echo utf8_encode($c['mtcredit']); ?>" fbo="<?php echo utf8_encode($idfbo); ?>" data-target="#" class="btn btn-info btn-sm" title="Régulariser"><i class="fa fa-refresh"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        <form action="index.php?module=fbo&amp;action=editfboCtrl" autocomplete="off" enctype="multipart/form-data" method="post" id="" role="form" class="form-horizontal">
                            <div class="form-group">
                                <label for="inputCode" class="col-sm-2 control-label">Code distributeur *</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $code; ?>" class="form-control" name="element_1" id="inputCode" placeholder="Code distributeur" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Nom Complet *</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $nom; ?>" class="form-control" name="element_2" id="inputName" placeholder="Nom complet" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBank" class="col-sm-2 control-label">Banque</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $banque; ?>" class="form-control" name="element_3" id="inputBank" placeholder="Numéro de Compte Banquaire">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBankcod" class="col-sm-2 control-label">Swift Code</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $swift; ?>" class="form-control" name="element_4" id="inputBankcod" placeholder="Numéro de Compte Banquaire">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputNation" class="col-sm-2 control-label">Pays du Compte</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $nationalite; ?>" class="form-control" name="element_5" id="inputNation" placeholder="Nationalité">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Grade</label>
                                <div class="col-sm-10">
                                    <select name="element_6" class="form-control">
                                        <option value="<?php echo $statut; ?>" selected="selected"><?php echo $statut; ?></option>
                                        <option value="Novus">Novus</option>
                                        <option value="Animateur Adjoint">Animateur Adjoint (AA)</option>
                                        <option value="Animateur">Animateur (A)</option>
                                        <option value="Manager Adjoint">Manager Adjoint (MA)</option>
                                        <option value="Manager">Manager (M)</option>
                                        <option value="Manager">Manager Saphir (MS)</option>
                                        <option value="Manager">Manager Diamant (MD)</option>
                                        <option value="Manager">Manager Double Diamant (MDD)</option>
                                        <option value="Manager">Manager Triple Diamant (MTD)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" value="<?php echo $email; ?>" class="form-control" name="element_7" id="inputEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputMobile" class="col-sm-2 control-label">Mobile</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $mobile; ?>" class="form-control" name="element_8" id="inputMobile" placeholder="Mobile">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Addresse</label>

                                <div class="col-sm-10">
                                    <textarea value="<?php echo $addresse; ?>" class="form-control" name="element_9" id="inputExperience" placeholder="Addresse Postale"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAdd" class="col-sm-2 control-label">Ville</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $ville; ?>" class="form-control" name="element_10" id="inputAdd" placeholder="Ville">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Commune</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $commune; ?>" class="form-control" name="element_11" id="inputSkills" placeholder="Commune">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputQuar" class="col-sm-2 control-label">Quartier</label>

                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $quartier; ?>" class="form-control" name="element_12" id="inputQuar" placeholder="Quartier">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPic" class="col-sm-2 control-label">Photo FBO<small>(JPEG,JPG et PNG autorisées. Dimensions 1000px/1000px. taille maximum 1Mo)</small></label> 

                                <div class="col-sm-10">    
                                    <input id="element_20" name="fichier" id="inputPic" type="file"><input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                </div>
                            </div>
                            <input type="hidden" name="idfbo" id="Idfbo" value="<?php echo $code ?>" />
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Modifier</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- =========================================================== -->

</section>
<!-- /.content -->
