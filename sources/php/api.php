<?php
header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];
$requestURI = trim($_SERVER["REQUEST_URI"], "/");
$username = "cinema_user";
$password = "userpassword";
/*if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(["message" => "API is working!"]);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}*/
try {
    $pdo = new PDO("mysql:host=cinema_db;dbname=cinema_db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($method ==="POST" && strpos($requestURI,"api.php/cinemas") !== false) {
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO Cinema(Name,PhoneNr) VALUES (?,?)");
        $stmt->execute([$data["Name"], $data["PhoneNr"]]);
        http_response_code(201);
        echo json_encode(["message" => "Cinema successfully added!"]);
    } else if($method === "GET" && strpos($requestURI,"api.php/cinemas") !== false) {
        $stmt = $pdo->query("SELECT * FROM Cinema");
        $cinemas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        http_response_code(200);
        echo json_encode($cinemas);
    } else if ($method === "DELETE" && strpos($requestURI,"api.php/cinemas") !== false) {
        $stmt = $pdo->query("DELETE FROM Cinema");
        http_response_code(200);
        echo json_encode(["message" => "Cinemas deleted!"]);
    } else {
        http_response_code(404);
        echo json_encode(["err"=> "Endpoint not found!"]);
    }
} catch (Exception $e) {}

?>
