<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/connection.php";
include_once "../../class/conferences.php";
include_once "../../class/dates.php";
include_once "../../class/contact.php";

$database = new Database();
$db = $database->getConnection();
$conf = new conference($db);
$date = new date($db);
$contact = new contact($db);

function getDateId($confID, $conn)
{

    $sqlquery = "select dateID from conference where confID=:confID";
    $stmt = $conn->prepare($sqlquery);
    $confID = htmlspecialchars(strip_tags($confID));
    $stmt->bindParam(":confID", $confID);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result["dateID"];
}

function getContactId($confID, $conn)
{
    $sqlquery = "select contactID from conference where confID=:confID";
    $stmt = $conn->prepare($sqlquery);
    $confID = htmlspecialchars(strip_tags($confID));
    $stmt->bindParam(":confID", $confID);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result["contactID"];
}

$data = json_decode(file_get_contents("php://input"));

$conf->confID = $data->confID;

// iupdate date
$date->dateID = getDateId($data->confID, $db);
$date->sDate = $data->sDate;
$date->eDate = $data->eDate;
$date->updateDate();

//// update contact
$contact->contactID = getContactId($data->confID, $db);
$contact->email = $data->email;
$contact->wapp = $data->wapp;
$contact->facebook = $data->facebook;
$contact->instagram = $data->instagram;
$contact->telegram = $data->telegram;
$contact->twitter = $data->twitter;
$contact->updateContact();

// conference values
$conf->confName = $data->confName;
$conf->confDomain = $data->confDomain;
$conf->confLieu = $data->confLieu;
//$conf->dateID = $data->dateID;
// $conf->contactID = $data->contactID;

if ($conf->updateConf()) {
    echo json_encode(array("success" => "true", message => "conference data updated."));
} else {
    echo json_encode(array("success" => "false", message => "Data could not be updated"));
}
