<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<?php
// Definition du default timezone
date_default_timezone_set('Africa/Abidjan');

//**********************************Affichage detail des bonus annuel dun fbo *************************************************//

function fbo_bonus_detail($code) {
    $auto = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
               SELECT b.idbonus,b.montapayer,b.mois,b.annee
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.fbo_code_distrib = :id AND ( b.etat = 0 OR b.etat = 2 )
               ORDER BY  b.mois ASC, b.annee ASC
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_NUM)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

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


if (!empty($_GET['id']) AND ! empty($_GET['fbo'])) {

    $mtcredit = $_GET['mt'];
    $idcredit = $_GET['id'];
    $code = $_GET['fbo'];

    $bonus_infos = fbo_bonus_detail($code);
    ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Régulariser un crédit</h4>
                <p>Vous avez décidé de régulariser le crédit Numero : <strong><?php echo $idcredit; ?></strong>&nbsp;&nbsp; d'un montant de : <strong><?php echo utf8_encode(number_format($mtcredit, 0, ',', ' ')); ?> F CFA</strong></strong> </p>
            </div>
            <form autocomplete="off" method="post" action="index.php?module=fbo&amp;action=regManuFbo"> 
                <div class="modal-body">     
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <h4>Liste des bonus</h4>
                        <table class="table table-bordered">
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
                    <!-- /.box-body --> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fermer</button>
                    <input class="btn btn-outline" type="submit" name="noter" value="Regulariser">
                </div> 
                <input type="hidden" name="idcred" value="<?php echo $idcredit; ?>" />
                <input type="hidden" name="mtcred" value="<?php echo $mtcredit; ?>" />
                <input type="hidden" name="code" value="<?php echo $code; ?>" />
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

    <!-- /.modal -->
    <script type="text/javascript">
        function lookup_id_ele(eleid) {
            if ($('#idele' + eleid).val() !== "") { // si le champs note input isset
                $('#idTriele' + eleid).val(eleid); // et on remplit le tableau des idele dynamiquement 
            } else {
                $('#idTriele' + eleid).val('');
            }
        }
    </script>
    <?php
}