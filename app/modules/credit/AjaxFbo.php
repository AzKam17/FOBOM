<?php

/*
 * Projet School Alerte
 * Designer et Entierement programmÃ© par Mr. Say-Halatte AYOLIE
 * Webmaster, Expert en developpement web et mobile
 * @HAXIS Cote d'Ivoire  * 
 */

// we need this so that PHP does not complain about deprectaed functions
//error_reporting(0);

// Definition du default timezone
date_default_timezone_set('Africa/Abidjan');

// Functions Fetch the data
function liste_fbo($ideta, $queryString) {
    $aut = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" 
                SELECT f.code_distrib,f.nom_complet
                FROM fbo as f
                WHERE f.nom_complet LIKE '$queryString%' AND f.pays_idpays = '$ideta'
                ORDER BY f.nom_complet ASC
                LIMIT 10
		");
    $requete->bindValue(':ideta', $ideta);
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $aut[] = $a;
    }
    return $aut;
}

function liste_code_fbo($ideta, $queryString) {
    $aut = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare
            (" SELECT f.code_distrib,f.nom_complet
                FROM fbo as f
                WHERE f.code_distrib LIKE '$queryString%' AND f.pays_idpays = '$ideta'
                ORDER BY f.nom_complet ASC
                LIMIT 10
		");
    $requete->execute();
    while ($a = $requete->fetch(PDO::FETCH_ASSOC)) {
        $aut[] = $a;
    }
    return $aut;
}

function totalbonus($idele) {
    $result = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare(" SELECT SUM( montapayer ) AS mtp
                               FROM bonus
                               WHERE fbo_code_distrib = :idele AND etat = 0");
    $requete->bindValue(':idele', $idele);
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['mtp'];
    }
    return false;
}

function totalcredit($idele) {
    $result = array();
    $pdo = new PDO('mysql:host=localhost;dbname=foreverdb;charset=utf8', 'root', 'StiveKelly$0203');
    $requete = $pdo->prepare("
			       SELECT SUM( mtcredit ) AS mt
                               FROM credit
                               WHERE fbo_code_distrib = :idele AND etat = 0
                                                                ");
    $requete->bindValue(':idele', $idele);
    $requete->execute();
    while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
        $requete->closeCursor();
        return $result['mt'];
    }
    return false;
}

function dateFr($timestamp) {
    $moisFr = array(1 => 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    $mois = intval(date('m', $timestamp));
    return date('d', $timestamp) . ' ' . $moisFr[$mois] . ' ' . date('Y', $timestamp);
}

/// si une variable queryString a été posté
if (isset($_POST['queryString'])) {
    $queryString = $_POST['queryString'];
    $ideta = $_POST['queryId'];
    // si la longueur du contenu de la variable est superieur à 0			
    if (strlen($queryString) > 0) {
        //Extraire la 1ere lettre de la variable querystring
        //$data = substr($queryString, 0, 1);
        if (is_numeric($queryString)) { // Si la variable data est egale a # or est un nombre, alors on passe la main au systeme d'annulation des reçus
            // on parcourt les resultats des reçus
            if ($liste_rec = liste_code_fbo($ideta, $queryString)) {
                // on parcourt les resultats
                foreach ($liste_rec as $l) {
                    $idele = $l['code_distrib'];
                    $nomsearch = str_replace("'","\\'",$l['nom_complet']);
                    $cred = totalcredit($idele);
                    $bon = totalbonus($idele);
                    $mtr =  $bon - $cred;
                    $info = '<p><strong>DETAILS FINANCIERS DU FBO</strong></p>'
                            . 'Cumul des bonus : <strong>' . number_format($bon, 0, ',', ' ') . ' F</strong><br> '
                            . 'Cumul des crédits : <strong>' . number_format($cred, 0, ',', ' ') . ' F</strong><br>'
                            . 'Montant restant à payer : <strong>' . number_format($mtr, 0, ',', ' ') . ' F</strong>';
                    // on affiche les resultats dans un element de liste en ajoutant la fonction la fill sur l'evenenement onClick
                    echo '<li onClick="fillele(\'' . $nomsearch . '\');fillid(\'' . $idele . '\');fillinfo(\'' . $info . '\');">' . $l['code_distrib'] . '&nbsp;&nbsp;&nbsp;' . $l['nom_complet'] . '</li>';
                }
            } else {
                echo 'Ce FBO est introuvable.';
            }
        } else { // Sinon on passe la main au systeme de facturation
            if ($liste = liste_fbo($ideta, $queryString)) {
                // on parcourt les resultats
                foreach ($liste as $l) {
                    $idele = $l['code_distrib'];
                    $nomsearch = str_replace("'","\\'",$l['nom_complet']);
                    $cred = totalcredit($idele);
                    $bon = totalbonus($idele);
                    $mtr =  $bon - $cred;
                    $info = '<p><strong>DETAILS FINANCIERS DU FBO</strong></p>'
                            . 'Cumul des bonus : <strong>' . number_format($bon, 0, ',', ' ') . ' F</strong><br> '
                            . 'Cumul des crédits : <strong>' . number_format($cred, 0, ',', ' ') . ' F</strong><br>'
                            . 'Montant restant à payer : <strong>' . number_format($mtr, 0, ',', ' ') . ' F</strong>';
                    // on affiche les resultats dans un element de liste en ajoutant la fonction la fill sur l'evenenement onClick
                    echo '<li onClick="fillele(\'' . $nomsearch . '\');fillid(\'' . $idele . '\');fillinfo(\'' . $info . '\');">' . $l['code_distrib'] . '&nbsp;&nbsp;&nbsp;' . $l['nom_complet'] . '</li>';
                }
            } else {
                echo 'Ce FBO est introuvable.';
            }
        }
    }
} else {
    echo 'Il ne devrait pas avoir un accès direct à ce script !!!';
}