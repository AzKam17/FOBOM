<!--
Projet de developpement@Copyright Forever Living
Application de gestion des bonus des FBO
Maitre d'ouvrage : KAM Corporate and Exchange Group
Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
-->

<?php
$selected = 'dashboard';

include 'modeles/dashboard.inc.php';

$cam = ChifAffMensBon();
$jsonx = json_encode($cam);
$data1 = preg_replace('/"/', '', $jsonx);
//echo $data1;
$can = ChifAffMensBonPaie();
$jsony = json_encode($can);
$data2 = preg_replace('/"/', '', $jsony);
//echo $data2;
$cann = ChifAffMensBonCour();
$jsonz = json_encode($cann);
$data3 = preg_replace('/"/', '', $jsonz);
//echo $data3;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Tableau de bord</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Acceuil</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

    <section class="content">
        <!-- Info boxes 1 -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=bonus&action=bonufichier">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Fichier Mensuel</span>
                            <span class="info-box-number"><?php echo number_format(nbre_total_fichier_bonus(), 0, ',', ' '); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=fbo&action=fbolist">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total FBO</span>
                            <span class="info-box-number"><?php echo number_format(nbre_total_fbo(), 0, ',', ' '); ?></span>
                            <p></p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="index.php?module=dashboard&action=stat_bonus">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-more-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Bonus</span>
                            <span class="info-box-number"><?php echo number_format(nbre_total_bonus(), 0, ',', ' '); ?></span>
                            <p></p>
                        </div>
                        <!-- /.info-box-content -->
                    </div> 
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-cash"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Crédits</span>
                        <span class="info-box-number"><?php echo number_format(mt_total_credit(), 0, ',', ' '); ?> <small>F</small></span>
                        <p><?php echo number_format(mt_total_credit_rembou(), 0, ',', ' '); ?> <small>F Remboursé</small></p>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monthly Recap Report</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-wrench"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Evolution du montant total des bonus mensuels payés et dues</strong>
                                </p>

                                <!--<div class="chart">
                                     Sales Chart Canvas 
                                    <canvas id="salesChart" style="height: 180px;"></canvas>
                                </div> -->
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-dashboard-chart" style="height: 200px;"></div>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Objectif</strong>
                                </p>

                                <div class="progress-group">
                                    <span class="progress-text">Total Bonus impayé</span>
                                    <span class="progress-number"><b><?php echo number_format(nbre_total_bonus_impaye_brut(), 0, ',', ' '); ?></b>/<?php echo number_format(nbre_total_bonus(), 0, ',', ' '); ?></span>

                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-red" style="width: <?php
                                        if ($ddd = nbre_total_bonus()) {
                                            echo number_format(((nbre_total_bonus_impaye_brut()) / (nbre_total_bonus())) * 100, 0, ',', ' ');
                                        }
                                        ?>%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">Total Bonus en cour</span>
                                    <span class="progress-number"><b><?php echo number_format(nbre_total_bonus_impaye_encour(), 0, ',', ' '); ?></b>/<?php echo number_format(nbre_total_bonus(), 0, ',', ' '); ?></span>

                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-aqua" style="width: <?php
                                        if ($dddd = nbre_total_bonus()) {
                                            echo number_format(((nbre_total_bonus_impaye_encour()) / (nbre_total_bonus())) * 100, 0, ',', ' ');
                                        }
                                        ?>%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">Total Bonus payement partiel</span>
                                    <span class="progress-number"><b><?php echo number_format(nbre_total_bonus_impaye_partiel(), 0, ',', ' '); ?></b>/<?php echo number_format(nbre_total_bonus(), 0, ',', ' '); ?></span>

                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-green" style="width: <?php
                                        if ($ddddd = nbre_total_bonus()) {
                                            echo number_format(((nbre_total_bonus_impaye_partiel()) / (nbre_total_bonus())) * 100, 0, ',', ' ');
                                        }
                                        ?>%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">Total Credit non remboursé</span>
                                    <span class="progress-number"><b><?php echo number_format(mt_total_credit() - mt_total_credit_rembou(), 0, ',', ' '); ?></b> F/<?php echo number_format(mt_total_credit(), 0, ',', ' '); ?> F</span>

                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-yellow" style="width: <?php
                                        if ($dd = mt_total_credit()) {
                                            echo number_format(((mt_total_credit() - mt_total_credit_rembou()) / (mt_total_credit())) * 100, 0, ',', ' ');
                                        }
                                        ?>%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                                    <h5 class="description-header">$35,210.43</h5>
                                    <span class="description-text">TOTAL REVENUE</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                                    <h5 class="description-header">$10,390.90</h5>
                                    <span class="description-text">TOTAL COST</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                                    <h5 class="description-header">$24,813.53</h5>
                                    <span class="description-text">TOTAL PROFIT</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block">
                                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                                    <h5 class="description-header">1200</h5>
                                    <span class="description-text">GOAL COMPLETIONS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>

