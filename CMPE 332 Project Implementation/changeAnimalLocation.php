<!DOCTYPE html>
<html>
<head>
<link href="style.css" type="text/css" rel="stylesheet" >
</head>
<body>
  <div class="mainHeader">
    <h1><a href="index.html">Animal Rescue</a></h1>
  </div>
<?php

$animal = $_POST["animalID"];
$location = $_POST["locationID"];
$moveDate = $_POST["moveDate"];
$rescueOrg = $_POST["rescueOrgID"];
$driver = $_POST["rescueOrgDriverName"];
$amountPaid = $_POST["rescueOrgDriverPaid"];

if (isset($_POST['rescueOrgUsed'])) {
    $rescueOrgUsed = 1;
} else {
    $rescueOrgUsed = 0;#default value
}


$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

$checkAnimalValid = $dbh->prepare("SELECT animalID from Animal where animalID= :animalID");
$checkAnimalValid->bindParam(':animalID', $animal);


$summaryShelter = $dbh->prepare("SELECT name from Organizations where orgID= :shelterID AND type='Shelter'");
$summaryShelter->bindParam(':shelterID', $location);

$summaryRescue = $dbh->prepare("SELECT name from Organizations where orgID= :rescueID AND type='Rescue'");
$summaryRescue->bindParam(':rescueID', $rescueOrg);

$summaryDriver = $dbh->prepare("SELECT fname, lname from Driver where lname= :driverID");
$summaryDriver->bindParam(':driverID', $driver);


$updateAnimalLocation = $dbh->prepare("UPDATE Animal SET shelter = :location, depart = :moveDate, rescued = :rescueOrgUsed where animalID = :animal");
$updateAnimalLocation->bindParam(':location', $location);
$updateAnimalLocation->bindParam(':animal', $animal);
$updateAnimalLocation->bindParam(':moveDate', $moveDate);
$updateAnimalLocation->bindParam(':rescueOrgUsed', $rescueOrgUsed);

$addRescue = $dbh->prepare("INSERT INTO Rescue VALUES(:animal,:rescueOrg,:amountPaid,:driver)");
$addRescue->bindParam(':rescueOrg', $rescueOrg);
$addRescue->bindParam(':animal', $animal);
$addRescue->bindParam(':amountPaid', $amountPaid);
$addRescue->bindParam(':driver', $driver);


try {
    $checkAnimalValid->execute();
    if ($checkAnimalValid->rowCount() == 0) {
        # Animal not in database
        echo "Please give a valid animal id.";
        die();
    }
    # Update the location in the animal database
    $updateAnimalLocation->execute();
    $summaryShelter->execute();
    if ($summaryShelter->rowCount() > 0) {
        $result1 = $summaryShelter->fetch(PDO::FETCH_BOTH);
        # Check if a rescue was used. If yes, update the drives table.
        # Print a summary statment
        if ($rescueOrgUsed) {
            $addRescue->execute();
            $summaryRescue->execute();
            $summaryDriver->execute();
            if ($summaryRescue->rowCount() > 0) {
                $result2 = $summaryRescue->fetch(PDO::FETCH_BOTH);
                if ($summaryDriver->rowCount() > 0) {
                    $result3 = $summaryDriver->fetch(PDO::FETCH_BOTH);
                }
                echo "<h3>Animal $animal was moved to ".$result1[0]." on $moveDate. ".$result3[0]." ".$result3[1]." from ".$result2[0]." helped rescue the animal.</h3>";
            } else {
                echo "Please give a valid rescue organization.";
            }
        } else {
            echo "<h3>Animal $animal was moved to ".$result1[0]." on $moveDate.";
        }
    } else {
        echo "Please give a valid shelter.";
    }
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

?>
</body>
</html>
