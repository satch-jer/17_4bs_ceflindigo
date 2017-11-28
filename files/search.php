<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 15:20
 */

//includes
include_once "../classes/Nummerplaat.class.php";
include_once "../classes/Titularis.class.php";
include_once "../classes/Firma.class.php";
include_once "../classes/Grp.class.php";
include_once "session.php";

//sessionvar betrokkenFirma
$betrokken_firma = $_SESSION["firma"];

//object van type Nummerplaat
$nummerplaat = new Nummerplaat();

//object van type Titularis
$titularis = new Titularis();

//object van type Firma
$firma = new Firma();

//object van type Grp
$grp = new Grp();

//array die resultaat gaat teruggeven aan script
$array_resultaat = array();

if($_POST["zoekOp"] == "searchForm_selectLicenseplate") {

    //deze var bevat alle gevonden nummerplaten
    $nummerplaten = $nummerplaat->getByNummerplaat(strip_tags($_POST["zoekwaarde"]));

    for ($i = 0; $i < count($nummerplaten); $i++) {
        //nieuw object 'gevonden' nummerplaat
        $gevondenNummerplaat = new Nummerplaat();

        //array voor gevonden nummerplaat
        $array_nummerplaat = array();

        //set waarden van gevonden nummerplaat
        $gevondenNummerplaat->matricule = $nummerplaten[$i]["NPLMatricule"];
        $gevondenNummerplaat->nummerplaat = $nummerplaten[$i]["NPLNummerplaat"];
        $gevondenNummerplaat->merk = $nummerplaten[$i]["NPLMerk"];
        $gevondenNummerplaat->eigenaar = $nummerplaten[$i]["NPLEigenaar"];
        $gevondenNummerplaat->deleted = $nummerplaten[$i]["NPLDeleted"];

        //push gevonden nummerplaat in nummerplaten array
        array_push($array_nummerplaat, $gevondenNummerplaat->expose());

        //deze var bevat de gevonden titularis
        $titularissen = $titularis->getByMatricule($gevondenNummerplaat->matricule);

        //nieuw object 'gevonden' titularis
        $gevondenTitularis = new Titularis();

        //array voor gevonden titularis
        $array_titularis = array();

        //set waarden van gevonden titularis
        $gevondenTitularis->matricule = $titularissen[0]["TITMatricule"];
        $gevondenTitularis->firmacode = $titularissen[0]["TITFirmacode"];
        $gevondenTitularis->naam = $titularissen[0]["TITNaam"];
        $gevondenTitularis->voornaam = $titularissen[0]["TITVoornaam"];
        $gevondenTitularis->grpcode = $titularissen[0]["TITGRPCode"];
        $gevondenTitularis->deleted = $titularissen[0]["TITDeleted"];

        //push gevonden nummerplaat in nummerplaten array
        array_push($array_titularis, $gevondenTitularis->expose());

        //deze var bevat de gevonden firma
        $firmas = $firma->getByFirmacode($gevondenTitularis->firmacode);

        //nieuw object 'gevonden' firma
        $gevondenFirma = new Firma();

        //array voor gevonden firma
        $array_firma = array();

        //set waarden van gevonden titularis
        $gevondenFirma->code = $firmas[0]["FRMCode"];
        $gevondenFirma->naam = $firmas[0]["FRMNaam"];
        $gevondenFirma->straat = $firmas[0]["FRMStraat"];
        $gevondenFirma->huisnummer = $firmas[0]["FRMHuisnummer"];
        $gevondenFirma->postcode = $firmas[0]["FRMPostcode"];
        $gevondenFirma->woonplaats = $firmas[0]["FRMWoonplaats"];
        $gevondenFirma->telefoon = $firmas[0]["FRMTelefoon"];
        $gevondenFirma->gsm = $firmas[0]["FRMGsm"];
        $gevondenFirma->btw = $firmas[0]["FRMBtw"];

        //push gevonden nummerplaat in nummerplaten array
        array_push($array_firma, $gevondenFirma->expose());

        //bevat gevonden gpr
        $grps = $grp->getByGrp($titularissen[0]["TITGRPCode"]);

        //nieuw object voor gevonden grp
        $gevondenGrp = new Grp();

        //array voor gevonden grp
        $array_grp = array();

        $gevondenGrp->code = $grps[0]["GRPCode"];
        $gevondenGrp->omschrijving = $grps[0]["GRPOmschrijving"];
        $gevondenGrp->bareelopen = $grps[0]["GRPSlagboomOpen"];

        //push gevonden grp in grp array
        array_push($array_grp, $gevondenGrp->expose());

        if($betrokken_firma == "" || $betrokken_firma == null || $betrokken_firma == trim($gevondenFirma->code, ' ')){
            //push gevonden nummerplaat in array
            array_push($array_resultaat, $array_nummerplaat, $array_titularis, $array_firma, $array_grp);
        }
    }
}else if($_POST["zoekOp"] == "searchForm_selectDriver") {

    //deze var bevat ale gevonden titularissen
    $titularissen = $titularis->getByName((strip_tags($_POST["zoekwaarde"])));

    for ($i = 0; $i < count($titularissen); $i++) {
        //nieuw object 'gevonden' titularis
        $gevondenTitularis = new Titularis();

        //array voor gevonden titularis
        $array_titularis = array();

        //set waarden van gevonden titularis
        $gevondenTitularis->matricule = $titularissen[$i]["TITMatricule"];
        $gevondenTitularis->firmacode = $titularissen[$i]["TITFirmacode"];
        $gevondenTitularis->naam = $titularissen[$i]["TITNaam"];
        $gevondenTitularis->voornaam = $titularissen[$i]["TITVoornaam"];
        $gevondenTitularis->grpcode = $titularissen[$i]["TITGRPCode"];
        $gevondenTitularis->deleted = $titularissen[$i]["TITDeleted"];

        //deze var bevat de gevonden nummerplaten
        $nummerplaten = $nummerplaat->getByMatricule($gevondenTitularis->matricule);

        for($j = 0; $j < count($nummerplaten); $j++){
            //nieuw object 'gevonden' nummerplaat
            $gevondenNummerplaat = new Nummerplaat();

            //array voor gevonden nummerplaat
            $array_nummerplaat = array();

            //set waarden van gevonden nummerplaat
            $gevondenNummerplaat->matricule = $nummerplaten[$j]["NPLMatricule"];
            $gevondenNummerplaat->nummerplaat = $nummerplaten[$j]["NPLNummerplaat"];
            $gevondenNummerplaat->merk = $nummerplaten[$j]["NPLMerk"];
            $gevondenNummerplaat->eigenaar = $nummerplaten[$j]["NPLEigenaar"];
            $gevondenNummerplaat->deleted = $nummerplaten[$j]["NPLDeleted"];

            //push gevonden nummerplaat in nummerplaten array
            array_push($array_nummerplaat, $gevondenNummerplaat->expose());

            //deze var bevat de gevonden firma
            $firmas = $firma->getByFirmacode($gevondenTitularis->firmacode);

            //nieuw object 'gevonden' firma
            $gevondenFirma = new Firma();

            //array voor gevonden firma
            $array_firma = array();

            //set waarden van gevonden firma
            $gevondenFirma->code = $firmas[0]["FRMCode"];
            $gevondenFirma->naam = $firmas[0]["FRMNaam"];
            $gevondenFirma->straat = $firmas[0]["FRMStraat"];
            $gevondenFirma->huisnummer = $firmas[0]["FRMHuisnummer"];
            $gevondenFirma->postcode = $firmas[0]["FRMPostcode"];
            $gevondenFirma->woonplaats = $firmas[0]["FRMWoonplaats"];
            $gevondenFirma->telefoon = $firmas[0]["FRMTelefoon"];
            $gevondenFirma->gsm = $firmas[0]["FRMGsm"];
            $gevondenFirma->btw = $firmas[0]["FRMBtw"];

            //push gevonden firma in firma array
            array_push($array_firma, $gevondenFirma->expose());

            //push gevonden nummerplaat in nummerplaten array
            array_push($array_titularis, $gevondenTitularis->expose());

            //bevat gevonden gpr
            $grps = $grp->getByGrp($titularissen[0]["TITGRPCode"]);

            //nieuw object voor gevonden grp
            $gevondenGrp = new Grp();

            //array voor gevonden grp
            $array_grp = array();

            $gevondenGrp->code = $grps[0]["GRPCode"];
            $gevondenGrp->omschrijving = $grps[0]["GRPOmschrijving"];
            $gevondenGrp->bareelopen = $grps[0]["GRPSlagboomOpen"];

            //push gevonden grp in grp array
            array_push($array_grp, $gevondenGrp->expose());

            //alleen pushen wanneer user het mag zien
            if($betrokken_firma == "" || $betrokken_firma == null || $betrokken_firma == trim($gevondenFirma->code, ' ')) {
                //push gevonden nummerplaat in array
                array_push($array_resultaat, $array_nummerplaat, $array_titularis, $array_firma, $array_grp);
            }
        }
    }
} else if($_POST["zoekOp"] == "searchForm_selectFirm") {

    //deze var bevat ale gevonden titularissen
    $firmas = $firma->getByName((strip_tags($_POST["zoekwaarde"])));

    for ($i = 0; $i < count($firmas); $i++) {
        //nieuw object 'gevonden' firma
        $gevondenFirma = new Firma();

        //array voor gevonden firma
        $array_firma = array();

        //set waarden van gevonden firma
        $gevondenFirma->code = $firmas[$i]["FRMCode"];
        $gevondenFirma->naam = $firmas[$i]["FRMNaam"];
        $gevondenFirma->straat = $firmas[$i]["FRMStraat"];
        $gevondenFirma->huisnummer = $firmas[$i]["FRMHuisnummer"];
        $gevondenFirma->postcode = $firmas[$i]["FRMPostcode"];
        $gevondenFirma->woonplaats = $firmas[$i]["FRMWoonplaats"];
        $gevondenFirma->telefoon = $firmas[$i]["FRMTelefoon"];
        $gevondenFirma->gsm = $firmas[$i]["FRMGsm"];
        $gevondenFirma->btw = $firmas[$i]["FRMBtw"];

        //TO DO
        //Nog een for nodig?
        $titularissen = $titularis->getByFirmacode($gevondenFirma->code);

        for($j = 0; $j < count($titularissen); $j++){
            //nieuw object 'gevonden' titularis
            $gevondenTitularis = new Titularis();

            //array voor gevonden titularis
            $array_titularis = array();

            //set waarden van gevonden titularis
            $gevondenTitularis->matricule = $titularissen[$j]["TITMatricule"];
            $gevondenTitularis->firmacode = $titularissen[$j]["TITFirmacode"];
            $gevondenTitularis->naam = $titularissen[$j]["TITNaam"];
            $gevondenTitularis->voornaam = $titularissen[$j]["TITVoornaam"];
            $gevondenTitularis->grpcode = $titularissen[$j]["TITGRPCode"];
            $gevondenTitularis->deleted = $titularissen[$j]["TITDeleted"];

            //bevat gevonden gpr
            $grps = $grp->getByGrp($titularissen[0]["TITGRPCode"]);

            //nieuw object voor gevonden grp
            $gevondenGrp = new Grp();

            //array voor gevonden grp
            $array_grp = array();

            $gevondenGrp->code = $grps[0]["GRPCode"];
            $gevondenGrp->omschrijving = $grps[0]["GRPOmschrijving"];
            $gevondenGrp->bareelopen = $grps[0]["GRPSlagboomOpen"];

            //push gevonden grp in grp array
            array_push($array_grp, $gevondenGrp->expose());

            //deze var bevat de gevonden nummerplaten
            $nummerplaten = $nummerplaat->getByMatricule($gevondenTitularis->matricule);

            for($k = 0; $k < count($nummerplaten); $k++){
                //nieuw object 'gevonden' nummerplaat
                $gevondenNummerplaat = new Nummerplaat();

                //array voor gevonden nummerplaat
                $array_nummerplaat = array();

                //set waarden van gevonden nummerplaat
                $gevondenNummerplaat->matricule = $nummerplaten[$k]["NPLMatricule"];
                $gevondenNummerplaat->nummerplaat = $nummerplaten[$k]["NPLNummerplaat"];
                $gevondenNummerplaat->merk = $nummerplaten[$k]["NPLMerk"];
                $gevondenNummerplaat->eigenaar = $nummerplaten[$k]["NPLEigenaar"];
                $gevondenNummerplaat->deleted = $nummerplaten[$k]["NPLDeleted"];

                //push gevonden nummerplaat in nummerplaten array
                array_push($array_titularis, $gevondenTitularis->expose());

                //push gevonden nummerplaat in nummerplaten array
                array_push($array_nummerplaat, $gevondenNummerplaat->expose());

                //push gevonden nummerplaat in nummerplaten array
                array_push($array_firma, $gevondenFirma->expose());

                //alleen pushen wanneer user het mag zien
                if($betrokken_firma == "" || $betrokken_firma == null || $betrokken_firma == trim($gevondenFirma->code, ' ')) {
                    //push gevonden nummerplaat in array
                    array_push($array_resultaat, $array_nummerplaat, $array_titularis, $array_firma, $array_grp);
                }
            }
        }
    }
}else if($_POST["zoekOp"] == "searchForm_selectDomicile") {

    //deze var bevat ale gevonden titularissen
    $firmas = $firma->getByWoonplaats((strip_tags($_POST["zoekwaarde"])));

    for ($i = 0; $i < count($firmas); $i++) {
        //nieuw object 'gevonden' firma
        $gevondenFirma = new Firma();

        //array voor gevonden firma
        $array_firma = array();

        //set waarden van gevonden firma
        $gevondenFirma->code = $firmas[$i]["FRMCode"];
        $gevondenFirma->naam = $firmas[$i]["FRMNaam"];
        $gevondenFirma->straat = $firmas[$i]["FRMStraat"];
        $gevondenFirma->huisnummer = $firmas[$i]["FRMHuisnummer"];
        $gevondenFirma->postcode = $firmas[$i]["FRMPostcode"];
        $gevondenFirma->woonplaats = $firmas[$i]["FRMWoonplaats"];
        $gevondenFirma->telefoon = $firmas[$i]["FRMTelefoon"];
        $gevondenFirma->gsm = $firmas[$i]["FRMGsm"];
        $gevondenFirma->btw = $firmas[$i]["FRMBtw"];

        //TO DO
        //Nog een for nodig?
        $titularissen = $titularis->getByFirmacode($gevondenFirma->code);

        for($j = 0; $j < count($titularissen); $j++){
            //nieuw object 'gevonden' titularis
            $gevondenTitularis = new Titularis();

            //array voor gevonden titularis
            $array_titularis = array();

            //set waarden van gevonden titularis
            $gevondenTitularis->matricule = $titularissen[$j]["TITMatricule"];
            $gevondenTitularis->firmacode = $titularissen[$j]["TITFirmacode"];
            $gevondenTitularis->naam = $titularissen[$j]["TITNaam"];
            $gevondenTitularis->voornaam = $titularissen[$j]["TITVoornaam"];
            $gevondenTitularis->grpcode = $titularissen[$j]["TITGRPCode"];
            $gevondenTitularis->deleted = $titularissen[$j]["TITDeleted"];

            //bevat gevonden gpr
            $grps = $grp->getByGrp($titularissen[0]["TITGRPCode"]);

            //nieuw object voor gevonden grp
            $gevondenGrp = new Grp();

            //array voor gevonden grp
            $array_grp = array();

            $gevondenGrp->code = $grps[0]["GRPCode"];
            $gevondenGrp->omschrijving = $grps[0]["GRPOmschrijving"];
            $gevondenGrp->bareelopen = $grps[0]["GRPSlagboomOpen"];

            //push gevonden grp in grp array
            array_push($array_grp, $gevondenGrp->expose());

            //deze var bevat de gevonden nummerplaten
            $nummerplaten = $nummerplaat->getByMatricule($gevondenTitularis->matricule);

            for($k = 0; $k < count($nummerplaten); $k++){
                //nieuw object 'gevonden' nummerplaat
                $gevondenNummerplaat = new Nummerplaat();

                //array voor gevonden nummerplaat
                $array_nummerplaat = array();

                //set waarden van gevonden nummerplaat
                $gevondenNummerplaat->matricule = $nummerplaten[$k]["NPLMatricule"];
                $gevondenNummerplaat->nummerplaat = $nummerplaten[$k]["NPLNummerplaat"];
                $gevondenNummerplaat->merk = $nummerplaten[$k]["NPLMerk"];
                $gevondenNummerplaat->eigenaar = $nummerplaten[$k]["NPLEigenaar"];
                $gevondenNummerplaat->deleted = $nummerplaten[$k]["NPLDeleted"];

                //push gevonden nummerplaat in nummerplaten array
                array_push($array_titularis, $gevondenTitularis->expose());

                //push gevonden nummerplaat in nummerplaten array
                array_push($array_nummerplaat, $gevondenNummerplaat->expose());

                //push gevonden nummerplaat in nummerplaten array
                array_push($array_firma, $gevondenFirma->expose());

                //alleen pushen wanneer user het mag zien
                if($betrokken_firma == "" || $betrokken_firma == null || $betrokken_firma == trim($gevondenFirma->code, ' ')) {
                    //push gevonden nummerplaat in array
                    array_push($array_resultaat, $array_nummerplaat, $array_titularis, $array_firma, $array_grp);
                }
            }
        }
    }
}

//gevonden nummerplaten retourneren naar script
//0 = nummerplaat 1 = titularis 2 = firma 3 = grp
echo json_encode($array_resultaat);