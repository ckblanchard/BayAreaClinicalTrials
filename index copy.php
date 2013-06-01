<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Simple drug development search</title>
	<?php include("drugLib.php"); ?>
</head>
<body>

<h1>Search Bay Area drug development</h1>

<div id="search-area">
  <h2>Search options</h2>
  
  <!-- Company search form -->
  <form action="companySearch.php" method="post" class="search-module">
  <h3>All drugs by company</h3>
  
    <label for="company">Company</label>
    <select name="company" id="company">
      <option value="">Select company</option>
      <?php
        // make db connection
        $conn = connectToDb();
        
        // query all companies in companies table
        $sql = "SELECT companyID, name FROM companies";
        $result = mysql_query($sql, $conn) or die(mysql_error());
        
        while ($row = mysql_fetch_assoc($result)){
          print '<option value="'.$row["companyID"].'">'.$row["name"].'</option>';
        }
      ?>
    </select>
    <input type="submit" value="Search">
  </form>
  
  <!-- Body part search form -->
  <form action="bodyPartSearch.php" method="post" class="search-module">
  <h3>All drugs by body part</h3>
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
    <input type="submit" value="Search">
  </form>
  
  <!-- Trial stage search form -->
  <form action="trialStageSearch.php" method="post" class="search-module">
  <h3>All drugs by trial stage</h3>
   <label for="stage">Trial stage</label>
    <select name="stage" id="stage">
      <option value="">Select trial stage</option>
      <option value="I">Stage I</option>
      <option value="I/II">Stage I/II</option>
      <option value="II">Stage II</option>
      <option value="II/III">Stage II/III</option>
      <option value="III">Stage III</option>
    </select>
    <input type="submit" value="Search">
  </form>
  
  <!-- Indication search form -->
  <form action="indicationSearch.php" method="post" class="search-module">
  <h3>All drugs by indication</h3>
    <label for="indication">Enter indication</label>
    <input type="text" name="indication" id="indication">
    <input type="submit" value="Search">
  </form>
</div> <!-- end search-area -->
</body>
</html>

















