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
    $bodyPart = filter_input(INPUT_POST, "body_part");  
  
  // perform queries from search criteria
    $sql = "SELECT drugs.name AS 'Drug name', companies.name AS 'Company', drugs.indication AS 'Indication', drugs.stage AS 'Stage', body_part.name AS 'Body part' FROM body_part, drugs, companies WHERE body_part.body_partID = $bodyPart AND drugs.body_partID = $bodyPart AND drugs.companyID = companies.companyID";

    $result = mysql_query($sql) or die(mysql_error());


  // return results in tabular format
    print toTable($sql);

?>

</div>
<?php include("footer.php"); ?>
</body>
</html>