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

        if (!empty($_POST['element_1'])) {
            // On recupere les $_post du formulaire des notes
            include CHEMIN_MODELE . 'virement.inc.php';

            $id = $_SESSION['id'];

            $post = $_POST['element_1'];
            $type = nettoyer($post);

            //On determine le type de virement
            if ($type == 1) {// Dc virement national
                if(empty($_POST['datepicker']) OR !isset($_POST['datepicker'])){ //Pas de tri, afficher le cumul
                   include 'modules/virement/virecourlist.php'; 
                } else { // Tri par periode
                //on recupere la date du formulaire pour determiner le tri   
                $post = $_POST['datepicker'];
                $dat = nettoyer($post);
                //on decompose la date en mois et annee pour la base de donnee des periodes
                $daten = explode("/", $dat);
                $moisbonus = $daten[1];
                $anneebonus = $daten[2]; 
                include 'modules/virement/virecourtrilist.php';
                }
            } else { // Virement etranger
                if(empty($_POST['datepicker']) OR !isset($_POST['datepicker'])){ //Pas de tri, afficher le cumul
                   include 'modules/virement/viretrangecourlist.php'; 
                } else { // Tri par periode
                //on recupere la date du formulaire pour determiner le tri   
                $post = $_POST['datepicker'];
                $dat = nettoyer($post);
                //on decompose la date en mois et annee pour la base de donnee des periodes
                $daten = explode("/", $dat);
                $moisbonus = $daten[1];
                $anneebonus = $daten[2]; 
                include 'modules/virement/viretrangecourtrilist.php';
                }
            }
        } else {
            $erreurs_a = 'Veuillez remplir les champs obligatoires!';
            include 'modules/virement/virechoix.php';
        }
    } else {
        $erreurs[] = 'vous ne pouvez pas accéder à cette page!';
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}