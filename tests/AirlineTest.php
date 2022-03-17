<?php

use FsHub\Sdk\Client;
use FsHub\Sdk\Tests\Support\TestConnector;
use PHPUnit\Framework\TestCase;

class AirlineTest extends TestCase
{
    public function testAirlineQueryValues()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $airline = $client->airlines->find(1778);

        // Check base object details.
        $this->assertEquals(1778, $airline->data->id);
        $this->assertEquals('BAW', $airline->data->abbreviation);
        $this->assertEquals('British Airways', $airline->data->name);

        // Check owner details.
        $this->assertEquals(2, $airline->data->owner->id);
        $this->assertEquals('Bobby Allen', $airline->data->owner->name);

        // Social media handles.
        $this->assertNull($airline->data->handles->facebook);
        $this->assertEquals('@BATestAccount', $airline->data->handles->twitter);
        $this->assertEquals('http://test.com', $airline->data->handles->website);

    }

    public function testCollectionOfAirlinesAreReturned()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $airlines = $client->airlines->get();
        $this->assertEquals(10, $airlines->count());
    }

    public function testPilotCollectionObjectValues()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $airlines = $client->airlines
            ->select(1778)
            ->offset(20)
            ->get();

        $total = $airlines->count();
        $this->assertEquals(10, $total);

        $testAirline1 = $airlines->data[0];
        $this->assertEquals(25, $testAirline1->id);
        $this->assertEquals('EMIRATES', $testAirline1->name);
        $this->assertEquals('UAE', $testAirline1->abbreviation);

        // Test cursor values...
        $this->assertEquals(10, $airlines->meta->cursor->count);
        $this->assertEquals(20, $airlines->meta->cursor->current);
        $this->assertEquals(52, $airlines->meta->cursor->next);

        // Now switch and get the next batch of results...
        $nextCursor = $airlines->meta->cursor->next;

        $airlines = $client->airlines->offset($nextCursor)->get();

        $testAirline1 = $airlines->data[8];
        $this->assertEquals(81, $testAirline1->id);
        $this->assertEquals('Turkish Airlines', $testAirline1->name);
        $this->assertEquals('THY', $testAirline1->abbreviation);

        $this->assertEquals(10, $airlines->meta->cursor->count);
        $this->assertEquals(52, $airlines->meta->cursor->current);
        $this->assertEquals(85, $airlines->meta->cursor->next);


    }

    public function testAirlineStats()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $stats = $client->airlines->select(2)->stats();

        $this->assertEquals(2, $stats->data->id);

        $this->assertEquals(289, $stats->data->allTime->flights);
        $this->assertEquals(762.56, $stats->data->allTime->hours);
        $this->assertEquals(326178, $stats->data->allTime->distance);
        $this->assertEquals(-182, $stats->data->allTime->averageLandingRate);

        $this->assertEquals(1, $stats->data->currentMonth->flights);
        $this->assertEquals(1.08, $stats->data->currentMonth->hours);
        $this->assertEquals(348, $stats->data->currentMonth->distance);
        $this->assertEquals(-85, $stats->data->currentMonth->averageLandingRate);
    }

    public function testAirlinePilots()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $airlinePilots = $client->airlines->select(1778)->pilots()->data; // Should be a collection (from ballen/collection library)

        $this->assertEquals('Bobby Allen', $airlinePilots[0]->name);
        $this->assertEquals('EGSS', ($client->pilots->first($airlinePilots[0]->id))->data->base);

        $this->assertEquals('auroraisluna', $airlinePilots[1]->name);
        $this->assertEquals('0.000408,0.013975', (string)$airlinePilots[2]->gps);
        $this->assertEquals("LEPA", $airlinePilots[3]->location);

    }

    public function testAirlineDepartures()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $airlineDepartures = $client->airlines->select(1778)->departures("EGPH");

        $this->assertEquals(1, $airlineDepartures->count());

        // All departures should have the same ICAO.
        foreach ($airlineDepartures->data as $flight) {
            $this->assertEquals("EGPH", $flight->departure->icao);
        }

        $this->assertEquals('EGLL', $airlineDepartures->data[0]->arrival->icao);

    }

    public function testAirlineArrivals()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $airlineArrivals = $client->airlines->select(1778)->arrivals("EGSS");

        $this->assertEquals(6, $airlineArrivals->count());

        // All departures should have the same ICAO.
        foreach ($airlineArrivals->data as $flight) {
            $this->assertEquals("EGSS", $flight->arrival->icao);
        }

        $this->assertEquals('EDDB', $airlineArrivals->data[0]->departure->icao);
        $this->assertEquals('LSZH', $airlineArrivals->data[1]->departure->icao);
        $this->assertEquals('EGPF', $airlineArrivals->data[2]->departure->icao);
    }

    public function testAirlineArrivalsFromNotFound()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $departureIcao = "EGSS";
        $arrivalIcao = "LPPT";

        $this->expectException(\FsHub\Sdk\Exceptions\NoRecordsFoundException::class);

        $client->airlines->select(1033)->route(
            departure: $departureIcao,
            arrival: $arrivalIcao,
        );
    }

    public function testAirlineArrivalsFrom()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $departureIcao = "EGSS";
        $arrivalIcao = "LOWS";

        $airlineRoutes = $client->airlines->select(1033)->route(
            departure: $departureIcao,
            arrival: $arrivalIcao,
        );

        $this->assertEquals(2, $airlineRoutes->count());

        foreach ($airlineRoutes->data as $flight) {
            $this->assertEquals($departureIcao, $flight->departure->icao);
            $this->assertEquals($arrivalIcao, $flight->arrival->icao);
        }

    }

    public function testAirlineScreenshots()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $screenshots = $client->airlines
            ->select(1778)
            ->screenshots();

        $this->assertEquals(10, $screenshots->count());

        $this->assertEquals(54785, $screenshots->data[0]->id);
        $this->assertEquals('27996e3cc0cc63b708a2f60682e7987c.png', $screenshots->data[0]->name);
        $this->assertEquals('https://fshub.ams3.digitaloceanspaces.com/uploads/tn_200_27996e3cc0cc63b708a2f60682e7987c.png',
            $screenshots->data[0]->url->thumbnailUrl);

        $this->assertEquals(55395, $screenshots->data[9]->id);
        $this->assertEquals('fec80f19e83c740c6f2a563116c4a191.png', $screenshots->data[9]->name);
        $this->assertEquals('https://fshub.ams3.digitaloceanspaces.com/uploads/fec80f19e83c740c6f2a563116c4a191.png',
            $screenshots->data[9]->url->fullsizeUrl);
    }


}