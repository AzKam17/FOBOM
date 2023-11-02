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

        //if (!isset($_POST['element_1'])) {
        // On recupere les $_post du formulaire des notes
        include CHEMIN_MODELE . 'virement.inc.php';

        $ideta = $_SESSION['pays'];
        $id = $_SESSION['id'];

        $post = $_POST['element_1'];
        $type = nettoyer($post);
        $post = $_POST['element_2'];
        $typepaie = nettoyer($post);
        $post = $_POST['element_3'];
        $typevire = nettoyer($post);

        //echo 'Date periode = '.$_POST['periode'];
        //echo 'Date paiement = '.$_POST['paiement'];

        if ((empty($_POST['periode']) OR ! isset($_POST['periode'])) AND ( empty($_POST['paiement']) OR ! isset($_POST['paiement']))) { //Erreur, ne pas remplir les deux champs de date à la fois
            $erreurs_a = 'Veuillez saisir au moins un critère de date';
            include 'modules/etat/choix.php';
        } elseif ((!empty($_POST['periode']) OR isset($_POST['periode'])) AND ( empty($_POST['paiement']) OR ! isset($_POST['paiement']))) { // Tri par periode de bonus
            //on recupere la date du formulaire pour determiner le tri   
            $post = $_POST['periode'];
            $dat = nettoyer($post);
            //On extrait tt dabord les deux dates
            $dap = explode("-", $dat);
            $dapdep = $dap[0];
            $dapfin = $dap[1];
            //on decompose la date en mois et annee pour la base de donnee des periodes
            $datebondep = explode("/", $dapdep);
            $moisbonusdep = $datebondep[1];
            $anneebonusdep = $datebondep[2];

            $datebonfin = explode("/", $dapfin);
            $moisbonusfin = $datebonfin[1];
            $anneebonusfin = $datebonfin[2];
            include 'modules/etat/dynamic.php';
            
        } elseif ((empty($_POST['periode']) OR ! isset($_POST['periode'])) AND ( !empty($_POST['paiement']) OR isset($_POST['paiement']))) { // Tri par date de paiement... Les fils de p...
            //on recupere la date du formulaire pour determiner le tri   
            $post = $_POST['paiement'];
            $dat = nettoyer($post);
            //On extrait tt dabord les deux dates
            $dap = explode("-", $dat);
            $dapdep = $dap[0];
            $dapfin = $dap[1];
            //on decompose la date en mois et annee pour la base de donnee des periodes
            $datebondep = explode("/", $dapdep);
            $anneebonusdep = $datebondep[2].'-'.$datebondep[1].'-'.$datebondep[0];
            //$anneebonusdep = $datebondep[2];

            $datebonfin = explode("/", $dapfin);
            $anneebonusfin = $datebonfin[2].'-'.$datebonfin[1].'-'.$datebonfin[0];
            //$anneebonusfin = $datebonfin[2];
            include 'modules/etat/dynamicx.php';
        }
    } else {
        $erreurs[] = 'vous ne pouvez pas accéder à cette page!';
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}