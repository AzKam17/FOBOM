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

/* * ************** Fonction de creation dun nouvelle fbo *********************************** */

function ajoutfbo($code_distrib, $pays_idpays, $nom) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				INSERT INTO fbo SET 
				code_distrib            = :code,
				pays_idpays             = :pays,
                                nom_complet             = :nom
                                                                 ");
    $requete->bindValue(':code', $code_distrib);
    $requete->bindValue(':pays', $pays_idpays);
    $requete->bindValue(':nom', $nom);
    if ($requete->execute()) {
        //$reponse = $pdo->lastInsertId();
        $reponse = 1;
    } else {
        //$reponse = $requete->errorInfo
        $reponse = 0;
    }
    return $reponse;
}


/* * ************** Fonction de creation et darchivage dun nouveau fichier de bonus periodic *********************************** */

function ajoutfichierbonus($idfichier, $nomfich, $nbre, $extension, $pays, $moisbonus, $anneebonus) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				INSERT INTO fichier_bonus SET 
				idfichier_bonus    = :fichier,
				nomfichier         = :fbo,
                                nbredistrib        = :mt,
                                extension          = :ext,
				dateupload         = SYSDATE(),
                                mois               = :mois,
                                annee              = :annee,
				code_pays          = :pays
                                                                ");
    $requete->bindValue(':fichier', $idfichier);
    $requete->bindValue(':fbo', $nomfich);
    $requete->bindValue(':mt', $nbre);
    $requete->bindValue(':ext', $extension);
    $requete->bindValue(':pays', $pays);
    $requete->bindValue(':mois', $moisbonus);
    $requete->bindValue(':annee', $anneebonus);
    if ($requete->execute()) {
        //$reponse = $pdo->lastInsertId();
        $reponse = 1;
    } else {
        //$reponse = $requete->errorInfo();
        $reponse = 0;
    }
    return $reponse;
}

/* * ************** Fonction de creation et darchivage dun nouveau bonus *********************************** */

function ajoutbonus($fichier, $fbo, $mt, $ajust, $soustot, $bic, $mtpaye, $moisbonus, $anneebonus) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				INSERT INTO bonus SET 
				fichier_bonus_idfichier_bonus    = :fichier,
				fbo_code_distrib                 = :fbo,
                                montant                          = :mt,
                                ajustement                       = :ajust,
				sous_total                       = :soustot,
                                bic                              = :bic,
                                montapayer                       = :mtpaye,
				mois                             = :mois,
                                annee                            = :annee
                                                                            ");
    $requete->bindValue(':fichier', $fichier);
    $requete->bindValue(':fbo', $fbo);
    $requete->bindValue(':mt', $mt);
    $requete->bindValue(':ajust', $ajust);
    $requete->bindValue(':soustot', $soustot);
    $requete->bindValue(':bic', $bic);
    $requete->bindValue(':mtpaye', $mtpaye);
    $requete->bindValue(':mois', $moisbonus);
    $requete->bindValue(':annee', $anneebonus);
    if ($requete->execute()) {
        //$reponse = $pdo->lastInsertId();
        $reponse = 1;
    } else {
        $reponse = $requete->errorInfo();
        //$reponse = 0;
    }
    return $reponse;
}

/* * ************ Fonction de mis a jour des numero de compte fbo CIV *************************** */

function updatecomptebanq($code, $numbanq) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				UPDATE fbo SET 
				compte_banque = :num,
                                nationalite   = 'CIV'
                                WHERE code_distrib = :code
                                                                 ");
    $requete->bindValue(':code', $code);
    $requete->bindValue(':num', $numbanq);
    if ($requete->execute()) {
        $reponse = 1;
    } else {
        //$reponse = $requete->errorInfo();
        $reponse = 0;
    }
    return $reponse;
}

function ajoutcomptebanq($code, $nom, $numbanq, $pays_idpays) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				INSERT INTO fbo SET 
				code_distrib            = :code,
				pays_idpays             = :pays,
                                nom_complet             = :nom,
                                compte_banque           = :num,
                                nationalite             = 'CIV'
                                                                 ");
    $requete->bindValue(':code', $code);
    $requete->bindValue(':num', $numbanq);
    $requete->bindValue(':pays', $pays_idpays);
    $requete->bindValue(':nom', $nom);
    if ($requete->execute()) {
        $reponse = 1;
    } else {
        //$reponse = $requete->errorInfo();
        $reponse = 0;
    }
    return $reponse;
}

/* * ************ Fonction de mis a jour des numero de compte fbo ETRANGER *************************** */

function updatecomptebanqetranger($code, $numbanq, $swift, $nation) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				UPDATE fbo SET 
				compte_banque = :num,
                                swift_code    = :swif,
                                nationalite   = :nat
                                WHERE code_distrib = :code
                                                                 ");
    $requete->bindValue(':code', $code);
    $requete->bindValue(':num', $numbanq);
    $requete->bindValue(':nat', $nation);
    $requete->bindValue(':swif', $swift);
    if ($requete->execute()) {
        $reponse = 1;
    } else {
        //$reponse = $requete->errorInfo();
        $reponse = 0;
    }
    return $reponse;
}

function ajoutcomptebanqetranger($code, $nom, $numbanq, $swift, $nation, $pays_idpays) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				INSERT INTO fbo SET 
				code_distrib            = :code,
				pays_idpays             = :pays,
                                nom_complet             = :nom,
                                compte_banque           = :num,
                                swift_code              = :swif,
                                nationalite             = :nat
                                                                 ");
    $requete->bindValue(':code', $code);
    $requete->bindValue(':num', $numbanq);
    $requete->bindValue(':pays', $pays_idpays);
    $requete->bindValue(':nom', $nom);
    $requete->bindValue(':swif', $swift);
    $requete->bindValue(':nat', $nation);
    if ($requete->execute()) {
        $reponse = 1;
    } else {
        //$reponse = $requete->errorInfo();
        $reponse = 0;
    }
    return $reponse;
}

/*************** Fonction de suppression dun fbo ******************/

function delFich($id) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
		               DELETE FROM fichier_bonus  
			       WHERE idfichier_bonus  = :idd
                                             ");
    $requete->bindValue(':idd', $id);

    if ($requete->execute()) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//**********************************Affichage detail dun fichier de bonus mensuel *************************************************//

function fichier_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT idfichier_bonus,nomfichier,nbredistrib,extension,dateupload,mois,annee,code_pays 
               FROM fichier_bonus
               WHERE idfichier_bonus = :id
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}