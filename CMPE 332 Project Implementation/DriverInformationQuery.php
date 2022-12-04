<!DOCTYPE html>
<html>
<head>
<link href="style.css" type="text/css" rel="stylesheet" >
</head>
<body>
  <div class="mainHeader">
    <h1><a href="index.html">Animal Rescue</a></h1>
  </div>
  <div class="row">
  <div class="column">
    <form action="DriverInformation.php" method="post">
      <p>Rescue Organization:</p>
      <input type="text" name="RescueOrganization" value="7">
      <input type="submit" value="View drivers">
    </form>
  </div>
  <div class="column">
  <p>List of Rescue Organizations:</p>
  <table>
  <tr><th>Rescue Organization</th><th>Name</th></tr>
  <?php
  $user = "root";
  $pass = "";
  $dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

  $stmt = $dbh->prepare("SELECT orgID, name from Organizations where type = 'Rescue'");
  try {
      $stmt->execute();
      if (is_array($stmt) || is_object($stmt)) {
          foreach ($stmt as $row) {
              echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
          }
      }
  } catch (PDOException $e) {
      echo "fail";
      print "Error!:".$e->getMessage()."<br/>";
      die();
  }

   ?>
 </table>
   </table>
  </div>
</div>



</body>
</html>
