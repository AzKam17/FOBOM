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

$datcredeb = $_GET['queryD'];
$datcredin = $_GET['queryF'];
$type = $_GET['queryTyp'];



/* MySQL connection */
$gaSql['user'] = "root";
$gaSql['password'] = "FobomAppRootPassword";
$gaSql['db'] = "foreverdb";
$gaSql['server'] = "p:mariadb";
$gaSql['type'] = "mysql";

$gaSql['link'] = mysqli_connect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
        die('Could not open connection to server');

mysqli_select_db($gaSql['link'], $gaSql['db']) or
        die('Could not select database ' . $gaSql['db']);

/* Paging */
$sLimit = "";
if (isset($_GET['iDisplayStart'])) {
    if ($_GET['iDisplayLength'] == -1) {

        $sLimit = "";
    } else {

        $sLimit = "LIMIT " . mysqli_real_escape_string($gaSql['link'], $_GET['iDisplayStart']) . ", " .
                mysqli_real_escape_string($gaSql['link'], $_GET['iDisplayLength']);
    }
}

/* Ordering */
if (isset($_GET['iSortCol_0'])) {
    $sOrder = "ORDER BY ";
    for ($i = 0; $i < mysqli_real_escape_string(
                    $gaSql['link'], $_GET['iSortingCols']); $i++) {
        $sOrder .= fnColumnToField(mysqli_real_escape_string(
                                $gaSql['link'], $_GET['iSortCol_' . $i])) . "
" . mysqli_real_escape_string($gaSql['link'], $_GET['sSortDir_' . $i])
                . ", ";
    }
    $sOrder = substr_replace($sOrder, "", -2);
}

/* Filtrage - Remplace le filtrage côté client, peut donc être
  long si la base de données est importante
 */
$sWhere = "";


if ($_GET['sSearch'] != "") {
    $sWhere = "WHERE (u.datecheque BETWEEN '$datcredeb' AND '$datcredin') AND u.etat = $type AND (" .
            "u.numcheque LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.typecheque LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.datechequet LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "' OR " .
            "u.dateretour LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "' OR " .
            "u.datedepotbanque LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.mtcheque LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.code_distrib LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.motif LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "')";
} else {

    $sWhere = "WHERE (u.datecheque BETWEEN '$datcredeb' AND '$datcredin') AND u.etat = $type";
}

$sQuery = " 
            SELECT SQL_CALC_FOUND_ROWS u.numcheque, u.typecheque, u.datecheque, DATE_FORMAT(u.datecheque,'%d/%m/%Y') as datecheq, u.dateretour, DATE_FORMAT(u.dateretour,'%d/%m/%Y') as datecheqr, u.datedepotbanque, DATE_FORMAT(u.datedepotbanque,'%d/%m/%Y') as datecheqd, u.mtcheque, u.etat, u.motif, u.credit_idcredit, f.nom_complet, f.code_distrib
            FROM cheque as u JOIN credit as c JOIN fbo as f
            ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib"
        . " $sWhere"
        . " $sOrder"
        . " $sLimit";
$rResult = mysqli_query($gaSql['link'], $sQuery) or
        die(mysqli_error($gaSql['link']));

$sQuery = "SELECT FOUND_ROWS()";

$rResultFilterTotal = mysqli_query($gaSql['link'], $sQuery) or
        die(mysqli_error($gaSql['link']));
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

$sQuery = "
            SELECT COUNT(u.numcheque) 
            FROM cheque as u JOIN credit as c JOIN fbo as f
            ON u.credit_idcredit = c.idcredit AND c.fbo_code_distrib = f.code_distrib
            WHERE (u.datecheque BETWEEN '$datcredeb' AND '$datcredin') AND u.etat = $type";
$rResultTotal = mysqli_query($gaSql['link'], $sQuery) or
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
    $tmp[] = addslashes(number_format($aRow['mtcheque'], 0, ',', ' '));
    $tmp[] = addslashes(utf8_encode($aRow['datecheq']));
    $tmp[] = addslashes(utf8_encode($aRow['datecheqd']));
    $tmp[] = addslashes(utf8_encode($aRow['datecheqr']));
    $tmp[] = addslashes(utf8_encode($aRow['motif']));
    $tmp[] = addslashes($aRow['code_distrib']);
    $tmp[] = addslashes($aRow['nom_complet']);

    $aaData[] = $tmp;
}
$sOutput['aaData'] = $aaData;

echo json_encode($sOutput);

function fnColumnToField($i) {
    if ($i == 0)
        return "numcheque";
    else if ($i == 1)
        return "mtcheque";
    else if ($i == 2)
        return "datecheq";
    else if ($i == 3)
        return "datecheqd";
    else if ($i == 4)
        return "datecheqr";
    else if ($i == 5)
        return "motif";
    else if ($i == 6)
        return "code_distrib";
    else if ($i == 7)
        return "nom_complet";
}
