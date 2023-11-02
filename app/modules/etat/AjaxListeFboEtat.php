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
    $sWhere = "WHERE pays_idpays = $iduser AND supprimer = 0 AND (" .
            "code_distrib LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "statut_fbo LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "' OR " .
            "compte_banque LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "')";
} else {
   
    $sWhere = "WHERE pays_idpays = $iduser AND supprimer = 0"; 
}

$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS code_distrib, nom_complet, statut_fbo, compte_banque, mobile, email, commune, ville ,quartier, addresse, nationalite
        FROM fbo "
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

$sQuery = "     SELECT COUNT(code_distrib) 
                FROM fbo
                WHERE pays_idpays = $iduser AND supprimer = 0 ";
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
    $tmp[] = addslashes(utf8_encode($aRow['code_distrib']));
    $tmp[] = addslashes(utf8_encode($aRow['nom_complet']));
    $tmp[] = addslashes(utf8_encode($aRow['statut_fbo']));
    $tmp[] = addslashes(utf8_encode($aRow['compte_banque']));
    $tmp[] = addslashes(utf8_encode($aRow['mobile']));
    $tmp[] = addslashes(utf8_encode($aRow['email']));
    $tmp[] = addslashes(utf8_encode($aRow['ville']));
    $tmp[] = addslashes(utf8_encode($aRow['commune']));
    $tmp[] = addslashes(utf8_encode($aRow['quartier']));
    $tmp[] = addslashes(utf8_encode($aRow['addresse']));
    $tmp[] = addslashes(utf8_encode($aRow['nationalite']));
    $aaData[] = $tmp;
}
$sOutput['aaData'] = $aaData;

echo json_encode($sOutput);

function fnColumnToField($i) {
    if ($i == 0)
        return "code_distrib";
    else if ($i == 1)
        return "nom_complet";
    else if ($i == 2)
        return "statut_fbo";
    else if ($i == 3)
        return "compte_banque";
    else if ($i == 4)
        return "mobile";
    else if ($i == 5)
        return "email";
    else if ($i == 6)
        return "ville";
    else if ($i == 7)
        return "commune";
    else if ($i == 8)
        return "quartier";
    else if ($i == 9)
        return "addresse";
    else if ($i == 10)
        return "nationalite";
}