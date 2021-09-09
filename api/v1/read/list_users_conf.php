<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function list_all_users($con, $db)
{
    $sqlquery = "select userID, fName, lName, username, email, compID,
            confID, sessionID, role from user where confID=:confID";
    $stmt = $db->prepare($sqlquery);
    $dateID = htmlspecialchars(strip_tags($con));
    $stmt->bindParam(":confID", $con);
    $stmt->execute();
    return $stmt;
}

include_once "../../config/connection.php";
$database = new Database();
$db = $database->getConnection();

$conf = isset($_GET['confid']) ? $_GET['confid'] : die();
$itemCount = list_all_users($conf, $db)->rowCount();
$stmt = list_all_users($conf, $db);

if ($itemCount > 0) {

    $listArr = array();
    $listArr["success"] = "true";
    $listArr["body"] = array();
    $listArr["itemCount"] = $itemCount;
    while ($row = $stmt->fetch()) {
        extract($row);
        $e = array(
            "confID" => $confID,
            "fName" => $fName,
            "lName" => $lName,
            "username" => $username,
            "email" => $email,
            "compID" => $compID,
            "confID" => $confID,
            "sessionID" => $sessionID,
            "role" => $role,
        );
        array_push($listArr["body"], $e);
    }
    echo json_encode($listArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("success" => "false", "message" => "No record found.")
    );
}
