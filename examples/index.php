<?php

use FsHub\Sdk\Client as FsHubClient;
use FsHub\Sdk\Entities\FlightData;

// Load Composer
require_once '../vendor/autoload.php';


$fshub = new FsHubClient('zvVHhCwe3441cTPmsG00eRAsZ0IrLjYLk1JteORhuctsCPKJk0ERDhICvURU');

// We can request our pilot data information from FsHub (uses our API key to return our personal pilot information)
$myPilotAccount = $fshub->user->Context()->data;
echo "Your name is: {$myPilotAccount->name}, you are current at {$myPilotAccount->location}. Your home airport is {$myPilotAccount->base}!";

// We can get airport information for a specific airport...
//$airport = $fshub->airports->find("EGLL");
//var_dump($airport);


// We can get all of our flights...
$myFlights = $fshub->flights->get();
echo "We have returned {$myFlights->count()} flights...";

// Our first flight is:
var_dump($myFlights->data[0]);

// We can then iterate the collection using offset(), take() and get() like so...
$perRequest = 25; // The number of results per page request.
$pages = 5; // The number of collection requests we want to return.
$cursor = 1798819; // We can specifically tell the client where to start getting results from...

/**
 * @var Array<FlightData>
 */
$flightCollection = [];

//for ($i = 0; $i < $pages; $i++) {
//    $flights = $fshub->flights->offset($cursor)->get();
//    foreach ($flights->data as $flight) {
//        $flightCollection[] = $flight;
//    }
//    $cursor = $flights->meta->cursor->next;
//    echo "Loaded {$flights->count()} flights from cursor position: {$cursor}, pausing for 3 seconds...";
//    sleep(3);
//}
//
//$totalFlights = count($flightCollection);
//echo "All data has been downloaded, outputting list of all ({$totalFlights}) flights...";


$myFlights = $fshub->flights->take(50)->offset(0)->get();

// We can get just a single flight report (by it's flight ID)...
$singleFlight = $fshub->flights->find(1814280);
//var_dump($singleFlight);

// We can return all screenshots for this flight too...
//$flightScreenshots = $fshub->flights->select($singleFlight->data->id)->screenshots();
//var_dump($flightScreenshots);

// Or we can utilise an implementation of "AirportInterface" and select it passing the entity instead...
$flightScreenshots = $fshub->flights->selectByEntity($singleFlight)->screenshots();
var_dump($flightScreenshots);
