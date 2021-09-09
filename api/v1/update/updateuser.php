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

$create->userID = $data->userID;
$create->fName = $data->fName;
$create->lName = $data->lName;
$create->username = $data->username;
$create->email = $data->email;
$create->passwordHash = $data->password;
$create->compID = $data->compID;
$create->confID = $data->confID;
$create->sessionID = $data->sessionID;
$create->role = $data->role;

if ($create->updateUser()) {
    echo json_encode(array("success" => "true", message => 'user created successfully.'));
} else {
    echo json_encode(array("success" => "false", message => 'user could not be created.'));
}
