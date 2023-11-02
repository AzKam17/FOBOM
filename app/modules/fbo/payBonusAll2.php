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
//$paie_infos = array();

if ($_SESSION['niveau'] == 1) {
    // On recupere les $_post du formulaire des notes

    include CHEMIN_MODELE . 'paiement.inc.php';

    $codeDistrib = $_POST['code'];
    //$idbonus = $_POST['idbon'];
    //$nat = $_POST['nationalite'];
    $type = $_POST['element_8'];

    $mttotpayer = $_POST['mtbon'];

    // On verifie dabord l'etat des bonus à payer
    $etat_bonus = fbo_bonus_etats($codeDistrib);
    $cpterror = 0;
    foreach ($etat_bonus as $eb) {
        if ($eb['etat'] == 3) { // Si le bonus est en cours de paiment alors loperation est avorter
            $cpterror ++;
        }
    }

    if ($cpterror !== 0) { // Si le bonus est en cours de paiment alors loperation est avorter
        $erreurs_a = 'Vous ne pouvez pas effectuer cette opération sur ce bonus! Un des paiements est deja en cours';
        include 'modules/fbo/info_fbo.php';
    } else {

        //On determine quel type de paiement ordonné (Caisse ou Virement)

        if ($type == 1) { /*         * ******** Donc paiement a la caisse *** */

            foreach ($etat_bonus as $eb) {
                if ($idpaie = ajoutnvopaie($eb['idbonus'], $_SESSION['id'], $eb['montapayer'])) {
                    $paie_infos[] = bonus_paiement($idpaie);
                }
            }

            $info_fbo = bonus_paiement_fbo($codeDistrib);

            include CHEMIN_VUE . 'bordereau_pall_vue.php';
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
        } else { /*         * ** Alors paiement par ordre de virement *** */

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

                  
