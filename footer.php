<footer>
  <form action="editTable.php" method="post">
    <label for="admin">Admin login</label>
    <input type="password" name="admin" id="admin">
    <label for="tableName">Select table to edit</label>
    <select name="tableName" id="tableName">
      <option value="drugs">Drug</option>
      <option value="companies">Company</option>
      <option value="body_part">Body part</option>
    </select>
    <input type="submit" value="Sign in">
  </form>
</footer>