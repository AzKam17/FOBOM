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

        if (!empty($_POST['element_2']) AND ! empty($_POST['element_3']) AND ! empty($_POST['element_4']) AND isset($_POST['element_5']) AND ! empty($_POST['element_6']) AND ! empty($_POST['element_7']) AND isset($_POST['element_8'])) {
            // On recupere les $_post du formulaire des notes
            include CHEMIN_MODELE . 'credit.inc.php';

            $ideta = $_SESSION['pays'];
            $id = $_SESSION['id'];

            $post = $_POST['element_2'];
            $code_distrib = nettoyer($post);
            $post = $_POST['element_3'];
            $nom_distrib = nettoyer($post);
            $post = $_POST['element_4'];
            $mtcred = nettoyer($post);
            $post = $_POST['element_5'];
            $motif = nettoyer($post);
            $post = $_POST['element_6'];
            $idcheq = nettoyer($post);
            $post = $_POST['element_7'];
            $mtcheq = nettoyer($post);
            $post = $_POST['element_8'];
            $typecheq = nettoyer($post);
            $dad1 = explode("/", $_POST['datepicker']);
            $datecred = $dad1[2] . '-' . $dad1[1] . '-' . $dad1[0];
            $dad2 = explode("/", $_POST['datepickerr']);
            $datecheq = $dad2[2] . '-' . $dad2[1] . '-' . $dad2[0];
            $dad11 = $_POST['datepicker'];
            $dad22 = $_POST['datepickerr'];

            //On save ensuite le credit et le cheque en base de donnees
            if ($idcred = ajoutcredit($code_distrib, $motif, $mtcred, $datecred, $idcheq, $mtcheq, $typecheq, $datecheq, $id)) {
                $erreurs_d = 'Le credit a été attribué avec SUCCES!';
            include CHEMIN_VUE.'ajoutchequeconfirm.php';
            } else {
                $erreurs_a = 'Erreur d\'attribution du crédit!';
            include 'modules/credit/ajoutcheque.php';
            }

        } else {
            $erreurs_a = 'Veuillez remplir les champs obligatoires!';
            include 'modules/credit/ajoutcheque.php';
        }
    } else {
        $erreurs[] = 'vous ne pouvez pas accéder à cette page!';
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}