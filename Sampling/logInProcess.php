<?php
session_start();  //creates a new session to store vaues from page to page.
//VALITADING THE USERNAME AND PASSWORD

// print_r($_POST);//DISPLAYS POST FORM ARRAY

include '../../dbConnection3.php';
   $conn = getDatabaseConnection('Sampling'); 

$username = $_POST['username'];
$password = sha1($_POST['password']);

//SQL USING NAMED APARAMETERS THAT PREVENTS SQL INJECTION
$sql = "SELECT *
        FROM users
        WHERE username = :username  
        AND   password = :password"; 
        
        $namedParameters=array();
        $namedParameters['username']=$username;
        $namedParameters['password']=$password;
        
        
$stmt = $conn->prepare($sql);
$stmt->execute($namedParameters);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

print_r($record);

if (empty($record)) {
    // error();
    header('Location: index.php'); //redirects users to admin page
    
} else {
  //echo "Successful login!";
    $_SESSION['username'] = $record['username'];
    $_SESSION['adminFullName'] = $record['name'] . " " . $record['lName'];//creates a record in the session associative array
        
  header('Location: home.php'); //redirects users to admin page
}


?>