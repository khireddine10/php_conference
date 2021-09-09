<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/connection.php";
include_once "../../class/conferences.php";

function deleteDate($dateID, $conn)
{

    $sqlquery = "delete from date where dateID=:dateID";
    $stmt = $conn->prepare($sqlquery);
    $dateID = htmlspecialchars(strip_tags($dateID));
    $stmt->bindParam(":dateID", $dateID);
    $stmt->execute();
}

function deleteContact($contactID, $conn)
{

    $sqlquery = "delete from contact where contactID=:contactID";
    $stmt = $conn->prepare($sqlquery);
    $contactID = htmlspecialchars(strip_tags($contactID));
    $stmt->bindParam(":contactID", $contactID);
    $stmt->execute();
}

$database = new Database();
$db = $database->getConnection();
$conf = new conference($db);

$data = $_GET["confid"];
$conf->confID = $data;
$delete = $conf->deleteConf();
$dateID = $delete[0];
$contactID = $delete[1];
$confarray = array();
if ($dateID) {
    deleteDate($dateID, $db);
    deleteContact($contactID, $db);
    $confarray["success"] = "true";
    $confarray["message"] = 'Conference deleted.';
    echo json_encode($confarray);
} else {
    $confarray["success"] = "false";
    $confarray["message"] = 'Conference could not be deleted.';
    echo json_encode($userarray);
}
