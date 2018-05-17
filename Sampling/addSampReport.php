<?php
session_start();//continues the session containing prevouse information

include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "INSERT INTO `samplingReport` (`Id`, `sampReqId`, `collSampId`, `sampSubTime`, `WONumber`, `userName`, `date`, `time`) 
        VALUES (NULL, :sampReq, :collectedSampId, :sampSubTime, :woNum, :userName, :date, :time)";

$namedParameters = array(); 
$namedParameters[":sampReq"] = $_GET['sampReq'];
$namedParameters[":collectedSampId"] = $_GET['collectedSampId'];
$namedParameters[":sampSubTime"] = $_GET['sampSubTime'];
$namedParameters[":woNum"] = $_GET['woNum'];
$namedParameters[":userName"] = $_SESSION['adminFullName'];
$namedParameters[":date"] = $_GET['date'];
$namedParameters[":time"] = $_GET['time'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any

?>