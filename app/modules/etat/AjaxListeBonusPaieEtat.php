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

$dadeb = $_GET['queryDad'];
$dafin = $_GET['queryDaf'];
$typencaiss = $_GET['queryTyp'];
$typepai = $_GET['queryPaie'];
$typevire = $_GET['queryVire'];



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

//Si virement ou pas
if ($typevire == 0) {// Pas de virement
      
        if ($_GET['sSearch'] != "") {
            $sWhere = "WHERE (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai AND (" .
                    "b.fbo_code_distrib LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                    "f.nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                    "f.compte_banque LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                    "f.swift_code LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                    "f.email LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                    "f.ville LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%')";
        } else {

            $sWhere = "WHERE (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai";
        }

        $sQuery = " 
          SELECT SQL_CALC_FOUND_ROWS b.montapayer, p.mtfacture, b.fbo_code_distrib, b.mois, b.annee, p.datepaie, DATE_FORMAT(p.datepaie,'%d/%m/%Y a %Hh%m') as datpaie, f.nom_complet, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
          FROM paiement as p JOIN bonus as b JOIN fbo as f
          ON p.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib"
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
                SELECT COUNT(p.idpaiement)
                FROM paiement as p JOIN bonus as b JOIN fbo as f
                ON p.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
                WHERE (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai";
        $rResultTotal = mysqli_query($gaSql['link'], $sQuery) or
                die(mysqli_error($gaSql['link']));
        $aResultTotal = mysqli_fetch_array($rResultTotal);
        $iTotal = $aResultTotal[0];
  
} elseif ($typevire == 1) { //Virement national
    
    if ($_GET['sSearch'] != "") {
        $sWhere = "WHERE f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai AND (" .
                "b.fbo_code_distrib LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.compte_banque LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.swift_code LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.email LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.ville LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%')";
    } else {

        $sWhere = "WHERE f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai";
    }

    $sQuery = "
          SELECT SQL_CALC_FOUND_ROWS b.montapayer, p.mtfacture, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, p.datepaie, DATE_FORMAT(p.datepaie,'%d/%m/%Y a %Hh%m') as datpaie, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
          FROM paiement as p JOIN bonus as b JOIN fbo as f
          ON p.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib"
            . " $sWhere"
            . " $sOrder $sLimit";
    $rResult = mysqli_query($gaSql['link'], $sQuery) or
            die(mysqli_error($gaSql['link']));

    $sQuery = "SELECT FOUND_ROWS()";

    $rResultFilterTotal = mysqli_query($gaSql['link'], $sQuery) or
            die(mysqli_error($gaSql['link']));
    $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];

    $sQuery = " SELECT COUNT(p.idpaiement)
                FROM paiement as p JOIN bonus as b JOIN fbo as f
                ON p.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
                WHERE f.compte_banque <> 'NULL' AND f.nationalite = 'CIV' AND (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai";
    $rResultTotal = mysqli_query($gaSql['link'], $sQuery) or
            die(mysqli_error($gaSql['link']));
    $aResultTotal = mysqli_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
    
} else {// Virement international 
      
    if ($_GET['sSearch'] != "") {
        $sWhere = "WHERE f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai AND (" .
                "b.fbo_code_distrib LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.compte_banque LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.swift_code LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.email LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
                "f.ville LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%')";
    } else {

        $sWhere = "WHERE f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai";
    }

    $sQuery = "
          SELECT SQL_CALC_FOUND_ROWS b.montapayer, p.mtfacture, b.mois, b.annee, b.fbo_code_distrib, f.nom_complet, p.datepaie, DATE_FORMAT(p.datepaie,'%d/%m/%Y a %Hh%m') as datpaie, f.compte_banque, f.swift_code, f.email, f.ville, f.commune, f.quartier, f.nationalite
          FROM paiement as p JOIN bonus as b JOIN fbo as f
          ON p.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib"
            . " $sWhere"
            . " $sOrder $sLimit";
    $rResult = mysqli_query($gaSql['link'], $sQuery) or
            die(mysqli_error($gaSql['link']));

    $sQuery = "SELECT FOUND_ROWS()";

    $rResultFilterTotal = mysqli_query($gaSql['link'], $sQuery) or
            die(mysqli_error($gaSql['link']));
    $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];

    $sQuery = " SELECT COUNT(p.idpaiement) 
                FROM paiement as p JOIN bonus as b JOIN fbo as f
                ON p.bonus_idbonus = b.idbonus AND b.fbo_code_distrib = f.code_distrib
                WHERE f.compte_banque <> 'NULL' AND f.nationalite != 'CIV' AND (p.datepaie BETWEEN '$dadeb' AND '$dafin') AND b.etat = $typencaiss AND p.typepaie = $typepai";
    $rResultTotal = mysqli_query($gaSql['link'], $sQuery) or
            die(mysqli_error($gaSql['link']));
    $aResultTotal = mysqli_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
}

$sOutput = array('sEcho' => intval($_GET['sEcho']),
    'iTotalRecords' => $iTotal,
    'iTotalDisplayRecords' => $iFilteredTotal);
$aaData = array();

while ($aRow = mysqli_fetch_array($rResult)) {
    $tmp = array();
    $tmp[] = addslashes($aRow['fbo_code_distrib']);
    $tmp[] = addslashes(utf8_encode($aRow['nom_complet']));
    $tmp[] = addslashes(utf8_encode($aRow['datpaie']));
    $tmp[] = addslashes(utf8_encode(number_format($aRow['mtfacture'], 0, ',', ' ')));
    $tmp[] = addslashes(utf8_encode($aRow['mois']).'/'.utf8_encode($aRow['annee']));
    //$tmp[] = 'Cumul des bonus du '.$moisbonud.'/'.$annebonud.' au '.$moisbonuf.'/'.$annebonuf;

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
        return "datpaie";
    else if ($i == 3)
        return "mtfacture";
    else if ($i == 4)
        return "mois";
}
