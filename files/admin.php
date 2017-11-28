<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 8/12/2016
 * Time: 15:40
 */

//includes
include_once "../classes/User.class.php";
include_once "session.php";

//object van type user
$user = new User();

//controleren of user administrator is
if($user->isUserAdmin($_SESSION["username"])){
    echo json_encode(true);
}else{
    echo json_encode(false);
}
