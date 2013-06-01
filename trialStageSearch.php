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
  
  // gather search criteria
    $stage = filter_input(INPUT_POST, "stage");  
  
  // perform queries from search criteria
    //$sql = "SELECT * FROM drugs WHERE stage = '$stage'";
    $sql = "SELECT drugs.name AS 'Drug name', drugs.indication AS 'Indication', drugs.stage AS 'Stage', companies.name AS 'Company', body_part.name AS 'Body part' FROM drugs, companies, body_part WHERE drugs.stage = '$stage' AND drugs.companyID = companies.companyID AND drugs.body_partID = body_part.body_partID";

    $result = mysql_query($sql) or die(mysql_error());


  // return results in tabular format
    print toTable($sql);
    
?>

</div>
<?php include("footer.php"); ?>
</body>
</html>
