<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Add a new drug</title>
</head>
<body>
<h1>Add a drug to the development database</h1>

<form action="saveNewDrug.php" method="post">
  
  <label for="name">Drug name</label>
  <input type="text" name="name" id="name">
  <br /><br />
  
  <label for="indication">Indication</label>
  <input type="text" name="indication" id="indication">
  <br /><br />
  
  <label for="body_part">Body part</label>
  <select name="body_part" id="body_part">
    <option value="">Select body part</option>

    <?php
      // get username and password for MySQL server
      include('db_connection_info.inc'); 

      // connect to the MySQL server as the user or terminate script 
      $conn = mysql_connect("localhost", $drugUsername, $drugPassword) or die('Unable to connect to MySQL. ' . mysql_error());

      // select the database to use 
      mysql_select_db("drug_dev", $conn) or die('Unable to select database. ' . mysql_error());
      
      // query all companies in companies table
      $sql = "SELECT body_partID, name FROM body_part";
      $result = mysql_query($sql, $conn) or die(mysql_error());
      
      while ($row = mysql_fetch_assoc($result)){
        print '<option value="'.$row["body_partID"].'">'.$row["name"].'</option>';
      }
    ?>  
  </select>
  <br /><br />

  <label for="stage">Trial stage</label>
  <select name="stage" id="stage">
    <option value="">Select trial stage</option>
    <option value="I">Stage I</option>
    <option value="I/II">Stage I/II</option>
    <option value="II">Stage II</option>
    <option value="II/III">Stage II/III</option>
    <option value="III">Stage III</option>
  </select>
  <br /><br />
  
  <label for="company">Company</label>
  <select name="company" id="company">
    <option value="">Select company</option>
    <?php
      // get username and password for MySQL server
      include('db_connection_info.inc'); 

      // connect to the MySQL server as the user or terminate script 
      $conn = mysql_connect("localhost", $drugUsername, $drugPassword) or die('Unable to connect to MySQL. ' . mysql_error());

      // select the database to use 
      mysql_select_db("drug_dev", $conn) or die('Unable to select database. ' . mysql_error());
      
      // query all companies in companies table
      $sql = "SELECT companyID, name FROM companies";
      $result = mysql_query($sql, $conn) or die(mysql_error());
      
      while ($row = mysql_fetch_assoc($result)){
        print '<option value="'.$row["companyID"].'">'.$row["name"].'</option>';
      }
    ?>
  </select>
  <br /><br />

  <input type="submit" value="Save drug">

</form>
</body>
</html>