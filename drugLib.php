<!-- Set CSS for app -->
	<link rel="stylesheet" href="drugstyle.css" />


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
  if (!$conn){
   print "<h3>problem connecting to database...</h3>";
  } // end if
   
  $select = mysql_select_db($dbName);
  if (!$select){ 
    print mysql_error() . "<br>"; 
  } // end if 
  return $conn; 
} // end connectToDb 


function toTable($sql){
  global $conn;
  $output = "";
  $result = mysql_query($sql, $conn);
  
  // start table
  $output .= "<table>";
  
  // get field names as column headings
  $output .= "<tr>"; 
  while ($field = mysql_fetch_field($result)) {
    $output .= "  <th>$field->name</th>";
  } // end while
  $output .= "</tr>";
  
  // get row data as associative array
  while ($row = mysql_fetch_assoc($result)){
    $output .= "<tr>";
    foreach ($row as $col=>$val){
      $output .= "  <td>$val</td>";
    } // end foreach
    $output .= "</tr>";
  } // end while
  $output .= "</table>";
  return $output;
} // end toTable



?>