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

//$iduser = $_GET['queryId'];


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
    $sWhere = "WHERE p.etat = 0 AND p.typepaie = 1 AND b.etat = 3 AND (" .
            "p.idpaiement LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "p.mtfacture LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "b.mois LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "p.datepaie LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "b.annee LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%')";
} else {
   
    $sWhere = "WHERE p.etat = 0 AND p.typepaie = 1 AND b.etat = 3"; 
}

$sQuery = "
          SELECT SQL_CALC_FOUND_ROWS p.idpaiement, p.bonus_idbonus, CONCAT(b.mois,'-',b.annee) as periode, b.montapayer, p.utilisateur_idutilisateur, CONCAT(u.civilite,' ',u.nom,' ',u.prenom) as operateur, p.datepaie, DATE_FORMAT(p.datepaie,'%d/%m/%Y a %Hh%m') as datpaie, p.etat, p.mtfacture, p.charge, p.typepaie, p.idcaissier
          FROM paiement as p JOIN bonus as b JOIN utilisateur as u
          ON p.bonus_idbonus = b.idbonus AND p.utilisateur_idutilisateur = u.idutilisateur "
        . "$sWhere"
        . " $sOrder $sLimit";
$rResult = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));

$sQuery = "SELECT FOUND_ROWS()";

$rResultFilterTotal = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

$sQuery = "     SELECT COUNT(p.idpaiement) 
                FROM paiement as p JOIN bonus as b
                ON p.bonus_idbonus = b.idbonus
                WHERE p.etat = 0 AND p.typepaie = 1 AND b.etat = 3 ";
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
    $tmp[] = addslashes($aRow['idpaiement']);
    $tmp[] = addslashes(utf8_encode(number_format($aRow['mtfacture'], 0, ',', ' ')));
    $tmp[] = addslashes(utf8_encode($aRow['periode']));
    $tmp[] = addslashes(utf8_encode($aRow['datpaie']));
    $tmp[] = addslashes(utf8_encode($aRow['operateur']));
    $tmp[] = '<a href="index.php?module=caisse&action=info_paie&id=' . $aRow['idpaiement'] . '" ><button title="detail du paiement" class="btn btn-primary btn-social-icon btn-sm" type="button"><i class="fa fa-arrow-circle-right"></i> </button></a>';

    $aaData[] = $tmp;
}
$sOutput['aaData'] = $aaData;

echo json_encode($sOutput);

function fnColumnToField($i) {
    if ($i == 0)
        return "idpaiement";
    else if ($i == 1)
        return "mtfacture";
    else if ($i == 2)
        return "periode";
    else if ($i == 3)
        return "datpaie";
    else if ($i == 4)
        return "operateur";
}