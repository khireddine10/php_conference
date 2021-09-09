<?php
// this class for interact with conference table
// manage CRUD opertions Create/Read/Update/Delete

class conference
{
    // data base to connect to
    private $conn;
    private $db_table = "conference";

    // data base columns
    public $confID;
    public $confName;
    public $confLieu;
    public $confDomain;
    public $dateID;
    public $contactID;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // get all conference
    public function getConfs()
    {
        $sqlQuery = "SELECT confID, confName, confLieu, confDomain, dateID, contactID FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // create a conference
    public function createConf()
    {
        $sqlQuery = "insert into conference
                    (confName, confLieu, confDomain, dateID, contactID)
                    VALUES (
                        :confName,
                        :confLieu,
                        :confDomain,
                        :dateID,
                        :contactID)";
        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize les columns
        $this->confName = htmlspecialchars(strip_tags($this->confName));
        $this->confLieu = htmlspecialchars(strip_tags($this->confLieu));
        $this->confDomain = htmlspecialchars(strip_tags($this->confDomain));
        $this->dateID = htmlspecialchars(strip_tags($this->dateID));
        $this->contactID = htmlspecialchars(strip_tags($this->contactID));
        // bind les columns
        $stmt->bindParam(":confName", $this->confName);
        $stmt->bindParam(":confLieu", $this->confLieu);
        $stmt->bindParam(":confDomain", $this->confDomain);
        $stmt->bindParam(":dateID", $this->dateID);
        $stmt->bindParam(":contactID", $this->contactID);
        // execute the query
        if ($stmt->execute()) {
            $last_id = $this->conn->lastInsertId();
            return $last_id;
        }
        return false;
    }

    // get single conference
    public function getSingleConf()
    {
        $sqlQuery = "SELECT
                        confID,
                        confName,
                        confLieu,
                        confDomain,
                        dateID,
                        contactID
                      FROM
                        " . $this->db_table . "
                    WHERE
                       confID = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->confID);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->confName = $dataRow['confName'];
        $this->confLieu = $dataRow['confLieu'];
        $this->confDomain = $dataRow['confDomain'];
        $this->dateID = $dataRow['dateID'];
        $this->contactID = $dataRow['contactID'];
    }

    // update conference
    public function updateConf()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        confName = :confName,
                        confLieu = :confLieu,
                        confDomain = :confDomain
                    WHERE
                        confID = :confID";
        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize les columns
        $this->confID = htmlspecialchars(strip_tags($this->confID));
        $this->confName = htmlspecialchars(strip_tags($this->confName));
        $this->confLieu = htmlspecialchars(strip_tags($this->confLieu));
        $this->confDomain = htmlspecialchars(strip_tags($this->confDomain));

        // bind data into the query
        $stmt->bindParam(":confID", $this->confID);
        $stmt->bindParam(":confName", $this->confName);
        $stmt->bindParam(":confLieu", $this->confLieu);
        $stmt->bindParam(":confDomain", $this->confDomain);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function deleteConf()
    {

        $sqlquery = "select dateID,contactID from conference where confID=:confID";
        $stmt = $this->conn->prepare($sqlquery);
        $stmt->bindParam(":confID", $this->confID);
        $stmt->execute();
        $result = $stmt->fetch();
        $this->dateID = $result["dateID"];
        $this->contactID = $result["contactID"];
        $sqlQuery = "DELETE FROM conference WHERE confID = :confID";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->confID = htmlspecialchars(strip_tags($this->confID));
        $stmt->bindParam(":confID", $this->confID);

        if ($stmt->execute()) {
            return array($this->dateID, $this->contactID);
        }
        return false;
    }
}
