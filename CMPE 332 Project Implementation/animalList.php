<!DOCTYPE html>
<html>
<head>
<link href="style.css" type="text/css" rel="stylesheet" >
</head>
<body>
  <div class="mainHeader">
    <h1><a href="index.html">Animal Rescue</a></h1>
  </div>
<table>

<?php

$SPCALocation = $_POST["SPCALocation"];
if("" == trim($SPCALocation)){
    echo "Please give a valid SPCA Location";
    die();
}

$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue',$user,$pass);

$summary = $dbh->prepare("SELECT name from Organizations where orgID = :SPCALocation AND type='SPCA'");
$summary->bindParam(':SPCALocation',$SPCALocation);
try{
  $summary->execute();
  if ($summary->rowCount() > 0) {
    $result = $summary->fetch(PDO::FETCH_BOTH);
    echo "<h3>Available animals in ".$result[0]."</h3>";
  }else{
    echo "Please give a valid SPCA Location";
    die();
  }
} catch(PDOException $e){
  print "Error!:".$e->getMessage()."<br/>";
  die();
}

$stmt = $dbh->prepare("SELECT animalID, type from Animal where SPCABranch = :SPCALocation AND shelter IS NULL");
$stmt->bindParam(':SPCALocation',$SPCALocation);

try{
  $stmt->execute();
  if ($stmt->rowCount() > 0) {
  if (is_array($stmt) || is_object($stmt)){
    echo "<tr><th>Animal ID</th><th>Type</th></tr>";
    foreach($stmt as $row){
      echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
    }
  }
}else{
  echo "<p>Sorry. No animals are available in ".$result[0]." at this time.</p>";

}
} catch(PDOException $e){
  print "Error!:".$e->getMessage()."<br/>";
  die();
}

?>
</table>
</body>
</html>
