<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../../config/connection.php";
include_once "../../class/conferences.php";
$database = new Database();
$db = $database->getConnection();
$conf = new conference($db);
$conf->confID = isset($_GET['confid']) ? $_GET['confid'] : die();
$stmt = $conf->getSingleConf();

function getDates($dateID, $db)
{
    $sqlquery = "select sDate, eDate from date where dateID= :dateID";
    $stmt = $db->prepare($sqlquery);
    $dateID = htmlspecialchars(strip_tags($dateID));
    $stmt->bindParam(":dateID", $dateID);
    $stmt->execute();
    $stmt = $stmt->fetch();
    return $stmt;
}

function getContact($contactID, $db)
{
    $sqlquery = "select * from contact where contactID= :contactID";
    $stmt = $db->prepare($sqlquery);
    $contactID = htmlspecialchars(strip_tags($contactID));
    $stmt->bindParam(":contactID", $contactID);
    $stmt->execute();
    $stmt = $stmt->fetch();
    return $stmt;
}

if ($conf->confName != null) {
    $conf_arr = array();
    $conf_arr["success"] = "true";
    $conf_arr["confID"] = $conf->confID;
    $conf_arr["confName"] = $conf->confName;
    $conf_arr["confLieu"] = $conf->confLieu;
    $conf_arr["startDate"] = getDates($conf->dateID, $db)["sDate"];
    $conf_arr["endDate"] = getDates($conf->dateID, $db)["eDate"];
    $conf_arr["email"] = getContact($conf->contactID, $db)["email"];
    $conf_arr["wapp"] = getContact($conf->contactID, $db)["wapp"];
    $conf_arr["facebook"] = getContact($conf->contactID, $db)["facebook"];
    $conf_arr["instagram"] = getContact($conf->contactID, $db)["instagram"];
    $conf_arr["telegram"] = getContact($conf->contactID, $db)["telegram"];
    $conf_arr["twitter"] = getContact($conf->contactID, $db)["twitter"];
    http_response_code(200);
    echo json_encode($conf_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("success" => "false", "message" => "No record found.")
    );
}
