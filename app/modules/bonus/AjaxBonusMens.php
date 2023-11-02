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
    $sWhere = "WHERE fichier_bonus_idfichier_bonus = $iduser AND (".
            "f.nom_complet LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "b.fbo_code_distrib LIKE '%" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "%' OR " .
            "b.ajustement LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "' OR " .
            "b.montapayer LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "' OR " .
            "b.montant LIKE '" . mysqli_real_escape_string($gaSql['link'],
                    utf8_decode($_GET['sSearch'])) . "')";
} else {
   
    $sWhere = "WHERE fichier_bonus_idfichier_bonus = $iduser"; 
}

$sQuery = "
          SELECT SQL_CALC_FOUND_ROWS b.idbonus,f.nom_complet,b.fbo_code_distrib,b.montant,b.ajustement,b.sous_total,b.bic,b.montapayer,b.mois,b.annee,b.etat,b.typencaisse
          FROM bonus as b JOIN fbo as f
          ON  f.code_distrib = b.fbo_code_distrib "
          ."$sWhere"
          . " $sOrder $sLimit " ;

$rResult = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));

$sQuery = "SELECT FOUND_ROWS()";

$rResultFilterTotal = mysqli_query($gaSql['link'],$sQuery) or
        die(mysqli_error($gaSql['link']));
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

$sQuery = "     SELECT COUNT(idbonus) 
                FROM bonus
                WHERE fichier_bonus_idfichier_bonus = $iduser ";

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
    $tmp[] = addslashes(number_format($aRow['montant'], 0, ',', ' '));
    $tmp[] = addslashes(number_format($aRow['ajustement'], 0, ',', ' '));
    $tmp[] = addslashes(number_format($aRow['sous_total'], 0, ',', ' '));
    $tmp[] = addslashes(number_format($aRow['bic'], 0, ',', ' '));
    $tmp[] = addslashes(number_format($aRow['montapayer'], 0, ',', ' '));
    
    if($aRow['etat']==0){$tmp[] = '<span class="label label-danger">Non Encaissé</span>';} 
    elseif ($aRow['etat'] == 1) {$tmp[] = '<span class="label label-success">Encaissé</span>';}
    elseif ($aRow['etat'] == 2) {$tmp[] = '<span class="label label-default">Partiel</span>';}
    else {$tmp[] = '<span class="label label-warning">En Attente</span>';}
    
     if($aRow['typencaisse']==0){$tmp[] = '<span class="label label-danger">Aucun</span>';} 
    elseif ($aRow['typencaisse'] == 1) {$tmp[] = '<span class="label label-success">Caisse</span>';}
    elseif ($aRow['typencaisse'] == 2) {$tmp[] = '<span class="label label-default">Virement</span>';}
    else {$tmp[] = '<span class="label label-warning">Régularisé</span>';}
    
    $tmp[] = '<a href="index.php?module=fbo&action=info_fbo&id=' . $aRow['fbo_code_distrib'] . '" ><button title="detail du bonus" class="btn btn-primary btn-social-icon btn-sm" type="button"><i class="fa fa-arrow-circle-right"></i> </button></a> '
            . '<a href="#"><button title="Supprimer bonus" class="btn btn-danger btn-social-icon btn-sm" disabled="" type="button"><i class="fa fa-trash"></i> </button></a>';

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
        return "montant";
    else if ($i == 3)
        return "ajustement";
    else if ($i == 4)
        return "sous_total";
    else if ($i == 4)
        return "bic";
    else if ($i == 4)
        return "montapayer";
    else if ($i == 4)
        return "etat";
    else if ($i == 4)
        return "typencaisse";
}