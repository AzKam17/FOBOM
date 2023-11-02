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

/* * ************ fonction de comparaison de la date prevue de levaluation ********** */

function datealerte($dateprevu) {

    $datejour = date('d/m/Y');

    //explode pour mettre la date du fin en format numerique: 02/03/1986  -> 02031986
    $dfin = explode("/", $dateprevu);

    //explode pour mettre la date du jour en format numerique: 06/01/2016  -> 06012016
    $djour = explode("/", $datejour);

    // concaténation pour inverser l'ordre: 02031986 -> 19860302
    $finab = $dfin[2] . $dfin[1] . $dfin[0];
    // concaténation pour inverser l'ordre: 06012016 -> 20160106
    $auj = $djour[2] . $djour[1] . $djour[0];
    
    $dif = $auj - $finab;

    if ($dif > 3) {
        $sms = 'retard';
    } else {
        $sms = 0203;
    }
    return $sms;
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

//**********************************Affichage detail des bonus mensuel dues dun fbo *************************************************//

function fbo_bonus_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.idbonus,b.montapayer,b.mois,b.annee
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.fbo_code_distrib = :id AND ( b.etat = 0 OR b.etat = 2 )
               ORDER BY  b.mois ASC, b.annee ASC
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_NUM)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/**************** Fonction du libelle dun motif de credit **************************/

function quelmotif($motif) {
    $result = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare(" SELECT libelle AS mot
                               FROM motif
                               WHERE idmotif = :code ");
    $requete->bindValue(':code', $motif);
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['mot'];
    }
    return false;
}

//**********************************Affichage detail du credit dues par un fbo *************************************************//

function fbo_credit_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT c.idcredit, c.motif_idmotif, t.libelle, c.mtcredit, c.datecredit, DATE_FORMAT(c.datecredit,'%d/%m/%Y') as datcred, c.etat, c.utilisateur_idutilisateur,c.fbo_code_distrib, f.nom_complet, f.compte_banque, f.statut_fbo, f.mobile, CONCAT(u.civilite,' ',u.nom,' ',u.prenom) as operateur, u.titre
               FROM utilisateur as u JOIN credit as c JOIN motif as t JOIN fbo as f
               ON u.idutilisateur = c.utilisateur_idutilisateur AND c.motif_idmotif = t.idmotif AND c.fbo_code_distrib = f.code_distrib
               WHERE c.idcredit = :id
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//**********************************Affichage detail du credit transac *************************************************//

function bonus_remb_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT p.idremboursement, p.utilisateur_idutilisateur, UNIX_TIMESTAMP(p.daterembour) as date_paie, p.credit_idcredit, p.typepaie, p.mtrembourser, p.daterembour, u.civilite, u.nom, u.prenom
               FROM remboursement as p JOIN utilisateur as u
               ON p.utilisateur_idutilisateur = u.idutilisateur
               WHERE p.credit_idcredit = :id
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_NUM)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

//**********************************Affichage detail du cheque dun credit dues par un fbo *************************************************//

function credit_cheque_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT q.numcheque, q.credit_idcredit, q.typecheque, q.datecheque, q.mtcheque, q.etat, DATE_FORMAT(q.datecheque,'%d/%m/%Y') as datcheq
               FROM cheque as q
               WHERE q.credit_idcredit = :id
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/* * ************** Fonction de creation dun nouvel credit avec cheque (transaction) *********************************** */

