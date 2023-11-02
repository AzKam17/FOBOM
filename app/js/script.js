
// To make Pace works on Ajax calls
$(document).ajaxStart(function () {
    Pace.restart();
});


$(function () {
    /* Date picker */
    $('#datepicker').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    $('#datepickerr').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    //Date range picker
    $('#reservation').daterangepicker();

    //Date range as a button
    $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Aujourdhui': [moment(), moment()],
                    //'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Les 6 Dernier mois': [moment().subtract(6, 'month').startOf('month'), moment()],
                    'Les 3 Dernier mois': [moment().subtract(3, 'month').startOf('month'), moment()],
                    'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                    'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                //$('#daterange-btn span').html(' Du ' + start.format('DD/MM/YYYY') + ' au ' + end.format('DD/MM/YYYY'));
                $('#daterange-btn #Periode').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
            }
    );
    
     //Date range as a button
    $('#daterange-btn2').daterangepicker(
            {
                ranges: {
                    'Aujourdhui': [moment(), moment()],
                    //'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Les 6 Dernier mois': [moment().subtract(6, 'month').startOf('month'), moment()],
                    'Les 3 Dernier mois': [moment().subtract(3, 'month').startOf('month'), moment()],
                    'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                    'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                //$('#daterange-btn span').html(' Du ' + start.format('DD/MM/YYYY') + ' au ' + end.format('DD/MM/YYYY'));
                $('#daterange-btn2 #Paiement').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
            }
    );

    //Flat red color scheme for iCheck
    $('input[type="radio"].flat-blue1, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
});


/* Jquery ajax file uplaod */

