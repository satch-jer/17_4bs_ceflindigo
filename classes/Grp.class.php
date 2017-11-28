<?php

/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 15:04
 */

//includes
include_once "Db.class.php";

class Grp
{
    private $grp_code;
    private $grp_omschrijving;
    private $grp_bareelopen;

    public function __set($name, $value)
    {
        // __set() method.
        switch($name)
        {
            case 'code':
                $this->grp_code = $value;
                break;
            case 'omschrijving':
                $this->grp_omschrijving = $value;
                break;
            case 'bareelopen':
                $this->grp_bareelopen= $value;
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
                return $this->grp_code;
            case 'omschrijving':
                return $this->grp_omschrijving;
            case 'bareelopen':
                return $this->grp_bareelopen;
            default;
                echo "error: " . $name . " n'existe pas..";
        }
    }

    public function getByGrp($code)
    {
        //open connection
        $db = Db::getInstance();

        //db query
        $stmt = $db->prepare("select * from P_GRP where GRPCode like :val ");
        $stmt->bindParam(':val', $code);
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