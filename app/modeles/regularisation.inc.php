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

/* * ************** Fonctions de regularisation dun credit par bonus (transaction) *********************************** */

function regcreditFull($id, $mtc, $user, $mtr, $idbon) {

    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();

    $requete = $pdo->prepare("
				INSERT INTO remboursement SET 
				utilisateur_idutilisateur     = :user,
                                credit_idcredit               = :code,
                                bonus_idbonus                 = :bon,
                                daterembour                   = SYSDATE(),
                                mtrembourser                  = :mtr,
                                typepaie                      = 2
                                             ");
    $requete->bindValue(':code', $id);
    $requete->bindValue(':mtr', $mtr);
    $requete->bindValue(':user', $user);
    $requete->bindValue(':bon', $idbon);
    $requete->execute();

    $requete = $pdo->prepare("
				UPDATE credit SET 
                                mtcredit       = :mt,
                                etat           = 1,
                                typerembour    = 2
                                WHERE idcredit = :idcred
                                             ");
    $requete->bindValue(':idcred', $id);
    $requete->bindValue(':mt', $mtc);
    $requete->execute();

    $requete = $pdo->prepare("  UPDATE cheque SET 
                                etat              = 1,
                                dateretour        = SYSDATE()
                                WHERE credit_idcredit = :idcred
                            ");

    $requete->bindValue(':idcred', $id);
    $requete->execute();

    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

function regcreditOnly($id, $mtc, $user, $mtr, $idbon) {
    $pdo = PDO2::getInstance();
    $pdo->beginTransaction();

    $requete = $pdo->prepare("
				INSERT INTO remboursement SET 
				utilisateur_idutilisateur     = :user,
                                credit_idcredit               = :code,
                                bonus_idbonus                 = :bon,
                                daterembour                   = SYSDATE(),
                                mtrembourser                  = :mtr,
                                typepaie                      = 2
                                             ");
    $requete->bindValue(':code', $id);
    $requete->bindValue(':mtr', $mtr);
    $requete->bindValue(':user', $user);
    $requete->bindValue(':bon', $idbon);
    $requete->execute();

    $requete = $pdo->prepare("
				UPDATE credit SET 
                                mtcredit       = :mt,
                                typerembour    = 2
                                WHERE idcredit = :idcred
                                             ");
    $requete->bindValue(':idcred', $id);
    $requete->bindValue(':mt', $mtc);
    $requete->execute();

    if ($pdo->commit()) {
        return TRUE;
    } else {
        $pdo->rollback;
        return FALSE;
    }
}

function regbonusFull($idbon, $mtb) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("  UPDATE bonus SET 
				montapayer       = :mtt,
                                etat             = 1,
                                typencaisse      = 3
				WHERE idbonus    = :idbon
                            ");

    $requete->bindValue(':idbon', $idbon);
    $requete->bindValue(':mtt', $mtb);

    if ($requete->execute()) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function regbonusOnly($idbon, $mtb) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("  UPDATE bonus SET 
				montapayer       = :mtt,
                                etat             = 2,
                                typencaisse      = 3
				WHERE idbonus    = :idbon
                            ");

    $requete->bindValue(':idbon', $idbon);
    $requete->bindValue(':mtt', $mtb);

    if ($requete->execute()) {
        return TRUE;
    } else {
        return FALSE;
    }
}
