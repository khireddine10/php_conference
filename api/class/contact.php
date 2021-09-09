<?php
// this class for interacting with contact table
// CRUD On contact table

class contact
{
    private $conn;

    public $contactID;
    public $email;
    public $wapp;
    public $facebook;
    public $instagram;
    public $telegram;
    public $twitter;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createContact()
    {
        $sqlquery = "INSERT INTO contact
        (email, wapp, facebook, instagram, telegram, twitter) VALUES
        (:email, :wapp, :facebook, :instagram, :telegram, :twitter)
        ";
        $stmt = $this->conn->prepare($sqlquery);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->wapp = htmlspecialchars(strip_tags($this->wapp));
        $this->facebook = htmlspecialchars(strip_tags($this->facebook));
        $this->instagram = htmlspecialchars(strip_tags($this->instagram));
        $this->telegram = htmlspecialchars(strip_tags($this->telegram));
        $this->twitter = htmlspecialchars(strip_tags($this->twitter));

        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":wapp", $this->wapp);
        $stmt->bindParam(":facebook", $this->facebook);
        $stmt->bindParam(":instagram", $this->instagram);
        $stmt->bindParam(":telegram", $this->telegram);
        $stmt->bindParam(":twitter", $this->twitter);

        if ($stmt->execute()) {
            $last_id = $this->conn->lastInsertId();
            return $last_id;
        }
        echo "error creating contact";
        return false;
    }
    public function updateContact()
    {
        $sqlquery = "update contact set email=:email, wapp=:wapp, facebook=:facebook,
                    instagram=:instagram, telegram=:telegram, twitter=:twitter
                    where contactID=:contactID";

        $stmt = $this->conn->prepare($sqlquery);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->wapp = htmlspecialchars(strip_tags($this->wapp));
        $this->facebook = htmlspecialchars(strip_tags($this->facebook));
        $this->instagram = htmlspecialchars(strip_tags($this->instagram));
        $this->telegram = htmlspecialchars(strip_tags($this->telegram));
        $this->twitter = htmlspecialchars(strip_tags($this->twitter));
        $stmt->bindParam(":contactID", $this->contactID);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":wapp", $this->wapp);
        $stmt->bindParam(":facebook", $this->facebook);
        $stmt->bindParam(":instagram", $this->instagram);
        $stmt->bindParam(":telegram", $this->telegram);
        $stmt->bindParam(":twitter", $this->twitter);
        if ($stmt->execute()) {
            return true;
        }
        echo "error update contact";
        return false;
    }
}
