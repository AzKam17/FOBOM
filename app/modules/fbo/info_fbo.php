<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

if (!utilisateur_est_connecte()) {
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';
} else {

    // Constantes
    // define('EXTENSION', 'jpg');
    define('DOSSIER', 'img/fbo/');
    $erreurs = array();

    if (($_SESSION['niveau'] == 1)) {
        // get the HTML
        if (isset($_GET['id']) OR ! empty($_GET['id'])) {
            $idfbo = $_GET['id'];
        } else {
            $idfbo = $codeDistrib;
        }
        include CHEMIN_MODELE . 'fbo.inc.php';
        $client_infos = fbo_detail($idfbo);
        //On parcours le detail des fbo
        foreach ($client_infos as $n) {
            $code = utf8_encode($n['code_distrib']);
            $nom = utf8_encode($n['nom_complet']);
            $lieu = utf8_encode($n['nompays']);
            $banque = utf8_encode($n['compte_banque']);
            $swift = utf8_encode($n['swift_code']);
            $statut = utf8_encode($n['statut_fbo']);
            $mobile = utf8_encode($n['mobile']);
            $email = utf8_encode($n['email']);
            $ville = utf8_encode($n['ville']);
            $commune = utf8_encode($n['commune']);
            $quartier = utf8_encode($n['quartier']);
            $addresse = utf8_encode($n['addresse']);
            $nationalite = utf8_encode($n['nationalite']);

            //dossier photo fbo
            $nomImage1 = $n['code_distrib'] . '.jpg';
            $fichier1 = DOSSIER . $nomImage1;
            $nomImage2 = $n['code_distrib'] . '.png';
            $fichier2 = DOSSIER . $nomImage2;
            $nomImage3 = $n['code_distrib'] . '.jpeg';
            $fichier3 = DOSSIER . $nomImage3;
            //On determine le cumul annuel des bonus
            $bon = totalbonus($code);
            //On parcours le detail des bonus du fbo
            $bonus_infos = fbo_bonus_detail($code);
            //On determine le cumul annuel des credit
            $cred = totalcredit($code);
            //On parcours le detail des credits du fbo
            $credit_infos = fbo_credit_detail($code);
            //On determeine la balance , on soustrait les credits des bonus
            $balc = $bon - $cred;
            //On inclus la vue 
            include CHEMIN_VUE . 'detail_fbo_vue.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>