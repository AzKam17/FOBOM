<?php

/*
 * Projet School Alerte
 * Designer et Entierement programmÃ© par Mr. Say-Halatte AYOLIE
 * Webmaster, Expert en developpement web et mobile
 * @HAXIS Cote d'Ivoire  * 
 */

$erreurs_a = array();
$erreurs_b = array();
$erreurs_c = array();
$erreurs_d = array();
$erreurs = array();

if ($_SESSION['niveau'] == 1) {
    // On recupere les $_post du formulaire des notes

    include CHEMIN_MODELE . 'paiement.inc.php';

    $codeDistrib = $_POST['code'];
    $idbonus = $_POST['idbon'];
    $mtbonus = $_POST['mtbon'];
    $mtpaie = $_POST['sumpaie'];


    // On verifie dabord l'etat du bonus
    $etat_bonus = fbo_bonus_etat($codeDistrib, $idbonus);
    if ($etat_bonus == 3) { // Si le bonus est en cours de paiment alors loperation est dirigé vers un autre processus
        if(deltransapaiecour($idbonus)){
           $erreurs_d = 'Les transactions  en attente du bonus ont été annulés avec succes';
        include 'modules/fbo/info_fbo.php'; 
        } else {
            $erreurs_a = 'Erreur lors de l\'annulation des transactions en attente du bonus';
        include 'modules/fbo/info_fbo.php';
        }
    } else {
        if(deltransapaie($idbonus, ($mtbonus + $mtpaie))){
           $erreurs_d = 'Les transactions du bonus ont été annulés avec succes';
        include 'modules/fbo/info_fbo.php'; 
        } else {
            $erreurs_a = 'Erreur lors de l\'annulation des transactions du bonus';
        include 'modules/fbo/info_fbo.php';
        }
    }
} else {
    $erreurs[] = 'Vous ne pouvez pas accéder à cette page!';
    include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
}

                  
