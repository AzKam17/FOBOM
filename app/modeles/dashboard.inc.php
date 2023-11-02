<?php

/* 
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : Ing AYOLIE Say-halatte Stivell and KAM Corporate
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

/* Nombre total de fichier bonus Excel uploadé */

function nbre_total_fichier_bonus() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM fichier_bonus
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients + 0;
    }
    return false;
}

/* Nombre total de bonus payé ou pas ou partiellement (Grand Total) */

function nbre_total_bonus() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM bonus
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients + 0;
    }
    return false;
}

/* Nombre total de FBO*/

function nbre_total_fbo() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM fbo
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients + 0;
    }
    return false;
}

/* Grand total des bonus qui ont été deja payé au moins une fois --- Totalement ou partiellement */

function nbre_total_bonus_paye() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM bonus as b
               WHERE b.etat = 1 OR b.etat = 2
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients + 0;
    }
    return false;
}

function sum_total_bonus_paye() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT SUM(p.mtfacture) as ba
               FROM paiement as p
               WHERE p.etat = 1
					");
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['ba'] + 0;
    }
    return false;
}

/* Total des bonus qui ont deja été payé Totalement -- Soldé */

function nbre_total_bonus_solde() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM bonus as b
               WHERE b.etat = 1
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients + 0;
    }
    return false;
}

function sum_total_bonus_solde() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT SUM(p.mtfacture) as ba
               FROM paiement as p JOIN bonus as b
               ON p.bonus_idbonus = b.idbonus
               WHERE p.etat = 1 AND b.etat = 1
					");
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['ba'] + 0;
    }
    return false;
}

/* Total des bonus qui ont deja été payé partiellment -- Payé en partie */

function nbre_total_bonus_paye_partiel() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM bonus as b
               WHERE b.etat = 2
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients + 0;
    }
    return false;
}

function sum_total_bonus_paye_partiel() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT SUM(p.mtfacture) as ba
               FROM paiement as p JOIN bonus as b
               ON p.bonus_idbonus = b.idbonus
               WHERE p.etat = 1 AND b.etat = 2
					");
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['ba'] + 0;
    }
    return false;
}

/* Nombre total des bonus impayé -- Non soldé */

function nbre_total_bonus_impaye() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM bonus as b
               WHERE b.etat = 0 OR b.etat = 2 OR b.etat = 3 
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

function sum_total_bonus_impaye() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT SUM(b.montapayer) as imp
               FROM bonus as b
               WHERE b.etat = 1 OR b.etat = 0 OR b.etat = 3
					");
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['imp'] + 0;
    }
    return false;
}

function nbre_total_bonus_impaye_encour() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM bonus as b
               WHERE b.etat = 3 
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

function nbre_total_bonus_impaye_partiel() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM bonus as b
               WHERE b.etat = 2
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

function nbre_total_bonus_impaye_brut() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT * 
               FROM bonus as b
               WHERE b.etat = 0
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

/* Nombre des bonus payé totalement ou partiellemnt à la caisse et par période */

function liste_total_bonus_paye() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.idbonus, b.fbo_code_distrib, f.nom_complet, b.montapayer + p.mtfacture as bonus, p.mtfacture as paye, b.montapayer as reste, b.mois,b.annee, p.typepaie as mode, p.idcaissier, p.utilisateur_idutilisateur, p.datepaie
               FROM fbo as f JOIN bonus as b JOIN paiement as p
               ON f.code_distrib = b.fbo_code_distrib AND b.idbonus = p.bonus_idbonus
               WHERE ( b.etat = 1 OR b.etat = 2 ) AND ( YEAR( p.datepaie ) = EXTRACT( YEAR FROM CURRENT_DATE ) AND MONTH( p.datepaie ) = EXTRACT( MONTH FROM CURRENT_DATE ) ) AND (b.typencaisse = 1)
					");
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients + 0;
    }
    return false;
}

function mt_total_credit() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
             SELECT SUM(c.mtcredit) as mtc
             FROM credit as c
             WHERE c.etat = 0
					");
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['mtc'] + 0;
    }
    return false;
}

function mt_total_credit_rembou() {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               
             SELECT SUM(c.mtcredit) as cred
             FROM credit as c
             WHERE c.etat = 1
					");
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['cred'] + 0;
    }
    return false;
}
//-----------------------------------------------------------------------------------------------------------------------------------------

function ChifAffMensBonPaie() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" SELECT CONCAT('gd(',YEAR(ANY_VALUE(p.datepaie)),', ',MONTH(ANY_VALUE(p.datepaie)),')') as mois, SUM(p.mtfacture) as cam
               FROM paiement as p 
               WHERE p.etat = 1
               GROUP BY YEAR(p.datepaie),MONTH(p.datepaie) 
               ORDER BY YEAR(p.datepaie),MONTH(p.datepaie)  ");
    //$requete->bindValue(':ideta', $ideta);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_NUM)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function ChifAffMensBon() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" SELECT CONCAT('gd(',ANY_VALUE(b.annee),', ',ANY_VALUE(b.mois),')') as mois, SUM(b.montapayer) as cam
               FROM bonus as b 
               WHERE b.etat = 0 OR b.etat = 2 OR b.etat = 3
               GROUP BY b.annee,b.mois 
               ORDER BY b.annee,b.mois ");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_NUM)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function ChifAffMensBonCour() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" SELECT CONCAT('gd(',YEAR(ANY_VALUE(p.datepaie)),', ',MONTH(ANY_VALUE(p.datepaie)),')') as mois, SUM(p.mtfacture) as cam
               FROM paiement as p 
               WHERE p.etat = 0
               GROUP BY YEAR(p.datepaie),MONTH(p.datepaie) 
               ORDER BY YEAR(p.datepaie),MONTH(p.datepaie)  ");
    //$requete->bindValue(':ideta', $ideta);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_NUM)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}