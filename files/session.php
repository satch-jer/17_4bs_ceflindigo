<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 14:05
 */

session_start();

function loggedIn(){
    if(isset($_SESSION["username"]) && !empty($_SESSION["username"])){
        header("location: ../public/main.php");
    }
}