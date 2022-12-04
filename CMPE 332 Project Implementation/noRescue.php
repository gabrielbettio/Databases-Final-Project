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
  <p>List of animals that went directly from an SPCA location to a shelter:</p>
  <table>
  <tr><th>Animal ID</th><th>Type</th><th>Shelter</th></tr>
  <?php
  $user = "root";
  $pass = "";
  $dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

  $stmt = $dbh->prepare("SELECT animalID, type, shelter from Animal A where rescued = FALSE AND depart IS NOT NULL");
  $getShelterName = $dbh->prepare("SELECT name from Organizations where orgID=:orgID");
  try {
      $stmt->execute();
      if (is_array($stmt) || is_object($stmt)) {
          foreach ($stmt as $row) {
              echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td>";
              if ($row[2]!=null) {
                  $getShelterName->bindParam(':orgID', $row[2]);
                  $getShelterName->execute();
                  $name = $getShelterName->fetch(PDO::FETCH_BOTH);
                  echo "<td>".$name[0]."</td></tr>";
              } else {
                  echo "<td>Adopted</td></tr>";
              }
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
