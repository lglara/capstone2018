<?php
session_start();//continues the session containing prevouse information

include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "UPDATE `users` SET 
        `name`=:name,
        `lName`=:lName,
        `username`=:userName,
        `password`=:password,
        `clearance`=:clearance
         WHERE Id =:userId";

$namedParameters = array(); 
$namedParameters[":userId"] = $_GET['userId'];
$namedParameters[":name"] = $_GET['name'];
$namedParameters[":lName"] = $_GET['lName'];
$namedParameters[":userName"] = $_GET['userName'];
$namedParameters[":password"] = sha1($_GET['password']);
$namedParameters[":clearance"] = $_GET['clearance'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any


?>