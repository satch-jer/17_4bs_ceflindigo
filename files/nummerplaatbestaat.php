<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 14/12/2016
 * Time: 12:43
 */

include_once "../classes/Nummerplaat.class.php";

$nummerplaat = new Nummerplaat();

if($nummerplaat->bestaat(strip_tags($_POST["nummerplaat"])))
{
    echo 0;
}
else
{
    echo 1;
}