$(function () {
    // Variable to store your files
    var files;

    // Add events
    $('input[type=file]').on('change', prepareUpload);
    $('form#import').on('submit', uploadFiles);

    // Grab the files and set them to our variable
    function prepareUpload(event)
    {
        files = event.target.files;
    }

    // Catch the form submit and upload the files
    function uploadFiles(event)
    {
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function (key, value)
        {
            data.append(key, value);
        });

        $.ajax({
            url: 'http://localhost/fobom/modules/bonus/submit.php?files',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function (data, textStatus, jqXHR)
            {
                if (typeof data.error === 'undefined')
                {
                    // Success so call function to process the form
                    submitForm(event, data);
                } else
                {
                    // Handle errors here
                    console.log('ERRORS: ' + data.error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
            }
        });
    }

    function submitForm(event, data)
    {
        // Create a jQuery object from the form
        $form = $(event.target);

        // Serialize the form data
        var formData = $form.serialize();

        // You should sterilise the file names
        $.each(data.files, function (key, value)
        {
            formData = formData + '&filenames[]=' + value;
        });

        $.ajax({
            url: 'http://localhost/fobom/modules/bonus/submit.php',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            success: function (data, textStatus, jqXHR)
            {
                if (typeof data.error === 'undefined')
                {
                    // Success so call function to process the form
                    //console.log('SUCCESS: ' + data.success);
                    $('.ajax-content').html(data.success);
                } else
                {
                    // Handle errors here
                    //console.log('ERRORS: ' + data.error);
                    $('.ajax-content').html(data.error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
            },
            complete: function ()
            {
                // STOP LOADING SPINNER
            }
        });
    }
});


/* DATA TABLES */

$(function () {

    var idetat = $('#Idetat').val();

    var idfich = $('#Idfich').val();

    var mois = $('#Mois').val();

    var annee = $('#Annee').val();

    console.log('run_datatables');

    if (typeof ($.fn.DataTable) === 'undefined') {
        return;
    }
    console.log('init_DataTables');

    var handleDataTableButtons = function () {
        if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
                dom: "Blfrtip",
                "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
                language: {
                    url: "locales/french.json"
                },
                buttons: [
                    /* {
                     extend: "copy",
                     className: "btn-sm"
                     }, */
                    {
                        extend: "csv",
                        title: 'Liste_des_fichiers_bonus',
                        className: "btn-sm"
                    },
                    {
                        extend: "excelHtml5",
                        title: 'Liste_des_fichiers_bonus',
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        title: 'Liste_des_fichiers_bonus',
                        className: "btn-sm"
                    },
                            /** {
                             extend: "print",
                             className: "btn-sm"
                             } **/
                ],
                responsive: false,
                Processing: true,
                bServerSide: true,
                sAjaxSource: "modules/bonus/AjaxBonusFichier.php?queryId=" + idetat
                        //deferRender: true,
                        //scrollY: 380,
                        //scrollCollapse: true,
                        //scroller: true
            });
        }

        $("#datatable-buttons_1").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_bonus',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_bonus',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_bonus',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/bonus/AjaxBonusMens.php?queryId=" + idfich,
            deferRender: true
        });


        $("#datatable-buttons_2").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_credits',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_credits',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_credits',
                    className: "btn-sm"
                }
            ],
            responsive: true,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/credit/AjaxListeCredit.php?queryId=" + idetat,
            deferRender: true
        });

        $("#datatable-buttons_3").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_fbo',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_fbo',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_fbo',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/fbo/AjaxListeFbo.php?queryId=" + idetat,
            deferRender: true
        });

        $("#datatable-buttons_4").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_ordres_de_paiement',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_ordres_de_paiement',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_ordres_de_paiement',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/caisse/AjaxListePaie.php",
            deferRender: true
        });

        $("#datatable-buttons_5").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_paiements',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_paiements',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_paiements',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/caisse/AjaxListePaieValid.php",
            deferRender: true
        });

        $("#datatable-buttons_6").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/virement/AjaxListeVireNat.php",
            deferRender: true
        });

        $("#datatable-buttons_7").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/virement/AjaxListeVireNatMens.php?queryMois=" + mois + "&queryYear=" + annee,
            deferRender: true
        });

        $("#datatable-buttons_8").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_virements_internationaux',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_virements_internationaux',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_virements_internationaux',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/virement/AjaxListeVirEtrang.php",
            deferRender: true
        });

        $("#datatable-buttons_9").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/virement/AjaxListeVirEtrangMens.php?queryMois=" + mois + "&queryYear=" + annee,
            deferRender: true
        });

        $("#datatable-buttons_10").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_virements_nationaux_en_cour',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_virements_nationaux_en_cour',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_virements_nationaux_en_cour',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/virement/AjaxListeVireCourNat.php",
            deferRender: true
        });

        $("#datatable-buttons_11").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/virement/AjaxListeVireCourNatMens.php?queryMois=" + mois + "&queryYear=" + annee,
            deferRender: true
        });

        $("#datatable-buttons_12").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_virements_nationaux_en_cour',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_virements_nationaux_en_cour',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_virements_nationaux_en_cour',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/virement/AjaxListeVireCourEtrang.php",
            deferRender: true
        });

        $("#datatable-buttons_13").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_virements_nationaux',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/virement/AjaxListeVireCourEtrangMens.php?queryMois=" + mois + "&queryYear=" + annee,
            deferRender: true
        });


        //Etat Bonus

        var moisd = $('#Moisd').val();

        var anneed = $('#Anneed').val();

        var moisf = $('#Moisf').val();

        var anneef = $('#Anneef').val();

        var encai = $('#Encaiss').val();

        var paie = $('#Typepai').val();

        var vire = $('#Typevire').val();

        $("#datatable-buttons_14").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Etat_des_bonus',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Etat_des_bonus',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Etat_des_bonus',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/etat/AjaxListeBonusEtat.php?queryMoisd=" + moisd + "&queryYeard=" + anneed + "&queryMoisf=" + moisf + "&queryYearf=" + anneef + "&queryTyp=" + encai + "&queryPaie=" + paie + "&queryVire=" + vire,
            deferRender: true
        });
        
        //Etat credit   
        
        var datd = $('#datdep').val();

        var datf = $('#datfin').val();

        var cred = $('#typecred').val();

        var rem = $('#typerem').val();
        
         $("#datatable-buttons_15").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Etat_des_credits',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Etat_des_credits',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Etat_des_credits',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/etat/AjaxListeCreditEtat.php?queryD=" + datd + "&queryF=" + datf + "&queryTyp=" + cred + "&queryRem=" + rem,
            deferRender: true
        });
        
         $("#datatable-buttons_16").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_administrateurs',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_administrateurs',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_administrateurs',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/profil/AjaxListeProf.php?queryId=" + idetat,
            deferRender: true
        });
        
        // Etat des bonus par date de paiement 
        
        var datedub = $('#Anneed').val();

        var datefin = $('#Anneef').val();

        var encai = $('#Encaiss').val();

        var paie = $('#Typepai').val();

        var vire = $('#Typevire').val();
        
        $("#datatable-buttons_17").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Etat_bonus_paiement',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Etat_bonus_paiement',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Etat_bonus_paiement',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/etat/AjaxListeBonusPaieEtat.php?queryDad=" + datedub + "&queryDaf=" + datefin + "&queryTyp=" + encai + "&queryPaie=" + paie + "&queryVire=" + vire,
            deferRender: true
        });

