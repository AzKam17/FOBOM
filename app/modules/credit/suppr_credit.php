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
        if (! empty($_GET['id']) and ! empty($_GET['mt'])) {
            $code = $_GET['id'];
            $mont = $_GET['mt'];
            $dat11 = $_GET['datcred'];
            $idfbo = $_GET['fbo'];
            $nom = $_GET['nomfbo'];
            //On inclus la vue 
            include CHEMIN_VUE . 'delete_cred_vue.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>