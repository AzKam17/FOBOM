<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<?php
// Definition du default timezone
date_default_timezone_set('Africa/Abidjan');

//**********************************Affichage detail de transaction *************************************************//

function bonus_fbo_detail($code) {
    $auto = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
               SELECT p.idpaiement, p.mtfacture, UNIX_TIMESTAMP(p.datepaie) as date_paie, p.etat, p.typepaie, p.bonus_idbonus, p.datepaie, p.charge, u.civilite, u.nom, u.prenom, c.civilite as civil, c.nom as nomcaisse, c.prenom as precaisse
               FROM paiement as p JOIN utilisateur as u JOIN utilisateur as c 
               ON p.utilisateur_idutilisateur = u.idutilisateur AND p.idcaissier = c.idutilisateur
               WHERE p.bonus_idbonus = :id AND p.etat = 1
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_NUM)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//**********************************Affichage detail de transaction *************************************************//

function bonus_remb_detail($code) {
    $auto = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
               SELECT p.idremboursement, p.utilisateur_idutilisateur, UNIX_TIMESTAMP(p.daterembour) as date_paie, p.credit_idcredit, p.typepaie, p.mtrembourser, p.daterembour, u.civilite, u.nom, u.prenom
               FROM remboursement as p JOIN utilisateur as u
               ON p.utilisateur_idutilisateur = u.idutilisateur
               WHERE p.bonus_idbonus = :id
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
               WHERE b.idbonus = :id AND p.etat = 1
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

    // details des transactions actuelle du bonus
    $bonus_infos = bonus_fbo_detail($idbonus);
    // details des regularisation actuelle du bonus
    $remb_infos = bonus_remb_detail($idbonus);
    // Sum des paiements effectués sur le bonus
    $paie_sum = bonus_paie_detail($idbonus);

    $totaltransac = 0;
    $totalremb = 0;
    ?>

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Transactions effectuées sur bonus mensuel</h4>
            </div>
            <div class="modal-body">     
                <!-- /.box-header -->
                <p>Détails des transactions bonus Numero : <strong><?php echo $idbonus; ?></strong> </br>
                    d'un montant actuel de : <strong><?php echo utf8_encode(number_format($mtbonus, 0, ',', ' ')); ?> F CFA</strong></strong> </p>
                <p>Période du : <strong><?php echo $mois . '/' . $annee; ?></strong></p>
                <hr></hr>
                <p>FBO : <strong><?php echo $code . '  -  ' . $nomfbo; ?></strong></p>
                <div class="box-body table-responsive no-padding">
                    <h4>Détails des transactions du bonus</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Etat</th>
                            <th>Type Transac</th>
                            <th>Ordonné par</th>
                            <th>Caissier(e)</th>
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
                                <td><?php echo utf8_encode($b['8'] . ' ' . $b['9'] . ' ' . $b['10']); ?></td>
                                <td><?php echo utf8_encode($b['11'] . ' ' . $b['12'] . ' ' . $b['13']); ?></td>
                                <td><?php echo utf8_encode(number_format($b['1'], 0, ',', ' ')); ?></td>
                            </tr>
                            <?php
                            $totaltransac += $b['1'];
                        }
                        ?>
                        <?php foreach ($remb_infos as $r) { ?>
                            <tr>
                                <td><?php echo utf8_encode($r['0']); ?></td>
                                <td><?php echo utf8_encode(dateFr($r['2'])); ?></td>
                                <td><span class="label label-success">Rembourser</span></td>
                                <td><?php if ($r['4'] == 1) { ?>
                                        <span class="label label-success">Espèce</span>
                                    <?php } else { ?>
                                        <span class="label label-primary">Regularisé</span>            
                                    <?php } ?>
                                </td>
                                <td><?php echo utf8_encode($r['7'] . ' ' . $r['8'] . ' ' . $r['9']); ?></td>
                                <td><?php echo ''; ?></td>
                                <td><?php echo utf8_encode(number_format($r['5'], 0, ',', ' ')); ?></td>
                            </tr>
                            <?php
                            $totalremb += $r['5'];
                        }
                        ?>
                        <tr>
                            <td colspan="6"><strong>TOTAL</strong></td>
                            <td><strong><?php echo utf8_encode(number_format(($totaltransac + $totalremb), 0, ',', ' ')); ?> F<strong></td>
                                        </tr>
                                        </table>
                                        </div>
                                        <!-- /.box-body --> 
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Fermer</button>

                                        </div> 
                                        </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->

                                        <!-- /.modal -->
                                        <?php
                                    }