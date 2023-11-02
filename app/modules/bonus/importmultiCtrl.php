<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

ini_set('max_execution_time', 3600); // 1 heure = 3600
ini_set('memory_limit', '256M');

$erreurs_a = array();
$erreurs_b = array();
$erreurs_c = array();
$erreurs_d = array();

require('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
//use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

/**  Define a Read Filter class implementing IReadFilter  
class ChunkReadFilter implements IReadFilter {

    private $startRow = 0;
    private $endRow = 0;

    
     * We expect a list of the rows that we want to read to be passed into the constructor.
     *
     * @param mixed $startRow
     * @param mixed $chunkSize
     
    public function __construct($startRow, $chunkSize) {
        $this->startRow = $startRow;
        $this->endRow = $startRow + $chunkSize;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //  Only read the heading row, and the rows that were configured in the constructor
        if (($row == 1) || ($row >= $this->startRow && $row < $this->endRow)) {
            return true;
        }

        return false;
    }

}
**/
if (!utilisateur_est_connecte()) {
    // On affiche la page d'erreur comme quoi l'utilisateur doit être connecté pour voir la page
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';
} else {
    if (isset($_FILES['fichier']['name']) and $_SESSION['niveau'] == 1) {

        include CHEMIN_MODELE . 'bonus.inc.php';

        //Initialisation
        $fbosucces = 0;
        $fbofail = 0;

        $pays = $_SESSION['pays'];

        //On affecte le fichier a lire dans une variable temporaire
        $inputFileName = $_FILES['fichier']['tmp_name'];
        // Recuperation de l'extension du fichier
        $inputFileType = IOFactory::identify($inputFileName);
        // Create a new Reader of the type defined in $inputFileType
        $reader = IOFactory::createReader($inputFileType);
        $worksheetData = $reader->listWorksheetInfo($inputFileName);

        // Define how many rows we want for each "chunk"
        //$chunkSize = 500;

        // On lit les information de la feuille excel, nbre de ligne et colonne
        foreach ($worksheetData as $worksheet) {
            $rows = $worksheet['totalRows'];
            $colum = $worksheet['totalColumns'];
            if ($colum == 3) { // Compte Banquaire CIV
                // Loop to read our worksheet in "chunk size" blocks
                //for ($startRow = 1; $startRow <= $rows; $startRow += $chunkSize) {
                    // Create a new Instance of our Read Filter, passing in the limits on which rows we want to read
                    //$chunkFilter = new ChunkReadFilter($startRow, $chunkSize);
                    // Tell the Reader that we want to use the new Read Filter that we've just Instantiated
                    //$reader->setReadFilter($chunkFilter);
                    // Load only the rows that match our filter from $inputFileName to a PhpSpreadsheet Object
                    $spreadsheet = $reader->load($inputFileName);

                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                    //var_dump($sheetData);
                    /*                     * ********** Debut du traitement des donnees ****** */
                    foreach ($sheetData as $n) {
                        //On save dabord les informations sur les nvo fbo en db
                        if (ajoutcomptebanq($n['A'], $n['B'], $n['C'], $pays)) {
                            $fbosucces++;
                        } else {
                            if (updatecomptebanq($n['A'], $n['C'])) {
                                $fbofail++;
                            }
                        }
                    }
                //}

                $erreurs_d = ''.$fbosucces.' nouveau fbo crées et '.$fbofail.' comptes ajoutés sur un TOTAL de '.$rows.' lignes';
                include 'modules/bonus/bonusimpomulti.php';
            } elseif ($colum == 5) { // Comptes banquaire etranger
                // Loop to read our worksheet in "chunk size" blocks
                //for ($startRow = 1; $startRow <= $rows; $startRow += $chunkSize) {
                    // Create a new Instance of our Read Filter, passing in the limits on which rows we want to read
                    //$chunkFilter = new ChunkReadFilter($startRow, $chunkSize);
                    // Tell the Reader that we want to use the new Read Filter that we've just Instantiated
                    //$reader->setReadFilter($chunkFilter);
                    // Load only the rows that match our filter from $inputFileName to a PhpSpreadsheet Object
                    $spreadsheet = $reader->load($inputFileName);

                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                    //var_dump($sheetData);
                    /*                     * ********** Debut du traitement des donnees ****** */
                    foreach ($sheetData as $n) {
                        //On save dabord les informations sur les nvo fbo en db
                        if (ajoutcomptebanqetranger($n['A'], $n['B'], $n['C'], $n['D'], $n['E'], $pays)) {
                            $fbosucces++;
                        } else {
                            if (updatecomptebanqetranger($n['A'], $n['C'], $n['D'], $n['E'])) {
                                $fbofail++;
                            }
                        }
                    }
                //}

                $erreurs_d = ''.$fbosucces.' nouveau fbo crées et '.$fbofail.' comptes étrangés ajoutés sur un TOTAL de '.$rows.' lignes';
                include 'modules/bonus/bonusimpomulti.php';
            } else {
                $erreurs_a = 'Nombre de colonne du ficher incorrect.';
                include 'modules/bonus/bonusimpomulti.php';
            }
        }
    }
}

