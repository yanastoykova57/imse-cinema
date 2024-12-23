<?php
require 'vendor/autoload.php';

$faker = Faker\Factory::create();
$baseUrl = 'http://localhost:8080/api.php/cinemas';

$options = [
    'http' => [
        'header' => "Content-Type: application/json\r\n",
        'method' => 'DELETE',
    ],
];

//following 3 lines not necessarily needed, but just for debugging:
    $context = stream_context_create($options);
    $response = file_get_contents($baseUrl, false, $context);
    echo "Delete response: $response\n";

$cinemaCounter = 10;

for($i = 1; $i <= $cinemaCounter; $i++){
    $data = [
        "Name" => $faker->company . " Cinema",
        "PhoneNr" => $faker->phoneNumber,
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($baseUrl, false, $context);
    echo "Response for Cinema $i: $response\n";
}

?>
