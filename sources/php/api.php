<?php
header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];
$requestURI = trim($_SERVER["REQUEST_URI"], "/");
$username = "cinema_user";
$password = "userpassword";

try {
    $pdo = new PDO("mysql:host=cinema_db;dbname=cinema_db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(strpos($requestURI,"api.php/cinemas") !== false) {
        include 'cinemaLogic.php';
    } else if(strpos($requestURI,"api.php/movies") !== false) {
        include 'moviesLogic.php';
    } else if(strpos($requestURI,"api.php/plays") !== false) {
        include 'playsLogic.php';
    } else if(strpos($requestURI,"api.php/customers") !== false) {
        include 'customerLogic.php';
    } else if(strpos($requestURI,"api.php/products") !== false) {
        include 'productsLogic.php';
    } else if(strpos($requestURI,"api.php/tickets") !== false) {
        include 'ticketLogic.php';
    } else if(strpos($requestURI,"api.php/snacks") !== false) {
        include 'snackLogic.php';
    } else if (strpos($requestURI,"api.php/sales") !== false) {
        include 'saleLogic.php';
    } else if (strpos($requestURI,"api.php/products_on_sale") !== false) {
        include 'useCase2Logic.php';
    } else {
        http_response_code(404);
        echo json_encode(["err"=> "Endpoint not found!"]);
    }
} catch (Exception $e) {}
?>
