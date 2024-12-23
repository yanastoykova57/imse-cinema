<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $RechnungsNr = isset($_POST['RechnungsNr']) ? $_POST['RechnungsNr'] : '';
}

$success = $database->deletePayment($RechnungsNr);
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
<h2 class= "mt-4">Delete Payment</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="delPayment.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="RechnungsNr">BillNR</span>
  </div>
  <input type="text" class="form-control" id="RechnungsNr" name="RechnungsNr" aria-label="Small" aria-describedby="RechnungsNr">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Delete Payment
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Payment '<?php echo "{$RechnungsNr}"; ?>' successfully deleted!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't delete Payment '<?php echo "{$RechnungsNr}"; ?>'!
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