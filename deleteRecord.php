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

  <h1>Delete Record</h1>
  
  <?php 
  $conn = connectToDb();
  
  //retrieve data
  $tableName = filter_input(INPUT_POST, "tableName");
  $keyName = filter_input(INPUT_POST, "keyName");
  $keyVal = filter_input(INPUT_POST, "keyVal");
  $tableName = mysql_real_escape_string($tableName);
  $keyName = mysql_real_escape_string($keyName);
  $keyVal = mysql_real_escape_string($keyVal);
  
  
  print deleteRecord($tableName, $keyName, $keyVal);
  ?>

</div> <!-- end main-content div -->

<?php include("footer.php"); ?>
</body>
</html>

