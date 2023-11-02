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

    if (($_SESSION['niveau'] == 1) OR ($_SESSION['niveau'] == 2)) {
        // get the HTML
        if (isset($_GET['id']) OR ! empty($_GET['id'])) {
            $idpaie = $_GET['id'];
        }
        include CHEMIN_MODELE . 'caisse.inc.php';
        // On marque le paiement vue
        upadatepaievue($idpaie);
        //On affecte les details du paiement 
        $client_infos = bonus_paie_valid($idpaie);
        //On parcours le detail des fbo
        foreach ($client_infos as $n) {
            $paie = utf8_encode($n['idpaiement']);
            $bonus = utf8_encode($n['bonus_idbonus']);
            $periode = utf8_encode($n['periode']);
            $etatbon = utf8_encode($n['etat']);
            $typencaisse = utf8_encode($n['typencaisse']);
            $mtbonus = utf8_encode($n['montapayer']);
            $nom = utf8_encode($n['nom_complet']);
            $code = utf8_encode($n['code_distrib']);
            $operateur = utf8_encode($n['operateur']);
            $titre = utf8_encode($n['titre']);
            $datordonne = utf8_encode($n['datpaie']);
            $mtpaie = utf8_encode($n['mtfacture']);
            $caisse = utf8_encode($n['typepaie']);
            $etatpaie = utf8_encode($n['eta']);

            //dossier photo enseignant
            $nomImage1 = $n['code_distrib'] . '.jpg';
            $fichier1 = DOSSIER . $nomImage1;
            $nomImage2 = $n['code_distrib'] . '.png';
            $fichier2 = DOSSIER . $nomImage2;
            $nomImage3 = $n['code_distrib'] . '.jpeg';
            $fichier3 = DOSSIER . $nomImage3;
            //On inclus la vue 
            include CHEMIN_VUE . 'detail_paie_valid_vue.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>