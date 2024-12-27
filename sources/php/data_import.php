<?php
//require 'vendor/autoload.php';

//$faker = Faker\Factory::create();

function getNames($filename) {
    $names = [];
    if (($handle = fopen($filename, "r")) !== false) {
        while (($line = fgetcsv($handle)) !== false) {
            $names[] = $line[0]; 
        }
        fclose($handle);
    }
    return $names;
}


function optRandElement($array, $prob = 0.3) {
    if(rand(0,100)/100 <= $prob) {
        return randomElement($array);
    } else return null;
}

function randomElement($array) {
    return $array[array_rand($array)];
}

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

$cinemaNames = ["English Cinema Haydn", "Burg Kino", "Votiv Kino",
			"APOLLO", "ARTIS INTERNATIONAL", "URANIA KINO",
			"CINEPLEXX MILENNIUM CITY", "Green Cinema", "Blue Cinema",
            "Black Cinema"];

///CINEMA
$cinemaUrl = 'http://cinema_php/api.php/cinemas';
$response = sendRequest($cinemaUrl, 'DELETE');
echo "Cinema delete response: $response\n";

$cinemaCounter = 10;
for($i = 1; $i <= $cinemaCounter; $i++){
    $cinemaData = [
        /*"Name" => $faker->company . " Cinema",
        "PhoneNr" => $faker->phoneNumber,*/
        "Name" => $cinemaNames[array_rand($cinemaNames)],
        "PhoneNr" => sprintf("%d-%03d-%03d-%04d", 43, rand(100, 999), rand(100, 999), rand(1000, 9999)),
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

$movies = [
    "The Shawshank Redemption",
    "The Godfather",
    "The Dark Knight",
    "Forrest Gump",
    "Inception",
    "Fight Club",
    "Pulp Fiction",
    "The Matrix",
    "The Lord of the Rings: The Return of the King",
    "Titanic",
    "Interstellar",
    "The Lion King",
    "Gladiator",
    "The Green Mile",
    "Schindler's List",
    "Saving Private Ryan",
    "Avengers: Endgame",
    "Star Wars: Episode V - The Empire Strikes Back",
    "Jurassic Park",
    "Toy Story"
] ;

for($i = 1; $i <= $movieCounter; $i++){
    $movieData = [
        "Title" => $movies[array_rand($movies)],
        "Genre" => $genres[array_rand($genres)],
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
        /*"CinemaID" => $faker->randomElement($cinemaIDs),
        "MovieID" => $faker->randomElement($movieIDs),*/
        "CinemaID" => randomElement($cinemaIDs),
        "MovieID" => randomElement($movieIDs),];

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

$customerNames = getNames('firstnames.csv');
$customersCounter = 10;
$customerIDs = [];
for($i = 1; $i <= $customersCounter; $i++){
    $customersData = [
        /*"CustomerName" => $faker->name,
        "CustomerPhoneNr" => $faker->phoneNumber,
        "RecommenderID" => empty($customerIDs) ? null : $faker->optional()->randomElement($customerIDs),
        "CinemaID" => $faker->randomElement($cinemaIDs),*/
        "CustomerName" => randomElement($customerNames),
        "CustomerPhoneNr" => sprintf("%d-%03d-%03d-%04d", 43, rand(100, 999), rand(100, 999), rand(1000, 9999)),
        "RecommenderID" => empty($customerIDs) ? null : optRandElement($customerIDs),
        "CinemaID" => randomElement($cinemaIDs),
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

$descriptions = ["Salty Popcorn", "Sweet Popcorn", "Water", 
			"Soda", "Chocolate", "Chips", "Candy"];
//TICKETS
$ticketsUrl = 'http://cinema_php/api.php/tickets';
$ticketCounter = 10;
for($i = 1; $i <= $ticketCounter; $i++){
    $ticketsData = [
        /*"Price" => $faker->randomFloat(2,2,50),
        "ProductDescription" => "Movie ticket",
        //"CustomerID" => $faker->randomElement($customerIDs),
        "CustomerID" => null,
        "ShowTime" => $faker->dateTimeThisMonth->format('Y-m-d H:i:s'),
        "SeatNr" => $faker->numberBetween(1,100)*/
        "Price" => mt_rand(2 * pow(10, 2), 50 * pow(10, 2)) / pow(10, 2),
        "ProductDescription" => "Movie ticket",
        //"CustomerID" => $faker->randomElement($customerIDs),
        "CustomerID" => null,
        "ShowTime" => date('Y-m-d H:i:s', rand(strtotime("first day of this month"), strtotime("last day of this month"))),
        "SeatNr" => rand(1,100)
    ];

    $response = sendRequest($ticketsUrl, 'POST', $ticketsData);
    echo "Response for products $i: $response\n";
}

$brands = ["Coca-Cola", "Sprite", "Voeslauer", "Herschey's",
			"Wether's Originals", "-", "M&M", "Lays"];
$snacksUrl = 'http://cinema_php/api.php/snacks';
$snackCounter = 10;
for($i = 1; $i <= $snackCounter; $i++){
    $snacksData = [
        /*"Price" => $faker->randomFloat(2,2,50),
        "ProductDescription" => $faker->sentence,
        //"CustomerID" => $faker->randomElement($customerIDs),
        "CustomerID" => null,
        "Size" => randomElement(['Small', 'Medium', 'Large']),
        "Brand" => $faker->company*/

        "Price" => mt_rand(2 * pow(10, 2), 50 * pow(10, 2)) / pow(10, 2),
        "ProductDescription" => randomElement($descriptions),
        //"CustomerID" => $faker->randomElement($customerIDs),
        "CustomerID" => null,
        "Size" => randomElement(['Small', 'Medium', 'Large']),
        "Brand" => randomElement($brands)

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
/*foreach ($productIDs as $productID) {
if($faker->boolean(50)) {
    $saleCount = rand(1,2);
    for($i = 1; $i <= $saleCount; $i++) {
        $saleCounter++;
        $salesData = [
            "ProductID" => $productID,
            "SaleID" => $saleCounter,
            //"Percent" => $faker->randomFloat(2, 5, 50),
            "Percent" => mt_rand(2 * pow(10, 2), 50 * pow(10, 2)) / pow(10, 2),
            "SaleName" => $saleNames[array_rand($saleNames)]
        ];
        $response = sendRequest($salesUrl, 'POST', $salesData);
        echo "Response for sales $i: $response\n";
    }
}
}*/

foreach ($productIDs as $productID) {
    if(rand(0,1) ===1) {
        $saleCount = rand(1,2);
        for($i = 1; $i <= $saleCount; $i++) {
            $saleCounter++;
            $salesData = [
                "ProductID" => $productID,
                "SaleID" => $saleCounter,
                //"Percent" => $faker->randomFloat(2, 5, 50),
                "Percent" => mt_rand(5 * pow(10, 2), 50 * pow(10, 2)) / pow(10, 2),
                "SaleName" => $saleNames[array_rand($saleNames)]
            ];
            $response = sendRequest($salesUrl, 'POST', $salesData);
            echo "Response for sales $i: $response\n";
        }
    }
    }


?>
