/**
 * Created by Jeroen on 6/12/2016.
 */

$(document).ready(function(){

    var $searchForm_inputZoekwaarde = $("#searchForm_inputZoekwaarde");
    var $searchForm_submitCheck = $("#searchForm_submitCheck");
    var $searchForm_searchOn = $("#searchForm_searchOn");
    var $searchResult_geenResultaat = $("#searchResult_geenResultaat");
    var $searchResult_nietsIngegeven = $("#searchResult_nietsIngegeven");
    var $searchResult_aroundTable = $("#searchResult_aroundTable");
    var $searchResult_table = $("#searchResult_table");
    var $searchResultForm = $("#searchResultForm");
    var $searchResultForm_inputNummerplaat = $("#searchResultForm_inputNummerplaat");
    var $searchResultForm_inputMerk = $("#searchResultForm_inputMerk");
    var $searchResultForm_inputDriver = $("#searchResultForm_inputDriver");
    var $searchResultForm_inputFirma = $("#searchResultForm_inputFirma");
    var $searchResultForm_inputAdres = $("#searchResultForm_inputAdres");
    var $searchResultForm_inputTel = $("#searchResultForm_inputTel");
    var $searchResultForm_inputGsm =  $("#searchResultForm_inputGsm");
    var $searchResultForm_inputOwner = $("#searchResultForm_inputOwner");
    var $searchResultForm_selectNplDeleted = $("#searchResultForm_selectNplDeleted");
    var $searchResultForm_inputTitDeleted = $("#searchResultForm_inputTitDeleted");
    var $searchResultForm_inputTitGrpOmschrijving = $("#searchResultForm_inputTitGrpOmschrijving");
    var $searchResultForm_inputTitGrpBareelopen = $("#searchResultForm_inputTitGrpBareelopen");
    var $searchResultForm_submitUpdate = $("#searchResultForm_submitUpdate");
    var $searchResultForm_message = $("#searchResultForm_message");
    var $searchResultForm_buttonEdit = $("#searchResultForm_buttonEdit");
    var $searchResultForm_buttonNew = $("#searchResultForm_buttonNew");
    var $searchResultForm_submitNew = $("#searchResultForm_submitNew");
    var $searchResult_colorIndicator = $("#searchResult_colorIndicator");
    var $header = $("header");
    var $searchForm_zone = $("#searchForm_zone");
    var $searchResultForm_buttonBack = $("#searchResultForm_buttonBack");


    //var om te controleren of er op de edit button al geklikt werd
    var searchResultForm_buttonEdit_pressed = false;
    var searchResultForm_buttonNew_pressed = false;

    //var om aan te geven of de back knop nodig is
    //deze knop is nodig als we vanuit resultatenlijst doorklikken naar detail
    var buttonBack_nodig = false;

    //var die tijdelijk de gezochte waarde bewaard
    //gebruikt door back button
    var buttonBack_zoekwaarde;
    var buttonBack_zoekOp;

    //controlevariabelen op wijzigigingen
    var cv_Merk = "";
    var cv_Owner = "";
    var cv_NplDeleted = "";

    //variable die memberfirma bijhoudt
    var memberCompany;

    //on page load direct admin functie uitvoeren
    //deze functie controleert of gebruiker adminrechten heeft
    //de admin gebruiker mag wijzigingen aan de gegevens doorvoeren
    admin();

    //on page load direct admin functie uitvoeren
    //deze functie controleert of gebruiker adminrechten heeft
    //de admin gebruiker mag wijzigingen aan de gegevens doorvoeren
    memberOfCompany();

    //height van searchResultZone (colorIndicator)
    //vult minimaal de open ruimte in
    $(window).on('resize', function(){
        var navigation_height = $header.height();
        var colorIndicator_height = $(window).height() - (navigation_height);

        $searchResult_colorIndicator.css("min-height", colorIndicator_height);
    }).trigger('resize');


    //stomme methode om inputfield leeg te maken on click
    $searchForm_inputZoekwaarde.on("click", function(e){
        //voorkom default form afhandeling
        e.preventDefault();

        //inputfield leegmaken
        $searchForm_inputZoekwaarde.val("");

        admin();
    });

    //stomme methode om text terug zwart te maken on click
    $(".searchResultForm_inputDisabled").on("click", function(e){
        //voorkom default form afhandeling
        e.preventDefault();

        $(this).css("color", "#333333");
    });

    //er wordt geklikt op de search button
    //gegevens grabben en doorgeven aan ajax call
    $searchForm_submitCheck.on("click", function(e){
        //voorkom default form afhandeling
        e.preventDefault();

        //set buttonBack_nodig op false
        buttonBack_nodig = false;

        //neem waarde van inputfield searchForm_inputZoekwaarde
        var zoekwaarde = $searchForm_inputZoekwaarde.val();

        //globale variable buttonBack_zoekwaarde setten
        buttonBack_zoekwaarde = zoekwaarde;

        //neem waarde van inputfield searchForm_searchOn
        //waarop gaan we zoeken?
        var zoekOp = $searchForm_searchOn.val();

        //globale variable buttonBack_zoekwaarde setten
        buttonBack_zoekOp = zoekOp;

        //check of gebruiker iets ingegeven heeft
        if($searchForm_inputZoekwaarde.val().length > 2){
            //zoekOp via ajax
            opzoeken(zoekwaarde, zoekOp);
        } else{
            //verberg alle elementen
            $searchResult_geenResultaat.hide();
            $searchResult_aroundTable.hide();
            $searchResultForm.hide();

            //zet bgc rood
            $searchResult_colorIndicator.css("background-color", "Tomato");

            //toon geen resultaat
            $searchResult_nietsIngegeven.show();
        }
    });

    //er wordt geklikt op een link uit de resultatenlijst
    //gegevens grabben en doorgeven aan ajax call
    $(document).on("click", ".searchResult_linkDetail", function(e){
        //voorkom default afhandeling
        e.preventDefault();

        //set buttonBack_nodig op true
        buttonBack_nodig = true;

        //neem waarde van inputfield searchForm_inputZoekwaarde
        var zoekwaarde = $(this).attr('id');

        //zoeken op nummerplaat
        var zoekOp = "searchForm_selectLicenseplate";

        //zoekOp via ajax
        opzoeken(zoekwaarde, zoekOp);
    });

    //button back wordt geklikt
    //terug naar overzichslijst
    $searchResultForm_buttonBack.on("click", function(e) {
        //voorkom default afhandeling
        e.preventDefault();

        //zoekOp via ajax
        opzoeken(buttonBack_zoekwaarde, buttonBack_zoekOp);
    });

    //logica edit / submit button
    $searchResultForm_buttonEdit.on("click", function (e){
        //voorkom default afhandeling
        e.preventDefault();

        //werd button al geklikt?
        if(searchResultForm_buttonEdit_pressed){
            //button gelikt is nee!
            searchResultForm_buttonEdit_pressed = false;

            //zet waarden terug zoals ze stonden
            $searchResultForm_inputMerk.val(cv_Merk);
            $searchResultForm_inputOwner.val(cv_Owner);
            $searchResultForm_selectNplDeleted.val();

            if(cv_NplDeleted == 0){
                $searchResultForm_selectNplDeleted.val("0");
            }else {
                $searchResultForm_selectNplDeleted.val("1");
            }

            //zet alle disabled op disabled
            $(".searchResultForm_inputDisabled").prop("disabled", true).css({"color": "#333", "text-decoration": "none"});

            //verberg submit button
            $searchResultForm_submitUpdate.hide();

            //toon new button
            $searchResultForm_buttonNew.show();

            //wijzig tekst edit button
            $(this).val("Edit");
        }else{
            //button geklikt is ja!
            searchResultForm_buttonEdit_pressed = true;

            //zet alle disabled op enabled
            $(".searchResultForm_inputDisabled").prop("disabled", false).css("text-decoration", "underline");
            $searchResultForm_submitUpdate.show();

            //hide new button
            $searchResultForm_buttonNew.hide();

            //wijzig tekst edit button
            $(this).val("Cancel");
        }
    });

    //waarde oude nummerplaat
    var oude_nummerplaat;
    var oude_merk;
    var oude_owner;
    var oude_nplDeleted;

    //logica add new button
    $searchResultForm_buttonNew.on("click", function (e){
        //voorkom default afhandeling
        e.preventDefault();

        if(searchResultForm_buttonNew_pressed){
            //button geklikt is nee!
            searchResultForm_buttonNew_pressed = false;

            //toon save button
            $searchResultForm_submitNew.hide();

            //verberg edit button
            $searchResultForm_buttonEdit.show();

            //set text of new button
            $searchResultForm_buttonNew.val("Nouveau");

            //zet inputs terug met zwarte tekst
            $(".searchResultForm_inputDisabled").css("color", "#333");

            //zet waarden terug
            $searchResultForm_inputNummerplaat.val(oude_nummerplaat);
            $searchResultForm_inputMerk.val(oude_merk);
            $searchResultForm_inputOwner.val(oude_owner);
            $searchResultForm_selectNplDeleted.val(oude_nummerplaat);

            //zet alle velden weer disabled
            $(".searchResultForm_inputDisabled").prop("disabled", true);

            //verwijder disabled class van nummerplaat field
            $searchResultForm_inputNummerplaat.removeClass("searchResultForm_inputDisabled");
        }else{
            //button geklikt is ja!
            searchResultForm_buttonNew_pressed = true;

            //toon save button
            $searchResultForm_submitNew.show();

            //verberg edit button
            $searchResultForm_buttonEdit.hide();

            //set text of new button
            $searchResultForm_buttonNew.val("Cancel");

            //waarde oude nummerplaat
            oude_nummerplaat = $searchResultForm_inputNummerplaat.val();
            oude_merk = $searchResultForm_inputMerk.val();
            oude_owner = $searchResultForm_inputOwner.val();
            oude_nplDeleted = $searchResultForm_selectNplDeleted.val();

            //velden leegmaken
            $searchResultForm_inputNummerplaat.val("");
            $searchResultForm_inputMerk.val("");
            $searchResultForm_inputOwner.val("");
            $searchResultForm_selectNplDeleted.val("0");

            //geef inputfield nummerplaat disabled class
            $searchResultForm_inputNummerplaat.addClass("searchResultForm_inputDisabled");

            //velden wijzigbaar zetten
            $(".searchResultForm_inputDisabled").prop("disabled", false);

            //maak ook nummerplaatveld wijzigbaar
            $searchResultForm_inputNummerplaat.prop("readonly", false);
        }
    });

    //logica save new button
    $searchResultForm_submitNew.on("click", function(e){
        //voorkom default afhandeling
        e.preventDefault();

        //waarde nieuwe nummerplaat
        var nieuwe_nummerplaat = $searchResultForm_inputNummerplaat.val();
        var nieuwe_merk = $searchResultForm_inputMerk.val();
        var nieuwe_owner = $searchResultForm_inputOwner.val();
        var nieuwe_nplDeleted = $searchResultForm_selectNplDeleted.val();

        if(nieuwe_nummerplaat.length > 10 || nieuwe_merk.length > 20 || nieuwe_owner.length > 30) {
            //toon foute velden
            if(nieuwe_nummerplaat.length > 10){
                $searchResultForm_inputNummerplaat.css('color', 'red');
            }

            if(nieuwe_merk.length > 20){
                $searchResultForm_inputMerk.css('color', 'red');
            }

            if(nieuwe_owner.length > 30){
                $searchResultForm_inputOwner.css('color', 'red');
            }

            //set en toon boodschap
            $searchResultForm_message.text("Vous devez corriger votre encodage.");
            $searchResultForm_message.show().delay(5000).fadeOut();
        }else if(nieuwe_nummerplaat == "" || nieuwe_merk == "" || nieuwe_owner == "" || nieuwe_nplDeleted == ""){
                //set en toon boodschap
                $searchResultForm_message.text("Completez les champs s.v.p");
                $searchResultForm_message.show().delay(5000).fadeOut();
        }else{
            bestaat(nieuwe_nummerplaat);
        }
    });

    //logica edit / submit button
    //functionaliteit nog verder uit te werken, fase 2
    $searchResultForm_submitUpdate.on("click", function (e) {
        //voorkom default afhandeling
        e.preventDefault();

        //waarden uit het formulier
        var nummerplaat = $searchResultForm_inputNummerplaat.val();
        var merk = $searchResultForm_inputMerk.val();
        var owner = $searchResultForm_inputOwner.val();
        var nplDeleted = $searchResultForm_selectNplDeleted.val();

        //als er niets gewijzigd werd
        if(merk == cv_Merk && owner == cv_Owner && nplDeleted == cv_NplDeleted){
            //set en toon boodschap
            $searchResultForm_message.text("Rien à changé.");
            $searchResultForm_message.show().delay(5000).fadeOut();
        }else if(merk.length > 20 || owner.length > 30) {
            if(merk.length > 20){
                $searchResultForm_inputMerk.css('color', 'red');
            }

            if(owner.length > 30){
                $searchResultForm_inputOwner.css('color', 'red');
            }

            //set en toon boodschap
            $searchResultForm_message.text("Vous devez corriger votre encodage.");
            $searchResultForm_message.show().delay(5000).fadeOut();
        }
        else{
            update(nummerplaat, merk, owner, nplDeleted);
        }

    });

    //functie die controleert of user admin is
    //wordt op pageload direct uitgevoerd
    function admin(){
        $.ajax({
            type: 'POST',
            url: '../files/admin.php',
            dataType: 'JSON',
            success: function (data) {
                if(data == false){
                    //verberg edit en add new button
                    $searchResultForm_buttonEdit.hide();
                    $searchResultForm_buttonNew.hide();
                }else{
                    //trigger click on cancel button
                    if(searchResultForm_buttonEdit_pressed){
                        $searchResultForm_buttonEdit.trigger('click');
                    }

                    if(searchResultForm_buttonNew_pressed){
                        $searchResultForm_buttonNew.trigger('click');
                    }
                }
            }
        })
    }

    //functie die controleert tot welke frma gebruiker behoort is
    //wordt op pageload direct uitgevoerd
    function memberOfCompany(){
        $.ajax({
            type: 'POST',
            url: '../files/memberOfCompany.php',
            dataType: 'JSON',
            success: function (data) {
                //set globale firma variable
                memberCompany = data[0]["firma"];
            }
        })
    }

    function opzoeken(zoekwaarde, zoekOp){
        $.ajax({
            type: 'POST',
            url: '../files/search.php',
            data: {zoekwaarde: zoekwaarde, zoekOp: zoekOp},
            dataType: 'JSON',
            success: function (data) {
                toonResultaat(data);
            }
        });
    }

    function update(nummerplaat, merk, owner, nplDeleted){
        $.ajax({
            type: 'POST',
            url: '../files/update.php',
            data: {nummerplaat: nummerplaat, merk: merk, owner: owner, nplDeleted: nplDeleted},
            dataType: 'JSON',
            success: function (data) {
                if(data == true){
                    //controlevariabelen setten
                    cv_Merk = $searchResultForm_inputMerk.val();
                    cv_Owner = $searchResultForm_inputOwner.val();
                    cv_NplDeleted = $searchResultForm_selectNplDeleted.val();

                    //set en toon boodschap
                    $searchResultForm_message.text("Modification des données réussie");
                    $searchResultForm_message.show().delay(5000).fadeOut();

                    //controleer of plaat gearchiveerd gewijzigd werd
                    if($searchResultForm_selectNplDeleted.val() == "1"){
                        //zet bgc oranje
                        $searchResult_colorIndicator.css("background-color", "Orange");
                    }else{
                        //zet bgc groen
                        $searchResult_colorIndicator.css("background-color", "LightGreen");
                    }

                    //wijzig tekst edit button
                    $searchResultForm_buttonEdit.val("Edit");

                    //verberg submit button
                    $searchResultForm_submitUpdate.hide();

                    //toon new button
                    $searchResultForm_buttonNew.show();

                    //button gelikt is nee!
                    searchResultForm_buttonEdit_pressed = false;

                    //zet alle inputs weer op disabled
                    $(".searchResultForm_inputDisabled").prop("disabled", true).css("text-decoration", "none");

                }else{
                    //set en toon boodschap
                    $searchResultForm_message.val("Erreur ...");
                    $searchResultForm_message.show().delay(5000).fadeOut();
                }
            }
        });
    }

    function bestaat(nieuweNummerplaat) {
        $.ajax({
            type: 'POST',
            url: '../files/nummerplaatbestaat.php',
            data: {nummerplaat: nieuweNummerplaat},
            dataType: "json",
            success: function (result) {

                if (result == 0) {
                    $searchResultForm_inputNummerplaat.css('color', 'red');

                    //set en toon boodschap
                    $searchResultForm_message.text("Cette plaque existe déjà.");
                    $searchResultForm_message.show().delay(5000).fadeOut();
                } else {
                    //waarde nieuwe nummerplaat
                    var nieuwe_nummerplaat = $searchResultForm_inputNummerplaat.val();
                    var nieuwe_merk = $searchResultForm_inputMerk.val();
                    var nieuwe_owner = $searchResultForm_inputOwner.val();
                    var nieuwe_nplDeleted = $searchResultForm_selectNplDeleted.val();

                    insert(oude_nummerplaat, nieuwe_nummerplaat, nieuwe_merk, nieuwe_owner, nieuwe_nplDeleted);
                    $searchResultForm_inputNummerplaat.css("color", "#333");
                }
            }
        });
    }

    function insert(oude_nummerplaat, nieuwe_nummerplaat, nieuwe_merk, nieuwe_owner, nieuwe_nplDeleted){
        $.ajax({
            type: 'POST',
            url: '../files/insert.php',
            data: {oude_nummerplaat: oude_nummerplaat, nieuwe_nummerplaat: nieuwe_nummerplaat, nieuwe_merk: nieuwe_merk, nieuwe_owner: nieuwe_owner, nieuwe_nplDeleted: nieuwe_nplDeleted},
            dataType: 'JSON',
            success: function (data) {
                if(data == true){
                    //controlevariabelen setten
                    cv_Merk = $searchResultForm_inputMerk.val();
                    cv_Owner = $searchResultForm_inputOwner.val();
                    cv_NplDeleted = $searchResultForm_selectNplDeleted.val();

                    //set en toon boodschap
                    $searchResultForm_message.text("Les données sont ajoutés.");
                    $searchResultForm_message.show().delay(5000).fadeOut();

                    //controleer of plaat gearchiveerd gewijzigd werd
                    if($searchResultForm_selectNplDeleted.val() == "1"){
                        //zet bgc oranje
                        $searchResult_colorIndicator.css("background-color", "Orange");
                    }else{
                        //zet bgc groen
                        $searchResult_colorIndicator.css("background-color", "LightGreen");
                    }

                    //verberg submit button
                    $searchResultForm_submitNew.hide();

                    //toon new & edit
                    searchResultForm_buttonEdit_pressed = false;
                    searchResultForm_buttonNew_pressed = false;
                    $searchResultForm_buttonNew.val("Nouveau");
                    $searchResultForm_buttonNew.show();
                    $searchResultForm_buttonEdit.val("Edit");
                    $searchResultForm_buttonEdit.show();

                    //zet alle inputs weer op disabled
                    $(".searchResultForm_inputDisabled").prop("disabled", true);

                    //verwijder disabled class van nummerplaat field
                    $searchResultForm_inputNummerplaat.removeClass("searchResultForm_inputDisabled");
                }else{
                    //set en toon boodschap
                    $searchResultForm_message.val("Erreur ...");
                    $searchResultForm_message.show().delay(5000).fadeOut();
                }
            }
        });
    }

    function toonResultaat(array_resultaat){
        //verberg alle elementen
        $searchResult_geenResultaat.hide();
        $searchResult_aroundTable.hide();
        $searchResult_nietsIngegeven.hide();
        $searchResultForm.hide();

        if(array_resultaat.length != 0) {
            //verwijder alle kiddos van vorige zoekopdracht
            $searchResult_table.find("tr:gt(0)").remove();

            //zet bgc groen
            $searchResult_colorIndicator.css("background-color", "LightGreen");

            //als resultaat groter is als 4 > toon overzichtstabel
            if(array_resultaat.length > 4){
                //set opening table body tag
                $searchResult_table.append('<tbody>');

                for(var i = 0; i < array_resultaat.length; i += 4){
                    //setten van alle variabelen
                    var nummerplaat = array_resultaat[i][0]["npl_nummerplaat"];
                    var merk = array_resultaat[i][0]["npl_merk"];
                    var voornaam = array_resultaat[i+1][0]['tit_voornaam'];
                    var achternaam = array_resultaat[i+1][0]["tit_naam"];
                    var firmacode = array_resultaat[i+1][0]["tit_firmacode"];
                    var firma = array_resultaat[i+2][0]['frm_naam'];

                    //als nummerplaat null is niet tonen
                    //heeft toch geen waarde om op verder te zoeken
                    if (nummerplaat != null) {
                        //voeg rij toe aan resultatentabel
                        $searchResult_table.append(
                            '<tr>' +
                            '<td><a class="searchResult_linkDetail" href="" id="' + nummerplaat + '">' + nummerplaat + '</a></td>' +
                            '<td>' + merk + '</td>' +
                            '<td>' + voornaam + ' ' + achternaam + '</td> ' +
                            '<td>' + firma + '</td>' +
                            '</tr>'
                        );
                    }
                }

                //set closing table body tag
                $searchResult_table.append('</tbody>');

                //toon net opgebouwde resultatentabel
                $searchResult_aroundTable.show();
            } else{
                //setten van alle variabelen
                var nummerplaat2 = $.trim(array_resultaat[0][0]["npl_nummerplaat"]);
                var merk2 = $.trim(array_resultaat[0][0]["npl_merk"]);
                var voornaam2 = $.trim(array_resultaat[1][0]['tit_voornaam']);
                var achternaam2 = $.trim(array_resultaat[1][0]["tit_naam"]);
                var firma2 = $.trim(array_resultaat[2][0]['frm_naam']);
                var tel = $.trim(array_resultaat[2][0]['frm_telefoon']);
                var gsm = $.trim(array_resultaat[2][0]['frm_gsm']);
                var straat = $.trim(array_resultaat[2][0]['frm_straat']);
                var huisnummer = $.trim(array_resultaat[2][0]['frm_huisnummer']);
                var postcode= $.trim(array_resultaat[2][0]['frm_postcode']);
                var woonplaats = $.trim(array_resultaat[2][0]['frm_woonplaats']);
                var nummerplaatDeleted = $.trim(array_resultaat[0][0]["npl_deleted"]);
                var titularisDeleted = $.trim(array_resultaat[1][0]["tit_deleted"]);
                var owner = $.trim(array_resultaat[0][0]["npl_eigenaar"]);
                var grpomschrijving = $.trim(array_resultaat[3][0]["grp_omschrijving"]);
                var grpbareelopen = $.trim(array_resultaat[3][0]["grp_bareelopen"]);

                //controlevariabelen setten
                cv_Merk = merk2;
                cv_Owner = owner;
                cv_NplDeleted = nummerplaatDeleted;

                //vervolledigen formulier
                $searchResultForm_inputNummerplaat.val(nummerplaat2);
                $searchResultForm_inputMerk.val(merk2);
                $searchResultForm_inputOwner.val(owner);
                $searchResultForm_inputDriver.val(voornaam2 + " " +achternaam2);
                $searchResultForm_inputFirma.val(firma2);
                $searchResultForm_inputAdres.val(straat + " " + huisnummer + ", " + postcode + " " +woonplaats);
                $searchResultForm_inputTel.val(tel);
                $searchResultForm_inputGsm.val(gsm);
                $searchResultForm_inputTitGrpOmschrijving.val(grpomschrijving);

                if(nummerplaatDeleted == 0){
                    $searchResultForm_selectNplDeleted.val("0");
                }else{
                    $searchResultForm_selectNplDeleted.val("1");

                    //zet bgc oranje
                    $searchResult_colorIndicator.css("background-color", "Orange");
                }

                if(titularisDeleted == 0){
                    $searchResultForm_inputTitDeleted.val("Non");
                }else{
                    $searchResultForm_inputTitDeleted.val("Oui");

                    //zet bgc oranje
                    $searchResult_colorIndicator.css("background-color", "Orange");
                }

                if(grpbareelopen == 1){
                    $searchResultForm_inputTitGrpBareelopen.val("Oui");
                }else{
                    $searchResultForm_inputTitGrpBareelopen.val("Non");

                    //zet bgc oranje
                    $searchResult_colorIndicator.css("background-color", "Orange");
                }

                //check of we back button nodig hebben
                if(buttonBack_nodig){
                    $searchResultForm_buttonBack.show();
                }else{
                    $searchResultForm_buttonBack.hide();
                }

                //toon net opgebouwde formulier met resultaten
                $searchResultForm.show();
            }
        } else{
            //zet bgc rood
            $searchResult_colorIndicator.css("background-color", "Tomato");

            //toon paragraaf geen resultaat
            $searchResult_geenResultaat.show();
        }
    }
});