//Etat credit   
        
        var datd = $('#datdep').val();

        var datf = $('#datfin').val();

        var cred = $('#typecred').val();
        
         $("#datatable-buttons_18").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Etat_des_cheques',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Etat_des_cheques',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Etat_des_cheques',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/bonus/AjaxListeBonusSolde.php?queryD=" + datd + "&queryF=" + datf + "&queryTyp=" + cred + "&queryRem=" + rem,
            deferRender: true
        });
      
        $("#datatable-buttons_19").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_bonus_soldés',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_bonus_soldés',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_bonus_soldés',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/bonus/AjaxListeBonusSolde.php?queryId=" + idetat,
            deferRender: true
        });
        
        $("#datatable-buttons_20").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_bonus_payés_partiellemnt',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_bonus_payés_partiellemnt',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_bonus_payés_partiellemnt',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/bonus/AjaxListeBonusPartiel.php?queryId=" + idetat,
            deferRender: true
        });
        
        $("#datatable-buttons_21").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_bonus_payés_caisse',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_bonus_payés_caisse',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_bonus_payés_caisse',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/bonus/AjaxListeBonusCaisse.php",
            deferRender: true
        });
        
        
        $("#datatable-buttons_22").DataTable({
            dom: "Blfrtip",
            "lengthMenu": [ [10, 20, 50, 100, 250, 500, 1000, -1], [10, 20, 50, 100, 250, 500, 1000, "Tous"] ],
            language: {
                url: "locales/french.json"
            },
            buttons: [
                {
                    extend: "csv",
                    title: 'Liste_des_fbo',
                    className: "btn-sm"
                },
                {
                    extend: "excelHtml5",
                    title: 'Liste_des_fbo',
                    className: "btn-sm"
                },
                {
                    extend: "pdfHtml5",
                    title: 'Liste_des_fbo',
                    className: "btn-sm"
                }
            ],
            responsive: false,
            Processing: true,
            bServerSide: true,
            sAjaxSource: "modules/etat/AjaxListeFboEtat.php?queryId=" + idetat,
            deferRender: true
        });

    };
    
    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                handleDataTableButtons();
            }
        };
    }();

    TableManageButtons.init();

});

/* SMART WIZARD */


$(function () {

    if (typeof ($.fn.smartWizard) === 'undefined') {
        return;
    }
    console.log('init_SmartWizard');

    $('#wizard').smartWizard({
        transitionEffect: 'slideleft',
        //onLeaveStep: leaveAStepCallback,
        //onFinish: onFinishCallback,
        enableFinishButton: true
    });

    //$('#wizard_verticle').smartWizard({
    //transitionEffect: 'slide'
    //});

    $('.buttonNext').addClass('btn btn-success');
    $('.buttonPrevious').addClass('btn btn-primary');
    $('.buttonFinish').addClass('btn btn-default');
});


/**Auto Search**/

function lookupele(nomEleve) {
    if (nomEleve.length == 0) { // si le champs txte est vide
        $('#suggestionsele').hide(); // on cache les suggestions
    } else { // sinon
        var ideta = $('#inputID').val(); // on recupère l'id de letablissement
        $.post("modules/credit/AjaxFbo.php", {queryString: "" + nomEleve + "", queryId: ideta}, function (data) { // on envoit la valeur du champ texte dans la variable post queryString ainsi que la variable queryID au fichier ajax.php
            if (data.length > 0) {
                $('#infomationBox').hide();
                $('#suggestionsele').show(); // si il y a un retour, on affiche la liste
                $('#autoSuggestionsListele').html(data); // et on remplit la liste des données
            } else {
                $('#infomationBox').hide();
                $('#suggestionsele').show(); // si il y a un retour, on affiche la liste
                $('#autoSuggestionsListele').html('<li>Cet élève n\'existe pas!</li>');
            }
        });
    }
}


function fillele(thisValue) { // remplir le champ texte si une suggestion est cliquée
    $('#nomEleve').val(thisValue);
    setTimeout("$('#suggestionsele').hide();", 200);
}

function fillid(thisValue) { // remplir le champ tpe hidden de lid eleve si une suggestion est cliquée
    $('#outputID').val(thisValue);
    setTimeout("$('#suggestionsele').hide();", 200);
}

