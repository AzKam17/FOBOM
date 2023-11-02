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
    $erreurs_a = array();
    $erreurs_b = array();
    $erreurs_d = array();
    $erreurs = array();

    if (($_SESSION['niveau'] == 1)) {
        // get the HTML
        if (!empty($_GET['id']) OR ! empty($_GET['fbo'])) {

            include CHEMIN_MODELE . 'credit.inc.php';

            $mtcredit = $_GET['mt'];
            $idcredit = $_GET['id'];
            $code = $_GET['fbo'];

            $bonus_infos = fbo_bonus_detail($code);
            include CHEMIN_VUE . 'detail_reg_vue.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
