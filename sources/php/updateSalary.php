<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$success = false;
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SV_Nummer = isset($_POST['SV_Nummer']) ? $_POST['SV_Nummer'] : '';
    $new_salary = isset($_POST['new_salary']) ? $_POST['new_salary'] : '';
}

// Insert method
$success = $database->updateSalary($SV_Nummer, $new_salary);
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
<h2 class= "mt-4">Update Salary</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="updateSalary.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="SV_Nummer">SVN</span>
  </div>
  <input type="text" class="form-control" id="SV_Nummer" name="SV_Nummer" aria-label="Small" aria-describedby="SV_Nummer">
</div>
    <br>
    <div class="input-group-prepend">
    <span class="input-group-text" id="new_salary">Salary (NEW)</span>
  </div>
  <input type="text" class="form-control" id="new_salary" name="new_salary" aria-label="Small" aria-describedby="new_salary">
</div>
    <br>
    <div>
        <button type="submit" class="btn btn-outline-success">
            Update Salary
        </button>
    </div>
</form>
</div>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
            Salary for Employee '<?php echo "{$SV_Nummer}"; ?>' successfully updated!
        </div>
    <?php else : ?> 
        <div class="alert alert-danger" role="alert">
        Error can't update Salary for Employee '<?php echo "{$SV_Nummer}"; ?>'!
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