<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

//global $erreurs, $erreurs_a, $erreurs_b, $erreurs_c, $erreurs_d;

$erreurs = array();
$erreurs_a = array();
$erreurs_b = array();
$erreurs_c = array();
$erreurs_d = array();

if (!utilisateur_est_connecte()) {
    // On affiche la page d'erreur comme quoi l'utilisateur doit être connecté pour voir la page
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';
} else {
    if ($_SESSION['niveau'] == 1) {
        // On recupere les $_post du formulaire des notes
        include CHEMIN_MODELE . 'credit.inc.php';

        $ideta = $_SESSION['pays'];
        $id = $_SESSION['id'];

        $code = $_GET['id'];

        $credit_info = fbo_credit_detail($code);

        $cheque_info = credit_cheque_detail($code);

        foreach ($credit_info as $v) {

            $idcred = $v['idcredit'];
            $code_distrib = $v['fbo_code_distrib'];
            $nom_distrib = $v['nom_complet'];
            $mtcred = $v['mtcredit'];
            $motif = $v['libelle'];
            $dad11 = $v['datcred'];

            include CHEMIN_VUE . 'detailcredit.php';
        }
    } else {
        $erreurs[] = 'vous ne pouvez pas accéder à cette page!';
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}