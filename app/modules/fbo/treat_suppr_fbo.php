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


    $erreurs_a = array();
    $erreurs_d = array();
    $erreurs = array();

    if (($_SESSION['niveau'] == 1)) {
        // get the HTML

        $idfbo = $_POST['code'];

        include CHEMIN_MODELE . 'fbo.inc.php';
        //On efface les fbo
        if (delFbo($idfbo)) {
            //On inclus la vue 
            $erreurs_d = 'Le fbo a été supprimé avec succes';
            include 'modules/fbo/fbolist.php';
        } else {
            $erreurs_a = 'Erreur lors de la suppression du fbo';
            include 'modules/fbo/fbolist.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>