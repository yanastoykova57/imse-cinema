<?php
if($method ==="POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO Plays(CinemaID,MovieID) VALUES (?,?)");
    $stmt->execute([$data["CinemaID"], $data["MovieID"]]);
    http_response_code(201);
    echo json_encode(["message" => "Play relationship successfully added!"]);
} else if($method === "GET") {
    $stmt = $pdo->query("SELECT * FROM Plays");
    $plays = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode($plays);
} else if ($method === "DELETE") {
    $stmt = $pdo->query("DELETE FROM Plays");
    http_response_code(200);
    echo json_encode(["message" => "Play relationships deleted!"]);
} else {
    http_response_code(404);
    echo json_encode(["err"=> "Endpoint not found!"]);
}
?>