function fillinfo(thisValue) { // remplir le champ tpe hidden de lid eleve si une suggestion est cliquée
    $('#infomationBox').show();
    $('#autoInformationListele').html(thisValue);
    setTimeout("$('#suggestionsele').hide();", 200);
}

$(document).ready(function () {
    $("input#nomEleve").keyup(function () { // si on presse une touche du clavier en étant dans le champ texte qui a pour id nomEleve
        lookupele($(this).val());
    });
});

// MODAL BOOSTRAP

$(document).ready(function () {

// Support for AJAX loaded modal window.
// Focuses on first input textbox after it loads the window.
    $('[data-toggle="modal_1"]').click(function (e) {

        e.preventDefault();
        var url = $(this).attr('href');
        var idcred = $(this).attr('id');
        var ido = $(this).attr('fbo');
        var mtcred = $(this).attr('mt');

        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, {"id": idcred, "fbo": ido, "mt": mtcred}, function (data) {
                $('<div class="modal modal-primary fade">' + data + '</div>').modal();
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
    });

    $('[data-toggle="modal_2"]').click(function (e) {

        e.preventDefault();
        var url = $(this).attr('href');
        var idcred = $(this).attr('id');
        var ido = $(this).attr('fbo');
        var mtcred = $(this).attr('mt');
        var nfbo = $(this).attr('nomfbo');

        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, {"id": idcred, "fbo": ido, "nomfbo": nfbo, "mt": mtcred}, function (data) {
                $('<div class="modal modal-primary fade">' + data + '</div>').modal();
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
    });

    $('[data-toggle="modal_3"]').click(function (e) {

        e.preventDefault();
        var url = $(this).attr('href');
        var idcred = $(this).attr('id');
        var ido = $(this).attr('fbo');
        var mtcred = $(this).attr('mt');
        var fbocompte = $(this).attr('compte');
        var fbonat = $(this).attr('nat');

        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, {"id": idcred, "fbo": ido, "mt": mtcred, "compte": fbocompte, "nat": fbonat}, function (data) {
                $('<div class="modal modal-primary fade">' + data + '</div>').modal();
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
    });
    
    $('[data-toggle="modal_4"]').click(function (e) {

        e.preventDefault();
        var url = $(this).attr('href');
        var idbon = $(this).attr('id');
        var ido = $(this).attr('fbo');
        var mtbon = $(this).attr('mt');
        var fbonom = $(this).attr('nom');
        var moiss = $(this).attr('mois');
        var annees = $(this).attr('annee');

        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, {"id": idbon, "fbo": ido, "mt": mtbon, "nom": fbonom, "moi": moiss, "ann": annees}, function (data) {
                $('<div class="modal modal-danger fade">' + data + '</div>').modal();
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
    });
    
    $('[data-toggle="modal_5"]').click(function (e) {

        e.preventDefault();
        var url = $(this).attr('href');
        var idbon = $(this).attr('id');
        var ido = $(this).attr('fbo');
        var mtbon = $(this).attr('mt');
        var fbonom = $(this).attr('nom');
        var moiss = $(this).attr('mois');
        var annees = $(this).attr('annee');

        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, {"id": idbon, "fbo": ido, "mt": mtbon, "nom": fbonom, "moi": moiss, "ann": annees}, function (data) {
                $('<div class="modal modal-warning fade">' + data + '</div>').modal();
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
    });
    
    $('[data-toggle="modal_6"]').click(function (e) {

        e.preventDefault();
        var url = $(this).attr('href');
        var idbon = $(this).attr('id');
        var ido = $(this).attr('fbo');
        var mtbon = $(this).attr('mt');
        var fbonom = $(this).attr('nom');
        var moiss = $(this).attr('mois');
        var annees = $(this).attr('annee');

        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, {"id": idbon, "fbo": ido, "mt": mtbon, "nom": fbonom, "moi": moiss, "ann": annees}, function (data) {
                $('<div class="modal modal-default fade">' + data + '</div>').modal();
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
    });
    
    
    $('[data-toggle="modal_7"]').click(function (e) {

        e.preventDefault();
        var url = $(this).attr('href');
        var idcred = $(this).attr('id');
        var ido = $(this).attr('fbo');
        var mtcred = $(this).attr('mt');
        var fbocompte = $(this).attr('compte');
        var fbonat = $(this).attr('nat');

        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, {"id": idcred, "fbo": ido, "mt": mtcred, "compte": fbocompte, "nat": fbonat}, function (data) {
                $('<div class="modal modal-primary fade">' + data + '</div>').modal();
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
    });

});

