<?php

/* 
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

// Les 5 plus recents
function bonus_paie_notifiction() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT p.idpaiement, p.bonus_idbonus, p.utilisateur_idutilisateur, p.datepaie, p.etat, p.mtfacture, p.charge, p.typepaie, p.idcaissier
               FROM paiement as p JOIN bonus as b JOIN utilisateur as u
               ON p.bonus_idbonus = b.idbonus AND p.utilisateur_idutilisateur = u.idutilisateur
               WHERE p.etat = 0 AND p.typepaie = 1 AND b.etat = 3
               ORDER BY p.datepaie DESC
               LIMIT 5
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//Nombre total de paiement a la caisse en attente
function total_bonus_paie_notif() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT p.idpaiement, p.bonus_idbonus, p.utilisateur_idutilisateur, p.datepaie, p.etat, p.mtfacture, p.charge, p.typepaie, p.idcaissier
               FROM paiement as p JOIN bonus as b JOIN utilisateur as u
               ON p.bonus_idbonus = b.idbonus AND p.utilisateur_idutilisateur = u.idutilisateur
               WHERE p.etat = 0 AND p.typepaie = 1 AND b.etat = 3
               ORDER BY p.datepaie DESC
		");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

// Les 5 plus recents
function bonus_encaisse_notifiction() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT p.idpaiement, p.bonus_idbonus, p.utilisateur_idutilisateur, p.datepaie, p.etat, p.mtfacture, p.charge, p.typepaie, p.idcaissier
               FROM paiement as p JOIN bonus as b JOIN utilisateur as u
               ON p.bonus_idbonus = b.idbonus AND p.utilisateur_idutilisateur = u.idutilisateur
               WHERE p.etat = 1 AND p.typepaie = 1 AND p.vue = 0 AND (b.etat = 2 OR b.etat = 1)
               ORDER BY p.datepaie DESC
               LIMIT 5
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//Nombre total de paiement a la caisse en attente
function total_bonus_encaisse_notif() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT p.idpaiement, p.bonus_idbonus, p.utilisateur_idutilisateur, p.datepaie, p.etat, p.mtfacture, p.charge, p.typepaie, p.idcaissier
               FROM paiement as p JOIN bonus as b JOIN utilisateur as u
               ON p.bonus_idbonus = b.idbonus AND p.utilisateur_idutilisateur = u.idutilisateur
               WHERE p.etat = 1 AND p.typepaie = 1 AND p.vue = 0 AND (b.etat = 2 OR b.etat = 1)
               ORDER BY p.datepaie DESC
		");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}