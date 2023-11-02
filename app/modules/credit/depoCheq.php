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

        if (!empty($_POST['datepickerrr']) AND ! empty($_POST['idcheq'])) {
            // On recupere les $_post du formulaire des notes
            include CHEMIN_MODELE . 'credit.inc.php';

            $code = $_SESSION['pays'];

            $post = $_POST['idcheq'];
            $idcheq = nettoyer($post);

            $dad1 = explode("/", $_POST['datepickerrr']);
            $datedepot = $dad1[2] . '-' . $dad1[1] . '-' . $dad1[0];

            //On save ensuite le credit et le cheque en base de donnees
            if (depotcheque($idcheq, $datedepot)) {
                
                $erreurs_d = 'Le chèque a été deposé avec SUCCES!';

                $cheque_listes = cheque_liste($code);
                $cheque_liste_encaisses = cheque_liste_encaisse($code);
                $cheque_liste_impayes = cheque_liste_impaye($code);
                $cheque_liste_depots = cheque_liste_depot($code);

                //On inclus la vue 
                include CHEMIN_VUE . 'suivit_cheque_vue.php';
            } else {
                $erreurs_a = 'Erreur d\'attribution du crédit!';
                include 'modules/credit/suivicheque.php';
            }
        } else {
            $erreurs_a = 'Veuillez remplir les champs obligatoires!';
            include 'modules/credit/suivicheque.php';
        }
    } else {
        $erreurs[] = 'vous ne pouvez pas accéder à cette page!';
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}