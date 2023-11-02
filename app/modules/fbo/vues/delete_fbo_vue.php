<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->
<?php
$selected = 'fbo';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        FBO
        <small>Supprimer un FBO</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">FBO</li>
        <li class=""><a href="index.php?module=fbo&action=fbolist">Liste FBO</a></li>
        <li class="active">Supprimer un FBO</li>
    </ol>
</section>


<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">SUPPRIMER UN FBO</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form action="index.php?module=fbo&amp;action=treat_suppr_fbo" method="post" id="imp" role="form">   
                    <div class="box-body">
                        <p>Vous avez décidé de supprimer le FBO numero : <strong><?php echo $code; ?></strong>&nbsp;&nbsp; dont le nom est : <strong><?php echo utf8_decode($nom); ?> </strong></strong> </p>
                        <p>Si vous menez cette action, toutes les informations liées à ce FBO seront effacées definitivement</p>
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
