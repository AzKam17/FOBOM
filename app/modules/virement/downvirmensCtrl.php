<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

ini_set('max_execution_time', 900); // 1 heure = 3600

$erreurs_a = array();
$erreurs_b = array();
$erreurs_c = array();
$erreurs_d = array();

require('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (!utilisateur_est_connecte()) {
    // On affiche la page d'erreur comme quoi l'utilisateur doit être connecté pour voir la page
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';
} else {

    if ($_SESSION['niveau'] == 1) {
        // On recupere les $_post du formulaire
        $mois = $_POST['moi'];
        $annee = $_POST['ann'];

        include CHEMIN_MODELE . 'virement.inc.php';

        $listvir = liste_vire_cour_nat_mens($mois, $annee);

        if (empty($listvir)) {//SI les tableau est vide dc on ne peut pas ordonner de virement
            $erreurs_a = 'Vous ne pouvez pas effectuer cette opération ! Aucun virement possible';
            include 'modules/virement/virecourchoix.php';
        } else {
            /*             * * Alors telechargement du fichier excel * * */

            // Create new Spreadsheet object
            $spreadsheet = new Spreadsheet();

            // Set document properties
            $spreadsheet->getProperties()->setCreator('Forever Living')
                    ->setTitle('FICHIER BANQUE Office 2007 XLSX')
                    ->setSubject('Fichier Banque Office 2007 XLSX')
                    ->setDescription('Fichier excel de virement banquaire, destiné au logiciel de paiement.')
                    ->setKeywords('Banque')
                    ->setCategory('Banque');

            // Add some data
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Debit Account Number');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Beneficiary Name');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Beneficiary Account');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Payment Amount');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Customer Reference');
            $spreadsheet->getActiveSheet()->setCellValue('F1', 'Payment Details Line 1');

            $baseRow = 2;
            foreach ($listvir as $r => $dataRow) {
                $row = $baseRow + $r;
                $spreadsheet->getActiveSheet()->insertNewRowBefore($row, 1);

                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, '0100100135900')
                        ->setCellValue('B' . $row, $dataRow['nom_complet'])
                        ->setCellValue('C' . $row, $dataRow['compte_banque'])
                        ->setCellValue('D' . $row, $dataRow['mtfacture'])
                        ->setCellValue('E' . $row, $dataRow['fbo_code_distrib'])
                        ->setCellValue('F' . $row, 'VIREMENT BONUS DU ' . $dataRow['mois'] . '/' . $dataRow['annee']);
            }
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="FICHIER_BANQUE_' . $mois . '/' . $annee . '.xlsx"');
            header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 2018 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
            $erreurs_d = 'Fichier banquaire nationaux mensuel du ' . $mois . '/' . $annee . ' téléchargé avec succes';
            include 'modules/virement/virecourchoix.php';
        }
    } else {
        $erreurs[] = 'Vous ne pouvez pas accéder à cette page!';
        include CHEMIN_VUE_GLOBALE . 'stop_vue.php';
    }
}

