<?php
require 'vendor/autoload.php';

$faker = Faker\Factory::create();

function sendRequest($url, $method, $data = null) {
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => $method,
        ],
    ];

    if (!empty($data)) {
        $options['http']['content'] = json_encode($data);
    }

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    return $response;
}

function getIDs($url, $data= null) {
    $response = file_get_contents($url);
    $records = json_decode($response, true);
    return array_column($records,$data);
}

///CINEMA
$cinemaUrl = 'http://cinema_php/api.php/cinemas';
$response = sendRequest($cinemaUrl, 'DELETE');
echo "Cinema delete response: $response\n";

$cinemaCounter = 10;
for($i = 1; $i <= $cinemaCounter; $i++){
    $cinemaData = [
        "Name" => $faker->company . " Cinema",
        "PhoneNr" => $faker->phoneNumber,
    ];

    
    $response = sendRequest($cinemaUrl, 'POST', $cinemaData);
    echo "Response for Cinema $i: $response\n";
}

///MOVIE
$movieUrl = 'http://cinema_php/api.php/movies';
$response = sendRequest($movieUrl, 'DELETE');
echo "Movie delete response: $response\n";

$movieCounter = 10;
$genres = ["Comedy", "Action", "Romance", "Thriller", "Horror"];

for($i = 1; $i <= $movieCounter; $i++){
    $movieData = [
        "Title" => $faker->catchPhrase,
        "Genre" => $faker->randomElement($genres),
    ];

    $response = sendRequest($movieUrl, 'POST', $movieData);
    echo "Response for Movie $i: $response\n";
}

////PLAYS
$playsUrl = 'http://cinema_php/api.php/plays';
$response = sendRequest($playsUrl, 'DELETE');
echo "Plays delete response: $response\n";

$cinemaIDs = getIDs($cinemaUrl, "CinemaID");
$movieIDs = getIDs($movieUrl, "MovieID");

if(empty($movieIDs) || empty($cinemaIDs)){
    die("There are no cinemas/movies in the DB.");
}

$playsCounter = 10;

for($i = 1; $i <= $playsCounter; $i++){
    $playsData = [
        "CinemaID" => $faker->randomElement($cinemaIDs),
        "MovieID" => $faker->randomElement($movieIDs),
    ];

    $response = sendRequest($playsUrl, 'POST', $playsData);
    echo "Response for Plays $i: $response\n";
}

//CUSTOMERS
$customersUrl = 'http://cinema_php/api.php/customers';
$response = sendRequest($customersUrl, 'DELETE');
echo "Customers delete response: $response\n";

if(empty($cinemaIDs)){
    die("There are no cinemas in the DB.");
}

$customersCounter = 10;
$customerIDs = [];
for($i = 1; $i <= $customersCounter; $i++){
    $customersData = [
        "CustomerName" => $faker->name,
        "CustomerPhoneNr" => $faker->phoneNumber,
        "RecommenderID" => empty($customerIDs) ? null : $faker->optional()->randomElement($customerIDs),
        "CinemaID" => $faker->randomElement($cinemaIDs),
    ];

    $response = sendRequest($customersUrl, 'POST', $customersData);
    echo "Response for customers $i: $response\n";

    $decodedResponse = json_decode($response, true);
    if(isset($decodedResponse["CustomerID"])){
        $customerIDs[] = $decodedResponse["CustomerID"];
    }

}

//PRODUCTS
$productsUrl = 'http://cinema_php/api.php/products';
$response = sendRequest($productsUrl, 'DELETE');
echo "Products delete response: $response\n";

/*$productsCounter = 20;
for($i = 1; $i <= $productsCounter; $i++){
    $productsData = [
        "Price" => $faker->randomFloat(2,2,50),
        "ProductDescription" => $faker->sentence,
        "CustomerID" => $faker->randomElement($customerIDs)
    ];

    $response = sendRequest($productsUrl, 'POST', $productsData);
    echo "Response for products $i: $response\n";

    $decodedResponse = json_decode($response, true);
    if(isset($decodedResponse["CustomerID"])){
        $customerIDs[] = $decodedResponse["CustomerID"];
    }

}*/

//TICKETS
$ticketsUrl = 'http://cinema_php/api.php/tickets';
$ticketCounter = 10;
for($i = 1; $i <= $ticketCounter; $i++){
    $ticketsData = [
        "Price" => $faker->randomFloat(2,2,50),
        "ProductDescription" => $faker->sentence,
        "CustomerID" => $faker->randomElement($customerIDs),
        "ShowTime" => $faker->dateTimeThisMonth->format('Y-m-d H:i:s'),
        "SeatNr" => $faker->numberBetween(1,100)
    ];

    $response = sendRequest($ticketsUrl, 'POST', $ticketsData);
    echo "Response for products $i: $response\n";
}

$snacksUrl = 'http://cinema_php/api.php/snacks';
$snackCounter = 10;
for($i = 1; $i <= $snackCounter; $i++){
    $snacksData = [
        "Price" => $faker->randomFloat(2,2,50),
        "ProductDescription" => $faker->sentence,
        "CustomerID" => $faker->randomElement($customerIDs),
        "Size" => $faker->randomElement(['Small', 'Medium', 'Large']),
        "Brand" => $faker->company
    ];

    $response = sendRequest($snacksUrl, 'POST', $snacksData);
    echo "Response for products $i: $response\n";
}


//SALES
$salesUrl = 'http://cinema_php/api.php/sales';
$response = sendRequest($salesUrl, 'DELETE');
echo "Sales delete response: $response\n";

$productIDs = getIDs($productsUrl, "ProductID");
$saleNames = ["Christmas Sale", "Summer Sale", "Easter Sale", "Student discount", "Elderly discount"];

$saleCounter = 5;
foreach ($productIDs as $productID) {
if($faker->boolean(50)) {
    $saleCount = rand(1,2);
    for($i = 1; $i <= $saleCount; $i++) {
        $saleCounter++;
        $salesData = [
            "ProductID" => $productID,
            "SaleID" => $saleCounter,
            "Percent" => $faker->randomFloat(2, 5, 50),
            "SaleName" => $saleNames[array_rand($saleNames)]
        ];
        $response = sendRequest($salesUrl, 'POST', $salesData);
        echo "Response for sales $i: $response\n";
    }
}
}


?>
