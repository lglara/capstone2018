<?php
include '../../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling');  
   
$sql = "SELECT * FROM `users`
        WHERE Id=:userId";

    $namedParameters = array(); 
    $namedParameters[":userId"] = $_GET['userId'];
    
$statement = $conn->prepare($sql);
$statement->execute($namedParameters);  //ALWAYS PASS the named parameters,if any
$Record = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($Record);
?>