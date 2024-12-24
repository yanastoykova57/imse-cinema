<?php
if($method ==="POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO Customer(CustomerName,CustomerPhoneNr,RecommenderID,CinemaID) VALUES (?,?,?,?)");
    $stmt->execute([$data["CustomerName"], $data["CustomerPhoneNr"],
    $data["RecommenderID"] ?? null, $data["CinemaID"] ?? null]);

    $customerID = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode(["message" => "Customer successfully added!",
    "CustomerID" => $customerID]);
} else if($method === "GET") {
    $stmt = $pdo->query("SELECT * FROM Customer"); //could change this to show null as "-"
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode($customers);
} else if ($method === "DELETE") {
    $stmt = $pdo->query("DELETE FROM Customer");
    http_response_code(200);
    echo json_encode(["message" => "Customers deleted!"]);
} else {
    http_response_code(404);
    echo json_encode(["err"=> "Endpoint not found!"]);
}
?>