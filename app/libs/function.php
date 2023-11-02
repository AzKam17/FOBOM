<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */


include('http://localhost/fobom/global/config.php');

function upload_image() {
    if (isset($_FILES["user_image"])) {
        $extension = explode('.', $_FILES['user_image']['name']);
        $new_name = rand() . '.' . $extension[1];
        $destination = './upload/' . $new_name;
        move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);
        return $new_name;
    }
}

function get_image_name($user_id) {
    include('db.php');
    $statement = $connection->prepare("SELECT image FROM users WHERE id = '$user_id'");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        return $row["image"];
    }
}

function get_total_all_records($iduser) {
    $connection = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
    $statement = $connection->prepare("SELECT SQL_CALC_FOUND_ROWS idfichier_bonus,nomfichier,nbredistrib,DATE_FORMAT(dateupload,'%d/%m/%Y') as dateup,mois,annee,code_pays
                                           FROM fichier_bonus 
                                           Where code_pays = '$iduser' ");
    $statement->execute();
    $result = $statement->rowCount();
    return $result;
}


