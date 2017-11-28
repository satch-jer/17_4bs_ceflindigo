<?php

/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 14:53
 */

//includes
include_once "Db.class.php";

class Nummerplaat
{
    private $npl_matricule;
    private $npl_nummerplaat;
    private $npl_merk;
    private $npl_eigenaar;
    private $npl_deleted;

    public function __set($name, $value)
    {
        // __set() method.
        switch($name)
        {
            case 'matricule':
                $this->npl_matricule = $value;
                break;
            case 'nummerplaat':
                $this->npl_nummerplaat = $value;
                break;
            case 'merk':
                $this->npl_merk = $value;
                break;
            case 'eigenaar':
                $this->npl_eigenaar = $value;
                break;
            case 'deleted':
                $this->npl_deleted = $value;
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
                return $this->npl_matricule;
            case 'nummerplaat':
                return $this->npl_nummerplaat;
            case 'merk':
                return $this->npl_merk;
            case 'eigenaar':
                return $this->npl_eigenaar;
            case 'deleted':
                return $this->npl_deleted;
            default;
                echo "error: " . $name . " n'existe pas..";
        }
    }

    public function getByNummerplaat($nummerplaat)
    {
        //open connection
        $db = Db::getInstance();

        //wildcards
        $npl = "%" . $nummerplaat . "%";

        //db query
        $stmt = $db->prepare("select NPLMatricule, NPLNummerplaat, NPLMerk, NPLEigenaar, NPLDeleted  from S_NPL where NPLNummerplaat like :val ");
        $stmt->bindParam(':val', $npl);
        $stmt->execute();

        //execute query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //close connection
        $db = null;

        //return result
        return $result;
    }

    public function getByMatricule($matricule)
    {
        //open connection
        $db = Db::getInstance();

        //db query
        $stmt = $db->prepare("select NPLMatricule, NPLNummerplaat, NPLMerk, NPLEigenaar, NPLDeleted  from S_NPL where NPLMatricule like :val ");
        $stmt->bindParam(':val', $matricule);
        $stmt->execute();

        //execute query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //close connection
        $db = null;

        //return result
        return $result;
    }

    public function update($merk, $owner, $deleted, $lastuser, $nummerplaat){
        //open connection
        $db = Db::getInstance();

        //db query
        $stmt = $db->prepare("update S_NPL SET NPLMerk = :val1, NPLEigenaar = :val2, NPLDeleted = :val3, NPLLastUser = :val4 where NPLNummerplaat = :val5");
        $stmt->bindParam(':val1', $merk);
        $stmt->bindParam(':val2', $owner);
        $stmt->bindParam(':val3', $deleted);
        $stmt->bindParam(':val4', $lastuser);
        $stmt->bindParam(':val5', $nummerplaat);

        $status = $stmt->execute();

        //close connection
        $db = null;

        //return update success
        return $status;
    }

    public function toevoegen($matricule, $nummerplaat, $merk, $deleted, $owner, $lastuser){
        //open connection
        $db = Db::getInstance();

        //db query
        $stmt = $db->prepare("insert into S_NPL (NPLMatricule, NPLNummerplaat, NPLMerk, NPLEigenaar, NPLDeleted, NPLLastUser) VALUES (:val1, :val2, :val3, :val4, :val5, :val6)");
        $stmt->bindParam(':val1', $matricule);
        $stmt->bindParam(':val2', $nummerplaat);
        $stmt->bindParam(':val3', $merk);
        $stmt->bindParam(':val4', $owner);
        $stmt->bindParam(':val5', $deleted);
        $stmt->bindParam(':val6', $lastuser);

        $status = $stmt->execute();

        //close connection
        $db = null;

        //return update success
        return $status;
    }

    //controleer of nummerplaat staat
    public function bestaat($nummerplaat){
        //open connection
        $db = Db::getInstance();

        //wildcards
        $npl = "%" . $nummerplaat . "%";

        //db query
        $stmt = $db->prepare("select NPLMatricule, NPLNummerplaat, NPLMerk, NPLEigenaar, NPLDeleted  from S_NPL where NPLNummerplaat like :val ");
        $stmt->bindParam(':val', $npl);
        $stmt->execute();

        //execute query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //close connection
        $db = null;

        if(count($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function expose()
    {
        return get_object_vars($this);
    }
}