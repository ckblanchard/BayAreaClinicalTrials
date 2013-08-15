<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Simple drug development search</title>
	<?php include("drugLib.php"); ?>
</head>
<body>
	<?php include("searchArea.php"); ?>
	
<div id="main-content">
<?php
  // make db connection
  $conn = connectToDb();
  
    
  // gather form submissions and clean input
  $name = filter_input(INPUT_POST, "name");
  $name = mysql_real_escape_string($name);
  $company = filter_input(INPUT_POST, "bycompany");
  $company = mysql_real_escape_string($company);

  // check to see which criteria to search by

  if($name != ""){
    // search was by drug name, so create appropriate sql statement
    //$sql = "SELECT * FROM drugs WHERE name LIKE '%$name%'";
    $sql = "SELECT drugs.drugID AS 'ID', drugs.name AS 'Name', drugs.indication AS 'Indication', drugs.stage AS 'Stage', companies.name AS 'Company', body_part.name AS 'Body part' FROM drugs, companies, body_part WHERE drugs.name LIKE '%$name%' AND drugs.companyID = companies.companyID AND drugs.body_partID = body_part.body_partID";
  } else {
    // search was by company, so create appropriate sql statement
    $sql = "SELECT drugs.drugID AS 'ID', drugs.name AS 'Name', companies.name AS 'Company', drugs.indication AS 'Indication', drugs.stage AS 'Stage', body_part.name AS 'Body part' FROM drugs, companies, body_part WHERE companies.companyID = $company AND drugs.companyID = $company AND drugs.body_partID = body_part.body_partID";
  } 
  
    //mysql_query
    $result = mysql_query($sql) or die(mysql_error());

    if($result){
      print crudTable($sql);
    } else {
      print "There was a problem with the search.";
    }


?>


</div> <!-- end main-content div -->

<?php include("footer.php"); ?>
</body>
</html>