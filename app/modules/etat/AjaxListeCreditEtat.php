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
$typerembo = $_GET['queryRem'];



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
    $sWhere = "WHERE (c.datecredit BETWEEN '$datcredeb' AND '$datcredin') AND c.etat = $type AND c.typerembour = $typerembo AND (" .
            "c.idcredit LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "t.libelle LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "c.mtcredit LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "' OR " .
            "c.datecredit LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "' OR " .
            "c.motif_idmotif LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "c.etat LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "c.fbo_code_distrib LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "f.statut_fbo LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.nom LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.prenom LIKE '%" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "%' OR " .
            "u.titre LIKE '" . mysqli_real_escape_string($gaSql['link'], utf8_decode($_GET['sSearch'])) . "')";
} else {

    $sWhere = "WHERE (c.datecredit BETWEEN '$datcredeb' AND '$datcredin') AND c.etat = $type AND c.typerembour = $typerembo";
}

$sQuery = " 
            SELECT SQL_CALC_FOUND_ROWS c.idcredit, c.motif_idmotif, t.libelle, c.mtcredit, c.datecredit, DATE_FORMAT(c.datecredit,'%d/%m/%Y') as datcred, c.etat, c.typerembour, c.utilisateur_idutilisateur,c.fbo_code_distrib, f.nom_complet, f.compte_banque, f.statut_fbo, f.mobile, CONCAT(u.civilite,' ',u.nom,' ',u.prenom) as operateur, u.titre, q.numcheque, q.typecheque, DATE_FORMAT(q.datecheque,'%d/%m/%Y') as datcheq, q.mtcheque
            FROM utilisateur as u JOIN credit as c JOIN cheque as q JOIN motif as t JOIN fbo as f
            ON u.idutilisateur = c.utilisateur_idutilisateur AND c.motif_idmotif = t.idmotif AND c.idcredit = q.credit_idcredit AND c.fbo_code_distrib = f.code_distrib"
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
            SELECT COUNT(c.idcredit) 
            FROM utilisateur as u JOIN credit as c JOIN cheque as q JOIN motif as t JOIN fbo as f
            ON u.idutilisateur = c.utilisateur_idutilisateur AND c.motif_idmotif = t.idmotif AND c.idcredit = q.credit_idcredit AND c.fbo_code_distrib = f.code_distrib
            WHERE (c.datecredit BETWEEN '$datcredeb' AND '$datcredin') AND c.etat = $type AND c.typerembour = $typerembo";
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
    $tmp[] = addslashes($aRow['idcredit']);
    $tmp[] = addslashes(number_format($aRow['mtcredit'], 0, ',', ' '));
    $tmp[] = addslashes(utf8_encode($aRow['datcred']));
    $tmp[] = addslashes(utf8_encode($aRow['libelle']));
    $tmp[] = addslashes($aRow['fbo_code_distrib']);
    $tmp[] = addslashes($aRow['nom_complet']);
    $tmp[] = addslashes($aRow['operateur']);

    $aaData[] = $tmp;
}
$sOutput['aaData'] = $aaData;

echo json_encode($sOutput);

function fnColumnToField($i) {
    if ($i == 0)
        return "idcredit";
    else if ($i == 1)
        return "mtcredit";
    else if ($i == 2)
        return "datcred";
    else if ($i == 3)
        return "libelle";
    else if ($i == 4)
        return "fbo_code_distrib";
    else if ($i == 5)
        return "nom_complet";
    else if ($i == 6)
        return "operateur";
}
