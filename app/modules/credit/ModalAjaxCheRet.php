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
    $idcheq = $_GET['id'];
    $idcredit = $_GET['fbo'];
    $nom = $_GET['nomfbo'];
    ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Déposer un chéque</h4>              
            </div>
            <form autocomplete="off" method="post" action="index.php?module=credit&amp;action=retourCheq"> 
                <div class="modal-body">     
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p>Vous avez re&ccedil;u le chèque Numero : <strong><?php echo $idcheq; ?></strong>&nbsp;&nbsp; 
                            d'un montant de : <strong><?php echo utf8_encode(number_format($mtcredit, 0, ',', ' ')); ?> F CFA</strong></p>
                        <p>Concernant le Credit : <strong><?php echo utf8_encode($idcredit); ?></strong>&nbsp;&nbsp; du FBO : <strong><?php echo utf8_encode($nom); ?></strong></p>

                        <div class="form-group">
                            <label for="datepicke">Date du Retour<span class="required">*</span>
                            </label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" data-date-start-view="2" data-date-language="fr" class="form-control pull-right" name="datepicke" id="datepicke" maxlength="255" value="<?php echo date('d/m/Y'); ?>" required="">

                                </div>
                        </div>
                        <script>
                            $(function () {
                                /* Date picker */
                                $('#datepicke').datepicker({
                                    format: "dd/mm/yyyy",
                                    todayBtn: "linked",
                                    keyboardNavigation: false,
                                    forceParse: false,
                                    calendarWeeks: true,
                                    autoclose: true
                                });
                            });
                        </script>
                        <p style="color: black;">SI IMPAYE</p>
                        <div class="form-group">
                            <label for="charge">Montant charge</label>
                            <input type="text" class="form-control" name="charge" id="charge" placeholder="Entrer le montant de la charge">
                        </div>
                        <div class="form-group">
                            <label for="motif">Motif</label>
                            <input type="text" class="form-control" name="motif" id="motif" placeholder="Entrer le motif">
                        </div>
                    </div>
                    <!-- /.box-body --> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fermer</button>
                    <input class="btn btn-outline" type="submit" name="noter" value="Valider">
                </div> 
                <input type="hidden" name="idcheq" value="<?php echo $idcheq; ?>" />
                <input type="hidden" name="idcredit" value="<?php echo $idcredit; ?>" />
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?php
}