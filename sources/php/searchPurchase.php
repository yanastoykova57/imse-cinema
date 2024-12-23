<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
/*$KundenNr = '';
if(isset($_GET['KundenNr'])){
    $KundenNr = $_GET['KundenNr'];
}*/
$purchases=[];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $KundenNr = isset($_POST['KundenNr']) ? $_POST['KundenNr'] : '';
}

// Insert method
$purchases = $database->selectFromPurchaseWhere($KundenNr);
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
<h2 class= "mt-4">Search Purchases</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="searchPurchase.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="KundenNr">ClientID</span>
  </div>
  <input type="text" class="form-control" id="KundenNr" name="KundenNr" aria-label="Small" aria-describedby="KundenNr">
</div>
    <br>

    <div>
        <button type="submit" class="btn btn-outline-success">
            Search Purchase
        </button>
    </div>
</form>
</div>
<!-- Search result Purchase -->
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
<h2>Purchase Search Result:</h2>
<table class="table">
    <thread class="thread-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">KaufNr</th>
        <th scope="col">Datum</th>
        <th scope="col">Preis</th>
        <th scope="col">KundenNr</th>
    </tr>
    </thread>
    <tbody>
    <?php foreach ($purchases as $index => $purchase) : ?>
        <tr>
            <th scope="row"><?php echo $index +1; ?></th>
            <td><?php echo $purchase['KAUFNR']; ?>  </td>
            <td><?php echo $purchase['DATUM']; ?>  </td>
            <td><?php echo $purchase['PREIS']; ?>  </td>
            <td><?php echo $purchase['KUNDENNR']; ?>  </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>
    </body>
    </html>