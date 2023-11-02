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
    $mois = $_POST['mo'];
    $annee = $_POST['an'];

    include CHEMIN_MODELE . 'virement.inc.php';

    $listvir = liste_vire_etrang_mens($mois, $annee);

    if (empty($listvir)) {//SI les tableau est vide dc on ne peut pas ordonner de virement
        $erreurs_a = 'Vous ne pouvez pas effectuer cette opération ! Aucun virement possible';
        include 'modules/virement/virechoix.php';
    } else {
        /*** Alors paiement par ordre de virement ***/

        $charg = $_POST['charge']; // La charge existe automatiquement lorsqu'il sagit dun virement
        $fail = 0;
        $succes = 0;
        foreach ($listvir as $v) {
            // On ajoute les virements en base de données 
            if (ajoutnvovirementmasse($v['idbonus'], $_SESSION['id'], $v['montapayer'], $charg)) {
                $succes += 1;
            } else {
                $fail += 1;
            }
        }
        $erreurs_d = $succes.' virement(s) internationaux de bonus ordornné avec succes pour la période du '.$mois.'/'.$annee;
        if($fail !== 0){
        $erreurs_b = $fail.' virement(s) internationaux de bonus n\'ont pas pu etre ordornné pour la période du '.$mois.'/'.$annee;
        }
        include 'modules/virement/virechoix.php';
    }
} else {
    $erreurs[] = 'Vous ne pouvez pas accéder à cette page!';
    include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
}

                  
