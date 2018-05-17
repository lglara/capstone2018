<?php
include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "SELECT * FROM `customers 
        WHERE Id=:custId`";
        
    $namedParameters = array(); 
    $namedParameters[":custId"] = $_GET['custId'];

$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any
$Record = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($Record)

?>