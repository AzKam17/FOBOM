<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<?php
// Definition du default timezone
date_default_timezone_set('Africa/Abidjan');

//**********************************Affichage detail dun bonus mensuel dun fbo *************************************************//

function bonus_fbo_detail($code) {
    $auto = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
               SELECT p.idpaiement, p.mtfacture, UNIX_TIMESTAMP(p.datepaie) as date_paie, p.etat, p.typepaie, p.bonus_idbonus, p.datepaie, p.charge
               FROM paiement as p JOIN bonus as b
               ON p.bonus_idbonus = b.idbonus
               WHERE p.bonus_idbonus = :id AND p.etat = 0
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_NUM)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//**********************************Affichage detail dun bonus mensuel dun fbo *************************************************//

function bonus_paie_detail($code) {
    $result = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
               SELECT SUM(p.mtfacture) as mtp, p.bonus_idbonus
               FROM paiement as p JOIN bonus as b
               ON p.bonus_idbonus = b.idbonus
               WHERE b.idbonus = :id AND p.etat = 0
               GROUP BY p.bonus_idbonus
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['mtp'];
    }
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


if (!empty($_GET['id'])) {

    $mtbonus = $_GET['mt'];
    $idbonus = $_GET['id'];
    $code = $_GET['fbo'];
    $nomfbo = $_GET['nom'];
    $mois = $_GET['moi'];
    $annee = $_GET['ann'];

    // details des transaction actuelle du bonus
    $bonus_infos = bonus_fbo_detail($idbonus);
    // Sum des paiements effectués sur le bonus
    $paie_sum = bonus_paie_detail($idbonus);
    ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Annuler le paiement d'un bonus mensuel</h4>
            </div>
            <form autocomplete="off" method="post" action="index.php?module=fbo&amp;action=annBonusMens" role="form"> 
                <div class="modal-body">     
                    <!-- /.box-header -->
                    <p>Vous avez décidé de annuler le paiment du bonus Numero : <strong><?php echo $idbonus; ?></strong> </br>
                        d'un montant actuel de : <strong><?php echo utf8_encode(number_format($mtbonus, 0, ',', ' ')); ?> F CFA</strong></strong> </p>
                    <p>Période du : <strong><?php echo $mois . '/' . $annee; ?></strong></p>
                    <hr></hr>
                    <p>FBO : <strong><?php echo $code . '  -  ' . $nomfbo; ?></strong></p>
                    <div class="box-body table-responsive no-padding">
                        <h4>Détails des transactions du bonus</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>ID Transaction</th>
                                <th>Date</th>
                                <th>Etat</th>
                                <th>Type Transction</th>
                                <th>Montant</th>
                            </tr>
                            <?php foreach ($bonus_infos as $b) { ?>
                                <tr>
                                    <td><?php echo utf8_encode($b['0']); ?></td>
                                    <td><?php echo utf8_encode(dateFr($b['2'])); ?></td>
                                    <td><?php if ($b['3'] == 0) { ?>
                                            <span class="label label-danger">En attente</span>
                                        <?php } else { ?>
                                            <span class="label label-success">Encaissé</span>            
                                        <?php } ?>
                                    </td>
                                    <td><?php if ($b['4'] == 1) { ?>
                                            <span class="label label-success">Caisse</span>
                                        <?php } elseif ($b['4'] == 2) { ?>
                                            <span class="label label-primary">Virement</span>            
                                        <?php } else { ?>
                                            <span class="label label-default">Regularisé</span>            
                                        <?php } ?>
                                    </td>
                                    <td><?php echo utf8_encode(number_format($b['1'], 0, ',', ' ')); ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4"><strong>TOTAL</strong></td>
                                <td><strong><?php echo utf8_encode(number_format($paie_sum, 0, ',', ' ')); ?> F<strong></td>
                            </tr>
                        </table>
                    </div>
                    <hr></hr>
                    <p>Si vous menez cette action, tous les paiements effectués sur ce bonus seront effacées définitivement</p>
                    <p>et le montant à payer du bonus sera remis au montant initial</p>
                    <!-- /.box-body --> 
                </div>
                <input type="hidden" name="idbon" value="<?php echo $idbonus; ?>" />
                <input type="hidden" name="mtbon" value="<?php echo $mtbonus; ?>" />
                <input type="hidden" name="code" value="<?php echo $code; ?>" />
                <input type="hidden" name="sumpaie" value="<?php echo $paie_sum; ?>" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fermer</button>
                    <input class="btn btn-outline" type="submit" name="annuler" value="ANNULER">
                </div> 
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

    <!-- /.modal -->
    <?php
}