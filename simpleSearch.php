<?php

  // connect to database, etc
    // get username and password for MySQL server
    include('db_connection_info.inc'); 
  
    // connect to the MySQL server as the user or terminate script 
    $conn = mysql_connect("localhost", $drugUsername, $drugPassword) or die('Unable to connect to MySQL. ' . mysql_error());
  
    // select the database to use 
    mysql_select_db("drug_dev", $conn) or die('Unable to select database. ' . mysql_error());
  
  // gather search criteria
    $company = filter_input(INPUT_POST, "company");
    $bodyPart = filter_input(INPUT_POST, "body_part");
    $stage = filter_input(INPUT_POST, "stage");
  
  
  // perform queries from search criteria
    /* try a single query with all variables, but if not, 
    I may need some logic to see if values were passed from form, and then based on certain cases 
    create queries depending on info submitted */
    $sql = "SELECT * FROM drugs WHERE companyID = $company OR body_partID = $bodyPart";

    $result = mysql_query($sql) or die(mysql_error());

    // return results as list, for now ... PROBLEM: if one field is blank then results don't work... must fix this issue
    if ($result) {
      while ($row = mysql_fetch_assoc($result)){
        foreach ($row as $key => $value) {
          print "$key: $value <br />\n";
        }
      print "<br />\n";
      } 
    } else {
      print "There was a problem with the query.";
    }

  
  // return results in tabular format (to come)




?>