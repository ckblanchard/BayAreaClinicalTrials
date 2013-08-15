<h1>Edit an existing drug</h1>

<form action="updateDrug.php" method="post">
    
  <label for="name">Search by drug name</label>
  <input type="text" id="name" name="name">
  <input type="submit" value="Search drug">

</form>

<form action="updateDrug.php" method="post">
  
  <label for="bycompany">Search by company</label>
  <select name="bycompany" id="bycompany">
    <?php
      // connect to db
        $conn = connectToDb();
        
      // query all companies in companies table
      $sql = "SELECT companyID, name FROM companies";
      $result = mysql_query($sql, $conn) or die(mysql_error());
      
      while ($row = mysql_fetch_assoc($result)){
        print '<option value="'.$row["companyID"].'">'.$row["name"].'</option>';
      }

    ?>
  </select>
  <input type="submit" value="Search company">
</form>
