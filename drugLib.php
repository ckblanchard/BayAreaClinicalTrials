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


// function to present query results as table
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


// function to create table that gives crud access to admin user
function tToEdit($tableName){

  // get tableName from index page
  $tableName = filter_input(INPUT_POST, "tableName");
  $tableName = mysql_real_escape_string($tableName);
  
  global $conn;
  $output = "";
  $query = "SELECT * FROM $tableName";

  $result = mysql_query($query, $conn);

  $output .= "<table>";
  
  //get field names as column headings
  $output .= "<tr>";
  while ($field = mysql_fetch_field($result)){
    $output .= "  <th>$field->name</th>";
  } // end while

  //get name of index field (presuming it's first field)
  $keyField = mysql_fetch_field($result, 0);
  $keyName = $keyField->name;
  
  //add empty columns for crud actions
  $output .= "<th></th><th></th>";
  $output .= "</tr>";

  //get row data as associative array
  while ($row = mysql_fetch_assoc($result)){
    $output .= "<tr>";
    //look at each field
    foreach ($row as $col=>$val){
      $output .= "  <td>$val</td>\n";
    } // end foreach
    
    //build forms for add, delete and edit

    //delete = DELETE FROM <table> WHERE <key> = <keyval>
    $keyVal = $row["$keyName"];
    $output .= <<<HERE

  <td>
    <form action = "deleteRecord.php"
          method = "post">
    <input type = "hidden"
           name = "tableName"
           value = "$tableName" />
    <input type= "hidden"
           name = "keyName"
           value = "$keyName" />
    <input type = "hidden"
           name = "keyVal"
           value = "$keyVal" />
    <input type = "submit"
           value = "delete" />
    </form>
  </td>

HERE;
    //update: won't update yet, but set up edit form
    $output .= <<<HERE
  <td>
    <form action = "editRecord.php"
          method = "post">
    <input type = "hidden"
           name = "tableName"
           value = "$tableName">
    <input type= "hidden"
           name = "keyName"
           value = "$keyName">
    <input type = "hidden"
           name = "keyVal"
           value = "$keyVal">
    <input type = "submit"
           value = "edit">
  </form>
  </td>

HERE;

    $output .= "</tr>";
    
  }// end while

    //add = INSERT INTO <table> {values}
    //set up insert form send table name
    $keyVal = $row["$keyName"];
    $output .= <<<HERE
<tr>
  <td colspan = "6">
    <form action = "addRecord.php"
          method = "post">
    <input type = "hidden"
           name = "tableName"
           value = "$tableName">
    <button type = "submit">
       add a record
    </button>
    </form>
  </td>
</tr>
</table>

HERE;


  return $output;

} // end tToEdit


// function form to edit a record
function editRecord ($query){
  
  global $conn;
  $output = "";
  $result = mysql_query($query, $conn);
  $row = mysql_fetch_assoc($result);

  //get table name from field object
  $fieldObj = mysql_fetch_field($result, 0);
  $tableName = $fieldObj->table;

  $output .= <<<HERE
<form action = "updateRecord.php"
      method = "post">
  <input type = "hidden"
         name = "tableName"
         value = "$tableName">
<dl>
HERE;
  $fieldNum = 0;
  foreach ($row as $col=>$val){
    if ($fieldNum == 0){
      //this is primary key, don't make textbox. Instead store value in hidden field
      $output .= <<<HERE
  
    <dt>$col</dt>
    <dd>$val
    <input type = "hidden"
           name = "$col"
             value = "$val"></dd>
             
HERE;
    } else if (preg_match("/(.*)ID$/", $col, $match)) {
      //it's a foreign key reference
      // get table name (match[1])
      //create a listbox based on table name and its name field
      $valList = fieldToList($match[1],$col, $fieldNum, "name");
      
      $output .= <<<HERE
    <dt>$col</dt>
    <dd>$valList</dd>
  
HERE;

    } else {
      $output .= <<<HERE
    <dt>$col</dt>
    <dd>
    <input type = "text"
           name = "$col"
           value = "$val"></dd>

HERE;
    } // end if
    $fieldNum++;
  } // end foreach
  $output .= <<<HERE
  </dl>
      <button type = "submit">
         update this record
      </button>
</form>

HERE;
  return $output;
} // end editRecord


