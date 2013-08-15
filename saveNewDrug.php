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
    $indication = filter_input(INPUT_POST, "indication");
    $bodyPart = filter_input(INPUT_POST, "body_part");
    $stage = filter_input(INPUT_POST, "stage");
    $company = filter_input(INPUT_POST, "company");

    // clean user input
    $name = mysql_real_escape_string($name);
    $indication = mysql_real_escape_string($indication);
    $bodyPart = mysql_real_escape_string($bodyPart);
    $stage = mysql_real_escape_string($stage);
    $company = mysql_real_escape_string($company);
    

  // add to database
    // sql query to insert info
    $sql = "INSERT INTO drugs (name, indication, stage, companyID, body_partID) VALUES ('$name', '$indication', '$stage', $company, $bodyPart)";

    //mysql_query
    $result = mysql_query($sql) or die(mysql_error());

    if($result){
      print "<p>Drug saved successfully.</p>";
      print addAnotherDrug();
    } else {
      print "There was a problem saving the drug.";
    }


?>


</div> <!-- end main-content div -->

<?php include("footer.php"); ?>
</body>
</html>