<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();
$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $KundenNr = isset($_POST['KundenNr']) ? $_POST['KundenNr'] : '';
    $ProduktNr = isset($_POST['ProduktNr']) ? $_POST['ProduktNr'] : '';
    $SV_Nummer = isset($_POST['SV_Nummer']) ? $_POST['SV_Nummer'] : '';
}
$success = $database->insertIntoSells($KundenNr, $ProduktNr, $SV_Nummer);
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
<h2 class= "mt-4">Add Sells</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="addSells.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="KundenNr">ClientNR</span>
  </div>
  <input type="text" class="form-control" id="KundenNr" name="KundenNr" aria-label="Small" aria-describedby="KundenNr">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="ProduktNr">ProductNR</span>
  </div>
  <input type="text" class="form-control" id="ProduktNr" name="ProduktNr" aria-label="Small" aria-describedby="ProduktNr">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="SV_Nummer">SVN</span>
  </div>
  <input type="text" class="form-control" id="SV_Nummer" name="SV_Nummer" aria-label="Small" aria-describedby="SV_Nummer">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Add Sells
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Sells '<?php echo "{$KundenNr} {$ProduktNr} {$SV_Nummer}"; ?>' successfully added!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't insert Sells '<?php echo "{$KundenNr} {$ProduktNr} {$SV_Nummer}"; ?>'!
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