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
    $company = filter_input(INPUT_POST, "company");  
  
  // perform queries from search criteria
    $sql = "SELECT drugs.name AS 'Drug name', drugs.indication AS 'Indication', drugs.stage AS 'Stage', companies.name AS 'Company', body_part.name AS 'Body part' FROM drugs, companies, body_part WHERE drugs.companyID = $company AND companies.companyID = $company AND drugs.body_partID = body_part.body_partID";


    $result = mysql_query($sql) or die(mysql_error());

  // listed style of query results
/*
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
*/

  
  // return results in tabular format
  print toTable($sql);



?>
</div>
<?php include("footer.php"); ?>
</body>
</html>