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
    <form action="DonorList.php" method="post">
      <p>Donor Name:</p>
      <input type="text" name="Donor" value="Anonymous">
      <input type="submit" value="View donation history">
    </form>
  </div>
  <div class="column">
  <p>List of Donors:</p>
  <table>
  <tr><th>Donor Surname</th></tr>
  <?php
  $user = "root";
  $pass = "";
  $dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

  $stmt = $dbh->prepare("SELECT lname from Donor");
  try {
      $stmt->execute();
      if (is_array($stmt) || is_object($stmt)) {
          foreach ($stmt as $row) {
              echo "<tr><td>".$row[0]."</td></tr>";
          }
      }
  } catch (PDOException $e) {
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
