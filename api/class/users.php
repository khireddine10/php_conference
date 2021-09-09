<?php
class user
{
    public $userID;
    public $fName;
    public $lName;
    public $username;
    public $email;
    public $passwordHash;
    public $contactID;
    public $compID;
    public $confID;
    public $sessionID;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createUser()
    {
        $sqlquery = "insert into user
        (fName, lName, username, email, passwordHash, compID, confID, sessionID, role)
        values
        (:fName, :lName, :username, :email, :passwordHash, :compID, :confID, :sessionID, :role)";

        $stmt = $this->conn->prepare($sqlquery);
        $this->passwordHash = hash("sha256", $this->passwordHash);
        $this->fName = htmlspecialchars(strip_tags($this->fName));
        $this->lName = htmlspecialchars(strip_tags($this->lName));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->passwordHash = htmlspecialchars(strip_tags($this->passwordHash));
        $this->compID = htmlspecialchars(strip_tags($this->compID));
        $this->confID = htmlspecialchars(strip_tags($this->confID));
        $this->sessionID = htmlspecialchars(strip_tags($this->sessionID));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $stmt->bindParam(":fName", $this->fName);
        $stmt->bindParam(":lName", $this->lName);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":passwordHash", $this->passwordHash);
        $stmt->bindParam(":compID", $this->compID);
        $stmt->bindParam(":confID", $this->confID);
        $stmt->bindParam(":sessionID", $this->sessionID);
        $stmt->bindParam(":role", $this->role);
        if ($stmt->execute()) {
            $last_id = $this->conn->lastInsertId();
            return $last_id;
        }
        echo "error create user";
        return false;
    }
    public function updateUser()
    {
        $sqlquery = "update user set
        fName= :fName, lName= :lName, username= :username, email= :email,
        passwordHash= :passwordHash, compID= :compID, confID= :confID, sessionID= :sessionID, role= :role
        where userID= :userID";

        $stmt = $this->conn->prepare($sqlquery);
        $this->passwordHash = hash("sha256", $this->passwordHash);
        $this->fName = htmlspecialchars(strip_tags($this->fName));
        $this->lName = htmlspecialchars(strip_tags($this->lName));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->passwordHash = htmlspecialchars(strip_tags($this->passwordHash));
        $this->compID = htmlspecialchars(strip_tags($this->compID));
        $this->confID = htmlspecialchars(strip_tags($this->confID));
        $this->sessionID = htmlspecialchars(strip_tags($this->sessionID));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $stmt->bindParam(":userID", $this->userID);
        $stmt->bindParam(":fName", $this->fName);
        $stmt->bindParam(":lName", $this->lName);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":passwordHash", $this->passwordHash);
        $stmt->bindParam(":compID", $this->compID);
        $stmt->bindParam(":confID", $this->confID);
        $stmt->bindParam(":sessionID", $this->sessionID);
        $stmt->bindParam(":role", $this->role);
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}
