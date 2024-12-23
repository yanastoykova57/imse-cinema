<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $KundenNr = isset($_POST['KundenNr']) ? $_POST['KundenNr'] : '';
    $new_phonenr = isset($_POST['new_phonenr']) ? $_POST['new_phonenr'] : '';
}
//Grab variables from POST request
/*$KundenNr = '';
if(isset($_POST['KundenNr'])){
    $KundenNr = $_POST['KundenNr'];
}

$new_phonenr = '';
if(isset($_POST['new_phonenr'])){
    $new_phonenr = $_POST['new_phonenr'];
}*/

// Insert method
$success = $database->updatePhone($KundenNr, $new_phonenr);

// Check result
/*if ($success){
    echo "Phone number is updated!";
}
else{
    echo "Error can't update phone number!";
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
<h2 class= "mt-4">Update PhoneNr</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="updateCPhoneNr.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="KundenNr">ClientNr</span>
  </div>
  <input type="text" class="form-control" id="KundenNr" name="KundenNr" aria-label="Small" aria-describedby="KundenNr">
</div>
    <br>
    <div class="input-group-prepend">
    <span class="input-group-text" id="new_phonenr">PhoneNr (NEW)</span>
  </div>
  <input type="text" class="form-control" id="new_phonenr" name="new_phonenr" aria-label="Small" aria-describedby="new_phonenr">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Update PhoneNr
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            PhoneNr for Client '<?php echo "{$KundenNr}"; ?>' successfully updated!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't update PhoneNr for Client '<?php echo "{$KundenNr}"; ?>'!
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