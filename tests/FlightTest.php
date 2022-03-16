<?php

use FsHub\Sdk\Client;
use FsHub\Sdk\Tests\Support\TestConnector;
use PHPUnit\Framework\TestCase;

class FlightTest extends TestCase
{
    public function testFlightQueryValues()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $flight = $client->flights->find(1798819);

        $this->assertEquals(2, $flight->data->pilot->id);
        $this->assertEquals('Bobby Allen', $flight->data->pilot->name);

        $this->assertEquals(1798819, $flight->data->id);
        $this->assertEquals(-145, $flight->data->landingRate);
        $this->assertEquals(0, $flight->data->fuelUsed);
        $this->assertEquals(3805, $flight->data->time);
        $this->assertEquals(356, $flight->data->distance->nauticalMiles);
        $this->assertEquals(659, $flight->data->distance->kilometres);
        $this->assertEquals(31499, $flight->data->max->altitude);
        $this->assertEquals(453, $flight->data->max->speed);

        $this->assertNull($flight->data->airline);

        $this->assertEquals('A20N', $flight->data->aircraft->icao);
        $this->assertEquals('Airbus A320 neo', $flight->data->aircraft->icaoName);

        $this->assertEquals('G-TTNB', $flight->data->aircraft->userConf->tailNumber);
        $this->assertEquals('A20N', $flight->data->aircraft->userConf->icao);

        $this->assertEquals('BA711', $flight->data->plan->callsign);
        $this->assertEquals(320, $flight->data->plan->cruiseLevel);
        $this->assertEquals('EGLL/09L ULTI1K ULTIB T420 TNT UN57 POL UN601 RIBEL RIBE1G EGPF/23',
            $flight->data->plan->route);

        $this->assertEquals('EGLL', $flight->data->departure->icao);
        $this->assertEquals(96, $flight->data->departure->hdg->true);
        $this->assertEquals("51.47746,-0.463419", (string)$flight->data->departure->geo);
        $this->assertEquals(11, $flight->data->departure->wind->speed);
        $this->assertEquals(160, $flight->data->departure->wind->direction);

        $this->assertEquals('EGPF', $flight->data->arrival->icao);
    }

    public function testOldAnonymousFlightQueryValues()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $flight = $client->flights->find(1);

        $this->assertEquals(1, $flight->data->pilot->id);
        $this->assertEquals('Anonymous', $flight->data->pilot->name);

        $this->assertEquals(1, $flight->data->id);
        $this->assertEquals('A36', $flight->data->aircraft->icao);
        $this->assertNull($flight->data->aircraft->icaoName);
        $this->assertEquals('', $flight->data->aircraft->userConf->tailNumber);
        $this->assertEquals('', $flight->data->aircraft->userConf->icao);

        $this->assertNull($flight->data->airline);
        $this->assertNull($flight->data->plan);
        $this->assertNull($flight->data->departure);

    }

    public function testFlightCollectionObjectValues()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $flights = $client->flights
            ->offset(1798819)
            ->get();

        $this->assertEquals(10, $flights->data->count());

        // Check the first flight in our collection.
        $testFlight1 = $flights->data[0];
        $this->assertEquals(1798820, $testFlight1->id);
        $this->assertEquals(4533, $testFlight1->pilot->id);
        $this->assertEquals('David Clark', $testFlight1->pilot->name);
        $this->assertNull($testFlight1->airline);
        $this->assertNull($testFlight1->plan);

        $this->assertEquals('A320', $testFlight1->aircraft->icao);
        $this->assertEquals('AIRBUS', $testFlight1->aircraft->type);

        $this->assertEquals('EGLL', $testFlight1->departure->icao);
        $this->assertEquals('LFBO', $testFlight1->arrival->type);

        $nextCursor = $flights->meta->cursor->next;

        // Test the cursor values...
        $this->assertEquals(10, $flights->meta->cursor->count);
        $this->assertEquals(1798819, $flights->meta->cursor->current);
        $this->assertEquals(1798829, $nextCursor);

        // Now we'll get and process the next batch of flights...
        $flights = $client->flights->offset($nextCursor)->get();

        $testFlight2 = $flights->data[2];
        $this->assertEquals(1798832, $testFlight2->id);
        $this->assertEquals('Anonymous', $testFlight2->pilot->name);
        $this->assertEquals('C172', $testFlight2->aircraft->icao);

        $this->assertEquals(10, $testFlight2->meta->cursor->count);
        $this->assertEquals(1798829, $testFlight2->meta->cursor->current);
        $this->assertEquals(1798839, $testFlight2->meta->cursor->next);

    }

    public function testFlightScreenshots()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $screenshots = $client->flights
            ->select(1802858)
            ->screenshots();

        $this->assertEquals(10, $screenshots->data->count());

        $this->assertEquals(68149, $screenshots->data[0]->id);
        $this->assertEquals('cf9eaf89168a626c99fd9b337149aea5.png', $screenshots->data[0]->name);
        $this->assertEquals('https://fshub.ams3.digitaloceanspaces.com/uploads/tn_200_cf9eaf89168a626c99fd9b337149aea5.png',
            $screenshots->data[0]->url->thumbnailUrl);

        $this->assertEquals(68158, $screenshots->data[9]->id);
        $this->assertEquals('7b38ed476b07852b7a6d7a799976380f.png', $screenshots->data[9]->name);
        $this->assertEquals('https://fshub.ams3.digitaloceanspaces.com/uploads/7b38ed476b07852b7a6d7a799976380f.png',
            $screenshots->data[9]->url->fullsizeUrl);

    }

}