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

$Donor = $_POST["Donor"];
if ("" == trim($Donor)) {
    echo "Please give a valid Donor";
    die();
}

$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

$summary = $dbh->prepare("SELECT donor from Donation where donor = :Donor");
$summary->bindParam(':Donor', $Donor);
try {
    $summary->execute();
    if ($summary->rowCount() > 0) {
        $result = $summary->fetch(PDO::FETCH_BOTH);
        echo "<h3>".$result[0]." has made the following donations over their lifetime.</h3>";
    } else {
        echo "Please give a valid Donor";
        die();
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

$stmt = $dbh->prepare("SELECT name, sum(amount) from Donation, Organizations where donor = :Donor AND recipient = orgID GROUP BY name");
$stmt->bindParam(':Donor', $Donor);

try {
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        if (is_array($stmt) || is_object($stmt)) {
            echo "<tr><th>Recipient</th><th>Amount</th></tr>";
            foreach ($stmt as $row) {
                echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
            }
        }
    } else {
        echo "Please give a valid Donor";
        die();
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

?>
</table>
</body>
</html>
