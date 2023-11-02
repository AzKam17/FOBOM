<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : Ing AYOLIE Say-halatte Stivell and KAM Corporate
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

// Constantes
$erreurs_a = array();
$erreurs_b = array();
$erreurs_d = array();
$erreurs = array();

if (!utilisateur_est_connecte()) {
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';
} else {
    if ($_SESSION['niveau'] == 1) {
        include CHEMIN_MODELE . 'credit.inc.php';

        $user = $_SESSION['id'];
        $idcredit = $_POST['idcred'];
        $mtremb = $_POST['charge'];
        $mtcredit = mtactuelcredit($idcredit);
        $reste = $mtcredit - $mtremb;

        if ($reste < 0) {// On rejette pour cause de mt saisi superieur au credit actuel
            $erreurs_a = 'Le montant saisit est superieur au crédit actuel';
            include 'modules/credit/listecredit.php';
        } elseif ($reste == 0) {// Le credit est soldé par remboursement
            if (rembcred($idcredit, $mtremb, $reste, $user)) {// On rejette pour cause de mt saisi superieur au credit actuel
                $erreurs_d = 'Le credit a été remboursé avec succes';
                include 'modules/credit/listecredit.php';
            } else {
                $erreurs_a = 'Erreur lors du remboursement';
                include 'modules/credit/listecredit.php';
            }
        } else {//Le credit est remboursé de manière partièle
            if (rembcredpar($idcredit, $mtremb, $reste, $user)) {// On rejette pour cause de mt saisi superieur au credit actuel
                $erreurs_d = 'Le credit a été remboursé partiellement avec succes';
                include 'modules/credit/listecredit.php';
            } else {
                $erreurs_a = 'Erreur lors du remboursement';
                include 'modules/credit/listecredit.php';
            }
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
