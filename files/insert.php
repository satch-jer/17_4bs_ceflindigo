<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 13/12/2016
 * Time: 8:36
 */

//includes
include_once "../classes/Nummerplaat.class.php";
include_once "../files/session.php";

//get session username
//user die wijzigingen aanbrengt dient opgeslagen te worden
$user = $_SESSION["username"];

//creër nieuw object
$nummerplaat = new Nummerplaat();

//deze var bevat benodigde info over oude nummerplaat
$nummerplaten = $nummerplaat->getByNummerplaat(strip_tags($_POST["oude_nummerplaat"]));

//oude nummerplaat
//creër nieuw object
$oude_nummerplaat = new Nummerplaat();

//neem matricule van oude nummerplaat
$oude_nummerplaat->matricule = $nummerplaten[0]["NPLMatricule"];

//set gegevens nieuwe nummerplaat
$nummerplaat->matricule = $oude_nummerplaat->matricule;
$nummerplaat->merk = strip_tags($_POST["nieuwe_merk"]);
$nummerplaat->nummerplaat = strip_tags($_POST["nieuwe_nummerplaat"]);
$nummerplaat->eigenaar = strip_tags($_POST["nieuwe_owner"]);

if($_POST["nieuwe_nplDeleted"] == "0"){
    $nummerplaat->deleted = false;
}else{
    $nummerplaat->deleted = true;
}

//insert
$status = $nummerplaat->toevoegen($nummerplaat->matricule, $nummerplaat->nummerplaat, $nummerplaat->merk, $nummerplaat->deleted, $nummerplaat->eigenaar, $user);

//geef status van update terug
//gelukt of mislukt
echo json_encode($status);