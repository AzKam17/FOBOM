<?php
				
// Utilisation et démarrage des sessions
session_start();

// Cacher les erreurs PHP 
//ini_set('display_errors',0);
//error_reporting(0);

// Definition du default timezone
date_default_timezone_set('Africa/Abidjan');

//global $erreurs, $erreurs_a, $erreurs_b, $erreurs_c, $erreurs_d;
global $selected, $under_selected ;

// Inclusion du fichier de configuration (qui définit des constantes)
include 'global/config.php';
include 'modeles/notification.php';

//-----------------------------------------------------------------------------------------------
// création de la gestion des dates 
    $jour = array("dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi");
	$mois = array("","janvier","fevrier","mars","avril","mai","juin","juillet","aout","septembre","octobre","novembre","decembre");
	$datefr = $jour[date("w")]." ".date("d")." ".$mois[date("n")]." ".date("Y");
        $line='<br/>';
	$par= ' :';
	$espace="  ";
	$tiret="-";
	$nul=0;
	$localisation ='Abidjan';
	$erreurs = array();
	$month_conv = array('janvier' => '1','fevrier' => '2','mars' => '3','avril' => '4','mai' => '5',
				'juin' => '6','juillet' => '7','aout'=> '8','septembre' =>'9',
				'octobre' => '10','novembre' => '11','decembre' => '12') ;
//tableau pour la gestion des messages ou erreurs
$erreurs_a = array();

// Vérifie si l'utilisateur est connecté 
    function utilisateur_est_connecte() { 
        return !empty($_SESSION['id']);
    }

// Désactivation des guillemets magiques
ini_set('magic_quotes_runtime', 0);
if (1 == get_magic_quotes_gpc()){
        function remove_magic_quotes_gpc(&$value) {
		
         $value = stripslashes($value);
        }
     array_walk_recursive($_GET, 'remove_magic_quotes_gpc');
     array_walk_recursive($_POST, 'remove_magic_quotes_gpc');
     array_walk_recursive($_COOKIE, 'remove_magic_quotes_gpc');
    }
// Inclusion de Pdo2, potentiellement utile partout
include CHEMIN_LIB.'pdo2.php';
