<?php

/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 15:04
 */

//includes
include_once "Db.class.php";

class Firma
{
    private $frm_code;
    private $frm_naam;
    private $frm_straat;
    private $frm_huisnummer;
    private $frm_postcode;
    private $frm_woonplaats;
    private $frm_telefoon;
    private $frm_gsm;
    private $frm_btw;

    public function __set($name, $value)
    {
        // __set() method.
        switch($name)
        {
            case 'code':
                $this->frm_code = $value;
                break;
            case 'naam':
                $this->frm_naam = $value;
                break;
            case 'straat':
                $this->frm_straat= $value;
                break;
            case 'huisnummer':
                $this->frm_huisnummer = $value;
                break;
            case 'postcode':
                $this->frm_postcode = $value;
                break;
            case 'woonplaats':
                $this->frm_woonplaats = $value;
                break;
            case 'telefoon':
                $this->frm_telefoon = $value;
                break;
            case 'gsm':
                $this->frm_gsm = $value;
                break;
            case 'btw':
                $this->frm_btw = $value;
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
            case 'code':
                return $this->frm_code;
            case 'naam':
                return $this->frm_naam;
            case 'straat':
                return $this->frm_straa;
            case 'huisnummer':
                return $this->frm_huisnummer;
            case 'postcode':
                return $this->frm_postcode;
            case 'woonplaats':
                return $this->frm_woonplaats;
            case 'telefoon':
                return $this->frm_telefoon;
            case 'gsm':
                return $this->frm_gsm;
            case 'btw':
                return $this->frm_btw;
            default;
                echo "error: " . $name . " n'existe pas..";
        }
    }

    public function getByFirmacode($firmacode)
    {
        //open connection
        $db = Db::getInstance();

        //db query
        $stmt = $db->prepare("select * from S_FRM where FRMCode like :val ");
        $stmt->bindParam(':val', $firmacode);
        $stmt->execute();

        //execute query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //close connection
        $db = null;

        //return result
        return $result;
    }

    public function getByName($firmanaam){
        //open connection
        $db = Db::getInstance();

        //wildcards
        $fn = "%" . $firmanaam . "%";

        //db query
        //concat over naam en voornaam
        $stmt = $db->prepare("select * from S_FRM where FRMNaam like :val1 OR FRMBtw like :val2");
        $stmt->bindParam(':val1', $fn);
        $stmt->bindParam(':val2', $fn);
        $stmt->execute();

        //execute query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //close connection
        $db = null;

        //return result
        return $result;
    }

    public function getByWoonplaats($woonplaats){
        //open connection
        $db = Db::getInstance();

        //wildcards
        $wp = "%" . $woonplaats . "%";

        //db query
        $stmt = $db->prepare("select * from S_FRM where FRMWoonplaats like :val1");
        $stmt->bindParam(':val1', $wp);
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