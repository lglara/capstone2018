<?php
session_start();//continues the session containing prevouse information

include '../../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   global $conn;
  
    deleteColl();
    
   function deleteColl(){
     global $conn;
   $sql = "DELETE FROM `collectedSamples` WHERE Id= :collectedSampId";

    $namedParameters = array();
    $namedParameters[":collectedSampId"] = $_GET['collectedSampId'];
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($namedParameters);
    
    updateReqStatus();
   }
   
   function updateReqStatus(){
       global $conn;
       $sql = "UPDATE `samplingRequests` 
        SET `status` = 'requested' 
        WHERE `Id` = :sampId";

    $namedParameters = array(); 
    $namedParameters[":sampId"] = $_GET['sampId'];
    
    $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);
   }

?>
