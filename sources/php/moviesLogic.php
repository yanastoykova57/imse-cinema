<?php
if($method ==="POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO Movie(Title,Genre) VALUES (?,?)");
    $stmt->execute([$data["Title"], $data["Genre"]]);
    http_response_code(201);
    echo json_encode(["message" => "Movie successfully added!"]);
} else if($method === "GET") {
    $stmt = $pdo->query("SELECT * FROM Movie");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode($movies);
} else if ($method === "DELETE") {
    $stmt = $pdo->query("DELETE FROM Movie");
    http_response_code(200);
    echo json_encode(["message" => "Movies deleted!"]);
} else {
    http_response_code(404);
    echo json_encode(["err"=> "Endpoint not found!"]);
}
?>