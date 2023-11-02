<?php

/* 
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

/* * ******************* Fonction de nottoyage ********************* */

function nettoye($post) {
    $value = utf8_decode($post);
    $trimer = trim($value); //Eliminer les espaces blancs avant et aprés les saisies
    $trime = strtoupper($trimer); //Mettre tout les caretere en majuscule pour les noms surtout
    return $trime;
}

//**********************************Fonction daffichage des details dun paiement a la caisse *************************************************//

function bonus_paiement($idpaie) {
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
        $auto = $a;
    }
    return $auto;
    return false;
}

function bonus_paiement_fbo($idpaie) {
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

//********************************** Fonction de verification de l'etat dun bonus *************************************************//

function fbo_bonus_etat($code, $idbonus) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.etat as eta
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.fbo_code_distrib = :id AND b.idbonus = :idbon
						");
    $requete->bindValue(':id', $code);
    $requete->bindValue(':idbon', $idbonus);
    $requete->execute();
     while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['eta'];
    }
    return false;
}

//********************************** Fonction de verification de l'etat dun bonus *************************************************//

function fbo_bonus_etats($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT b.etat, b.idbonus, b.montapayer
               FROM bonus as b JOIN fbo as f
               ON b.fbo_code_distrib = f.code_distrib
               WHERE b.fbo_code_distrib = :id
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
     while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {        
        $auto[] = $a;
    }
    return $auto;
    return false;
}

/* * ************** Fonction de creation dun ordre de paiement de bonus a la caisse *********************************** */

function ajoutnvopaie($idbonus, $user, $mt) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();
    
    $requete = $pdo->prepare("
				INSERT INTO paiement SET 
				bonus_idbonus               = :bonus,
                                utilisateur_idutilisateur   = :user,
                                datepaie                    = SYSDATE(),
                                mtfacture                   = :mont,
                                typepaie                    = 1
                                                                ");
    $requete->bindValue(':bonus', $idbonus);
    $requete->bindValue(':user', $user);
    $requete->bindValue(':mont', $mt);
    $requete->execute();
    
    $last = $pdo->lastInsertId();
    
    $requete = $pdo->prepare("
				UPDATE bonus SET 
				etat               = 3,
                                typencaisse        = 1
                                WHERE idbonus = :code
                                                             ");
    $requete->bindValue(':code', $idbonus);
    $requete->execute();
    
    if ($pdo->commit()) {
        return $last;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

/* * ************** Fonction de validation dun ordre de paiement de bonus a la caisse niveau 2*********************************** */

function updatenvopaieFull($idpaie, $idbonus, $user, $recu, $reste) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();
    
    $requete = $pdo->prepare("
				UPDATE paiement SET 
				etat             = 1,
                                idcaissier       = :user,
                                datepaie         = SYSDATE(),
                                numero_recu      = :mont
                                WHERE idpaiement = :id
                                                                ");
    $requete->bindValue(':user', $user);
    $requete->bindValue(':mont', $recu);
    $requete->bindValue(':id', $idpaie);
    $requete->execute();
    
    
    $requete = $pdo->prepare("
				UPDATE bonus SET 
				etat               = 1,
                                montapayer         = :mtbon,
                                typencaisse        = 1
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


function updatenvopaieOnly($idpaie, $idbonus, $user, $recu, $reste) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();
    
    $requete = $pdo->prepare("
				UPDATE paiement SET 
				etat             = 1,
                                idcaissier       = :user,
                                datepaie         = SYSDATE(),
                                numero_recu      = :mont
                                WHERE idpaiement = :id
                                                                ");
    $requete->bindValue(':user', $user);
    $requete->bindValue(':mont', $recu);
    $requete->bindValue(':id', $idpaie);
    $requete->execute();
    
    
    $requete = $pdo->prepare("
				UPDATE bonus SET 
				etat               = 2,
                                montapayer         = :mtbon,
                                typencaisse        = 1
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

/* * ************** Fonction de creation dun ordre de paiement de bonus par virement *********************************** */

function ajoutnvovirement($idbonus, $user, $mt, $charg) {
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


/* * ************** Fonction de annulation dun paiement de bonus deja encaissé soit par virement ou par caisse *********************************** */

function deltransapaie($idbonus, $mt) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();
    
    $requete = $pdo->prepare("  
                               DELETE FROM paiement  
			       WHERE bonus_idbonus  = :bonus etat = 1
                                                            ");
    $requete->bindValue(':bonus', $idbonus);
    $requete->execute();
    
    
    $requete = $pdo->prepare("
				UPDATE bonus SET 
				etat               = 0,
                                typencaisse        = 0,
                                montapayer         = :mt
                                WHERE idbonus = :code
                                                                ");
    $requete->bindValue(':code', $idbonus);
     $requete->bindValue(':mt', $mt);
    $requete->execute();
    
    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

/* * ************** Fonction de annulation dun paiement de bonus en cour soit par virement ou par caisse *********************************** */

function deltransapaiecour($idbonus) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();
    
    $requete = $pdo->prepare("  
                               DELETE FROM paiement  
			       WHERE bonus_idbonus  = :bonus AND etat = 0
                                                            ");
    $requete->bindValue(':bonus', $idbonus);
    $requete->execute();
    
    
    $requete = $pdo->prepare("
				UPDATE bonus SET 
				etat               = 0,
                                typencaisse        = 0
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
