<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/connection.php";
include "../../class/dates.php";

$database = new Database();
$db = $database->getConnection();
$date = new date($db);

// insert new date

function create_session($sessionName, $confID, $dateID, $db)
{
    $sqlquery = "insert into session (sessionName, confID, dateID) values (:sessionName, :confID, :dateID)";
    $stmt = $db->prepare($sqlquery);
    $stmt->bindParam(":sessionName", $sessionName);
    $stmt->bindParam(":confID", $confID);
    $stmt->bindParam(":dateID", $dateID);
    $stmt->execute();
    return true;
}

$data = json_decode(file_get_contents("php://input"));

// insert new session
$session = $data->sessionName;
$confid = $data->confID;
$sdate = $data->sDate;
$edate = $data->eDate;

// create date for session
$date->sDate = $sdate;
$date->eDate = $edate;
$dateID = $date->createDate();
$lastid = $dateID;
$confarray = array();

if (create_session($session, $confid, $lastid, $db)) {
    $confarray["success"] = "true";
    $confarray["message"] = 'session created successfully.';
    $confarray["body"] = $data;
    echo json_encode($confarray);
} else {
    $confarray["success"] = "false";
    $confarray["message"] = 'conference could not be created.';
    echo json_encode($confarray);
}
/*
array();
$confarray["body"]["confID"] = $lastid;
$confarray["body"]["confName"] = $data->confName;
$confarray["body"]["confLieu"] = $data->confLieu;
$confarray["body"]["confDomain"] = $data->confDomain;
$confarray["body"]["sDate"] = $data->sDate;
$confarray["body"]["eDate"] = $data->eDate;
$confarray["body"]["email"] = $data->email;
$confarray["body"]["wapp"] = $data->wapp;
$confarray["body"]["facebook"] = $data->facebook;
$confarray["body"]["instagram"] = $data->instagram;
$confarray["body"]["telegram"] = $data->telegram;
$confarray["body"]["twitter"] = $data->twitter;*/
