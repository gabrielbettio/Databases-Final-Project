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

$RescueOrganization = $_POST["RescueOrganization"];
if ("" == trim($RescueOrganization)) {
    echo "Please give a valid Rescue Organization";
    die();
}

$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

$summary = $dbh->prepare("SELECT name from Organizations where orgID = :RescueOrganization AND type='Rescue'");
$summary->bindParam(':RescueOrganization', $RescueOrganization);
try {
    $summary->execute();
    if ($summary->rowCount() > 0) {
        $result = $summary->fetch(PDO::FETCH_BOTH);
        echo "<h3>All Drivers Associated With ".$result[0]."</h3>";
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

$stmt = $dbh->prepare("SELECT fname, lname, emergPhone, licensePl, driveLic from Driver where rescueOrg = :RescueOrganization");
$stmt->bindParam(':RescueOrganization', $RescueOrganization);

try {
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        if (is_array($stmt) || is_object($stmt)) {
            echo "<tr><th>First Name</th><th>Last Name</th><th>Emergency Phone</th><th>License Plate</th><th>Drivers License</th></tr>";
            foreach ($stmt as $row) {
                echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td></tr>";
            }
        }
    } else {
        echo "Please give a valid Rescue Organization";
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

?>
</table>
</body>
</html>