// function to update a record
function updateRecord($tableName, $fields, $vals){
  //expects name of a record, fields array values array
  //updates database with new values
  
  global $conn;
  
  $output = "";
  $keyName = $fields[0];
  $keyVal = $vals[0];
  $query = "";
  
  $query .= "UPDATE $tableName SET \n";
  for ($i = 1; $i < count($fields); $i++){
    $query .= $fields[$i];
    $query .= " = '";
    $query .= $vals[$i];
    $query .= "',\n";
  } // end for loop

  //remove last comma from output
  $query = substr($query, 0, strlen($query) - 2);
  
  $query .= "\nWHERE $keyName = '$keyVal'";

  $result = mysql_query($query, $conn);
  if ($result){
    $query = "SELECT * FROM $tableName WHERE $keyName = '$keyVal'";
    $output .= "<h1>update successful</h1>\n";
    $output .= "<h2>new value of record:</h2>";
    $output .= toTable($query);
  } else {
    $output .= "<h3>there was a problem...</h3><pre>$query</pre>\n";
  } // end if
  return $output;
} // end updateRecord


// function to delete a record
function deleteRecord ($table, $keyName, $keyVal){
  //deletes $keyVal record from $table
  global $conn;
  $output = "";
  $query = "DELETE from $table WHERE $keyName = '$keyVal'";

  $result = mysql_query($query, $conn);
  if ($result){
    $output = "<h3>Record sucessfully deleted</h3>\n";
  } else {
    $output = "<h3>Error deleting record</h3>\n";
  } //end if
  return $output;
} // end deleteRecord


// function to prepare a record to add
function toAdd($tableName){
  //given table name, generates HTML form to add an entry to the table
  
  global $conn;
  $output = "";
  
  //process a query just to get field names
  $query = "SELECT * FROM $tableName";
  $result = mysql_query($query, $conn) or die(mysql_error());

  $output .= <<<HERE
  <form action = "processAdd.php"
        method = "post">
    <dl>
      <dt>Field</dt>
      <dd>Value</dd>
    
HERE;

  $fieldNum = 0;
  while ($theField = mysql_fetch_field($result)){
    $fieldName = $theField->name;
    if ($fieldNum == 0){
      //it's the primary key field so it will autonumber, pass it "null"
      $output .= <<<HERE
 
        <dt>$fieldName</dt>
        <dd>AUTONUMBER
          <input type = "hidden"
                 name = "$fieldName"
                 value = "null">
        </dd>

HERE;
    } else if (preg_match("/(.*)ID$/", $fieldName, $match)) {
      //it's a foreign key reference.  Use fieldToList to get a select object for this field

      $valList = fieldToList($match[1],$fieldName, 0, "name");
      $output .= <<<HERE
        <dt>$fieldName</dt>
        <dd>$valList</dd>

HERE;
    } else {
    //it's an ordinary field, so print a text box
    $output .= <<<HERE
        <dt>$fieldName</dt>
        <dd><input type = "text"
                   name = "$fieldName"
                   value = "">
        </dd>

HERE;
    } // end if
    $fieldNum++;
  } // end while
  $output .= <<<HERE
    </dl>
    
        <input type = "hidden"
               name = "tableName"
               value = "$tableName">
        <button type = "submit">
           add record
        </button>
  </form>

HERE;

  return $output;
      
} // end toAdd


// function to add record to database
function processAdd($tableName, $fields, $vals){
  //generates INSERT query, applies to database
  global $conn;
  
  $output = "";
  $query = "INSERT into $tableName VALUES (";
  foreach ($vals as $theValue){
    $query .= "'$theValue', ";
  } // end foreach

  //trim off trailing space and comma
  $query = substr($query, 0, strlen($query) - 2);
  
  $query .= ")";
  $output = "query is $query<br>\n";
  
  $result = mysql_query($query, $conn);
  if ($result){
    $output .= "<h3>Record added</h3>\n";
  } else {
    $output .= "<h3>There was an error</h3>\n";
  } // end if
  return $output;
} // end processAdd


// function to add a select field to a form (called in multiple library functions)
function fieldToList($tableName, $keyName, $keyVal, $fieldName){
  //generates an HTML select structure named $keyName. values will be key field of table, but text will come from the $fieldName value. keyVal indicates which element is currently selected
  
  global $conn;
  $output = "";
  $query = "SELECT $keyName, $fieldName FROM $tableName";
  $result = mysql_query($query, $conn);
  $output .= "<select name = \"$keyName\">\n";
  $recNum = 1;
  while ($row = mysql_fetch_assoc($result)){
    $theIndex = $row["$keyName"];
    $theValue = $row["$fieldName"];
    $output .= <<<HERE
  <option value = "$theIndex"
HERE;

    //make it currently selected item
    if ($theIndex == $keyVal){
      $output .= " selected = \"selected\"";
    } // end if
    $output .= ">$theValue</option>\n";
    $recNum++;
  } // end while
  $output .= "</select>\n";
  return $output;
} // end fieldToList

?>
















