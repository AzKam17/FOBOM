<?php
$selected = 'credit';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Crédit
        <small>Régulariser un Crédit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Crédit</li>
        <li class=""><a href="index.php?module=credit&action=listecredit">Liste crédit</a></li>
        <li class="active">Régulariser crédit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Régulariser le crédit Numero : <strong><?php echo $idcredit; ?></strong></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- Form Reg submit -->  
                <form autocomplete="off" method="post" action="index.php?module=credit&amp;action=regManuFbo"> 
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p>Vous avez décidé de régulariser le crédit Numero : <strong><?php echo $idcredit; ?></strong>&nbsp;&nbsp; d'un montant de : <strong><?php echo utf8_encode(number_format($mtcredit, 0, ',', ' ')); ?> F CFA</strong></strong> </p>
                        <div class="box-body table-responsive no-padding">
                            <h4>Liste des bonus</h4>
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <th>Montant</th>
                                    <th>Mois</th>
                                    <th>Année</th>
                                    <th>Mt Reg</th>
                                </tr>
                                <?php foreach ($bonus_infos as $b) { ?>

                                    <tr>
                                        <td><?php echo utf8_encode($b['0']); ?></td>
                                        <td>
                                            <?php echo utf8_encode(number_format($b['1'], 0, ',', ' ')); ?>
                                            <input type="hidden" name="montantbonus[]" value="<?php echo $b['1']; ?>" id="<?php echo 'mtTriele' . $b['0']; ?>" />
                                        </td>
                                        <td><?php echo utf8_encode($b['2']); ?></td>
                                        <td><?php echo utf8_encode($b['3']); ?></td>
                                        <td>
                                            <input type="text" class="form-control" id="<?php echo 'idele' . $b['0']; ?>" name="noteinput[]" value="" placeholder="Montant à regulariser" onkeyup="lookup_id_ele(<?= $b['0']; ?>);">
                                            <input type="hidden" name="idbonus[]" value="" id="<?php echo 'idTriele' . $b['0']; ?>" />
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Regulariser</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer-->
                    <input type="hidden" name="idcred" value="<?php echo $idcredit; ?>" />
                    <input type="hidden" name="mtcred" value="<?php echo $mtcredit; ?>" />
                    <input type="hidden" name="code" value="<?php echo $code; ?>" />
                </form>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <script type="text/javascript">
        function lookup_id_ele(eleid) {
            if ($('#idele' + eleid).val() !== "") { // si le champs note input isset
                $('#idTriele' + eleid).val(eleid); // et on remplit le tableau des idele dynamiquement 
            } else {
                $('#idTriele' + eleid).val('');
            }
        }
    </script>
    <!-- =========================================================== -->

</section>
<!-- /.content -->
