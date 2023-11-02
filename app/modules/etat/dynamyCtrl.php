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
        include CHEMIN_MODELE . 'credit.inc.php';

        $ideta = $_SESSION['pays'];
        $id = $_SESSION['id'];

        $post = $_POST['element_1'];
        $type = nettoyer($post);
        $post = $_POST['element_2'];
        $typeremb = nettoyer($post);

        if (empty($_POST['periode']) OR ! isset($_POST['periode'])) { //Pas de tri, afficher le cumul
            $post = $_POST['periode'];
            $dat = nettoyer($post);
            
            $dapdep = 'ND';
            $dapfin = 'ND';
        } else { // Tri par periode
            //on recupere la date du formulaire pour determiner le tri   
            $post = $_POST['periode'];
            $dat = nettoyer($post);
            //On extrait tt dabord les deux dates
            $dap = explode("-", $dat);
            $dapdep = $dap[0];
            $dapfin = $dap[1];
            //on decompose la date en mois et annee pour la base de donnee des periodes
            $datebondep = explode("/", $dapdep);
            $anneecredep = $datebondep[2].'-'.$datebondep[1].'-'.$datebondep[0];

            $datebonfin = explode("/", $dapfin);
            $anneecredfin = $datebonfin[2].'-'.$datebonfin[1].'-'.$datebonfin[0];
        }
        include 'modules/etat/dynamyc.php';
        //} else {
        //$erreurs_a = 'Veuillez remplir les champs obligatoires!';
        //include 'modules/etat/choix.php';
        //}
    } else {
        $erreurs[] = 'vous ne pouvez pas accéder à cette page!';
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}