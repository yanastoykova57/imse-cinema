<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <script src="scripts.js" defer></script>
    <title>Purchase Product on Sale</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
    <h2>Available Products</h2>
    <table class="table"">
        <thead>
            <tr>
                <th> Product ID </th>
                <th> Description </th>
                <th> Price </th>
                <th> Discount </th>
                <th> Final Price </th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="productList">
        </tbody>
    </table>
</div>

<script>
    async function fetchProducts() {
    const response = await fetch("/api.php/products_on_sale");
    const products = await response.json();
    const productList = document.getElementById("productList");

    productList.innerHTML = "";
    products.forEach(product => {
        productList.innerHTML += `
            <tr>
                <td>${product.ProductID}</td>
                <td>${product.ProductDescription}</td>
                <td>${product.Price.toFixed(2)}</td>
                <td>${product.Discount}%</td>
                <td>${product.FinalPrice.toFixed(2)}</td>
                <td>
                    <button class="btn btn-primary" onclick="selectProduct(${product.ProductID})">Select</button>
                </td>
            </tr>
        `;
    });
}

function selectProduct(productId) {
    const customerID =prompt("Enter your customerID: ");
    if(customerID) {
        confirmPurchase(productId, customerID);
    }
}

async function confirmPurchase(productId, customerID) {
    const response = await fetch("/api.php/products_on_sale", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ProductID: productId, CustomerID: customerID})
    });
    const result =await response.json();
    alert(result.message || "Failed purchase");
}
fetchProducts();
</script>
</body>
</html>