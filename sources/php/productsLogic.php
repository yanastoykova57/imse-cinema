<?php
if($method ==="POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO Product(Price, ProductDescription, CustomerID) VALUES (?,?,?)");
    $stmt->execute([$data["Price"], $data["ProductDescription"],
    $data["CustomerID"] ?? null ]);

    $productID = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode(["message" => "Customer successfully added!",
    "ProductID" => $productID]);
} else if($method === "GET") {
    $stmt = $pdo->query("SELECT * FROM Product"); //could change this to show null as "-"
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode($products);
} else if ($method === "DELETE") {
    $stmt = $pdo->query("DELETE FROM Product");
    http_response_code(200);
    echo json_encode(["message" => "Products deleted!"]);
} else {
    http_response_code(404);
    echo json_encode(["err"=> "Endpoint not found!"]);
}
?>