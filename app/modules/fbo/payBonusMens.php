<?php

/*
 * Projet School Alerte
 * Designer et Entierement programmÃ© par Mr. Say-Halatte AYOLIE
 * Webmaster, Expert en developpement web et mobile
 * @HAXIS Cote d'Ivoire  * 
 */

ob_start();

$erreurs_a = array();
$erreurs_b = array();
$erreurs_c = array();
$erreurs_d = array();
$erreurs = array();

if ($_SESSION['niveau'] == 1) {
    // On recupere les $_post du formulaire des notes

    include CHEMIN_MODELE . 'paiement.inc.php';

    $codeDistrib = $_POST['code'];
    $idbonus = $_POST['idbon'];
    $nat = $_POST['nationalite'];
    $type = $_POST['element_8'];

    // On determine quel montant a payer
    if (empty($_POST['noteinput'])) {//SI vide ou non set le montant a payer est le montant total du bonus
        $reste = 0;
        $mtapayer = $_POST['mtbon'];
    } else { //Sinon le montant a payer est le montant renseigné dans le champs
        $reste = $_POST['mtbon'] - $_POST['noteinput'];
        $mtapayer = $_POST['noteinput'];
    }

    // On verifie dabord l'etat du bonus
    $etat_bonus = fbo_bonus_etat($codeDistrib, $idbonus);
    if ($etat_bonus == 3) { // Si le bonus est en cours de paiment alors loperation est avorter
        $erreurs_a = 'Vous ne pouvez pas effectuer cette opération sur ce bonus! Un paiement est deja en cours';
        include 'modules/fbo/info_fbo.php';
    } elseif ($reste < 0) { // Sinon si le montant saisi est superieur au montant du bonus
        $erreurs_a = 'Vous ne pouvez pas payer un montant superieur au bonus !';
        include 'modules/fbo/info_fbo.php';
    } else {
        //On determine quel type de paiement ordonné (Caisse ou Virement)
        if ($type == 1) { /*         * * Donc paiement a la caisse ** */

            if ($idpaie = ajoutnvopaie($idbonus, $_SESSION['id'], $mtapayer)) {
                include CHEMIN_MODELE . 'caisse.inc.php';
                $paie_infos = bonus_paie($idpaie);
                include CHEMIN_VUE . 'bordereau_paie_vue.php';
                $content = ob_get_clean();
                // convert to PDF
                require_once 'html2pdf_v4.03/html2pdf.class.php';
                try {
                    $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 3);
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                    ob_end_clean();
                    $html2pdf->Output('bordereau_de_paiement.pdf');
                } catch (HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }
            } else {
                $erreurs_a = 'Erreur de paiement du bonus!';
                include 'modules/fbo/info_fbo.php';
            }
        } else { /*         * * Alors paiement par ordre de virement ** */

            if (empty($_POST['charge'])) {// On determine quel charge payer. La charge existe automatiquement lorsqu'il sagit dun virement
                $charg = 1000;
            } else {
                $charg = $_POST['charge'];
            }

            if (ajoutnvovirement($idbonus, $_SESSION['id'], $mtapayer, $charg)) {
                $erreurs_d = 'Le virement du bonus a été ordornné avec succes !';
                include 'modules/fbo/info_fbo.php';
            } else {
                $erreurs_a = 'Erreur de virement du bonus!';
                include 'modules/fbo/info_fbo.php';
            }
        }
    }
} else {
    $erreurs[] = 'Vous ne pouvez pas accéder à cette page!';
    include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
}

                  
