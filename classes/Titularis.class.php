<?php

/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 15:01
 */

//includes
include_once "Db.class.php";

class Titularis
{
    private $tit_matricule;
    private $tit_firmacode;
    private $tit_naam;
    private $tit_voornaam;
    private $tit_grpcode;
    private $tit_deleted;

    public function __set($name, $value)
    {
        // __set() method.
        switch($name)
        {
            case 'matricule':
                $this->tit_matricule = $value;
                break;
            case 'firmacode':
                $this->tit_firmacode = $value;
                break;
            case 'naam':
                $this->tit_naam = $value;
                break;
            case 'voornaam':
                $this->tit_voornaam = $value;
                break;
            case 'deleted':
                $this->tit_deleted = $value;
                break;
            case 'grpcode':
                $this->tit_grpcode = $value;
                break;
            default:
                echo "error: " . $name . " n'existe pas..";
        }
    }

    public function __get($name)
    {
        //  __get() method.
        switch($name)
        {
            case 'matricule':
                return $this->tit_matricule;
            case 'firmacode':
                return $this->tit_firmacode;
            case 'naam':
                return $this->tit_naam;
            case 'voornaam':
                return $this->tit_voornaam;
            case 'grpcode':
                return $this->tit_grpcode;
            case 'deleted':
                return $this->tit_deleted;
            default;
                echo "error: " . $name . " n'existe pas..";
        }
    }

    public function getByMatricule($matricule)
    {
        //open connection
        $db = Db::getInstance();

        //db query
        $stmt = $db->prepare("select TITMatricule, TITFirmacode, TITNaam, TITVoornaam, TITGRPCode, TITDeleted  from S_TIT where TITMatricule like :val ");
        $stmt->bindParam(':val', $matricule);
        $stmt->execute();

        //execute query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //close connection
        $db = null;

        //return result
        return $result;
    }

    public function getByName($name){
        //open connection
        $db = Db::getInstance();

        //wildcards
        $nm = "%" . $name . "%";

        //db query
        //concat over naam en voornaam
        $stmt = $db->prepare("select TITMatricule, TITFirmacode, TITNaam, TITVoornaam, TITGRPCode, TITDeleted  from S_TIT where RTRIM(LTRIM(TITNaam)) + ' ' + RTRIM(LTRIM(TITVoornaam)) LIKE :val1 OR RTRIM(LTRIM(TITVoornaam)) + ' ' + RTRIM(LTRIM(TITNaam)) LIKE :val2");
        $stmt->bindParam(':val1', $nm);
        $stmt->bindParam(':val2', $nm);
        $stmt->execute();

        //execute query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //close connection
        $db = null;

        //return result
        return $result;
    }

    public function getByFirmacode($firmacode){
        //open connection
        $db = Db::getInstance();

        //db query
        //concat over naam en voornaam
        $stmt = $db->prepare("select TITMatricule, TITFirmacode, TITNaam, TITVoornaam, TITGRPCode, TITDeleted  from S_TIT where TITFirmacode LIKE :val");
        $stmt->bindParam(':val', $firmacode);
        $stmt->execute();

        //execute query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //close connection
        $db = null;

        //return result
        return $result;
    }

    public function expose()
    {
        return get_object_vars($this);
    }
}