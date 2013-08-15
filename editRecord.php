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

  <h1>Edit Record</h1>
  
  <?php 
  
  $conn = connectToDb();
  
  // expects $keyVal for specific record from drugs table to edit
  $keyVal = filter_input(INPUT_POST, "keyVal");
  $keyVal = mysql_real_escape_string($keyVal);
  
  //$query = "SELECT * FROM $tableName WHERE $keyName = $keyVal";
  $sql = "SELECT * FROM drugs WHERE drugID = '$keyVal'";
  
  
  // build fields to edit this drug
  $result = mysql_query($sql, $conn);
  $row = mysql_fetch_assoc($result);

  $output .= <<<HERE
<form action = "updateRecord.php"
      method = "post">
  <input type = "hidden"
         name = "tableName"
         value = "drugs">
HERE;

  // cycle through fields to build update form fields
  foreach ($row as $col=>$val){
    if ($col == "drugID"){
      //this is primary key, don't make textbox. Instead store value in hidden field
      $output .= <<<HERE
  
    <label>$col: $val</label>
    <input type = "hidden"
           name = "$col"
             value = "$val">
HERE;

    } else if ($col == "name") {
      
      $output .= <<<HERE
      <br /><br />
    <label>Name</label>
    <input type="text" name="name" value="$val">
  
HERE;

    } else if ($col == "indication") {
      $output .= <<<HERE
      <br /><br />
    <label>Indication</label>
    <input type="text" name="indication" value="$val">

HERE;

    } else if ($col == "stage") {
      $output .= <<<HERE
      <br /><br />
    <label>Stage</label>
    <input type="text" name="stage" value="$val">

HERE;

    } // end if

  } // end foreach
  $output .= <<<HERE
      <br /><br />
      <button type = "submit">
         update this record
      </button>
</form>

HERE;
  print $output;
  
  
  ?>

</div> <!-- end main-content div -->

<?php include("footer.php"); ?>
</body>
</html>

