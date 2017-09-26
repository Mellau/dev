<?php  
//connect to db for take the api usser and password 
function getUserPasswordSMS(){
    $hostname = "localhost";
    $database = "api";
    $username = "root";
    $password = "";


    $mysqli=mysqli_connect($hostname,$username,$password,$database);  
    $query = "SELECT user, password FROM api WHERE name='SMS'";  
    $result = mysqli_query($mysqli,$query)or die(mysqli_error());
    $row=mysqli_fetch_array($result);  
    
    $result = array(
    "user" => $row["user"],
    "password" => base64_decode($row["password"]),
    );
    
    mysqli_close($mysqli);
    return $result;
} 

?> 