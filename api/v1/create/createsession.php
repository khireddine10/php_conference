<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/connection.php";
include_once "../../class/conferences.php";
include "../../class/dates.php";
include "../../class/contact.php";

$database = new Database();
$db = $database->getConnection();
$conf = new conference($db);
$date = new date($db);
$contact = new contact($db);

$data = json_decode(file_get_contents("php://input"));
// insert new date
$date->sDate = $data->sDate;
$date->eDate = $data->eDate;

// insert new contact
$contact->email = $data->email;
$contact->wapp = $data->wapp;
$contact->facebook = $data->facebook;
$contact->instagram = $data->instagram;
$contact->telegram = $data->telegram;
$contact->twitter = $data->twitter;

// insert new conference
$conf->confName = $data->confName;
$conf->confLieu = $data->confLieu;
$conf->confDomain = $data->confDomain;
$conf->dateID = $date->createDate();
$conf->contactID = $contact->createContact();

$last = $conf->createConf();
$lastid = $last;
$confarray = array();
if ($last) {
    $confarray["success"] = "true";
    $confarray["message"] = 'conference created successfully.';
    $confarray["body"] = $data;
    $confarray["confID"] = $lastid;
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
