<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 14/12/2016
 * Time: 7:29
 */

//includes
include_once "../classes/User.class.php";
include_once "session.php";

//object van type user
$user = new User();

//array die firma gaat teruggeven aan script
$array_firma = array();

//get firma of user
$users = $user->getUserByUsername($_SESSION["username"]);
$user->firma = $users["firma"];

//set firma in sessions
$_SESSION["firma"] = trim($users["firma"], " ");

//voeg firma toe aan array
array_push($array_firma, $user->expose());

//geef firma terug
echo json_encode($array_firma);

