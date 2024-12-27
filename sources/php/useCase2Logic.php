<?php
if($method === "GET") {
    $stmt = $pdo->query("
        SELECT
            Product.ProductID,
            Product.Price,
            Product.ProductDescription,
            IFNULL(Sale.Percent, 0) AS Discount,
            Product.Price*(1 - IFNULL(Sale.Percent, 0) / 100) AS FinalPrice
            FROM Product
            LEFT JOIN Sale ON Product.ProductID = Sale.ProductID
    ");
    $products_on_sale = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode($products_on_sale);
} if($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmtProduct = $pdo->prepare("SELECT ProductID, Price FROM Product WHERE ProductID = ?");
    $stmtProduct->execute([$data["ProductID"]]);
    $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);

    if(!$product) {
        http_response_code(404);
        echo json_encode(["err" => "Product not found!"]);
        exit;
    }

    $stmtCustomer = $pdo->prepare("SELECT CustomerID FROM Customer WHERE CustomerID = ?");
    $stmtCustomer->execute([$data["CustomerID"]]);
    $product = $stmtCustomer->fetch(PDO::FETCH_ASSOC);

    if(!$customer) {
        http_response_code(404);
        echo json_encode(["err" => "Product not found!"]);
        exit;
    }

    $stmtSale = $pdo->prepare("SELECT Percent FROM Sale WHERE ProductID = ?");
    $stmtSale->execute([$data["ProductID"]]);
    $sale = $stmtSale->fetch(PDO::FETCH_ASSOC);
    $discount = $sale ? $sale["Percent"] :0;

    $finalPrice = $product["Price"] * ((100-$discount)/100);

    $stmtUpdate = $pdo->prepare("UPDATE Product SET CustomerID = ? WHERE ProductID = ?");
    $stmtUpdate->execute([$data["CustomerID"], $data["ProductID"]]);
    http_response_code(201);
    echo json_encode(["message" => "Successful purchase has been made!",
    "ProductID" => $data["ProductID"], "FinalPrice"=> $finalPrice, 
    "Discount" => $discount]);
} else {
    http_response_code(404);
    echo json_encode(["err"=> "Endpoint not found!"]);
}
?>