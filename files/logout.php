/**
* Created by PhpStorm.
* User: Jeroen
* Date: 8/12/2016
* Time: 15:32
*/

<?php

include_once 'session.php';

//beeindig session
session_destroy();

//terug naar login
header('location: ../index.php');