<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ProduktNr = isset($_POST['ProduktNr']) ? $_POST['ProduktNr'] : '';
    $Bezeichnung = isset($_POST['Bezeichnung']) ? $_POST['Bezeichnung'] : '';
    $Preis = isset($_POST['Preis']) ? $_POST['Preis'] : '';
    $KaufNR = isset($_POST['KaufNR']) ? $_POST['KaufNR'] : '';
    //$Filmtitel = isset($_POST['Filmtitel']) ? $_POST['Filmtitel'] : '';
    //$Sitzplatz = isset($_POST['Sitzplatz']) ? $_POST['Sitzplatz'] : '';
    //$Marke = isset($_POST['Marke']) ? $_POST['Marke'] : '';
    //$Groesse = isset($_POST['Groesse']) ? $_POST['Groesse'] : '';
}
$success = $database->insertIntoProduct($ProduktNr, $Bezeichnung, $Preis, $KaufNR);
//Grab variables from POST request
/*$ProduktNr = '';
if(isset($_POST['ProduktNr'])){
    $ProduktNr = $_POST['ProduktNr'];
}

$Bezeichnung = '';
if(isset($_POST['Bezeichnung'])){
    $Bezeichnung = $_POST['Bezeichnung'];
}

$Preis = '';
if(isset($_POST['Preis'])){
    $Preis = $_POST['Preis'];
}

$Filmtitel = '';
if(isset($_POST['Filmtitel'])){
    $Filmtitel = $_POST['Filmtitel'];
}

$Sitzplatz = '';
if(isset($_POST['Sitzplatz'])){
    $Sitzplatz = $_POST['Sitzplatz'];
}

$Marke = '';
if(isset($_POST['Marke'])){
    $Marke = $_POST['Marke'];
}

$Groesse = '';
if(isset($_POST['Groesse'])){
    $Groesse = $_POST['Groesse'];
}

// Insert method
$success = $database->insertIntoProduct($ProduktNr, $Bezeichnung, $Preis, $Filmtitel, $Sitzplatz, $Marke, $Groesse);

// Check result
if ($success){
    echo "Product '{$ProduktNr} {$Bezeichnung} {$Preis} {$Filmtitel} {$Sitzplatz} {$Marke} {$Groesse}' successfully added!'";
}
else{
    echo "Error can't insert Product '{$ProduktNr} {$Bezeichnung} {$Preis} {$Filmtitel} {$Sitzplatz} {$Marke} {$Groesse}'!";
}*/
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
<h2 class= "mt-4">Add Product</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="addProduct.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="ProduktNr">ProductNR</span>
  </div>
  <input type="text" class="form-control" id="ProduktNr" name="ProduktNr" aria-label="Small" aria-describedby="ProduktNr">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Bezeichnung">Description</span>
  </div>
  <input type="text" class="form-control" id="Bezeichnung" name="Bezeichnung" aria-label="Small" aria-describedby="Bezeichnung">
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
    <span class="input-group-text" id="KaufNR">PurchaseNR</span>
  </div>
  <input type="text" class="form-control" id="KaufNR" name="KaufNR" aria-label="Small" aria-describedby="KaufNR">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Add Product
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Product '<?php echo "{$ProduktNr} {$Bezeichnung} {$Preis} {$KaufNR}"; ?>' successfully added!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't insert Product '<?php echo "{$ProduktNr} {$Bezeichnung} {$Preis} {$KaufNR}"; ?>'!
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