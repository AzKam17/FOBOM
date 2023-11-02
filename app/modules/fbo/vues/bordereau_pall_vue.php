
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
            <td style="width: 75%;">
            </td>
            <td style="width: 25%; color: #444444;">
                <img style="width: 35%;" src="img/logo.png" alt="Logo"><br>
                FOREVER LIVING PRODUCTS
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <?php
        foreach ($info_fbo as $n) {
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
                <td style="width:50%;">Code Distributeur : <?php echo $code; ?></td>
                <td style="width:25%; ">Adresse : </td>
                <td style="width:25%">Tel : <?php echo $mobil; ?></td>
            </tr>
            <tr>
                <td style="width:50%;">Nom Complet : <?php echo $nom; ?></td>
                <td style="width:25%; ">Ville : <?php echo $ville; ?></td>
                <td style="width:25%">Email : <?php echo $email; ?></td>
            </tr>
            <tr>
                <td style="width:50%;">Statut : <?php echo $statu; ?></td>
                <td style="width:25%; ">Commune : <?php echo $comm; ?></td>
                <td style="width:25%"></td>
            </tr>
            <tr>
                <td style="width:50%;"><?php //echo utf8_encode($b['annee']);       ?></td>
                <td style="width:25%; ">Quartier : <?php echo $quart; ?></td>
                <td style="width:25%"></td>
            </tr>
            <tr>
                <td style="width:50%;"></td>
                <td style="width:25%; "></td>
                <td style="width:25%"></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left;font-size: 10pt">
        <tr>
            <td style="width:70%;"></td>
            <td style="width:30%; ">Abidjan, le <?php echo date('d/m/Y'); ?> &agrave; <?php echo date('H:i'); ?></td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: center;font-size:22pt">
        <tr>
            <td style="width:15%;"></td>
            <td style="width:70%; border: 2px;">
                <i>
                    <b style="width: 100%">BORDEREAU DE RETRAIT</b><br>  
                </i>
            </td>
            <td style="width:15%;"></td>
        </tr>
    </table>
    <br>
    <br>
    Madame, Monsieur, Cher Client,<br>
    <br>
    <br>
    Par la présente, nous vous remettons ce bordereau de retrait
    concernant les &laquo; Bonus &raquo; des périodes suivantes selon le tableau ci-dessous, 
    d'un montant total de <b><?php echo number_format($mttotpayer, 0, ',', ' '); ?> F CFA</b><br>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%; text-align: left;">Référence</th>
            <th style="width: 10%; text-align: left;">idbonus</th>
            <th style="width: 12%; text-align: left;">Période</th>
            <th style="width: 18%; text-align: left;">date du paiement</th>
            <th style="width: 15%; text-align: left;">Etat</th>
            <th style="width: 15%; text-align: left;">Ordornné par</th>
            <th style="width: 20%; text-align: left;">Montant à payer</th>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: left; font-size: 10pt;">
        <?php
        foreach ($paie_infos as $n) {
            $paie = utf8_encode($n['idpaiement']);
            $bonus = utf8_encode($n['bonus_idbonus']);
            $periode = utf8_encode($n['periode']);
            $etatbon = utf8_encode($n['etat']);
            $typencaisse = utf8_encode($n['typencaisse']);
            $mtbonus = utf8_encode($n['montapayer']);
            $datordonne = $n['datpaie'];
            $mtpaie = utf8_encode($n['mtfacture']);
            $caisse = utf8_encode($n['typepaie']);
            $etatpaie = utf8_encode($n['eta']);
            $operateur = utf8_encode($n['operateur']);
            ?>
            <tr>
                <td style="width: 10%"><?php echo $paie; ?></td>
                <td style="width: 10%"><?php echo $bonus; ?></td>
                <td style="width: 12%"><?php echo $periode; ?></td>
                <td style="width: 18%"><?php echo $datordonne; ?></td>
                <td style="width: 15%">NON ENCAISSE</td>
                <td style="width: 15%"><?php echo $operateur; ?></td>
                <td style="width: 20%; text-align: left;"><?php echo number_format($mtpaie, 0, ',', ' '); ?> F CFA</td>
            </tr>

        <?php } ?>
    </table>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
        <tr>
            <th style="width: 70%; text-align: right;">Total : </th>
            <th style="width: 30%; text-align: right;"><?php echo number_format($mttotpayer, 0, ',', ' '); ?> F CFA</th>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    Veuillez vous rendre à la caisse munis de ce bordereau.<br>
    Nous vous demandons de garder ce document de manière confidentielle. Car en cas de perte ou de mauvaise utilisation de ce dit document. Forever Living Products decline toutes responsabilités.<br>
    <br>
    Vous acceptez nos conditions et règlements en vigueur.<br>
    <br>
    <nobreak>
        <br>
        Dans cette attente, nous vous prions de recevoir, Madame, Monsieur, Cher Client, nos meilleures salutations.<br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table cellspacing="0" style="width: 100%;">
            <tr>
                <td style="width:50%; text-align: left;">
                    <b><u>Signature du Client</u></b>
                </td>
                <td style="width:50%; text-align: right;">
                    <b><u>Cachet et Signature du Comptable</u></b>
                </td>
            </tr>
        </table>
    </nobreak>
</page>