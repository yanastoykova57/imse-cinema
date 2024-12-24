<?php
if($method ==="POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO Cinema(Name,PhoneNr) VALUES (?,?)");
    $stmt->execute([$data["Name"], $data["PhoneNr"]]);
    http_response_code(201);
    echo json_encode(["message" => "Cinema successfully added!"]);
} else if($method === "GET") {
    $stmt = $pdo->query("SELECT * FROM Cinema");
    $cinemas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode($cinemas);
} else if ($method === "DELETE") {
    $stmt = $pdo->query("DELETE FROM Cinema");
    http_response_code(200);
    echo json_encode(["message" => "Cinemas deleted!"]);
} else {
    http_response_code(404);
    echo json_encode(["err"=> "Endpoint not found!"]);
}
?>