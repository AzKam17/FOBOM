<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<?php
// Definition du default timezone
date_default_timezone_set('Africa/Abidjan');

/* * **************** fonction de transcription dune date en français *************** */

function dateFR($timestamp) {
    $numero_jour = date('N', $timestamp);
    $numero_mois = date('n', $timestamp);
    $numero_jour_mois = date('d', $timestamp);
    $numero_annee = date('Y', $timestamp);
    $mois = array(
        1 => 'Janvier',
        2 => 'Fevrier',
        3 => 'Mars',
        4 => 'Avril',
        5 => 'Mai',
        6 => 'Juin',
        7 => 'Juillet',
        8 => 'Août',
        9 => 'Septembre',
        10 => 'Octobre',
        11 => 'Novembre',
        12 => 'Decembre'
    );
    $jour_fr = array(
        1 => 'Lundi',
        2 => 'Mardi',
        3 => 'Mercredi',
        4 => 'Jeudi',
        5 => 'Vendredi',
        6 => 'Samedi',
        7 => 'Dimanche'
    );
    $retour = $jour_fr[$numero_jour] . ' ' . $numero_jour_mois . ' ' . $mois[$numero_mois] . ' ' . $numero_annee;
    return $retour;
}

/* * ********************* dedut du processus *************** */


if (!empty($_GET['id'])) {

    $mtcredit = $_GET['mt'];
    $idcredit = $_GET['id'];
    $code = $_GET['fbo'];
    $nom = $_GET['nomfbo'];
    ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Déposer un chéque</h4>              
            </div>
            <form autocomplete="off" method="post" action="index.php?module=credit&amp;action=depoCheq"> 
                <div class="modal-body">     
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p>Vous avez décidé de remettre le chèque Numero : 
                            <strong><?php echo $idcredit; ?></strong>&nbsp;&nbsp; 
                            d'un montant de : <strong><?php echo utf8_encode(number_format($mtcredit, 0, ',', ' ')); ?> F CFA</strong></strong> </p>
                        <p>Ce chèque appartient au FBO : 
                            <strong><?php echo utf8_encode($nom); ?></strong>&nbsp;&nbsp; </br>
                            code distributeur : <strong><?php echo utf8_encode($code); ?></strong></strong> </p>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date du Dépot<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" data-date-start-view="2" data-date-language="fr" class="form-control pull-right" name="datepickerrr" id="datepickerrr" maxlength="255" value="<?php echo date('d/m/Y'); ?>" required="">

                                </div>
                            </div>
                        </div>
                        <script>
                            $(function () {
                                /* Date picker */
                                $('#datepickerrr').datepicker({
                                    format: "dd/mm/yyyy",
                                    todayBtn: "linked",
                                    keyboardNavigation: false,
                                    forceParse: false,
                                    calendarWeeks: true,
                                    autoclose: true
                                });
                            });
                        </script>

                    </div>
                    <!-- /.box-body --> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fermer</button>
                    <input class="btn btn-outline" type="submit" name="noter" value="Dépot">
                </div> 
                <input type="hidden" name="idcheq" value="<?php echo $idcredit; ?>" />
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?php
}