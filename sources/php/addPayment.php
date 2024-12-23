<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $RechnungsNr = isset($_POST['RechnungsNr']) ? $_POST['RechnungsNr'] : '';
    $KaufNr = isset($_POST['KaufNr']) ? $_POST['KaufNr'] : '';
    $Zahlungsart = isset($_POST['Zahlungsart']) ? $_POST['Zahlungsart'] : '';
    $Summe = isset($_POST['Summe']) ? $_POST['Summe'] : '';
}
$success = $database->insertIntoPayment($RechnungsNr, $KaufNr, $Zahlungsart, $Summe);
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
<h2 class= "mt-4">Add Payment</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="addPayment.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="RechnungsNr">BillNr</span>
  </div>
  <input type="text" class="form-control" id="RechnungsNr" name="RechnungsNr" aria-label="Small" aria-describedby="RechnungsNr">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="KaufNr">PurchaseNR</span>
  </div>
  <input type="text" class="form-control" id="KaufNr" name="KaufNr" aria-label="Small" aria-describedby="KaufNr">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Zahlungsart">Payment method</span>
  </div>
  <input type="text" class="form-control" id="Zahlungsart" name="Zahlungsart" aria-label="Small" aria-describedby="Zahlungsart">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Summe">Payment total</span>
  </div>
  <input type="text" class="form-control" id="Summe" name="Summe" aria-label="Small" aria-describedby="Summe">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Add Payment
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Payment '<?php echo "{$RechnungsNr} {$KaufNr} {$Zahlungsart} {$Summe}"; ?>' successfully added!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't insert Payment '<?php echo "{$RechnungsNr} {$KaufNr} {$Zahlungsart} {$Summe}"; ?>'!
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