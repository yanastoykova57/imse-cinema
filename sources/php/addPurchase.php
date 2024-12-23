<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $KaufNr = isset($_POST['KaufNr']) ? $_POST['KaufNr'] : '';
    $Datum = isset($_POST['Datum']) ? $_POST['Datum'] : '';
    $Preis = isset($_POST['Preis']) ? $_POST['Preis'] : '';
    $KundenNr = isset($_POST['KundenNr']) ? $_POST['KundenNr'] : '';
}

$success = $database->insertIntoPurchase($KaufNr, $Datum, $Preis, $KundenNr);
?>

<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <title>DBS Project</title>

</head>

<body>

<div class="container">
<br>
<div class="text-center">
<h2 class= "mt-4">Add Purchase</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="addPurchase.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="KaufNr">PurchaseNr</span>
  </div>
  <input type="text" class="form-control" id="KaufNr" name="KaufNr" aria-label="Small" aria-describedby="KaufNr">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Datum">Date</span>
  </div>
  <input type="text" class="form-control" id="Datum" name="Datum" aria-label="Small" aria-describedby="Datum">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Preis">Price</span>
  </div>
  <input type="text" class="form-control" id="Preis" name="Preis" aria-label="Small" aria-describedby="Preis">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="KundenNr">ClientNR</span>
  </div>
  <input type="text" class="form-control" id="KundenNr" name="KundenNr" aria-label="Small" aria-describedby="KundenNr">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Add Purchase
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Purchase '<?php echo "{$KaufNr} {$Datum} {$Preis} {$KundenNr}"; ?>' successfully added!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't insert Purchase '<?php echo "{$KaufNr} {$Datum} {$Preis} {$KundenNr}"; ?>'!
        </div>
        <?php endif; ?> 
        <?php endif; ?> 

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>
    </body>
    </html>