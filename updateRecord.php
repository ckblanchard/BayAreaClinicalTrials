<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Update record</title>
	<?php include("drugLib.php"); ?>
</head>
<body>
	<?php include("searchArea.php"); ?>

<div id="main-content">

<?php 
  $conn = connectToDb();
  
  // collect info from fields and clean input
  $drugID = filter_input(INPUT_POST, "drugID");
  $name = filter_input(INPUT_POST, "name");
  $indication = filter_input(INPUT_POST, "indication");
  $stage = filter_input(INPUT_POST, "stage");
  $drugID =  mysql_real_escape_string($drugID);
  $name =  mysql_real_escape_string($name);
  $indication =  mysql_real_escape_string($indication);
  $stage =  mysql_real_escape_string($stage);
  
  // make sql statement to update db
  $sql = "UPDATE drugs SET name = '$name', indication = '$indication', stage = '$stage' WHERE drugID = '$drugID'";
  
  //mysql_query
  $result = mysql_query($sql, $conn);
  
  // get results of query
  if ($result){
    $query = "SELECT drugs.drugID AS 'ID', drugs.name AS 'Name', drugs.indication AS 'Indication', companies.name AS 'Company', body_part.name AS 'Body part' FROM drugs, companies, body_part WHERE drugID = '$drugID' AND companies.companyID = drugs.companyID AND body_part.body_partID = drugs.body_partID";
    $output .= "<h1>update successful</h1>\n";
    $output .= "<h2>new value of record:</h2>";
    $output .= toTable($query);
  } else {
    $output .= "<h3>there was a problem...</h3><pre>$query</pre>\n";
  } // end if
  
  print $output;
  


?>
</div> <!-- end main-content div -->

<?php include("footer.php"); ?>
</body>
</html>