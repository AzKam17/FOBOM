<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

if (!utilisateur_est_connecte()) {
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';
} else {

    // Constantes
    // define('EXTENSION', 'jpg');
    //define('DOSSIER', 'img/fbo/');
    $erreurs = array();

    if (($_SESSION['niveau'] == 1)) {
        
        
        include CHEMIN_MODELE . 'credit.inc.php';
        
        $code = $_SESSION['pays'];
        
        $cheque_listes = cheque_liste($code);
        $cheque_liste_encaisses = cheque_liste_encaisse($code);
        $cheque_liste_impayes = cheque_liste_impaye($code);
        $cheque_liste_depots = cheque_liste_depot($code);
        
            //On inclus la vue 
            include CHEMIN_VUE . 'suivit_cheque_vue.php';
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>