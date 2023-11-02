<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profil
        <small>Gestion des administrateurs</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Profil</li>
        <li class="active">Gestion des administrateurs</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des administrateurs</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#liste" data-toggle="tab">Liste des administrateurs</a></li>
                            <li><a href="#creer" data-toggle="tab">Créer un administrateur</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="liste">
                                <table id="datatable-buttons_16" class="table table-bordered table-striped dt-responsive nowrap" style="width: 30px; margin-left: 100px;">
                                    <thead>
                                        <tr>
                                            <th>civilite</th>
                                            <th>Nom</th> 
                                            <th>Prenom</th>
                                            <th>Nom Utilisateur</th>
                                            <th>Titre</th>
                                            <th>Niveau</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="gradeA">
                                            <td align="center" colspan="8">Chargement de la liste des administrateurs en cours...</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>civilite</th>
                                            <th>Nom</th> 
                                            <th>Prenom</th>
                                            <th>Nom Utilisateur</th>
                                            <th>Titre</th>
                                            <th>Niveau</th>
                                            <th>Options</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="creer">
                                <form action="index.php?module=profil&amp;action=ajoutprofilCtrl" autocomplete="off" enctype="multipart/form-data" method="post" id="" role="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Civilité</label>
                                        <div class="col-sm-10">
                                            <select name="element_1" class="form-control">
                                                <option value="Mr" selected="selected">Mr</option>
                                                <option value="Mme">Mme</option>
                                                <option value="Mlle">Mlle</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">Nom *</label>

                                        <div class="col-sm-10">
                                            <input type="text" value="" class="form-control" name="element_2" id="inputName" placeholder="Nom de l'administrateur" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputBank" class="col-sm-2 control-label">Prénoms</label>

                                        <div class="col-sm-10">
                                            <input type="text" value="" class="form-control" name="element_3" id="inputBank" placeholder="Prénom de l'administrateur">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputBankcod" class="col-sm-2 control-label">Username *</label>

                                        <div class="col-sm-10">
                                            <input type="text" value="" class="form-control" name="element_4" id="inputBankcod" placeholder="Nom d'utilisateur" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNation" class="col-sm-2 control-label">Password *</label>

                                        <div class="col-sm-10">
                                            <input type="password" value="" class="form-control" name="element_5" id="inputNation" placeholder="Mot de passe" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNation" class="col-sm-2 control-label">Titre</label>

                                        <div class="col-sm-10">
                                            <input type="text" value="" class="form-control" name="element_6" id="inputNation" placeholder="Titre">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Niveau *</label>
                                        <div class="col-sm-10">
                                            <select name="element_7" class="form-control" required="">
                                                <option value="1" selected="selected">Administrateur</option>
                                                <option value="2">Caissière</option>
                                                <option value="3">Comptable</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPic" class="col-sm-8 control-label">Photo administrateur <small>(JPEG,JPG et PNG autorisées. Dimensions 1000px/1000px. taille maximum 1Mo)</small></label> 

                                        <div class="col-sm-4">    
                                            <input id="element_20" name="fichier" id="inputPic" type="file"><input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary btn-lrg">Créer</button>
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
