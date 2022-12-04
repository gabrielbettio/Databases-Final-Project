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


  <?php
  $user = "root";
  $pass = "";
  $dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

  $stmt = $dbh->prepare("SELECT count(animalID) from Animal where rescued = TRUE AND depart > '2017-12-31' AND depart < '2019-01-01'");
  try {
      $stmt->execute();
      if (is_array($stmt) || is_object($stmt)) {
          foreach ($stmt as $row) {
              if ($row[0]==1) {
                  echo "<p>".$row[0]." animal was rescued in 2018.</p>";
              } else {
                  echo "<p>".$row[0]." animals were rescued in 2018.</p>";
              }
          }
      }
  } catch (PDOException $e) {
      print "Error!:".$e->getMessage()."<br/>";
      die();
  }

  ?>
</div>



</body>
</html>
