<?php

/* 
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

$username = 'root';
$password = 'FobomAppRootPassword';
$db = 'foreverdb';
$connection = new PDO( 'mysql:host=mariadb;dbname='.$db.'', $username, $password );

