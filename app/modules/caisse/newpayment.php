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
    if ($_SESSION['niveau'] == 2) {

        if (!empty($_POST['charge']) OR isset($_POST['charge'])) { // On verifie que le numero du boredereau est saisi
            if ($_POST['charge'] == $_POST['idpaie']) { //Si le numero du bordereau est concordant, on autorise le paiement
                // On recupere les $_post du formulaire des notes
                include CHEMIN_MODELE . 'paiement.inc.php';

                $user = $_SESSION['id'];

                $post = $_POST['idpaie'];
                $idpaie = nettoye($post);
                $post = $_POST['idbonus'];
                $idbonus = nettoye($post);
                $post = $_POST['charge'];
                $recu = nettoye($post);
                $post = $_POST['mtbonus'];
                $mtbonus = nettoye($post);
                $post = $_POST['mtfacture'];
                $mtfacture = nettoye($post);
                //On soustrait le montant de la facture du montant du bonus
                $reste = $mtbonus - $mtfacture;

                if ($reste > 0) {//Paiement partiel du bonus
                    //On save ensuite les changement en base de donnees
                    if (updatenvopaieOnly($idpaie, $idbonus, $user, $recu, $reste)) {
                        $erreurs_d = 'Le paiement a été enregistré avec SUCCES!';
                        include 'modules/caisse/paielist.php';
                    } else {
                        $erreurs_a = 'Erreur validation du paiement!';
                        include 'modules/caisse/paielist.php';
                    }
                } else {//Paiement soldé du bonus
                    //On save ensuite les changement en base de donnees
                    if (updatenvopaieFull($idpaie, $idbonus, $user, $recu, $reste)) {
                        $erreurs_d = 'Le paiement a été enregistré avec SUCCES!';
                        include 'modules/caisse/paielist.php';
                    } else {
                        $erreurs_a = 'Erreur validation du paiement!';
                        include 'modules/caisse/paielist.php';
                    }
                }
            } else { // Sinon on stop le paiement pour erreur de validation
                $erreurs_a = 'Le paiement est refusé ! Veuillez saisir le correct numero du bordereau.';
                include 'modules/caisse/paielist.php';
            }
        } else {
            $erreurs_a = 'Veuillez remplir les champs obligatoires!';
            include 'modules/caisse/paielist.php';
        }
    } else {
        $erreurs[] = 'vous ne pouvez pas accéder à cette page!';
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}