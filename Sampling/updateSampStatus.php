<?php
session_start();//continues the session containing prevouse information

include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "UPDATE `samplingRequests` 
        SET `status` = 'collected' 
        WHERE `samplingRequests`.`Id` = :sampId";

$namedParameters = array(); 
$namedParameters[":sampId"] = $_GET['sampId'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any


?>