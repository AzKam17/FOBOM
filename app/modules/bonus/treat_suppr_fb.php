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

        $idfb = $_POST['code'];

        include CHEMIN_MODELE . 'bonus.inc.php';
        //On efface les fbo
        if (delFich($idfb)) {
            //On inclus la vue 
            $erreurs_d = 'Le fichier bonus a été supprimé avec succes';
            include 'modules/bonus/bonufichier.php';
        } else {
            $erreurs_a = 'Erreur lors de la suppression du fichier';
            include 'modules/fbo/bonufichier.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>