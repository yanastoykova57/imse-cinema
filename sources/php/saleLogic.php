<?php
if($method ==="POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO Sale (ProductID, SaleID, Percent, SaleName) VALUES (?,?,?,?)");
    $stmt->execute([$data["ProductID"], $data["SaleID"], $data["Percent"], $data["SaleName"]]);
    http_response_code(201);
    echo json_encode(["message" => "Sale successfully added!"]);
} else if($method === "GET") {
    $stmt = $pdo->query("SELECT * FROM Sale");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode($movies);
} else if ($method === "DELETE") {
    $stmt = $pdo->query("DELETE FROM Sale");
    http_response_code(200);
    echo json_encode(["message" => "Sales deleted!"]);
} else {
    http_response_code(404);
    echo json_encode(["err"=> "Endpoint not found!"]);
}
?>