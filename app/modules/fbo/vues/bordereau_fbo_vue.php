
<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<style type="text/css">
    <!--
    table { vertical-align: top; }
    tr    { vertical-align: top; }
    td    { vertical-align: top; }

    -->
</style>
<page backcolor="#FEFEFE" backimg="" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;heure" style="font-size: 12pt">
    <bookmark title="Lettre" level="0" ></bookmark>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 14px">
        <tr>
            <td style="width: 70%; text-align: left;" >
                <?php
                    if (is_file($fichier1)) {
                        echo ' <img style="width: 15%;" src="' . $fichier1 . '" alt="Logo"> ';
                    } elseif (is_file($fichier2)) {
                        echo ' <img style="width: 15%;" src="' . $fichier2 . '" alt="Logo"> ';
                    } elseif (is_file($fichier3)) {
                        echo ' <img style="width: 15%;" src="' . $fichier3 . '" alt="Logo"> ';
                    } else {
                        echo ' <img style="width: 15%;" src="img/fbo/avatar.jpg" alt="Photo"> ';
                    }
                    ?>
            </td>
            <td style="width: 30%; color: #444444;">
                <img style="width: 35%;" src="img/logo.png" alt="Logo"><br>
                FOREVER LIVING PRODUCTS
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: center;font-size:22pt">
        <tr>
            <td style="width:15%;"></td>
            <td style="width:70%; border: 2px;">
                <i>
                    <b style="width: 100%">FICHE BUSINESS OWNER</b><br>  
                </i>
            </td>
            <td style="width:15%;"></td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="10" style="width: 100%; text-align: left; font-size: 12pt;">
        <?php
        foreach ($fbod as $n) {
            $nom = utf8_encode($n['nom_complet']);
            $code = utf8_encode($n['code_distrib']);
            $statu = utf8_encode($n['statut_fbo']);
            $mobil = utf8_encode($n['mobile']);
            $email = utf8_encode($n['email']);
            $ville = utf8_encode($n['ville']);
            $comm = utf8_encode($n['commune']);
            $quart = utf8_encode($n['quartier']);
            $address = utf8_encode($n['addresse']);
            //$titre = utf8_encode($n['titre']);
            ?>
            <tr>
                <td style="width:50%;"><u>Code Distributeur</u> : <b><?php echo $code; ?></b></td>
            <td style="width:50%"><u>Tel</u> : <b><?php echo $mobil; ?></b></td>
            </tr>
            <tr>
                <td style="width:50%;"><u>Nom Complet</u> : <b><?php echo $nom; ?></b></td>
            <td style="width:50%; "><u>Adresse</u> : <b><?php echo $address; ?></b></td>
            </tr>
            <tr>
                <td style="width:50%; "><u>Statut</u> : <b><?php echo $statu; ?></b></td>
            <td style="width:50%"><u>Ville</u> : <b><?php echo $ville; ?></b></td>
            </tr>
            <tr>
                <td style="width:50%;"><u>Email</u> : <b><?php echo $email; ?></b></td>
            <td style="width:50%; "><u>Commune</u> : <b><?php echo $comm; ?></b></td>
            </tr>
            <tr>
                <td style="width:50%;"></td>
                <td style="width:50%; "><u>Quartier</u> : <b><?php echo $quart; ?></b></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    TABLEAU DES BONUS POUR UN TOTAL RESTANT A PAYER DE : <b><?php echo number_format($mttotpayer, 0, ',', ' '); ?> F CFA</b>
    <br>
    <br>
    <table cellspacing="10" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 15%; text-align: left;">idbonus</th>
            <th style="width: 20%; text-align: left;">Période</th>
            <th style="width: 25%; text-align: left;">Etat</th>
            <th style="width: 20%; text-align: left;">Type encaissement</th>
            <th style="width: 20%; text-align: left;">Montant à payer</th>
        </tr>
    </table>
    <table cellspacing="15" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: left; font-size: 10pt;">
        <?php
        foreach ($fbob as $n) {
            $bonus = utf8_encode($n['idbonus']);
            $periodem = utf8_encode($n['mois']);
            $periodea = utf8_encode($n['annee']);
            $etat = $n['etat'];
            $typencaisse = utf8_encode($n['typencaisse']);
            $mtbonus = utf8_encode($n['montapayer']);
            ?>
            <tr>
                <td style="width: 15%"><?php echo $bonus; ?></td>
                <td style="width: 20%"><?php echo $periodem . ' / ' . $periodea; ?></td>
                <td style="width: 25%"><?php if ($etat == 0) { ?>
                        <span class="label label-danger">Non Encaissé</span>
                    <?php } elseif ($etat == 1) { ?>
                        <span class="label label-success">Encaissé</span>            
                    <?php } elseif ($etat == 2) { ?>
                        <span class="label label-default">Partiel</span>
                    <?php } else { ?>
                        <span class="label label-warning">En Attente</span>
                    <?php } ?>
                </td>
                <td style="width: 20%">
                    <?php if ($typencaisse == 0) { ?>
                        <span class="label label-danger">Aucun</span>
                    <?php } elseif ($typencaisse == 1) { ?>
                        <span class="label label-success">Caisse</span>            
                    <?php } elseif ($typencaisse == 2) { ?>
                        <span class="label label-default">Virement</span>            
                    <?php } else { ?>
                        <span class="label label-primary">Régularisé</span>           
                    <?php } ?>
                </td>
                <td style="width: 20%; text-align: left;"><?php echo number_format($mtbonus, 0, ',', ' '); ?> F CFA</td>
            </tr>

        <?php } ?>
    </table>
    <table cellspacing="15" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
        <tr>
            <th style="width: 70%; text-align: right;">Total : </th>
            <th style="width: 30%; text-align: right;"><?php echo number_format($mttotpayer, 0, ',', ' '); ?> F CFA</th>
        </tr>
    </table>
    <br>
    <br>
    <nobreak>

        <table cellspacing="0" style="width: 100%;">
            <tr>
                <td style="width:70%; text-align: left;">

                </td>
                <td style="width:30%; text-align: right;">
                    Abidjan, le <?php echo date('d/m/Y'); ?> &agrave; <?php echo date('H:i'); ?>
                </td>
            </tr>
        </table>
    </nobreak>
</page>