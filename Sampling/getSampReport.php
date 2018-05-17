<?php
include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "SELECT * FROM `samplingReport`
        WHERE Id = :reqId";

    $namedParameters = array(); 
    $namedParameters[":reqId"] = $_GET['reqId'];
    
$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any
$Record = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($Record);
?>