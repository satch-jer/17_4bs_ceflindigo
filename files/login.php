<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 13:59
 */

include_once "../classes/User.class.php";
include_once "session.php";

if(isset($_POST["loginForm_submitLogin"])){
    try{
        $user = new User();

        $user->username = strip_tags($_POST["loginForm_inputUsername"]);
        $user->password = strip_tags($_POST["loginForm_inputPassword"]);

        if($user->logIn($user->username, $user->password)){
            $_SESSION["username"] = strtoupper($user->username);
            header("location: public/main.php");
        }else{
            $loginForm_errorMessage = "le login est échoue";
        }
    }catch(Exception $e){
        $loginForm_errorMessage = $e->getMessage();
    }
}
