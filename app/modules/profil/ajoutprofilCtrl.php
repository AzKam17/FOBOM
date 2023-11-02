<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : Ing AYOLIE Say-halatte Stivell and KAM Corporate
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

if (!utilisateur_est_connecte()) {
    // On affiche la page d'erreur comme quoi l'utilisateur doit être connecté pour voir la page
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';
} else {

    include \CHEMIN_MODELE . 'info.inc.php';

    // Nettoyage des donnees de champs
    $erreurs = array();
    $erreurs_a = array();
    $erreurs_b = array();
    $erreurs_c = array();
    $erreurs_d = array();

    if (!empty($_POST['element_2']) and ! empty($_POST['element_4']) and ! empty($_POST['element_5'])) {

        //On recupere les donnes du formulaire
        $post = $_POST['element_1'];
        $civil = nettoyer($post);
        $post = $_POST['element_2'];
        $nom = nettoyer($post);
        $post = $_POST['element_3'];
        $prenom = nettoyer($post);
        $post = $_POST['element_4'];
        $user = nettoyer($post);
        $post = $_POST['element_5'];
        $pass = nethash($post);
        $post = $_POST['element_6'];
        $titre = nettoyer($post);
        $post = $_POST['element_7'];
        $niveau = nettoyer($post);

        $pays = $_SESSION['pays'];

        // Enregistrement de la photo de leleve 
        if (!empty($_FILES['fichier']['name'])) { // On verifie si le champ est rempli
            // Constantes
            define('TARGET', 'img/admin/');  // Repertoire cible
            define('MAX_SIZE', 10000);    // Taille max en octets du fichier
            define('WIDTH_MAX', 200);    // Largeur max de l'image en pixels
            define('HEIGHT_MAX', 200);    // Hauteur max de l'image en pixels
            // Tableaux de donnees
            $tabExt = array('jpg', 'jpeg', 'png');    // Extensions autorisees
            $infosImg = array();

            // Variables
            $extension = '';
            $nomImage = '';

            /*             * *********************************************************
             * Creation du repertoire cible si inexistant
             * *********************************************************** */
            if (!is_dir(TARGET)) {
                if (!mkdir(TARGET, 0755)) {
                    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous disposez des droits suffisants pour le faire ou créez le manuellement !');
                }
            }

            /*             * *******************************************************
             * Script d'upload
             * ********************************************************* */
            // Recuperation de l'extension du fichier
            $extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
            // On verifie l'extension du fichier
            if (in_array(strtolower($extension), $tabExt)) {
                // On recupere les dimensions du fichier
                $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

                // On verifie le type de l'image
                if ($infosImg[2] >= 1 && $infosImg[2] <= 14) {
                    // On verifie les dimensions et taille de l'image
                    if (($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE)) {
                        // Parcours du tableau d'erreurs
                        if (isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error']) {
                            // ajout dans la base de donnees du nvelle admin et recuperation de son nouvelle id 
                            if ($fbo = ajoutuser($pays, $nom, $prenom, $user, $pass, $titre, $niveau, $civil)) {
                                // On renomme le fichier
                                $nomImage = $fbo . '.' . $extension;
                                //dossier ancienne photo fbo
                                $nomImage1 = $fbo . '.jpg';
                                $fichier1 = TARGET . $nomImage1;
                                $nomImage2 = $fbo . '.png';
                                $fichier2 = TARGET . $nomImage2;
                                $nomImage3 = $fbo . '.jpeg';
                                $fichier3 = TARGET . $nomImage3;
                                // On efface les anciennes images du fbo
                                if (is_file($fichier1)) {
                                    unlink($fichier1);
                                }
                                if (is_file($fichier2)) {
                                    unlink($fichier2);
                                }
                                if (is_file($fichier3)) {
                                    unlink($fichier3);
                                }
                                if (move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET . $nomImage)) {
                                    
                                    // On affiche la confirmation
                                    $erreurs_d = 'L\'administrateur a été crée avec succes et la photo de profil uploader';
                                    include 'modules/profil/listeprofil.php';
                                } else {
                                    
                                    // Sinon on affiche une erreur systeme
                                    $erreurs_d = 'L\'administrateur a été crée avec succes';
                                    $erreurs_b = 'Mais erreur lors de l\'upload de la photo de profil';
                                    include 'modules/profil/listeprofil.php';
                                }
                            } else {
                                
                                //Si il y a un probleme en base de donnees 
                                $sms = '<b>Erreur</b> lors de la création de l\'administrateur.';
                                $alert = htmlentities($sms, ENT_QUOTES);
                                $erreurs_a = html_entity_decode($alert);
                                include 'modules/profil/listeprofil.php';
                            }
                        } else {
                            
                            //Sinon erreur de permission apache
                            $sms = 'Une <b>erreur interne</b> a empêché l\'uplaod de l\'image';
                            $alert = htmlentities($sms, ENT_QUOTES);
                            $erreurs_a = html_entity_decode($alert);
                            include 'modules/profil/listeprofil.php';
                        }
                    } else {
                        
                        // Sinon erreur sur les dimensions et taille de l'image
                        $sms = 'Erreur dans les <b>dimensions de l\'image</b> !';
                        $alert = htmlentities($sms, ENT_QUOTES);
                        $erreurs_a = html_entity_decode($alert);
                        include 'modules/profil/listeprofil.php';
                    }
                } else {
                    
                    // Sinon erreur sur le type de l'image
                    $sms = 'Le <b>fichier</b> à uploader n\'est pas une image !';
                    $alert = htmlentities($sms, ENT_QUOTES);
                    $erreurs_a = html_entity_decode($alert);
                    include 'modules/profil/listeprofil.php';
                }
            } else {
                
                // Sinon on affiche une erreur pour l'extension
                $sms = 'L\'<b>extension</b> du fichier est incorrecte !';
                $alert = htmlentities($sms, ENT_QUOTES);
                $erreurs_a = html_entity_decode($alert);
                include 'modules/profil/listeprofil.php';
            }
        } else {

            // ajout de ladministrateur dans la base de données 
            if (ajoutuser($pays, $nom, $prenom, $user, $pass, $titre, $niveau, $civil)) {

                //inclut la vue pop up de confirmation confirmationVue
                $erreurs_d = 'L\' administrateur a été crée avec succes';
                include 'modules/profil/listeprofil.php';
            } else {
                $sms = '<b>Erreur</b> lors de la création de l\' administrateur.';
                $alert = htmlentities($sms, ENT_QUOTES);
                $erreurs_a = html_entity_decode($alert);
                include 'modules/profil/listeprofil.php';
            }
        }
    } else {
        $erreurs_a = 'Veuillez remplir les champs obligatoires!';
        include 'modules/profil/listeprofil.php';
    }
}