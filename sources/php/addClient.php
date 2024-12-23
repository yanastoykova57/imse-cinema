<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $KundenNr = isset($_POST['KundenNr']) ? $_POST['KundenNr'] : '';
    $Name = isset($_POST['Name']) ? $_POST['Name'] : '';
    $TelefonNr = isset($_POST['TelefonNr']) ? $_POST['TelefonNr'] : '';
}

$success = $database->insertIntoClient($KundenNr, $Name, $TelefonNr);
?>

<!-- link back to index page-->
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
<h2 class= "mt-4">Add Client</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="addClient.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="KundenNr">ClientNR</span>
  </div>
  <input type="text" class="form-control" id="KundenNr" name="KundenNr" aria-label="Small" aria-describedby="KundenNr">
</div>
    <br>
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Name">Name</span>
  </div>
  <input type="text" class="form-control" id="Name" name="Name" aria-label="Small" aria-describedby="Name">
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
            Add Client
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Client '<?php echo "{$KundenNr}, {$Name}, {$TelefonNr}"; ?>' successfully added!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't insert Client '<?php echo "{$KundenNr}, {$Name}, {$TelefonNr}"; ?>'!
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