<?php
session_start();//continues the session containing prevouse information

include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "UPDATE `samplingRequests` SET 
        `lotName`= :updtlotName,
        `grower`= :updtgrower,
        `ranch`= :updtRanch,
        `sampleSize`= :updtSampSize,
        `compId_name`= :updtComp,
        `requestDate`= :updtreqDate,
        `userName`= :userName,
        `date`= :date,
        `time`= :time,
        `status`= :status 
        WHERE Id= :sampId";

$namedParameters = array(); 
$namedParameters[":sampId"] = $_GET['sampId'];
$namedParameters[":updtlotName"] = $_GET['updtlotName'];
$namedParameters[":updtgrower"] = $_GET['updtgrower'];
$namedParameters[":updtRanch"] = $_GET['updtRanch'];
$namedParameters[":updtSampSize"] = $_GET['updtSampSize'];
$namedParameters[":updtComp"] = $_GET['updtComp'];
$namedParameters[":updtreqDate"] = $_GET['updtreqDate'];
$namedParameters[":status"] = $_GET['status'];
$namedParameters[":userName"] = $_SESSION['adminFullName'];
$namedParameters[":date"] = $_GET['date'];
$namedParameters[":time"] = $_GET['time'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any


?>