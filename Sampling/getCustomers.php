<?php
include '../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "SELECT * FROM `customers`";

$statement = $conn->prepare($sql);
$statement->execute();  //ALWAYS PASS the named parameters,if any
$Record = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($Record)

?>