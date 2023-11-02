<?php

/* 
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */


//**********************************Affichage detail dun fbo *************************************************//

function fbo_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT f.code_distrib,f.pays_idpays,p.nompays,f.nom_complet,f.compte_banque,f.swift_code,f.statut_fbo,f.mobile,f.email,f.ville,f.commune,f.quartier,f.addresse,f.nationalite
               FROM fbo as f JOIN pays as p
               ON f.pays_idpays = p.idpays
               WHERE f.code_distrib = :id
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//**********************************Affichage detail des bonus annuel dun fbo *************************************************//

function fbo_bonus_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.idbonus,b.fbo_code_distrib,b.montapayer,b.mois,b.annee,b.etat,b.typencaisse,f.nom_complet,f.compte_banque,f.nationalite
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.fbo_code_distrib = :id
               ORDER BY  b.mois ASC, b.annee ASC
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}


//**********************************Affichage detail des bonus annuel dun fbo *************************************************//

function fbo_credit_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT c.idcredit, c.motif_idmotif, m.libelle, c.mtcredit, c.typerembour, DATE_FORMAT(c.datecredit,'%d/%m/%Y') as datecred, UNIX_TIMESTAMP(c.datecredit) as date_cred, c.etat, CONCAT(u.civilite,' ',u.nom,' ',u.prenom) as operateur, u.titre
               FROM utilisateur as u JOIN credit as c JOIN motif as m
               ON u.idutilisateur = c.utilisateur_idutilisateur  AND c.motif_idmotif = m.idmotif
               WHERE c.fbo_code_distrib = :id
               ORDER BY  datecred DESC
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/**************** Fonction du cumul des bonus dun fbo **************************/

function totalbonus($code) {
    $result = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare(" SELECT SUM( montapayer ) AS mtp
                               FROM bonus
                               WHERE fbo_code_distrib = :code AND (etat = 0 OR etat = 2 OR etat = 3)");
    $requete->bindValue(':code', $code);
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['mtp'];
    }
    return false;
}


/**************** Fonction du cumul des credits dun fbo **************************/

function totalcredit($code) {
    $result = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
			       SELECT SUM( mtcredit ) AS mt
                               FROM credit
                               WHERE fbo_code_distrib = :code AND etat = 0
                                                                ");
    $requete->bindValue(':code', $code);
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['mt'];
    }
    return false;
}


/* * **************** fonction de transcription dune date en français *************** */

function dateFR($timestamp) {
    $numero_jour = date('N', $timestamp);
    $numero_mois = date('n', $timestamp);
    $numero_jour_mois = date('d', $timestamp);
    $numero_annee = date('Y', $timestamp);
    $mois = array(
        1 => 'Janvier',
        2 => 'Fevrier',
        3 => 'Mars',
        4 => 'Avril',
        5 => 'Mai',
        6 => 'Juin',
        7 => 'Juillet',
        8 => 'Août',
        9 => 'Septembre',
        10 => 'Octobre',
        11 => 'Novembre',
        12 => 'Decembre'
    );
    $jour_fr = array(
        1 => 'Lundi',
        2 => 'Mardi',
        3 => 'Mercredi',
        4 => 'Jeudi',
        5 => 'Vendredi',
        6 => 'Samedi',
        7 => 'Dimanche'
    );
    $retour = $jour_fr[$numero_jour] . ' ' . $numero_jour_mois . ' ' . $mois[$numero_mois] . ' ' . $numero_annee;
    return $retour;
}


/*** Fonction de suppression dun fbo ***/

function delFbo($id) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
		               DELETE FROM fbo  
			       WHERE code_distrib  = :idd
                                             ");
    $requete->bindValue(':idd', $id);

    if ($requete->execute()) {
        return TRUE;
    } else {
        return FALSE;
    }
}


/************ Fonction de suppression dun user ************/


function delUser($id) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
		               UPDATE utilisateur SET
                               supprimer      = 1
			       WHERE idutilisateur  = :idd
                                             ");
    $requete->bindValue(':idd', $id);

    if ($requete->execute()) {
        return TRUE;
    } else {
        return FALSE;
    }
}

