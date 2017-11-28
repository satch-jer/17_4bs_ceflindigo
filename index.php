<?php
/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 13:51
 */

//includes
include_once "classes/User.class.php";
include_once "files/login.php";
include_once "files/session.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>cefl car checker</title>
    <link rel="stylesheet" type="text/css" href="public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div id="loginPage_divContainer">
        <div id="loginPage_divForm">
            <h1>CEFL</h1>

            <form action="" method="post" autocomplete="off">
                <input type="text" name="loginForm_inputUsername" placeholder="username"><br>
                <input type="password" name="loginForm_inputPassword" placeholder="password"><br>
                <input type="submit" name="loginForm_submitLogin" value="login"><br>
                <p id="loginForm_errorMessage"> <?php echo $loginForm_errorMessage?></p>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</body>
</html>
