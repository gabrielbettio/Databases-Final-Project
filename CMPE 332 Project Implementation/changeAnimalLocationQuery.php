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
  <form action="changeAnimalLocation.php" method="post">
    <p>Animal:</p>
    <input type="text" name="animalID">
    <p>Shelter to be moved to:</p>
    <input type="text" name="locationID" value="4">
    <p>Move Date:</p>
    <input type="date" name="moveDate" value="2018-03-26">
    <p>Rescue Organization Used?:</p>
    <input type="checkbox" name="rescueOrgUsed">
    <p>Rescue Organization:</p>
    <input type="text" name="rescueOrgID" value="7">
    <p>Driver Last Name:</p>
    <input type="text" name="rescueOrgDriverName" value="Buchanan">
    <p>Amount paid to driver:</p>
    <input type="text" name="rescueOrgDriverPaid">
    <input type="submit" value="Update location">
  </form>
</div class="column">
<div class="column">
  <p>List of Available Shelters:</p>
  <table>
  <tr><th>Shelter ID</th><th>Name</th></tr>
  <?php
  $user = "root";
  $pass = "";
  $dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue',$user,$pass);

  $stmt = $dbh->prepare("SELECT orgID, name from Organizations where type = 'Shelter'");
  try{
    $stmt->execute();
    if (is_array($stmt) || is_object($stmt)){
      foreach($stmt as $row){
        echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
      }
    }
  } catch(PDOException $e){
    echo "fail";
    print "Error!:".$e->getMessage()."<br/>";
    die();
  }

   ?>
</table>
<p>List of Rescue Organizations:</p>
<table>
<tr><th>Rescue Organization ID</th><th>Name</th></tr>
<?php
$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue',$user,$pass);

$stmt = $dbh->prepare("SELECT orgID, name from Organizations where type = 'Rescue'");
try{
  $stmt->execute();
  if (is_array($stmt) || is_object($stmt)){
    foreach($stmt as $row){
      echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
    }
  }
} catch(PDOException $e){
  echo "fail";
  print "Error!:".$e->getMessage()."<br/>";
  die();
}

 ?>
</table>
<p>List of Rescue Drivers:</p>
<table>
<tr><th>Driver Name</th><th>Associated Rescue Organization</th></tr>
<?php
$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue',$user,$pass);

$stmt = $dbh->prepare("SELECT fname, lname, rescueOrg from Driver ORDER BY rescueOrg");
try{
  $stmt->execute();
  if (is_array($stmt) || is_object($stmt)){
    foreach($stmt as $row){
      echo "<tr><td>".$row[0]." ".$row[1]."</td><td>".$row[2]."</td></tr>";
    }
  }
} catch(PDOException $e){
  echo "fail";
  print "Error!:".$e->getMessage()."<br/>";
  die();
}

?>
</table>
</div class="column">
</div class="row">

</body>
</html>
