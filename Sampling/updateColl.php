<?php
session_start();//continues the session containing prevouse information

include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "UPDATE `collectedSamples` SET 
                `actSampleAmount`= :actSampAmnt,
                `sampDate`= :actdate,
                `userName`= :user,
                `date`= :date,
                `time`= :time 
                WHERE Id = :collectedSampId AND  order_Id= :sampReq";

$namedParameters = array(); 
$namedParameters[":sampReq"] = $_GET['sampReq'];
$namedParameters[":collectedSampId"] = $_GET['collectedSampId'];
$namedParameters[":actSampAmnt"] = $_GET['actSampAmnt'];
$namedParameters[":actdate"] = $_GET['actdate'];
$namedParameters[":user"] = $_SESSION['adminFullName'];
$namedParameters[":date"] = $_GET['date'];
$namedParameters[":time"] = $_GET['time'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any


?>