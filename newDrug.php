<div id="new-drug">
  
  <h1>Add a drug to the development database</h1>
  
  <form action="saveNewDrug.php" method="post">
    
    <label for="newName">Drug name</label>
    <input type="text" name="name" id="newName">
    <br /><br />
    
    <label for="newIndication">Indication</label>
    <input type="text" name="indication" id="newIndication">
    <br /><br />
    
    <label for="newBody_part">Body part</label>
    <select name="body_part" id="newBody_part">
      <option value="">Select body part</option>
  
      <?php
        // make db connection
        $conn = connectToDb();

        
        // query all companies in companies table
        $sql = "SELECT body_partID, name FROM body_part";
        $result = mysql_query($sql, $conn) or die(mysql_error());
        
        while ($row = mysql_fetch_assoc($result)){
          print '<option value="'.$row["body_partID"].'">'.$row["name"].'</option>';
        }
      ?>  
    </select>
    <br /><br />
  
    <label for="newStage">Trial stage</label>
    <select name="stage" id="newStage">
      <option value="">Select trial stage</option>
      <option value="I">Stage I</option>
      <option value="I/II">Stage I/II</option>
      <option value="II">Stage II</option>
      <option value="II/III">Stage II/III</option>
      <option value="III">Stage III</option>
      <option value="IV">Stage IV</option>
    </select>
    <br /><br />
    
    <label for="newCompany">Company</label>
    <select name="company" id="newCompany">
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
    <br /><br />
  
    <input type="submit" value="Save drug">
  
  </form>

</div> <!-- End of new-drug div -->