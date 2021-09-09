<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/connection.php";
include_once "../../class/users.php";
include_once "../../class/conferences.php";
$database = new Database();
$db = $database->getConnection();
$create = new user($db);
$data = json_decode(file_get_contents("php://input"));

$create->fName = $data->fName;
$create->lName = $data->lName;
$create->username = $data->username;
$create->email = $data->email;
$create->passwordHash = $data->password;
$create->compID = $data->compID;
$create->confID = $data->confID;
$create->sessionID = $data->sessionID;
$create->role = $data->role;

$last = $create->createUser();
$lastid = $last;
$userarray = array();
if ($last) {
    $userarray["success"] = "true";
    $userarray["message"] = 'user created successfully.';
    $userarray["body"] = array();
    $userarray["body"]["userID"] = $lastid;
    $userarray["body"]["fname"] = $data->fName;
    $userarray["body"]["lname"] = $data->lName;
    $userarray["body"]["username"] = $data->username;
    $userarray["body"]["email"] = $data->email;
    $userarray["body"]["compID"] = $data->compID;
    $userarray["body"]["confID"] = $data->confID;
    $userarray["body"]["sessionID"] = $data->sessionID;
    $userarray["body"]["role"] = $data->role;
    echo json_encode($userarray);
} else {
    $userarray["success"] = "false";
    $userarray["message"] = 'user could not be created.';
    echo json_encode($userarray);
}
