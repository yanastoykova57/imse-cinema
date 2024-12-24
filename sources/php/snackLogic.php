<?php
if($method ==="POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO Product(Price, ProductDescription, CustomerID) VALUES (?,?,?)");
    $stmt->execute([$data["Price"], $data["ProductDescription"],
    $data["CustomerID"] ?? null ]);

    $productID = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode(["message" => "Product successfully added!",
    "ProductID" => $productID]);

    $stmtSnack = $pdo->prepare("INSERT INTO Snack(ProductID, Size, Brand) VALUES (?,?,?)");
    $stmtSnack->execute([$productID, $data["Size"], $data["Brand"] ]);

    echo json_encode(["message" => "Snack successfully added!",
    "ProductID" => $productID]);
} else if($method === "GET") {
    #$stmt = $pdo->query("SELECT * FROM Product INNER JOIN Snack ON Product.ProductID = Snack.ProductID");
    $stmt = $pdo->query("SELECT * FROM Snack"); 
    $snacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode($snacks);
} else if ($method === "DELETE") {
    $stmt = $pdo->query("DELETE FROM Product WHERE ProductID IN (SELECT ProductID FROM Snack)");
    http_response_code(200);
    echo json_encode(["message" => "Snacks deleted!"]);
} else {
    http_response_code(404);
    echo json_encode(["err"=> "Endpoint not found!"]);
}
?>