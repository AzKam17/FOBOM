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
    $sWhere = "WHERE f.pays_idpays = $iduser AND  u.etat IN (0,1) AND (" .
            "u.numcheque LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.typecheque LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.datecheq LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "' OR " .
            "u.datecheque LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "' OR " .
            "u.mtcheque LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR ".
            "u.etat LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR ".
            "f.nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "')";
} else {
   
    $sWhere = "WHERE f.pays_idpays = $iduser AND  u.etat IN (0,1)"; 
}

$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS  u.numcheque, u.typecheque, u.datecheque, DATE_FORMAT(u.datecheque,'%d/%m/%Y') as datecheq, u.mtcheque, u.etat, f.nom_complet
        FROM cheque as u JOIN credit as c JOIN fbo as f
        ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib "
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

$sQuery = "     SELECT COUNT(u.numcheque) 
                FROM cheque as u JOIN credit as c JOIN fbo as f
                WHERE f.pays_idpays = $iduser AND  u.etat IN (0,1) ";
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
    $tmp[] = addslashes($aRow['numcheque']);
    $tmp[] = addslashes(utf8_encode($aRow['typecheque']));
    $tmp[] = addslashes(utf8_encode($aRow['mtcheque']));
    $tmp[] = addslashes(utf8_encode($aRow['datecheq']));
    $tmp[] = addslashes($aRow['etat']);
    $tmp[] = '<a href="index.php?module=credit&action=endosse&idfich=' . $aRow['numcheque'] . '" ><button title="Endossé le chèque" class="btn btn-success btn-social-icon btn-sm" type="button"><i class="fa fa-arrow-circle-right"></i> </button></a> '
            . ' <a href="index.php?module=credit&action=modif_cheque&idfich=' . $aRow['numcheque'] . '" ><button title="modifier le chèque" class="btn btn-primary btn-social-icon btn-sm" type="button"><i class="fa fa-pencil"></i> </button></a> '
            . '<a href="index.php?module=credit&action=suppr_cheque&idfich=' . $aRow['numcheque'] . '"><button title="Supprimer le chèque" class="btn btn-danger btn-social-icon btn-sm" type="button"><i class="fa fa-trash"></i> </button></a>';

    $aaData[] = $tmp;
}
$sOutput['aaData'] = $aaData;

echo json_encode($sOutput);

function fnColumnToField($i) {
    if ($i == 0)
        return "numcheque";
    else if ($i == 1)
        return "typecheque";
    else if ($i == 2)
        return "mtcheque";
    else if ($i == 3)
        return "datecheq";
    else if ($i == 4)
        return "etat";
}