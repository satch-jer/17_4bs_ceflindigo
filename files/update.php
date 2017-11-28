<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 13/12/2016
 * Time: 8:36
 */

//includes
include_once "../classes/Nummerplaat.class.php";
include_once "../classes/Titularis.class.php";
include_once "../classes/Firma.class.php";
include_once "../files/session.php";

//get session username
//user die wijzigingen aanbrengt dient opgeslagen te worden
$user = $_SESSION["username"];

//creër nieuw object
$nummerplaat = new Nummerplaat();

//set states
$nummerplaat->nummerplaat = strip_tags($_POST["nummerplaat"]);
$nummerplaat->merk = strip_tags($_POST["merk"]);
$nummerplaat->eigenaar = strip_tags($_POST["owner"]);

if($_POST["nplDeleted"] == "0"){
    $nummerplaat->deleted = false;
}else{
    $nummerplaat->deleted = true;
}

//update
$status = $nummerplaat->update($nummerplaat->merk, $nummerplaat->eigenaar, $nummerplaat->deleted, $user, $nummerplaat->nummerplaat);

//geef status van update terug
//gelukt of mislukt
echo json_encode($status);




