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

<h1>Update Record</h1>

<?php 
$conn = connectToDb();

$fieldNames = "";
$fieldValues = "";

foreach ($_REQUEST as $fieldName => $value){
  if ($fieldName == "tableName"){
    $theTable = $value;
  } else {
    $fieldName = mysql_real_escape_string($fieldName);
    $value = mysql_real_escape_string($value);
    $fields[] = $fieldName;
    $values[] = $value;
  } // end if
} // end foreach

print updateRecord($theTable, $fields, $values);


?>
</div> <!-- end main-content div -->

<?php include("footer.php"); ?>
</body>
</html>