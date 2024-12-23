<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SV_Nummer = isset($_POST['SV_Nummer']) ? $_POST['SV_Nummer'] : '';
}

$success = $database->deleteMitarbeiter($SV_Nummer);
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
<h2 class= "mt-4">Delete Employee</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="delMitarbeiter.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="SV_Nummer">SVN</span>
  </div>
  <input type="text" class="form-control" id="SV_Nummer" name="SV_Nummer" aria-label="Small" aria-describedby="SV_Nummer">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Delete Employee
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Employee '<?php echo "{$SV_Nummer}"; ?>' successfully deleted!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't delete Employee '<?php echo "{$SV_Nummer}"; ?>'!
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