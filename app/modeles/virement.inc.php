<?php

/* 
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

/* * ******************* Fonction de nottoyage ********************* */

function nettoyer($post) {
    $value = utf8_decode($post);
    $trimer = trim($value); //Eliminer les espaces blancs avant et aprés les saisies
    $trime = strtoupper($trimer); //Mettre tout les caretere en majuscule pour les noms surtout
    return $trime;
}

/*** Fonction de la liste des virements nationaux et cumul des bonus dues ***/

function liste_vire_nat_cumul() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.montapayer, b.idbonus, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (b.etat = 0 OR b.etat = 2)
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function liste_vire_nat_mens($mois,$annee) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.montapayer, b.idbonus, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.mois = :mo AND b.annee = :an AND f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (b.etat = 0 OR b.etat = 2)
						");
    $requete->bindValue(':mo', $mois);
    $requete->bindValue(':an', $annee);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/*** Fonction de la liste des virements nationaux et cumul des bonus dues en cour de virement ***/

function liste_vire_cour_nat_cumul() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT SUM(t.mtfacture) as cumul, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM paiement as t JOIN bonus as b JOIN fbo as f
               ON t.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
               WHERE f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (t.etat = 0 AND t.typepaie = 2) 
               GROUP BY b.fbo_code_distrib
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function liste_vire_nat_cumul_encour() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT t.mtfacture, t.idpaiement, t.bonus_idbonus, b.montapayer, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM paiement as t JOIN bonus as b JOIN fbo as f
               ON t.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
               WHERE f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (t.etat = 0 AND t.typepaie = 2) AND b.etat = 3
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function liste_vire_cour_nat_mens($mois,$annee) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT t.bonus_idbonus, t.mtfacture, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM paiement as t JOIN bonus as b JOIN fbo as f
               ON t.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
               WHERE b.mois = :mo AND b.annee = :an AND f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (t.etat = 0 AND t.typepaie = 2)
						");
    $requete->bindValue(':mo', $mois);
    $requete->bindValue(':an', $annee);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function liste_vire_nat_cumul_encour_mens($mois,$annee) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT t.mtfacture, t.idpaiement, t.bonus_idbonus, b.montapayer, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM paiement as t JOIN bonus as b JOIN fbo as f
               ON t.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
               WHERE b.mois = :mo AND b.annee = :an AND f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (t.etat = 0 AND t.typepaie = 2) AND b.etat = 3
						");
    $requete->bindValue(':mo', $mois);
    $requete->bindValue(':an', $annee);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/*** Fonction de la liste des virements internationaux et cumul des bonus dues ***/

function liste_vire_etrang_cumul() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.montapayer, b.idbonus, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (b.etat = 0 OR b.etat = 2)
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function liste_vire_etrang_mens($mois,$annee) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.montapayer, b.idbonus, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.mois = :mo AND b.annee = :an AND f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (b.etat = 0 OR b.etat = 2)
						");
    $requete->bindValue(':mo', $mois);
    $requete->bindValue(':an', $annee);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/*** Fonction de la liste des virements internationaux et cumul des bonus dues en cour de virement ***/

function liste_vire_cour_etrang_cumul() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT SUM(t.mtfacture) as cumul, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM paiement as t JOIN bonus as b JOIN fbo as f
               ON t.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib 
               WHERE f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (t.etat = 0 AND t.typepaie = 2)
               GROUP BY b.fbo_code_distrib
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function liste_vire_nat_cumul_encour_etrang() {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT t.mtfacture, t.idpaiement, t.bonus_idbonus, b.montapayer, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM paiement as t JOIN bonus as b JOIN fbo as f
               ON t.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
               WHERE f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (t.etat = 0 AND t.typepaie = 2) AND b.etat = 3
						");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function liste_vire_cour_etrang_mens($mois,$annee) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT t.bonus_idbonus, t.mtfacture, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM paiement as t JOIN bonus as b JOIN fbo as f
               ON t.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
               WHERE b.mois = :mo AND b.annee = :an AND f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (t.etat = 0 AND t.typepaie = 2)
						");
    $requete->bindValue(':mo', $mois);
    $requete->bindValue(':an', $annee);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function liste_vire_nat_cumul_encour_mens_etrang($mois,$annee) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT t.mtfacture, t.idpaiement, t.bonus_idbonus, b.montapayer, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
               FROM paiement as t JOIN bonus as b JOIN fbo as f
               ON t.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
               WHERE b.mois = :mo AND b.annee = :an AND f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (t.etat = 0 AND t.typepaie = 2) AND b.etat = 3
						");
    $requete->bindValue(':mo', $mois);
    $requete->bindValue(':an', $annee);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/* * ************** Fonction de creation dun ordre de paiement de bonus par virement *********************************** */

function ajoutnvovirementmasse($idbonus, $user, $mt, $charg) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();
    
    $requete = $pdo->prepare("
				INSERT INTO paiement SET 
				bonus_idbonus               = :bonus,
                                utilisateur_idutilisateur   = :user,
                                datepaie                    = SYSDATE(),
                                mtfacture                   = :mt,
                                charge                      = :char,
                                typepaie                    = 2
                                                                ");
    $requete->bindValue(':bonus', $idbonus);
    $requete->bindValue(':user', $user);
    $requete->bindValue(':mt', $mt);
    $requete->bindValue(':char', $charg);
    $requete->execute();
    
    
    $requete = $pdo->prepare("
				UPDATE bonus SET 
				etat               = 3,
                                typencaisse        = 2
                                WHERE idbonus = :code
                                                                ");
    $requete->bindValue(':code', $idbonus);
    $requete->execute();
    
    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

/* * ************** Fonction de validation dun ordre de paiement de bonus par virement niveau 1*********************************** */

function updatenvovireFull($idpaie, $idbonus, $user, $reste) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();
    
    $requete = $pdo->prepare("
				UPDATE paiement SET 
				etat             = 1,
                                idcaissier       = :user,
                                datepaie         = SYSDATE()
                                WHERE idpaiement = :id
                                                                ");
    $requete->bindValue(':user', $user);
    $requete->bindValue(':id', $idpaie);
    $requete->execute();
    
    
    $requete = $pdo->prepare("
				UPDATE bonus SET 
				etat               = 1,
                                montapayer         = :mtbon,
                                typencaisse        = 2
                                WHERE idbonus = :code
                                                             ");
    $requete->bindValue(':code', $idbonus);
    $requete->bindValue(':mtbon', $reste);
    $requete->execute();
    
    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}


function updatenvovireOnly($idpaie, $idbonus, $user, $reste) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();
    
    $requete = $pdo->prepare("
				UPDATE paiement SET 
				etat             = 1,
                                idcaissier       = :user,
                                datepaie         = SYSDATE()
                                WHERE idpaiement = :id
                                                                ");
    $requete->bindValue(':user', $user);
    $requete->bindValue(':id', $idpaie);
    $requete->execute();
    
    
    $requete = $pdo->prepare("
				UPDATE bonus SET 
				etat               = 2,
                                montapayer         = :mtbon,
                                typencaisse        = 2
                                WHERE idbonus = :code
                                                             ");
    $requete->bindValue(':code', $idbonus);
    $requete->bindValue(':mtbon', $reste);
    $requete->execute();
    
    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}
