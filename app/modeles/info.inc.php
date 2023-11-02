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
    //$trime = strtoupper($trimer); Mettre tout les caretere en majuscule pour les noms surtout
    return $trimer;
}

function nethash($post) {
    $value = utf8_decode($post);
    $trimer = trim($value); //Eliminer les espaces blancs avant et aprés les saisies
    $hmdp = hash('sha256', $trimer);
    //$trime = strtoupper($trimer); Mettre tout les caretere en majuscule pour les noms surtout
    return $hmdp;
}

/* * ******************* Fonction de verification des integrités des donnees ********************* */

function traitement($nom, $prenoms, $email, $mobile, $ville, $quartier, $commune) {

    if (strlen($nom) < 2) {
        $sms = 'le <i><b>nom</b></i> saisit est trop court!';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (strlen($nom) > 300) {
        $sms = 'le <i><b>nom</b></i> saisit est trop long!';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (preg_match("#[0-9]#", $nom)) {
        $sms = 'le champs <i><b>nom</b></i> ne peut pas contenir de chiffres!';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (preg_match("#[0-9]#", $prenoms)) {
        $sms = 'le(s) champs <i><b>pays</b></i> ne peut pas contenir de chiffres!';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (strlen($email) > 200) {
        $sms = 'l\' <i><b>adresse electronique</b></i> saisie est trop long!';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (strlen($prenoms) > 100) {
        $sms = 'le <i><b>pays</b></i> saisit est trop long! <b>(maximum 100 caractères)</b>!';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (strlen($quartier) > 150) {
        $sms = 'le <i><b>quartier</b></i> saisit est trop long! <b>(maximum 150 caractères)</b>';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (strlen($commune) > 150) {
        $sms = 'la <i><b>commune</b></i> saisit est trop long! <b>(maximum 150 caractères)</b>';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (preg_match("#[0-9]#", $ville)) {
        $sms = 'le champs <i><b>ville</b></i> ne peut pas contenir de chiffres!';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (strlen($ville) > 150) {
        $sms = 'la <i><b>ville</b></i> saisit est trop long! <b>(maximum 150 caractères)</b>';
        $alert = htmlentities($sms, ENT_QUOTES);
    } elseif (!preg_match("#[0-9]#", $mobile) AND strlen($mobile) > 1) {
        $sms = 'le <i><b>numero de mobile</b></i> ne peut contenir que des chiffres!';
        $alert = htmlentities($sms, ENT_QUOTES);
    } else {
        $alert = 0203;
    }
    return $alert;
}

/* * ************** Fonction de modification dun enseignant de type professeur ou instituteur *********************************** */

function modifbo($code, $nom, $banque, $swift, $email, $statut, $address, $mobile, $ville, $quartier, $commune, $nat, $idfbo) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				UPDATE fbo  SET 
				code_distrib           = :id,
				nom_complet            = :nom,
                                compte_banque          = :banque,
				swift_code             = :swift,
				statut_fbo             = :statut,
				email                  = :email,
				mobile                 = :mobile,
                                ville                  = :ville,
                                commune                = :commune,
                                quartier               = :quartier,
                                addresse               = :addre,
                                nationalite            = :nation
                                WHERE code_distrib     = :idd
								");
    $requete->bindValue(':id', $code);
    $requete->bindValue(':nom', $nom);
    $requete->bindValue(':banque', $banque);
    $requete->bindValue(':swift', $swift);
    $requete->bindValue(':email', $email);
    $requete->bindValue(':statut', $statut);
    $requete->bindValue(':addre', $address);
    $requete->bindValue(':mobile', $mobile);
    $requete->bindValue(':ville', $ville);
    $requete->bindValue(':commune', $commune);
    $requete->bindValue(':quartier', $quartier);
    $requete->bindValue(':nation', $nat);
    $requete->bindValue(':idd', $idfbo);
    if ($requete->execute()) {
        //$reponse = $pdo->lastInsertId();
        return $reponse = 1;
    } else {
        //return $reponse = $requete->errorInfo();
        return $reponse = 0;
    }
    //return $reponse;
}

/*** Fonction de creation dun nvo utilisateur ***/

function ajoutuser($pays, $nom, $prenom, $user, $pass, $titre, $niveau, $civil) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("
				INSERT INTO utilisateur  SET 
				pays_idpays    = :id,
				civilite       = :civil,
                                nom            = :noms,
				prenom         = :prenoms,
				username       = :usernm,
				password       = :pass,
				titre          = :title,
                                niveau         = :niv
								");
    $requete->bindValue(':id', $pays);
    $requete->bindValue(':noms', $nom);
    $requete->bindValue(':prenoms', $prenom);
    $requete->bindValue(':usernm', $user);
    $requete->bindValue(':pass', $pass);
    $requete->bindValue(':title', $titre);
    $requete->bindValue(':niv', $niveau);
    $requete->bindValue(':civil', $civil);
    if ($requete->execute()) {
        $reponse = $pdo->lastInsertId();
        //$reponse = TRUE;
    } else {
        //$reponse = $requete->errorInfo();
        $reponse = FALSE;
    }
    return $reponse;
}

//**********************************Affichage detail dun administrateur *************************************************//

function admin_detail($code) {
    $auto = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare
            (" 
               SELECT f.idutilisateur,f.pays_idpays,p.nompays,f.civilite,f.nom,f.prenom,f.username,f.password,f.titre,f.niveau,f.bloquer,f.supprimer
               FROM utilisateur as f JOIN pays as p
               ON f.pays_idpays = p.idpays
               WHERE f.idutilisateur = :id AND f.supprimer = 0
						");
    $requete->bindValue(':id', $code);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $auto[] = $a;
    }
    return $auto;
    return false;
}