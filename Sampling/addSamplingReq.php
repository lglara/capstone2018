<?php
include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');   
   
$sql = "INSERT INTO `samplingRequests` (`Id`, `lotId_Name`, `sampleSize`, `compId_name`, `requestDate`, `userName`, `date`, `time`) 
VALUES (NULL, '304A', '60', 'Western Harvesting', '2018-05-16', 'laura', '2018-05-16', '10:10:14');";

$statement = $conn->prepare($sql);
$statement->execute();  //ALWAYS PASS the named parameters,if any


?>