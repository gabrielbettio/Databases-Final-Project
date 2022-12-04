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

$Organization = $_POST["Organization"];
if ("" == trim($Organization)) {
    echo "Please give a valid Organization";
    die();
}

$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

$summary = $dbh->prepare("SELECT name from Organizations where orgID = :Organization");
$summary->bindParam(':Organization', $Organization);
try {
    $summary->execute();
    if ($summary->rowCount() > 0) {
        $result = $summary->fetch(PDO::FETCH_BOTH);
        echo "<h3>Total amount donated in 2018 to ".$result[0]."</h3>";
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

$stmt = $dbh->prepare("SELECT SUM(amount) from Donation where recipient = :Organization and EXTRACT(YEAR FROM date) = 2018");
$stmt->bindParam(':Organization', $Organization);

try {
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        if (is_array($stmt) || is_object($stmt)) {
            echo "<tr><th>Amount</th></tr>";
            foreach ($stmt as $row) {
                if ($row[0]==null) {
                    echo "<tr><td>0</td></tr>";
                } else {
                    echo "<tr><td>".$row[0]."</td></tr>";
                }
            }
        }
    } else {
        echo "Please give a valid Organization";
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

?>
</table>
</body>
</html>
