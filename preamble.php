<?php

// These credentials are for the Docker image. If you want to run Calorific
// locally without using Docker, don't change these; add them to credentials.php!
$mysqlHost = "db";
$mysqlUser = "php_docker";
$mysqlPassword = "password123";

error_reporting(E_ERROR); // Silence the next line so it doesn't cry when running in Docker
include("./credentials.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors", 1);

require("./php/functions.php");

$link = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword);
if(!$link) {
    die("Couldn't connect: " . mysqli_error($link));
}

require("./php/dbsetup.php");

$resSettings = mysqli_query($link, "SELECT * FROM `settings`;");

// Default settings values, will be overwritten by values found in db
$calorieGoal = 0;
$hourOffset = 0;
$filterBoxState = 1;

for($i = 0; $i < mysqli_num_rows($resSettings); $i++) {
    $key = mysqli_result($resSettings, $i, "key");
    $value = mysqli_result($resSettings, $i, "value");
    
    if($key == "calorieGoal") {
        $calorieGoal = $value;
    } elseif($key == "hourOffset") {
        $hourOffset = $value;
    } elseif($key == "filterBoxState") {
        $filterBoxState = $value;
    }
}

?>
