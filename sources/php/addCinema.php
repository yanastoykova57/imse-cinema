<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
$Name = '';
$Adresse = '';
$TelefonNr = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Name = isset($_POST['Name']) ? $_POST['Name'] : '';
    $Adresse = isset($_POST['Adresse']) ? $_POST['Adresse'] : '';
    $TelefonNr = isset($_POST['TelefonNr']) ? $_POST['TelefonNr'] : '';

    $success = $database->insertIntoKino($Name, $Adresse, $TelefonNr);
}
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
<h2 class= "mt-4">Add Cinema</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="addCinema.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Name">Cinema Name</span>
  </div>
  <input type="text" class="form-control" id="Name" name="Name" aria-label="Small" aria-describedby="cinemaName">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Adresse">Address</span>
  </div>
  <input type="text" class="form-control" id="Adresse" name="Adresse" aria-label="Small" aria-describedby="Adresse">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="TelefonNr">PhoneNr</span>
  </div>
  <input type="text" class="form-control" id="TelefonNr" name="TelefonNr" aria-label="Small" aria-describedby="TelefonNr">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Add Cinema
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Cinema '<?php echo "{$Name} {$Adresse} {$TelefonNr}"; ?>' successfully added!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't insert Cinema '<?php echo "{$Name} {$Adresse} {$TelefonNr}"; ?>'!
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