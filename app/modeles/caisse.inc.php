<?php

/* 
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

//**********************************Fonction daffichage des bonus en attente de paiement a la caisse *************************************************//

function bonus_paie_detail() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT p.idpaiement, p.bonus_idbonus, CONCAT(b.mois,'-',b.annee) as periode, b.montapayer, f.nom_complet, f.code_distrib, p.utilisateur_idutilisateur, CONCAT(u.civilite,' ',u.nom,' ',prenom) as operateur, u.titre, p.datepaie, DATE_FORMAT(p.datepaie,'%d/%m/%Y à %Hh%m') as datpaie, p.etat, p.mtfacture, p.charge, p.typepaie, p.idcaissier
               FROM paiement as p JOIN bonus as b JOIN utilisateur as u JOIN fbo as f
               ON p.bonus_idbonus = b.idbonus AND p.utilisateur_idutilisateur = u.idutilisateur AND b.fbo_code_distrib = f.code_distrib
               WHERE p.etat = 0 AND p.typepaie = 1 AND b.etat = 3
               ORDER BY p.datepaie DESC
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//Nombre total de paiement a la caisse en attente
function total_bonus_paie_detail() {
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

//**********************************Fonction daffichage des details dun paiement a la caisse *************************************************//

function bonus_paie($idpaie) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
            SELECT p.idpaiement, p.etat as eta, p.bonus_idbonus, b.etat, b.typencaisse, CONCAT(b.mois,'-',b.annee) as periode, b.montapayer, f.nom_complet, f.code_distrib, f.statut_fbo, f.mobile, f.email, f.ville, f.commune, f.quartier, f.addresse, f.nationalite, p.utilisateur_idutilisateur, CONCAT(u.civilite,' ',u.nom,' ',prenom) as operateur, u.titre, p.datepaie, DATE_FORMAT(p.datepaie,'%d/%m/%Y à %Hh%m') as datpaie, p.mtfacture, p.charge, p.typepaie
            FROM paiement as p JOIN bonus as b JOIN utilisateur as u JOIN fbo as f
            ON p.bonus_idbonus = b.idbonus AND p.utilisateur_idutilisateur = u.idutilisateur AND b.fbo_code_distrib = f.code_distrib
            WHERE p.idpaiement = :id AND p.etat = 0 AND p.typepaie = 1 AND b.etat = 3
						");
    $requete->bindValue(':id', $idpaie);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function bonus_paie_fbo($idpaie) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
            SELECT f.nom_complet, f.code_distrib, f.statut_fbo, f.mobile, f.email, f.ville, f.commune, f.quartier, f.addresse, f.nationalite
            FROM fbo as f
            WHERE f.code_distrib = :id
						");
    $requete->bindValue(':id', $idpaie);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//Somme des bonus en etat d'etre paié dun fbo
function bonus_total($code) {
    $auto = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
               SELECT SUM(b.montapayer) as tot
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.fbo_code_distrib = :id AND ( b.etat = 0 OR b.etat = 2 )
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    if ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        return $a['tot'];
    }
    
    return false;
}

//**********************************Fonction daffichage des details dun paiement executé *************************************************//

function bonus_paie_valid($idpaie) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
            SELECT p.idpaiement, p.etat as eta, p.bonus_idbonus, b.etat, b.typencaisse, CONCAT(b.mois,'-',b.annee) as periode, b.montapayer, f.nom_complet, f.code_distrib, p.utilisateur_idutilisateur, CONCAT(u.civilite,' ',u.nom,' ',prenom) as operateur, u.titre, p.datepaie, DATE_FORMAT(p.datepaie,'%d/%m/%Y à %Hh%m') as datpaie, p.mtfacture, p.charge, p.typepaie
            FROM paiement as p JOIN bonus as b JOIN utilisateur as u JOIN fbo as f
            ON p.bonus_idbonus = b.idbonus AND p.utilisateur_idutilisateur = u.idutilisateur AND b.fbo_code_distrib = f.code_distrib
            WHERE p.idpaiement = :id AND p.etat = 1 AND p.typepaie = 1 AND (b.etat = 2 OR b.etat = 1)
						");
    $requete->bindValue(':id', $idpaie);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/******************* Fonction de vue dun nouveau paiment validé ***************************/

function upadatepaievue($idpaie) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				UPDATE paiement SET 
				vue            = 1
				WHERE idpaiement  = :code
                                                                 ");
    $requete->bindValue(':code', $idpaie);
    if ($requete->execute()) {
        $reponse = 1;
    } else {
        $reponse = 0;
    }
    return $reponse;
}