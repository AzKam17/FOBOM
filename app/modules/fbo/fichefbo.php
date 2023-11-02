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
    include CHEMIN_MODELE . 'fbo.inc.php';
    define('DOSSIER', 'img/fbo/');

    $codeDistrib = $_GET['id'];

    // detail du fbo
    $fbod = fbo_detail($codeDistrib);
    // liste des bonus et leur états du fbo
    $fbob = fbo_bonus_detail($codeDistrib);
    //Montant total des bonus restant a payer
    $mttotpayer = totalbonus($codeDistrib);
    //dossier photo fbo
    $nomImage1 = $codeDistrib . '.jpg';
    $fichier1 = DOSSIER . $nomImage1;
    $nomImage2 = $codeDistrib . '.png';
    $fichier2 = DOSSIER . $nomImage2;
    $nomImage3 = $codeDistrib . '.jpeg';
    $fichier3 = DOSSIER . $nomImage3;

    //Construction du fichier pdf 
    include CHEMIN_VUE . 'bordereau_fbo_vue.php';
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
    $erreurs[] = 'Vous ne pouvez pas accéder à cette page!';
    include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
}             
