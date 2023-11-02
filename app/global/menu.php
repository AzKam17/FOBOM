<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <?php if ($_SESSION['niveau'] == 1) { ?>
        <ul class="nav navbar-nav">
            <li class="<?php if ($selected == "dashboard") { echo 'active'; } ?>"><a href="index.php?module=dashboard&action=dashboard">Tableau de bord <span class="sr-only">(current)</span></a></li>
            <li class="dropdown <?php if ($selected == "bonusfichier") { echo 'active'; } ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bonus <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=bonus&action=bonufichier">Bonus Mensuel</a></li>
                    <li><a href="#">Bonus Archivé</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?module=bonus&action=bonusimp">Import</a></li>
                    <li><a href="index.php?module=bonus&action=bonusimport">Import Archive</a></li>
                    <li><a href="index.php?module=bonus&action=bonusimpomulti">Import bancaire</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if ($selected == "fbo") { echo 'active'; } ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fbo <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=fbo&action=fbolist">Liste des fbo</a></li>
                    <li><a href="#">Ajouter un fbo</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if ($selected == "credit") { echo 'active'; } ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Credit <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=credit&action=ajoutcheque">Nouveau Cheque</a></li>
                    <li><a href="index.php?module=credit&action=ajoutcredit">Nouveau Crédit</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Regulariser</a></li>
                    <li><a href="#">Remboursement</a></li>
                    <li class="divider"></li>                
                    <li><a href="index.php?module=credit&action=listecredit">Liste Crédit</a></li>
                    <li><a href="index.php?module=credit&action=suivicheque">Suivit Cheque</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if ($selected == "transac") { echo 'active'; } ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaction <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=caisse&action=paielist">Paiement en cours</a></li>
                    <li><a href="index.php?module=caisse&action=paievalidlist">Paiement validé</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?module=virement&action=virechoix">Virement</a></li>
                    <li><a href="index.php?module=virement&action=virecourchoix">Virement en cours</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if ($selected == "etat") { echo 'active'; } ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Etats <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=etat&action=choix">Bonus</a></li>
                    <li class="divider"></li>  
                    <li><a href="index.php?module=etat&action=choi">fbo</a></li>
                    <li class="divider"></li> 
                    <li><a href="index.php?module=etat&action=choixx">Crédit</a></li>
                    <li class="divider"></li>                
                    <li><a href="index.php?module=etat&action=choixxx">Chèque</a></li>
                </ul>
            </li>
        </ul>
    <?php } elseif ($_SESSION['niveau'] == 2) { ?>
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php?module=dashboard&action=dashboard">Tableau de bord <span class="sr-only">(current)</span></a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fbo <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=fbo&action=fbolist">Liste des fbo</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Paiement <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=caisse&action=paielist">Paiement en cours</a></li>
                    <li><a href="index.php?module=caisse&action=paievalidlist">Paiement validé</a></li>
                </ul>
            </li>
        </ul>
    <?php } else { ?>
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php?module=dashboard&action=dashboard">Tableau de bord <span class="sr-only">(current)</span></a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bonus <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=bonus&action=bonufichier">Bonus Mensuel</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?module=bonus&action=bonusimp">Import</a></li>
                    <li><a href="index.php?module=bonus&action=bonusimpomulti">Import bancaire</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fbo <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=fbo&action=fbolist">Liste des fbo</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Etats <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=etat&action=choix">Bonus</a></li>
                    <li class="divider"></li>                
                    <li><a href="index.php?module=etat&action=choixx">Crédit</a></li>
                    <li class="divider"></li>                
                    <li><a href="index.php?module=etat&action=choixxx">Chèque</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaction <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?module=caisse&action=paielist">Paiement en cours</a></li>
                    <li><a href="index.php?module=caisse&action=paievalidlist">Paiement validé</a></li>
                </ul>
            </li>
        </ul>
    <?php } ?>
    <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
        </div>
    </form>
</div>
<!-- /.navbar-collapse -->