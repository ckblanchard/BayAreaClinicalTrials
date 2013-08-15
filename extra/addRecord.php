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

  <h1>Add Record</h1>
  <?php 
  
  $conn = connectToDb();
  
  $tableName = filter_input(INPUT_POST, "tableName");
  $tableName = mysql_real_escape_string($tableName);
  
  print toAdd($tableName);
  
  ?>

</div> <!-- end main-content div -->

<?php include("footer.php"); ?>
</body>
</html>
