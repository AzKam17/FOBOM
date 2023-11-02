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

$moisbonu = $_GET['queryMois'];
$annebonu = $_GET['queryYear'];


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
    $sWhere = "WHERE b.mois = $moisbonu AND b.annee = $annebonu AND f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (b.etat = 0 OR b.etat = 2) AND (" .
            "b.fbo_code_distrib LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.compte_banque LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.swift_code LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.email LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.ville LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%')";
} else {
   
    $sWhere = "WHERE b.mois = $moisbonu AND b.annee = $annebonu AND f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (b.etat = 0 OR b.etat = 2)"; 
}

$sQuery = "
          SELECT SQL_CALC_FOUND_ROWS b.idbonus, b.montapayer, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
          FROM bonus as b JOIN fbo as f
          ON b.fbo_code_distrib = f.code_distrib "
        . "$sWhere"
        . " $sOrder $sLimit";
$rResult = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));

$sQuery = "SELECT FOUND_ROWS()";

$rResultFilterTotal = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

$sQuery = "     SELECT COUNT(b.fbo_code_distrib) 
                FROM bonus as b JOIN fbo as f
                ON b.fbo_code_distrib = f.code_distrib
                WHERE b.mois = $moisbonu AND b.annee = $annebonu AND f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (b.etat = 0 OR b.etat = 2) 
                 ";
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
    $tmp[] = addslashes($aRow['fbo_code_distrib']);
    $tmp[] = addslashes(utf8_encode($aRow['nom_complet']));
    $tmp[] = addslashes(utf8_encode($aRow['compte_banque']));
    $tmp[] = addslashes(utf8_encode($aRow['swift_code']));
    $tmp[] = addslashes(utf8_encode(number_format($aRow['montapayer'], 0, ',', ' ')));
    $tmp[] = addslashes(utf8_encode($aRow['nationalite']));
    $tmp[] = addslashes(utf8_encode($aRow['mois']).'/'.utf8_encode($aRow['annee']));
    
    $aaData[] = $tmp;
}
$sOutput['aaData'] = $aaData;

echo json_encode($sOutput);

function fnColumnToField($i) {
    if ($i == 0)
        return "fbo_code_distrib";
    else if ($i == 1)
        return "nom_complet";
    else if ($i == 2)
        return "compte_banque";
    else if ($i == 3)
        return "swift_code";
    else if ($i == 4)
        return "montapayer";
    else if ($i == 5)
        return "nationalite";
    else if ($i == 6)
        return "mois";
}