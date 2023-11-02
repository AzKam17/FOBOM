<?php

/*
 * Projet School Alerte
 * Designer et Entierement programmÃ© par Mr. Say-Halatte AYOLIE
 * Webmaster, Expert en developpement web et mobile
 * @HAXIS Cote d'Ivoire  * 
 */

$erreurs_a = array();
$erreurs_b = array();
$erreurs_c = array();
$erreurs_d = array();
$erreurs = array();

//$noteinput = array();
//$idbonus = array();
//$mtbonus = array();

if ($_SESSION['niveau'] == 1) {

    if (isset($_POST['noteinput']) && !empty($_POST['noteinput'])) {
        // On recupere les $_post du formulaire des notes

        include CHEMIN_MODELE . 'regularisation.inc.php';
        
        $user = $_SESSION['id'];

        $codeDistrib = $_POST['code'];
        $idcred = $_POST['idcred'];
        $mtcred = $_POST['mtcred'];


        $noteinput = $_POST['noteinput'];
        $idbonus = $_POST['idbonus'];
        $mtbonus = $_POST['montantbonus'];

        $nbr1 = count($noteinput);
        $nbr2 = count($idbonus);
        if ($nbr1 = $nbr2) {
            $cpt = $nbr1;
        }

        /*         * *******************Enregistrement de la note en bdd************ */

        for ($i = 0; $i < $cpt; $i++) {
            if ((isset($noteinput[$i]) AND isset($idbonus[$i])) OR ( !empty($noteinput[$i]) AND ! empty($idbonus[$i]))) { // si le montant est mentionné
                //$newmtcred = $mtcred ;
                if ($noteinput[$i] <= $mtbonus[$i]) {// On verifie que le montant saisie n'est pas superieur au montant du bonus
                    if ($noteinput[$i] <= $mtcred) {  //On verifie que le montant saisie n'est pas superieur au montant du credit
                       
                        $mtcredupdat = $mtcred - $noteinput[$i];
                        $mtbonupdat = $mtbonus[$i] - $noteinput[$i];
                        if ($mtcredupdat <= 0) {
                            regcreditFull($idcred, $mtcredupdat, $user, $noteinput[$i], $idbonus[$i]);
                        }
                        if ($mtcredupdat > 0) {
                            regcreditOnly($idcred, $mtcredupdat, $user, $noteinput[$i], $idbonus[$i]);
                        }

                        if ($mtbonupdat <= 0) {
                            regbonusFull($idbonus[$i], $mtbonupdat);
                        }
                        if ($mtbonupdat > 0) {
                            regbonusOnly($idbonus[$i], $mtbonupdat);
                        }

                        $mtcred = $mtcredupdat;
                    }
                }
            }
        }

        $erreurs_c = 'Les bonus designés ont été régularisé avec succes !';
        $erreurs_d = 'Le crédit et les bonus designés ont été mis à jour !';
        include 'modules/credit/listecredit.php';
    } else {
        //$codeDistrib = $_POST['code'];
        $erreurs_a = 'VEUILLEZ REGULARISER AU MOINS UN BONUS !!!';
        include 'modules/credit/listecredit.php';
    }
} else {
    $erreurs[] = 'Vous ne pouvez pas accéder à cette page!';
    include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
}

                  
