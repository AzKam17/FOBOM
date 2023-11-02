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

        if (!empty($_POST['datepicke']) AND ! empty($_POST['idcheq'])) {
            // On recupere les $_post du formulaire des notes
            include CHEMIN_MODELE . 'credit.inc.php';

            $code = $_SESSION['pays'];

            $post = $_POST['idcheq'];
            $idcheq = nettoyer($post);
            $post = $_POST['idcredit'];
            $idcredit = nettoyer($post);
            $post = $_POST['charge'];
            $mtcharge = nettoyer($post);
            $post = $_POST['motif'];
            $motif = nettoyer($post);

            $dad1 = explode("/", $_POST['datepicke']);
            $dateretour = $dad1[2] . '-' . $dad1[1] . '-' . $dad1[0];

            //On verifie si cest un retour impayé ou non
            if (empty($_POST['charge']) AND empty($_POST['motif'])) {//Le cheque est payé
               if (retourcheq($idcheq, $dateretour, $idcredit)) {

                    $erreurs_d = 'Le chèque a été payé avec SUCCES et le crédit a été soldé!';

                    $cheque_listes = cheque_liste($code);
                    $cheque_liste_encaisses = cheque_liste_encaisse($code);
                    $cheque_liste_impayes = cheque_liste_impaye($code);
                    $cheque_liste_depots = cheque_liste_depot($code);

                    //On inclus la vue 
                    include CHEMIN_VUE . 'suivit_cheque_vue.php';
                } else {
                    $erreurs_a = 'Erreur attribution du crédit!';
                    include 'modules/credit/suivicheque.php';
                }   
                
            } else { // Le cheque est impayé
              if (retourcheqimpaye($idcheq, $idcredit, $dateretour, $motif, $mtcharge + mtactuelcredit($idcredit))) {

                    $erreurs_b = 'Le chèque a été remis dans le portefeuil IMPAYE!';
                    $erreurs_d = 'Les charges impayés ont été ajouté au crédit!';

                    $cheque_listes = cheque_liste($code);
                    $cheque_liste_encaisses = cheque_liste_encaisse($code);
                    $cheque_liste_impayes = cheque_liste_impaye($code);
                    $cheque_liste_depots = cheque_liste_depot($code);

                    //On inclus la vue 
                    include CHEMIN_VUE . 'suivit_cheque_vue.php';
                } else {
                    $erreurs_a = 'Erreur attribution du crédit!';
                    include 'modules/credit/suivicheque.php';
                }  
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