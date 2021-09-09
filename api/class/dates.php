<?php
// this class for interacting with date table
// CRUD On date table

class date
{
    private $conn;

    public $sDate;
    public $eDate;
    public $dateID;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createDate()
    {
        $sqlquery = "INSERT INTO  date
        (sDate, eDate) VALUES
        (:sDate,:eDate)
        ";
        $stmt = $this->conn->prepare($sqlquery);
        $this->sDate = htmlspecialchars(strip_tags($this->sDate));
        $this->eDate = htmlspecialchars(strip_tags($this->eDate));
        $stmt->bindParam(":sDate", $this->sDate);
        $stmt->bindParam(":eDate", $this->eDate);

        if ($stmt->execute()) {
            $last_id = $this->conn->lastInsertId();
            return $last_id;
        }
        echo "error creating date";
        return false;
    }
    public function updateDate()
    {
        /*$sqlquery = "UPDATE date SET
        sDate=:sDate
        eDate=:sDate
        WHERE dateID= 8";*/
        $sqlquery = "update date set sDate=:sDate, eDate=:eDate where dateID=:dateID";

        $stmt = $this->conn->prepare($sqlquery);
        $this->sDate = htmlspecialchars(strip_tags($this->sDate));
        $this->eDate = htmlspecialchars(strip_tags($this->eDate));
        $this->dateID = htmlspecialchars(strip_tags($this->dateID));
        $stmt->bindParam(":sDate", $this->sDate);
        $stmt->bindParam(":eDate", $this->eDate);
        $stmt->bindParam(":dateID", $this->dateID);
        if ($stmt->execute()) {
            return true;
        }
        echo "error update date";
        return false;
    }
}
/*include_once "../config/connection.php";
$database = new Database();
$db = $database->getConnection();
$dt = new date($db);
$dt->dateID = "8";
$dt->sDate = "2000-12-18 00:00:00";
$dt->eDate = "2120-12-11 13:17:17";
$dt->createDate();
//$dt->updateDate();
$dt->getDateById();*/