function ajoutcredit($code_distrib, $motif, $mtcred, $datecred, $idcheq, $mtcheq, $typecheq, $datecheq, $id) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();

    $requete = $pdo->prepare("
				INSERT INTO credit SET 
				fbo_code_distrib       = :code,
				motif_idmotif          = :motif,
                                mtcredit               = :mt,
                                datecredit             = :dat,
                                utilisateur_idutilisateur = :user
                                                                 ");
    $requete->bindValue(':code', $code_distrib);
    $requete->bindValue(':motif', $motif);
    $requete->bindValue(':mt', $mtcred);
    $requete->bindValue(':dat', $datecred);
    $requete->bindValue(':user', $id);
    $requete->execute();

    $last = $pdo->lastInsertId();

    $requete = $pdo->prepare("  INSERT INTO cheque SET 
				numcheque        = :idcheq,
				credit_idcredit  = :id,
                                typecheque       = :typecheq,
				datecheque       = :datecheq,
				mtcheque         = :mtcheq
                            ");

    $requete->bindValue(':idcheq', $idcheq);
    $requete->bindValue(':mtcheq', $mtcheq);
    $requete->bindValue(':typecheq', $typecheq);
    $requete->bindValue(':datecheq', $datecheq);
    $requete->bindValue(':id', $last);
    $requete->execute();

    if ($pdo->commit()) {
        return $last;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

/* * ************ Fonction de creation dun credit sans cheque *************************** */

function creditsanscheque($code_distrib, $motif, $mtcred, $datecred, $id) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				INSERT INTO credit SET 
				fbo_code_distrib       = :code,
				motif_idmotif          = :motif,
                                mtcredit               = :mt,
                                datecredit             = :dat,
                                utilisateur_idutilisateur = :user
                                                                 ");
    $requete->bindValue(':code', $code_distrib);
    $requete->bindValue(':motif', $motif);
    $requete->bindValue(':mt', $mtcred);
    $requete->bindValue(':dat', $datecred);
    $requete->bindValue(':user', $id);
    if ($requete->execute()) {
        //$reponse = $pdo->lastInsertId();
        $reponse = 1;
    } else {
        //$reponse = $requete->errorInfo
        $reponse = 0;
    }
    return $reponse;
}

/* * ************** Fonction du montant actuel du credit rataché au chèque ************************* */

function mtactuelcredit($idcredit) {
    $result = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
			       SELECT mtcredit AS mt
                               FROM credit
                               WHERE idcredit = :code AND etat = 0
                                                                ");
    $requete->bindValue(':code', $idcredit);
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['mt'];
    }
    return false;
}

//**********************************Affichage liste des cheques recu des fbo *************************************************//

function cheque_liste($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT u.numcheque, u.typecheque, u.datecheque, DATE_FORMAT(u.datecheque,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, f.nom_complet, f.code_distrib
               FROM cheque as u JOIN credit as c JOIN fbo as f
               ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib 
               WHERE f.pays_idpays = :id AND  u.etat = 0
               ORDER BY u.datecheque DESC
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function total_cheque_liste($code) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            ("  SELECT u.numcheque, u.typecheque, u.datecheque, DATE_FORMAT(u.datecheque,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, f.nom_complet, f.code_distrib
               FROM cheque as u JOIN credit as c JOIN fbo as f
               ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib 
               WHERE f.pays_idpays = :id AND  u.etat = 0
		");
    $requete->bindValue(':id', $code);
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

//**********************************Affichage liste des cheques retour encaisse  *************************************************//

function cheque_liste_encaisse($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT u.numcheque, u.typecheque, u.dateretour, DATE_FORMAT(u.dateretour,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, u.credit_idcredit, f.nom_complet, f.code_distrib
               FROM cheque as u JOIN credit as c JOIN fbo as f
               ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib 
               WHERE f.pays_idpays = :id AND  u.etat = 1
               ORDER BY u.dateretour DESC
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function total_liste_encaisse($code) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            ("  SELECT u.numcheque, u.typecheque, u.dateretour, DATE_FORMAT(u.datecheque,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, f.nom_complet, f.code_distrib
               FROM cheque as u JOIN credit as c JOIN fbo as f
               ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib 
               WHERE f.pays_idpays = :id AND  u.etat = 1
		");
    $requete->bindValue(':id', $code);
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

//**********************************Affichage liste des cheques deposé a la banque  *************************************************//

function cheque_liste_depot($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT u.numcheque, u.typecheque, u.datedepotbanque, DATE_FORMAT(u.datedepotbanque,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, u.credit_idcredit, f.nom_complet, f.code_distrib
               FROM cheque as u JOIN credit as c JOIN fbo as f
               ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib 
               WHERE f.pays_idpays = :id AND  u.etat = 2
               ORDER BY u.datedepotbanque DESC
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function total_liste_depot($code) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            ("  SELECT u.numcheque, u.typecheque, u.datedepotbanque, DATE_FORMAT(u.datedepotbanque,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, f.nom_complet, f.code_distrib
               FROM cheque as u JOIN credit as c JOIN fbo as f
               ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib 
               WHERE f.pays_idpays = :id AND  u.etat = 2
		");
    $requete->bindValue(':id', $code);
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

//**********************************Affichage liste des cheques retour impaye  *************************************************//

function cheque_liste_impaye($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT u.numcheque, u.typecheque, u.dateretour, DATE_FORMAT(u.dateretour,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, u.motif, u.credit_idcredit, f.nom_complet, f.code_distrib
               FROM cheque as u JOIN credit as c JOIN fbo as f
               ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib 
               WHERE f.pays_idpays = :id AND  u.etat = 3
               ORDER BY u.dateretour DESC
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}

function total_liste_impaye($code) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            ("  SELECT u.numcheque, u.typecheque, u.dateretour, DATE_FORMAT(u.dateretour,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, f.nom_complet, f.code_distrib
               FROM cheque as u JOIN credit as c JOIN fbo as f
               ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib 
               WHERE f.pays_idpays = :id AND  u.etat = 3
		");
    $requete->bindValue(':id', $code);
    $requete->execute();
    if ($infos_clients = $requete->rowCount()) {
        $requete->closeCursor();
        return $infos_clients;
    }
    return false;
}

/* * ************ Fonction de mis a jour dun cheque a letat 2 donc depot en banque *************************** */

function depotcheque($idcheq, $datedepot) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				UPDATE cheque SET 
				etat              = 2,
                                datedepotbanque   = :dat
                                WHERE numcheque = :code
                                                                 ");
    $requete->bindValue(':code', $idcheq);
    $requete->bindValue(':dat', $datedepot);
    if ($requete->execute()) {
        $reponse = 1;
    } else {
        $reponse = 0;
    }
    return $reponse;
}

/* * ************ Fonction transactionnelle de mis a jour dun cheque a letat 1 donc retour de banque payé et annulation du credit ****************** */

function retourcheq($idcheq, $dateretour, $idcredit) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();

    $requete = $pdo->prepare("
				UPDATE cheque SET 
				etat              = 1,
                                dateretour        = :dat
                                WHERE numcheque = :code
                                             ");
    $requete->bindValue(':code', $idcheq);
    $requete->bindValue(':dat', $dateretour);
    $requete->execute();

    $requete = $pdo->prepare("  UPDATE credit SET 
                                etat              = 1,
                                typerembour       = 1
				WHERE idcredit    = :idcred
                            ");

    $requete->bindValue(':idcred', $idcredit);
    $requete->execute();

    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

/* * ************ Fonction de mis a jour dun cheque a letat 4 donc retour de banque impayé et ajout des charges au montant du credit *************************** */

function retourcheqimpaye($idcheq, $idcredit, $dateretour, $motif, $charge) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();

    $requete = $pdo->prepare("
				UPDATE cheque SET 
				etat              = 3,
                                dateretour        = :dat,
                                motif             = :mot
                                WHERE numcheque = :code
                                             ");
    $requete->bindValue(':code', $idcheq);
    $requete->bindValue(':dat', $dateretour);
    $requete->bindValue(':mot', $motif);
    $requete->execute();

    $requete = $pdo->prepare("  UPDATE credit SET 
                                mtcredit          = :mt
				WHERE idcredit    = :idcred
                            ");

    $requete->bindValue(':idcred', $idcredit);
    $requete->bindValue(':mt', $charge);
    $requete->execute();

    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

/* * ************ Fonction transactionnelle de mis a jour dun cheque a letat 1 donc retour de banque payé et annulation du credit ****************** */

function rembcredpar($idcredit, $mtremb, $reste, $user) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();

    $requete = $pdo->prepare("
				INSERT INTO remboursement SET 
				utilisateur_idutilisateur     = :user,
                                credit_idcredit               = :code,
                                daterembour                   = SYSDATE(),
                                mtrembourser                  = :mtr,
                                typepaie                      = 1
                                             ");
    $requete->bindValue(':code', $idcredit);
    $requete->bindValue(':mtr', $mtremb);
    $requete->bindValue(':user', $user);
    $requete->execute();

    $requete = $pdo->prepare("  UPDATE credit SET 
                                etat              = 0,
                                typerembour       = 3,
                                mtcredit          = :rest
				WHERE idcredit    = :idcred
                            ");

    $requete->bindValue(':rest', $reste);
    $requete->bindValue(':idcred', $idcredit);
    $requete->execute();

    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

function rembcred($idcredit, $mtremb, $reste, $user) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();

    $requete = $pdo->prepare("
				INSERT INTO remboursement SET 
				utilisateur_idutilisateur     = :user,
                                credit_idcredit               = :code,
                                daterembour                   = SYSDATE(),
                                mtrembourser                  = :mtr,
                                typepaie                      = 1
                                             ");
    $requete->bindValue(':code', $idcredit);
    $requete->bindValue(':mtr', $mtremb);
    $requete->bindValue(':user', $user);
    $requete->execute();

    $requete = $pdo->prepare("  UPDATE credit SET 
                                etat              = 1,
                                typerembour       = 3,
                                mtcredit          = :rest
				WHERE idcredit    = :idcred
                            ");

    $requete->bindValue(':rest', $reste);
    $requete->bindValue(':idcred', $idcredit);
    $requete->execute();

    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

/************ Fonction de suppression dun credit ************/

function delCred($idcred) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
		               DELETE FROM credit  
			       WHERE idcredit  = :idd
                                             ");
    $requete->bindValue(':idd', $idcred);

    if ($requete->execute()) {
        return TRUE;
    } else {
        return FALSE;
    }
}

