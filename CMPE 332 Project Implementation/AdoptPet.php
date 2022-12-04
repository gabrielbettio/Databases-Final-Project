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
<?php

$Shelter = $_POST["Shelter"];

$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

# Get the name of the shelter for the summary
$summary = $dbh->prepare("SELECT name from Organizations where orgID = :Shelter AND type='Shelter'");
$summary->bindParam(':Shelter', $Shelter);

# Check to see if the shelter entered is valid and if so print the summary
try {
    $summary->execute();
    if ($summary->rowCount() > 0) {
        $result = $summary->fetch(PDO::FETCH_BOTH);
        echo "<h3>Adopt a pet from ".$result[0]."</h3>" ;
    } else {
        echo "<h3>Please enter a valid shelter.</h3>";
        die();
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

# Prepared statement to get a list of animals up for adoption
$getAnimalsInShelter = $dbh->prepare("SELECT animalID, type from Animal where shelter = :Shelter AND adopter IS NULL");
$getAnimalsInShelter->bindParam(':Shelter', $Shelter);

# Check to see if there are any available animals. If there are, create the adoption form and list the animals. Otherwise let the user know there are no animals available.
try {
    $getAnimalsInShelter->execute();
    if ($getAnimalsInShelter->rowCount() > 0) {
        if (is_array($getAnimalsInShelter) || is_object($getAnimalsInShelter)) {
            echo "<form action='AdoptThisPet.php' method='post'>
	<input type='hidden' name='Shelter' value=$Shelter>
	<p>Animal ID:</p>
	<input type='text' name='animalID'>
	<p>Adopter Last Name:</p>
	<input type='text' name='LastName'>
	<p>Amount Paid:</p>
	<input type='text' name='amount'>
	<input type=\"submit\" class= \"button\" name= \"activate\" value=\"Adopt This Pet\" />
	</form>";
            echo "</div><div class=\"column\"><p>List of animals available for adoption:</p><table>";
            echo "<tr><th>Pet ID</th><th>Type</th></tr>";
            foreach ($getAnimalsInShelter as $row) {
                echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
            }
            echo "</table>";
        }
    } else {
        echo "There are no animals available for adoption at this time. Please check again later.";
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

?>
</div>
</div>
</body>
</html>
