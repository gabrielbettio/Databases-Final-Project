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
    <form action="animalList.php" method="post">
      <p>SPCA Location:</p>
      <input type="text" name="SPCALocation" value="1">
      <input type="submit" value="View animals">
    </form>
  </div>
  <div class="column">
  <p>List of SPCA Locations:</p>
  <table>
  <tr><th>SPCA ID</th><th>Name</th></tr>
  <?php
  $user = "root";
  $pass = "";
  $dbh = new PDO('mysql:host=localhost;dbname=AnimalRescue',$user,$pass);

  $stmt = $dbh->prepare("SELECT orgID, name from Organizations where type = 'SPCA'");
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
   </table>
  </div>
</div>



</body>
</html>
