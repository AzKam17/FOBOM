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

function fbo_bonus_detail($code) {
    $auto = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
               SELECT b.idbonus,b.montapayer,b.mois,b.annee
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.fbo_code_distrib = :id AND ( b.etat = 0 OR b.etat = 2 )
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

function fbo_bonus_total($code) {
    $auto = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
               SELECT SUM(b.montapayer) as tot
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.fbo_code_distrib = :id AND ( b.etat = 0 OR b.etat = 2 )
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    if ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        return $a['tot'];
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


if (!empty($_GET['fbo'])) {
    $code = $_GET['fbo'];
    $cpte = $_GET['compte'];
    $bonus_infos = fbo_bonus_detail($code);
    $bonus_sum = fbo_bonus_total($code);
    ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Paiement d'un bonus mensuel</h4>
                <p>Vous avez décidé de payer les bonus suivants d'un total de : <strong><?php echo utf8_encode(number_format($bonus_sum, 0, ',', ' ')); ?> F CFA </p>
            </div>
            <form autocomplete="off" method="post" action="index.php?module=fbo&amp;action=payBonusAll2" target="_blank"> 
                <div class="modal-body">     
                    <!-- /.box-header -->
                    <div class="form-group">
                        <label for="element_8">Type de paiement</label>
                        <div class="">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="element_8" id="element_8" value="1" class="flat-blue1" checked>
                                    Caisse
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="element_8" id="element_8" <?php if(empty($cpte) OR !isset($cpte)){ echo 'disabled=""';} ?> value="2" class="flat-blue1">
                                    Virement
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="box-body table-responsive no-padding">
                        <h4>Détails des bonus</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <th>Montant</th>
                                <th>Mois</th>
                                <th>Année</th>
                            </tr>
                            <?php foreach ($bonus_infos as $b) { ?>

                                <tr>
                                    <td><?php echo utf8_encode($b['0']); ?></td>
                                    <td>
                                        <?php echo utf8_encode(number_format($b['1'], 0, ',', ' ')); ?>
                                    </td>
                                    <td><?php echo utf8_encode($b['2']); ?></td>
                                    <td><?php echo utf8_encode($b['3']); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <!-- /.box-body --> <hr></hr>
                    <div class="form-group">
                        <label for="charge">Charge Transfert</label>
                        <input type="text" class="form-control" name="charge" id="charge" <?php if(empty($cpte) OR !isset($cpte)){ echo 'disabled=""';} ?> placeholder="Entrer le montant du transfert">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fermer</button>
                    <input class="btn btn-outline" type="submit" name="noter" value="PAYER">
                </div>
                <input type="hidden" name="code" value="<?php echo $code; ?>" />
                <input type="hidden" name="mtbon" value="<?php echo $bonus_sum; ?>" />
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

    <!-- /.modal -->
    <?php
}