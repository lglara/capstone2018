<?php
session_start();//continues the session containing prevouse information

include '../../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
   $sql = "DELETE FROM `samplingRequests` WHERE Id= :sampId";

    $namedParameters = array();
    $namedParameters[":sampId"] = $_GET['sampId'];
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($namedParameters);

?>
