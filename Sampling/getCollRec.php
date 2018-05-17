<?php
include '../../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "SELECT * FROM `collectedSamples`
        WHERE Id=:collectedSampId AND order_Id=:sampId";

    $namedParameters = array(); 
    $namedParameters[":sampId"] = $_GET['sampId'];
    $namedParameters[":collectedSampId"] = $_GET['collectedSampId'];
    
$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any
$Record = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($Record);
?>