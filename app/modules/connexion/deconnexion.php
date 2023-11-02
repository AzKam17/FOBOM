<?php
// Suppression de toutes les variables et destruction de la session
$_SESSION = array();
session_unset();
session_destroy();
include CHEMIN_VUE.'deconnexionVue.php';