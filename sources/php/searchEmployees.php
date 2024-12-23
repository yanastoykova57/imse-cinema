<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');
//instantiate DatabaseHelper class
$database = new DatabaseHelper();
$employees = [];
/*
//Grab variables from POST request
$Kinoid = '';
if(isset($_GET['Kinoid'])){
    $Kinoid = $_GET['Kinoid'];
}*/
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Kinoid = isset($_POST['Kinoid']) ? $_POST['Kinoid'] : '';
}

// Insert method
$employees = $database->selectFromEmployeeWhere($Kinoid);
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
<h2 class= "mt-4">Search Employees</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="searchEmployees.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="Kinoid">CinemaID</span>
  </div>
  <input type="text" class="form-control" id="Kinoid" name="Kinoid" aria-label="Small" aria-describedby="Kinoid">
</div>
    <br>

    <div>
        <button type="submit" class="btn btn-outline-success">
            Search Employees
        </button>
    </div>
</form>
</div>

<!-- Search result Employee-->
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
<h2>Employee Search Result:</h2>
<table class="table">
    <thread class="thread-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Cinema ID</th>
        <th scope="col">Email</th>
        <th scope="col">Salary</th>
        <th scope="col">Manager SVNummer</th>
    </tr>
</thread>
    <tbody>
    <?php foreach ($employees as $index => $employee) : ?>
        <tr>
            <th scope="row"><?php echo $index +1; ?></th>
            <td><?php echo $employee['SV_NUMMER']; ?>  </td>
            <td><?php echo $employee['MITARBEITERNAME']; ?>  </td>
            <td><?php echo $employee['KINOID']; ?>  </td>
            <td><?php echo $employee['E_MAIL']; ?>  </td>
            <td><?php echo $employee['GEHALT']; ?>  </td>
            <td><?php echo $employee['LEITER_SV_NUMMER']; ?>  </td>
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


