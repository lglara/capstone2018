<?php
session_start();//continues the session containing prevouse information

include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "INSERT INTO `users`(`Id`, `name`, `lName`, `username`, `password`, `clearance`) 
            VALUES (NULL, :name, :lName, :userName, :password, :clearance)";

$namedParameters = array(); 
$namedParameters[":name"] = $_GET['name'];
$namedParameters[":lName"] = $_GET['lName'];
$namedParameters[":userName"] = $_GET['userName'];
$namedParameters[":password"] = sha1($_GET['password']);
$namedParameters[":clearance"] = $_GET['clearance'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any


?>