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
        if (isset($_GET['id']) OR ! empty($_GET['id'])) {
            $idfbo = $_GET['id'];
        } 
        include CHEMIN_MODELE . 'info.inc.php';
        $client_infos = admin_detail($idfbo);
        //On parcours le detail des fbo
        foreach ($client_infos as $n) {
            $code = utf8_encode($n['idutilisateur']);
            $titre = utf8_encode($n['titre']);
            $nom = utf8_encode($n['nom']);
            $prenom = utf8_encode($n['prenom']);
            //On inclus la vue 
            include CHEMIN_VUE . 'delete_admin_vue.php';
        }
    } else {
        $erreurs[] = "Accès Refusé.";
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}
?>