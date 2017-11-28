<?php

/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 14:04
 */

//includes
include_once "Db.class.php";

class User
{
    private $username;
    private $password;
    private $admin;
    private $firma;

    public function __set($property, $value){
        switch($property){
            case 'username':
                $this->username = $value;
                break;
            case 'password':
                $this->password = $value;
                break;
            case 'admin':
                $this->admin = $value;
                break;
            case 'firma':
                $this->firma = $value;
                break;
            default:
                echo "error: " . $property . " n'existe pas..";
        }
    }

    public function __get($property){
        switch($property){
            case 'username':
                return $this->username;
            case 'password':
                return $this->password;
            case 'admin':
                return $this->admin;
            case 'firma':
                return $this->firma;
            default:
                echo "error: " . $property . " does not exist.";
        }
    }

    public function getUserByUsername($username){
        $db = Db::getInstance();

        $stmt = $db->prepare("select * from S_USER where username = :val ");
        $stmt->bindParam(':val', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function logIn($username, $password){
        $result = $this->getUserByUsername($username);

        $trimmed_pass = trim($result["password"], " ");

        if(password_verify($password, $trimmed_pass)){
            return true;
        }else{
            return false;
        }
    }

    public function isUserAdmin($username){
        $result = $this->getUserByUsername($username);

        if($result["admin"]){
            return true;
        }else{
            return false;
        }
    }

    public function isUserMemberOfCompany($username){
        $result = $this->getUserByUsername($username);

        $trimmed_firma = trim($result["firma"], " ");

        if($trimmed_firma != null){
            return true;
        }else{
            return false;
        }
    }

    public function expose()
    {
        return get_object_vars($this);
    }
}