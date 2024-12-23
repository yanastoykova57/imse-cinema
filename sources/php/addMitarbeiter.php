<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SV_Nummer = isset($_POST['SV_Nummer']) ? $_POST['SV_Nummer'] : '';
    $MitarbeiterName = isset($_POST['MitarbeiterName']) ? $_POST['MitarbeiterName'] : '';
    $Kinoid = isset($_POST['Kinoid']) ? $_POST['Kinoid'] : '';
    $E_Mail = isset($_POST['E_Mail']) ? $_POST['E_Mail'] : '';
    $Gehalt = isset($_POST['Gehalt']) ? $_POST['Gehalt'] : '';
    $Leiter_SV_Nummer = isset($_POST['Leiter_SV_Nummer']) ? $_POST['Leiter_SV_Nummer'] : '';
}

// Insert method
$success = $database->insertIntoMitarbeiter($SV_Nummer, $MitarbeiterName, $Kinoid, $E_Mail, $Gehalt, $Leiter_SV_Nummer);
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
<h2 class= "mt-4">Add Employee</h2>
</div>  
        <!--FORM-->
<form class= "mb-5" method="post" action="addMitarbeiter.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="SV_Nummer">SVN</span>
  </div>
  <input type="text" class="form-control" id="SV_Nummer" name="SV_Nummer" aria-label="Small" aria-describedby="SV_Nummer">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="MitarbeiterName">Name</span>
  </div>
  <input type="text" class="form-control" id="MitarbeiterName" name="MitarbeiterName" aria-label="Small" aria-describedby="MitarbeiterName">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Kinoid">CinemaID</span>
  </div>
  <input type="text" class="form-control" id="Kinoid" name="Kinoid" aria-label="Small" aria-describedby="Kinoid">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="E_Mail">E-Mail</span>
  </div>
  <input type="text" class="form-control" id="E_Mail" name="E_Mail" aria-label="Small" aria-describedby="E_Mail">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Gehalt">Salary</span>
  </div>
  <input type="text" class="form-control" id="Gehalt" name="Gehalt" aria-label="Small" aria-describedby="Gehalt">
</div>
    <br>
    <div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Leiter_SV_Nummer">Manager SVN</span>
  </div>
  <input type="text" class="form-control" id="Leiter_SV_Nummer" name="Leiter_SV_Nummer" aria-label="Small" aria-describedby="Leiter_SV_Nummer">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Add Employee
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Employee '<?php echo "{$SV_Nummer} {$MitarbeiterName} {$Kinoid} {$E_Mail} {$Gehalt}"; ?>' successfully added!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't insert Employee '<?php echo "{$SV_Nummer} {$MitarbeiterName} {$Kinoid} {$E_Mail} {$Gehalt}"; ?>'!
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