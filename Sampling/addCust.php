<?php
session_start();//continues the session containing prevouse information

include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');   
   
$sql = "INSERT INTO `customers`(`Id`, `name`, `repName`, `location`, `phone`, `email`) 
VALUES (NULL,:custName,:custRepName,:custLocation,:custPhone,:custEmail)";

$namedParameters = array(); 
$namedParameters[":custName"] = $_GET['custName'];
$namedParameters[":custRepName"] = $_GET['custRepName'];
$namedParameters[":custLocation"] = $_GET['custLocation'];
$namedParameters[":custPhone"] = $_GET['custPhone'];
$namedParameters[":custEmail"] = $_GET['custEmail'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any


?>