<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once "../../config/connection.php";
include_once "../../class/conferences.php";
$database = new Database();
$db = $database->getConnection();
$conf = new conference($db);

$stmt = $conf->getConfs();
$itemCount = $stmt->rowCount();

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

if ($itemCount > 0) {

    $confArr = array();
    $confArr["success"] = "true";
    $confArr["body"] = array();
    $confArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "confID" => $confID,
            "confName" => $confName,
            "confLieu" => $confLieu,
            "startDate" => getDates($dateID, $db)["sDate"],
            "endDate" => getDates($dateID, $db)["eDate"],
            "email" => getContact($contactID, $db)["email"],
            "wapp" => getContact($contactID, $db)["wapp"],
            "facebook" => getContact($contactID, $db)["facebook"],
            "instagram" => getContact($contactID, $db)["instagram"],
            "telegram" => getContact($contactID, $db)["telegram"],
            "twitter" => getContact($contactID, $db)["twitter"],
        );
        array_push($confArr["body"], $e);
    }
    echo json_encode($confArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("success" => "false", "message" => "No record found.")
    );
}
