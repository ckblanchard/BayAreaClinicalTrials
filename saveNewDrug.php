<?php

  // connect to database, etc
    // get username and password for MySQL server
    include('db_connection_info.inc'); 
  
    // connect to the MySQL server as the user or terminate script 
    $conn = mysql_connect("localhost", $drugUsername, $drugPassword) or die('Unable to connect to MySQL. ' . mysql_error());
  
    // select the database to use 
    mysql_select_db("drug_dev", $conn) or die('Unable to select database. ' . mysql_error());
  
  // gather form submissions and clean input
    $name = filter_input(INPUT_POST, "name");
    $indication = filter_input(INPUT_POST, "indication");
    $bodyPart = filter_input(INPUT_POST, "body_part");
    $stage = filter_input(INPUT_POST, "stage");
    $company = filter_input(INPUT_POST, "company");

    // clean user input
    $name = mysql_real_escape_string($name);
    $indication = mysql_real_escape_string($indication);
    $bodyPart = mysql_real_escape_string($bodyPart);

  // add to database
    // sql query to insert info
    $sql = "INSERT INTO drugs (name, indication, stage, companyID, body_partID) VALUES ('$name', '$indication', '$stage', $company, $bodyPart)";

    //mysql_query
    $result = mysql_query($sql) or die(mysql_error());

    if($result){
      print "Drug saved successfully.";
    } else {
      print "There was a problem saving the drug.";
    }


?>