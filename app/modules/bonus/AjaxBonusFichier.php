<?php

/* 
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Maitre d'ouvrage : KAM Corporate and Exchange Group
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */


// Definition du default timezone
date_default_timezone_set('Africa/Abidjan');

$erreurs = array();

$iduser = $_GET['queryId'];


/* MySQL connection */
$gaSql['user'] = "root";
$gaSql['password'] = "FobomAppRootPassword";
$gaSql['db'] = "foreverdb";
$gaSql['server'] = "p:mariadb";
$gaSql['type'] = "mysql";

$gaSql['link'] = mysqli_connect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
        die('Could not open connection to server');

mysqli_select_db($gaSql['link'],$gaSql['db']) or
        die('Could not select database ' . $gaSql['db']);

/* Paging */
$sLimit = "";
if (isset($_GET['iDisplayStart'])) {
    if ($_GET['iDisplayLength'] == -1) {

        $sLimit = "";
    } else {

        $sLimit = "LIMIT " . mysqli_real_escape_string($gaSql['link'],
                        $_GET['iDisplayStart']) . ", " .
                mysqli_real_escape_string($gaSql['link'],$_GET['iDisplayLength']);
    }
}

/* Ordering */
if (isset($_GET['iSortCol_0'])) {
    $sOrder = "ORDER BY ";
    for ($i = 0; $i < mysqli_real_escape_string(
                    $gaSql['link'],$_GET['iSortingCols']); $i++) {
        $sOrder .= fnColumnToField(mysqli_real_escape_string(
                                $gaSql['link'],$_GET['iSortCol_' . $i])) . "
" . mysqli_real_escape_string($gaSql['link'],$_GET['sSortDir_' . $i])
                . ", ";
    }
    $sOrder = substr_replace($sOrder, "", -2);
}

/* Filtrage - Remplace le filtrage côté client, peut donc être
  long si la base de données est importante
 */
$sWhere = "";
if ($_GET['sSearch'] != "") {
    $sWhere = "WHERE code_pays = $iduser AND (" .
            "nomfichier LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "nbredistrib LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "dateupload LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "' OR " .
            "mois LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "' OR " .
            "annee LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "')";
} else {
   
    $sWhere = "WHERE code_pays = $iduser"; 
}

$sQuery = "
    SELECT SQL_CALC_FOUND_ROWS idfichier_bonus,nomfichier,nbredistrib,DATE_FORMAT(dateupload,'%d/%m/%Y') as dateup,mois,annee,code_pays
        FROM fichier_bonus "
        . "$sWhere"
        . " $sOrder $sLimit
    ";
$rResult = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));

$sQuery = "SELECT FOUND_ROWS()";

$rResultFilterTotal = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

$sQuery = "     SELECT COUNT(idfichier_bonus) 
                FROM fichier_bonus
                WHERE code_pays = $iduser ";
$rResultTotal = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));
$aResultTotal = mysqli_fetch_array($rResultTotal);
$iTotal = $aResultTotal[0];

$sOutput = array('sEcho' => intval($_GET['sEcho']),
    'iTotalRecords' => $iTotal,
    'iTotalDisplayRecords' => $iFilteredTotal);
$aaData = array();

while ($aRow = mysqli_fetch_array($rResult)) {
    $tmp = array();
    $tmp[] = addslashes($aRow['nomfichier']);
    $tmp[] = addslashes(utf8_encode($aRow['nbredistrib']));
    $tmp[] = addslashes(utf8_encode($aRow['dateup']));
    $tmp[] = addslashes(utf8_encode($aRow['mois']));
    $tmp[] = addslashes($aRow['annee']);
    $tmp[] = ' <a href="index.php?module=bonus&action=info_fich&idfich=' . $aRow['idfichier_bonus'] . '" ><button title="detail fichier" class="btn btn-primary btn-social-icon btn-sm" type="button"><i class="fa fa-arrow-circle-right"></i> </button></a> '
            . '<a href="index.php?module=bonus&action=suppr_fich&idfich=' . $aRow['idfichier_bonus'] . '"><button title="Supprimer fichier" class="btn btn-danger btn-social-icon btn-sm" type="button"><i class="fa fa-trash"></i> </button></a>';

    $aaData[] = $tmp;
}
$sOutput['aaData'] = $aaData;

echo json_encode($sOutput);

function fnColumnToField($i) {
    if ($i == 0)
        return "nomfichier";
    else if ($i == 1)
        return "nbredistrib";
    else if ($i == 2)
        return "dateup";
    else if ($i == 3)
        return "mois";
    else if ($i == 4)
        return "annee";
}