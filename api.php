<?php

$status = 200;
$retval = array();
$retval["status"] = FALSE;

require("./preamble.php");

if ( isset($_GET["action"]) ) {
  $retval["action"] = $_GET["action"];
  if ( $_GET["action"] == "simpleadd" ) {
    if ( ! isset($_GET["addMealDescription"]) ) {
      $status = 500;
      $retval["error"] = "addMealDescription not supplied.";
    } elseif ( ! isset($_GET["addMealTotalKcal"]) ) {
      $status = 500;
      $retval["error"] = "addMealTotalKcal not supplied.";
    } else {
      $_GET["logWhen"] = "now";
      $_GET["newMealSubmitted"] = "1";
      include_once("php/addmeal.php");
      $retval["status"] = TRUE;
    }
  } else {
    $status = 500;
    $retval["error"] = sprintf("Action %s not implemented.", $_GET["action"]);
  }
} else {
  $status = 500;
  $retval["error"] = "No action supplied.";
}

http_response_code($status);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval, JSON_THROW_ON_ERROR);

?>
