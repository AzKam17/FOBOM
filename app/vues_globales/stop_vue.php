<?php if (!empty($erreurs)) { ?>
    <!-- Main content -->
    <section class="content">

        <div class="error-page">
            <h2 class="headline text-red">500</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Oops! <?php foreach ($erreurs as $e) { echo $e; } ?>.</h3>

                <p>
                    Vous avez pas le privilège necessaire pour voir cette information.
                    Cependant, vous pouvez <a href="index.php?module=dashboard&action=dashboard">retourner au tableau de bord</a> ou contacter l'administrateur.
                </p>
            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- /.content -->
<?php
}  