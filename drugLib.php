<?php

// connection info
include('db_connection_info.inc');  // get username and password for MySQL server
include('admin_password.inc');      // admin password in external file 

//variables 
$userName = $drugUsername;
$password = $drugPassword;
$serverName = "localhost"; 
$dbName = "drug_dev"; 
$conn = "";
$mainProgram = "spyMaster.php";

function connectToDb(){
  //connects to the database 
  global $serverName, $userName, $password, $dbName;
  $conn = mysql_connect($serverName, $userName, $password) or die('Unable to connect to MySQL. ' . mysql_error());
  if (!$dbConn){
   print "<h3>problem connecting to database...</h3>";
  } // end if
   
  $select = mysql_select_db($dbName);
  if (!$select){ 
    print mysql_error() . "<br>"; 
  } // end if 
  return $conn; 
} // end connectToDb 


?>

