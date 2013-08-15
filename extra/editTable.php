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
$tableName = filter_input(INPUT_POST, "tableName");

if ($pwd == $adminPassword){
  $conn = connectToDb();
  
  //sanitize $tableName before using it in SQL
  $tableName = mysql_real_escape_string($tableName);
  
  print tToEdit("$tableName");
} else {
  print "<h2>You must have administrative access to proceed</h2>\n";
} // end if

?>
</div> <!-- end main-content div -->

<?php include("footer.php"); ?>
</body>
</html>


