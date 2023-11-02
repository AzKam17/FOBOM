<?php


/* * ******************* Fonction de nottoyage ********************* */

function nettoyer($post) {
    $value = utf8_decode($post);
    $trimer = trim($value); //Eliminer les espaces blancs avant et aprés les saisies
    $loginTrim = htmlspecialchars($trimer);
    //$trime = strtoupper($trimer); Mettre tout les caretere en majuscule pour les noms surtout
    return $loginTrim;
}

function nethash($post) {
    $value = utf8_decode($post);
    $trimer = trim($value); 
    $loginTrim = htmlspecialchars($trimer);//Eliminer les espaces blancs avant et aprés les saisies
    $hmdp = hash('sha256', $loginTrim);
    //$trime = strtoupper($trimer); Mettre tout les caretere en majuscule pour les noms surtout
    return $hmdp;
}

/* * **** Extraction du login et mdp utilisateur par username****** */

function connecteruser($login, $mdp) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("SELECT idutilisateur FROM utilisateur WHERE username = :login AND password = :mdp");
    $requete->bindValue(':login', $login);
    $requete->bindValue(':mdp', $mdp);
    $requete->execute();
    if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['idutilisateur'];
    }
    return false;
}

/* * *******infos du client du niveau administration******* */

function infosuser($clientid) {
    $client = array();
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare(" SELECT u.idutilisateur,u.nom,u.prenom,u.username,u.bloquer,u.supprimer,u.civilite,u.niveau,u.titre,CONCAT(u.nom,'  ',u.prenom) as nomcomplet,u.pays_idpays
                               FROM utilisateur as u
			       WHERE  u.idutilisateur = :id
								");
    $requete->bindValue(':id', $clientid);
    $requete->execute();
    if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        $client[] = $result;
    }
    return $client;
}

/* * **** blocage utilisateur***** */

function verifierAutorisation($clientid) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("SELECT bloquer FROM utilisateur where idutilisateur = :id ");
    $requete->bindValue(':id', $clientid);
    $requete->execute();
    if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['bloquer'] + 0;
    }

    return false;
}

/* * ***** compte verifier user****** */

function verifyaccount($clientid) {
    $pdo = PDO2::getInstance();
    $requete = $pdo->prepare("SELECT supprimer FROM utilisateur WHERE idutilisateur = :id ");
    $requete->bindValue(':id', $clientid);
    $requete->execute();
    if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['supprimer'] + 0;
    }

    return false;
}
