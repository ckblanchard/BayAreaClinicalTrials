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

//check password

$pwd = filter_input(INPUT_POST, "admin");

if ($pwd == $adminPassword){
  $conn = connectToDb();
  
  //print addDrug("$tableName");
  include("newdrug.php");
} else {
  print "<h2>You must have administrative access to proceed</h2>\n";
  include("retry.php");
} // end if

?>
</div> <!-- end main-content div -->

<?php include("footer2.php"); ?>
</body>
</html>


