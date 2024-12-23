<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');
//instantiate DatabaseHelper class
$database = new DatabaseHelper();
$client = [];
$KundenNr = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $KundenNr = isset($_POST['KundenNr']) ? $_POST['KundenNr'] : '';
}
// Insert method
$client = $database->selectFromClientWhere($KundenNr);
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
<h2 class= "mt-4">Search Client</h2>  
</div>
        <!--FORM-->
<form class= "mb-5" method="post" action="searchClient.php">
<div class="input-group input-group-sm">
  <div class="input-group-prepend">
    <span class="input-group-text" id="KundenNr">ClientID</span>
  </div>
  <input type="text" class="form-control" id="KundenNr" name="KundenNr" aria-label="Small" aria-describedby="KundenNr">
</div>
    <br>

    <div>
        <button type="submit" class="btn btn-outline-success">
            Search Client
        </button>
    </div>
</form>
</div>
<!-- Search result Employee-->
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
<h2>Clients Search Result:</h2>
<table class="table">
    <thread class="thread-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">ClientNr</th>
        <th scope="col">Name</th>
        <th scope="col">PhoneNr</th>
    </tr>
    </thread>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td><?php echo $client['KUNDENNR']; ?>  </td>
            <td><?php echo $client['NAME']; ?>  </td>
            <td><?php echo $client['TELEFONNR']; ?>  </td>
        </tr>
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