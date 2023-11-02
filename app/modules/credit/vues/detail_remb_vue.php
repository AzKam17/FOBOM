<?php
$selected = 'credit';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Crédit
        <small>Rembourser un Crédit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Crédit</li>
        <li class=""><a href="index.php?module=credit&action=listecredit">Liste crédit</a></li>
        <li class="active">Rembourser crédit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <!-- =========================================================== -->

    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Rembourser le crédit Numero : <strong><?php echo $idcredit; ?></strong></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- Form Reg submit -->  
                <form autocomplete="off" method="post" action="index.php?module=credit&amp;action=rembCtrl"> 
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p>Vous avez décidé de rembourser le crédit Numero : <strong><?php echo $idcredit; ?></strong>&nbsp;&nbsp;dont le montant actuel est de : <strong><?php echo utf8_encode(number_format($mtcredit, 0, ',', ' ')); ?> F CFA</strong></strong> </p>
                        <p>Veuillez entrer le montant à rembourser, ce dit montant est considéré comme de l'espèce</p>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="charge">Montant <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="charge" id="charge" placeholder="Entrer le montant versé en espèce" required="required">
                            </div>  
                        </div>
                        <input type="hidden" name="idcred" id="idcred" value="<?php echo $idcredit; ?>" />
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Rembourser</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer-->
                    <input type="hidden" name="idcred" value="<?php echo $idcredit; ?>" />
                    <input type="hidden" name="mtcred" value="<?php echo $mtcredit; ?>" />
                </form>
            </div>
        </div>
        <!-- /.box -->
    </div>
</section>
<!-- /.content -->
