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

    $erreurs = array();

    if (($_SESSION['niveau'] == 1)) {
        // get the HTML
        if (isset($_GET['idfich']) OR ! empty($_GET['idfich'])) {
            $id = $_GET['idfich'];
        } 
        include CHEMIN_MODELE . 'bonus.inc.php';
        $client_infos = fichier_detail($id);
        //On parcours le detail des fbo
        foreach ($client_infos as $n) {
            $code = utf8_encode($n['idfichier_bonus']);
            $nom = utf8_encode($n['nomfichier']);
            $mois = utf8_encode($n['mois']);
            $annee = utf8_encode($n['annee']);
            //On inclus la vue 
            include CHEMIN_VUE . 'delete_fichier_vue.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>