<?php
session_start();//continues the session containing prevouse information

include '../../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "UPDATE `customers` SET 
                `name`= :custName,
                `repName`= :custRepName,
                `location`= :custLocation,
                `phone`= :custPhone,
                `email`= :custEmail
            WHERE Id = :custId";

$namedParameters = array(); 
$namedParameters[":custId"] = $_GET['custId'];
$namedParameters[":custName"] = $_GET['custName'];
$namedParameters[":custRepName"] = $_GET['custRepName'];
$namedParameters[":custLocation"] = $_GET['custLocation'];
$namedParameters[":custPhone"] = $_GET['custPhone'];
$namedParameters[":custEmail"] = $_GET['custEmail'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any


?>