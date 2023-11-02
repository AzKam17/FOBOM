<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profil
        <small>Supprimer un administrateur</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Profil</li>
        <li class=""><a href="index.php?module=fbo&action=fbolist">Gestion des administrateurs</a></li>
        <li class="active">Supprimer un administrateur</li>
    </ol>
</section>


<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">SUPPRIMER UN ADMINISTRATEUR</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form action="index.php?module=profil&amp;action=treat_suppr_admin" method="post" id="imp" role="form">   
                    <div class="box-body">
                        <p>Vous avez décidé de supprimer l'administrateur : <strong><?php echo utf8_decode($nom).' '.utf8_decode($prenom); ?> </strong> </p>
                        <p>Titre : <strong><?php echo utf8_decode($titre) ?> </strong> </p>
                        <p>Si vous menez cette action, toutes les informations liées à cet administrateur ne seront plus accessibles</p>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-danger btn-lrg" title="Supprimer">
                                    <i class="fa fa-trash-o"></i>&nbsp; SUPPRIMER
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="code" id="Cod" value="<?php echo $code ?>" />
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
