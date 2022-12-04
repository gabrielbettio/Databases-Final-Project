<!DOCTYPE html>
<html>
<head><!DOCTYPE html>
<html>
<head>
<link href="style.css" type="text/css" rel="stylesheet" >
</head>
<body>
  <div class="mainHeader">
    <h1><a href="index.html">Animal Rescue</a></h1>
  </div>
<?php

# Connect to DB
$user = "root";
$pass = "";
$dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue', $user, $pass);

# Get information from adoption form in AdoptPet
$animal = $_POST["animalID"];
$ShelterLocation = $_POST["Shelter"];
$amountPaid = $_POST["amount"];
$adopterName = $_POST["LastName"];

if ($amountPaid == "") {
    $amountPaid = 0;
}

# Check to see if the animal given is actually in the shelter its supposed to be
$checkAnimalValid = $dbh->prepare("SELECT animalID from Animal where animalID = :animalID AND shelter = :shelterLocation");
$checkAnimalValid->bindParam(':shelterLocation', $ShelterLocation);
$checkAnimalValid->bindParam(':animalID', $animal);

# Check if the adopter is in the adopter database
$checkAdopt = $dbh->prepare("SELECT lname from Adopter where lname = :adopterName");
$checkAdopt->bindParam(':adopterName', $adopterName);

# Prepared statement to add the adopter into the Adopter table if they are not already in it
$addAdopter = $dbh->prepare("INSERT INTO Adopter VALUES(:lname,:phone,:address)");
$addAdopter -> bindParam(':lname', $adopterName);
$addAdopter -> bindValue(':phone', null);
$addAdopter -> bindValue(':address', null);

# Prepared statement to update the animals status to reflect adoption
$updateAnimalAdoption = $dbh->prepare("UPDATE Animal SET shelter = :ShelterLocation, adopter = :adopterName, adptAmnt = :amountPaid where animalID = :animal");
$updateAnimalAdoption->bindValue(':ShelterLocation', null);
$updateAnimalAdoption->bindParam(':amountPaid', $amountPaid);
$updateAnimalAdoption->bindParam(':adopterName', $adopterName);
$updateAnimalAdoption->bindParam(':animal', $animal);

try {
    $checkAnimalValid->execute();
    # Now insert logic to see if animal result is empty - if yes kill
    if ($checkAnimalValid->rowCount() == 0) {
        echo "Please select an animal from shelter ".$ShelterLocation;
        die();
    }
    # Check to see if the adopter name passed in empty
    if ($adopterName == "") {
        echo "Please enter an adopter last name";
        die();
    }
    $checkAdopt->execute();
    # check to see if the adopter is already in the Adopter table
    if ($checkAdopt->rowCount() == 0) {
        # adopter is not in the system, add the adopter
        $addAdopter->execute();
    }

    # Animal is valid and adopter is in the system. do the adoption
    $updateAnimalAdoption->execute();

    #print summary statement
    echo "<p>".$adopterName." adopted animal ".$animal." and paid $".$amountPaid."</p>";
} catch (PDOException $e) {
    print "Error!:".$e->getMessage()."<br/>";
    die();
}

?>
</body>
</html>
