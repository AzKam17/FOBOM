<?php

// Vérification des droits d'accès de la page
if (utilisateur_est_connecte()) {
    // On affiche la page d'erreur comme quoi l'utilisateur est déjà connecté 
    include CHEMIN_VUE_GLOBALE . 'erreur_deja_connecte.php';
} else {

    $erreurs_a = array();
    $erreurs_b = array();
    $erreurs_c = array();
    $erreurs_d = array();

    if (isset($_POST['connexion'])) {
        if (empty($_POST['login'])) {
            $erreurs_a = 'Saisissez votre Login!';
            include 'global/accueil.php';
        } elseif (empty($_POST['pass'])) {
            $erreurs_a = 'Saisissez votre Mot de Passe!';
            include 'global/accueil.php';
        } else {
            include CHEMIN_MODELE . 'connexion.inc.php';
            $login = nettoyer($_POST['login']);
            $mdp = nethash($_POST['pass']);
            // fonction de recuperation de la premiere lettre du mot de passe
            $clientid = '';
            //$tablenames = tablename($mdp);
            if ($clientid = connecteruser($login, $mdp)) {
                $suppr = verifyaccount($clientid);
                $bloq = verifierAutorisation($clientid);
                // Supprimer le compte
                if ($suppr == 0) {
                    // bloquer le compte
                    if ($bloq == 0) {
                        // on recolte et on conserve les infos sur le parent
                        $clients = infosuser($clientid);
                        // On enregistre les informations dans la variable global session
                        foreach ($clients as $c) {
                            $_SESSION['id'] = $clientid;
                            $_SESSION['nom'] = utf8_encode($c['nom']);
                            $_SESSION['prenom'] = utf8_encode($c['prenom']);
                            $_SESSION['titre'] = utf8_encode($c['titre']);
                            $_SESSION['nomcomplet'] = utf8_encode($c['nomcomplet']);
                            $_SESSION['niveau'] = $c['niveau'];
                            $_SESSION['civilite'] = $c['civilite'];
                            $_SESSION['pays'] = $c['pays_idpays'];
                            include 'modules/dashboard/dashboard.php';
                        }
                    } else {
                        $sms = 'Votre compte est <b>inactif</b> ou <b>bloqué</b>! Veuillez contacter le support. Merci !';
                        $alert = htmlentities($sms, ENT_COMPAT);
                        $erreurs_c = html_entity_decode($alert);
                        include 'global/accueil.php';
                        // Suppression des cookies de connexion automatique
                        setcookie('id', '');
                        setcookie('connexion_auto', '');
                    }
                } else {
                    $sms = 'Votre compte est <b>inexistant</b> ! Veuillez contacter le support. Merci!';
                    $alert = htmlentities($sms, ENT_COMPAT);
                    $erreurs_b = html_entity_decode($alert);
                    include 'global/accueil.php';
                    // Suppression des cookies de connexion automatique
                    setcookie('id', '');
                    setcookie('connexion_auto', '');
                }
            } else {
                $erreurs_a = 'Nom utilisateur et/ou Mot de passe inexistants !';
                include 'global/accueil.php';
                // Suppression des cookies de connexion automatique
                setcookie('id', '');
                setcookie('connexion_auto', '');
            }
        }
    }
}