</section>
<!-- /.content -->

<!-- Graphe des paiement -->
<script>
    $(function () {
        var data1 = <?= $data1; ?>;
        var data2 = <?= $data2; ?>;
        var data3 = <?= $data3; ?>;
        var dataset = [{
                label: "Montant total des bonus impayés par mois",
                data: data1,
                color: "#DD4B39",
                lines: {
                    lineWidth: 1,
                    show: false,
                    fill: true,
                    fillColor: {
                        colors: [{
                                opacity: 0.1
                            }, {
                                opacity: 0.2
                            }]
                    }
                },
                splines: {
                    show: true,
                    tension: 0.2,
                    lineWidth: 2,
                    fill: 0.1
                },
                points: {
                    show: true,
                    tension: 0.6,
                    lineWidth: 2
                }
            },
            {
                label: "Montant total des bonus payés par mois",
                data: data2,
                color: "#00A65A",
                lines: {
                    lineWidth: 1,
                    show: false,
                    fill: true,
                    fillColor: {
                        colors: [{
                                opacity: 0.1
                            }, {
                                opacity: 0.2
                            }]
                    }
                },
                splines: {
                    show: true,
                    tension: 0.2,
                    lineWidth: 2,
                    fill: 0.1
                },
                points: {
                    show: true,
                    tension: 0.6,
                    lineWidth: 2
                }
            },
            {
                label: "Montant total des bonus en cour de paiement par mois",
                data: data3,
                color: "#1C84C6",
                lines: {
                    lineWidth: 1,
                    show: false,
                    fill: true,
                    fillColor: {
                        colors: [{
                                opacity: 0.1
                            }, {
                                opacity: 0.2
                            }]
                    }
                },
                splines: {
                    show: true,
                    tension: 0.2,
                    lineWidth: 2,
                    fill: 0.1
                },
                points: {
                    show: true,
                    tension: 0.6,
                    lineWidth: 2
                }
            }
        ];
        var options = {
            xaxis: {
                mode: "time",
                timeformat: "%b %Y",
                monthNames: ["Janv", "Fev", "Mars", "Avril", "Mai", "Juin", "Juil", "Août", "Sept", "Oct", "Nov", "Dec"],
                dayNames: ["Dim", "Lun", "Mar", "Mar", "Jeu", "Ven", "Sam"],
                tickSize: [1, "month"],
                tickLength: 5,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 14,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 10,
                color: "#d5d5d5"
            },
            yaxes: [{
                    position: "left",
                    color: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 3
                }
            ],
            legend: {
                noColumns: 1,
                margin: [25, -7],
                labelBoxBorderColor: "#000000",
                position: "nw"
            },
            grid: {
                hoverable: true,
                borderWidth: 0
            },
            tooltip: true,
            tooltipOpts: {
                content: "Le %s pour %x est de %y FCFA"
            }
        };
        function gd(year, month) {
            return new Date(year, month - 1).getTime();
        }

        var previousPoint = null, previousLabel = null;
        $.plot($("#flot-dashboard-chart"), dataset, options);
    });
</script>
