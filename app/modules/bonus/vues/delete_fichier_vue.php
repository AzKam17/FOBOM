<?php
$selected = 'bonusfichier';
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
        FBO
        <small>Supprimer un Fichier Bonus</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Bonus</li>
        <li class=""><a href="index.php?module=bonus&action=bonufichier">Bonus Mensuel</a></li>
        <li class="active">Supprimer un fichier</li>
    </ol>
</section>


<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">SUPPRIMER UN FICHIER BONUS</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form action="index.php?module=bonus&amp;action=treat_suppr_fb" method="post" id="imp" role="form">   
                    <div class="box-body">
                        <p>Vous avez décidé de supprimer le Fichier numero : <strong><?php echo $code; ?></strong></p>
                        <p>dont le nom est : <strong><?php echo utf8_decode($nom); ?> </strong></strong> </p>
                        <p>Période : <strong><?php echo $mois.'/'.$annee; ?></strong>
                        <p>Si vous menez cette action, toutes les informations liées à ce Ficher Bonus mensuel seront effacées definitivement</p>
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
