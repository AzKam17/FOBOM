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

    include CHEMIN_MODELE . 'virement.inc.php';

    if (isset($_POST['an']) AND isset($_POST['mo'])) {//SI les tableau est vide dc on ne peut pas ordonner de virement
        $mois = $_POST['mo'];
        $annee = $_POST['an'];
        $listvir = liste_vire_nat_cumul_encour_mens_etrang($mois, $annee);
    } else {
        $listvir = liste_vire_nat_cumul_encour_etrang();
    }

    // On determine quel montant a payer
    if (empty($listvir)) {//SI les tableau est vide dc on ne peut pas ordonner de virement
        $erreurs_a = 'Vous ne pouvez pas effectuer cette opération ! Aucun virement possible';
        include 'modules/virement/virecourchoix.php';
    } else {
        /*         * * Alors paiement par ordre de virement ** */

        // $charg = 1000; La charge existe automatiquement lorsqu'il sagit dun virement
        $fail = 0;
        $succes = 0;
        $fails = 0;
        $success = 0;
        foreach ($listvir as $v) {
            // Mise a jour les virements en base de données en fonction du reste à payer
            if (($v['montapayer'] - $v['mtfacture']) > 0) {
                if (updatenvovireOnly($v['idpaiement'], $v['bonus_idbonus'], $_SESSION['id'], ($v['montapayer'] - $v['mtfacture']))) {
                    $succes += 1;
                } else {
                    $fail += 1;
                }
            } else {
                if (updatenvovireFull($v['idpaiement'], $v['bonus_idbonus'], $_SESSION['id'], ($v['montapayer'] - $v['mtfacture']))) {
                    $success += 1;
                } else {
                    $fails += 1;
                }
            }
        }
        $erreurs_d = $succes + $success . ' virement(s) internationaux de bonus ont été validé avec succes !';
        if ($fail !== 0 OR $fails !== 0) {
            $erreurs_b = $fail + $fails . ' virement(s) internationaux de bonus n\'ont pas pu etre validé !';
        }
        include 'modules/virement/virecourchoix.php';
    }
} else {
    $erreurs[] = 'Vous ne pouvez pas accéder à cette page!';
    include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
}

                  
