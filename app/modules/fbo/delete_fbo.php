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
            $statut = utf8_encode($n['statut_fbo']);
            //On inclus la vue 
            include CHEMIN_VUE . 'delete_fbo_vue.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>