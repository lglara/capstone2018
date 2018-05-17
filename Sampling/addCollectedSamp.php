<?php
session_start();//continues the session containing prevouse information

include '../../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "INSERT INTO `collectedSamples` (`Id`, `order_Id`, `actSampleAmount`, `sampDate`, `userName`, `date`, `time`) 
        VALUES (NULL, :sampReq, :sampActAmnt, :sampdate, :userName, :date, :time)";

$namedParameters = array(); 
$namedParameters[":sampReq"] = $_GET['sampReq'];
$namedParameters[":sampActAmnt"] = $_GET['sampActAmnt'];
$namedParameters[":sampdate"] = $_GET['sampdate'];
$namedParameters[":userName"] = $_SESSION['adminFullName'];
$namedParameters[":date"] = $_GET['date'];
$namedParameters[":time"] = $_GET['time'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any


?>