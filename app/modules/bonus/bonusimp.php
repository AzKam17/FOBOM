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
        Bonus
        <small>Importer bonus mensuel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Bonus</li>
        <li class="active">Import</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Importation de Bonus</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form action="index.php?module=bonus&amp;action=importbonCtrl" enctype="multipart/form-data" method="post" id="imp" role="form">   
                    <div class="box-body">
                        Importer le fichier mensuel des bonus. Le fichier doit etre de type : <code> XLS,XLSX,CSV</code>
                        <br>
                        <p>Le bonus uploadé est considéré comme etant celui du mois précédent</p>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <!-- file upload -->
                                <div class="form-group">
                                    <label for="exampleInputFile">Fichier Bonus:</label>
                                    <input type="file" name="fichier" id="fichier" required="">

                                </div>
                            </div>
                        </div>
                        <div class="ajax-content">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lrg ajax" title="Ajax Request">
                                    Télécharger
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
