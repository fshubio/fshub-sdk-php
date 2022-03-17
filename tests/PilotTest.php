<?php

use FsHub\Sdk\Client;
use FsHub\Sdk\Tests\Support\TestConnector;
use PHPUnit\Framework\TestCase;

class PilotTest extends TestCase
{

    public function testDateTimeObjectAccessor()
    {
        $dt = new DateTime('2022-03-03T11:42:32.991295Z');
        $this->assertEquals('1646307752', $dt->getTimestamp());
        //$dt->setTimezone(new DateTimeZone('Australia/Melbourne'));
        //$this->assertEquals('1646307752', $dt->getTimestamp()); // Test we can convert to a local time...
    }

    public function testPilotContextIsReturned()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $context = $client->user->context();

        $this->assertEquals(2, $context->data->id);
        $this->assertEquals('Bobby Allen', $context->data->name);
        $this->assertEquals('EGSS', $context->data->base);
        $this->assertEquals('EGPE', $context->data->location);
        $this->assertEquals('57.538012,-4.063036', $context->data->gps->__toString());
        $this->assertEquals(57.538012, $context->data->gps->latitude);
        $this->assertTrue($context->data->isOnline);

        $dt = new DateTime('2022-03-03T11:42:32.991295Z');
        $this->assertEquals($dt, $context->data->onlineAt);
        $this->assertEquals(1646307752, $context->data->onlineAt->getTimestamp());
    }

    public function testPilotObjectIsReturned()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $pilot = $client->pilots->find(2558); // Return's thunfischbaum's account

        $this->assertEquals(2558, $pilot->data->id);
        $this->assertEquals('thunfischbaum', $pilot->data->name);
        $this->assertTrue(str_contains($pilot->data->bio, 'You might see this Bio Text'));
        $this->assertNull($pilot->data->handles->facebook);
        $this->assertNull($pilot->data->handles->website);
        $this->assertNull($pilot->data->handles->vatsim);
        $this->assertNull($pilot->data->handles->ivao);
        $this->assertEquals('twitter.com/thunfischbaum', $pilot->data->handles->twitter);
        $this->assertEquals('EDDF', $pilot->data->location);
        $this->assertEquals('DE', $pilot->data->country);
        $this->assertEquals('Europe/Berlin', $pilot->data->timezone);
        $this->assertFalse($pilot->data->isOnline);

        $onlineAt = new DateTime('2022-02-27T18:36:34.6550480Z');
        $this->assertEquals($onlineAt, $pilot->data->onlineAt);
        $this->assertEquals(1645986994, $pilot->data->onlineAt->getTimestamp());

        $createdAt = new DateTime('2019-12-15T16:53:46.000000Z');
        $this->assertEquals($createdAt, $pilot->data->createdAt);

    }

    public function testPilotObjectIsReturnedFrom()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $pilot = $client->pilots
            ->find($client->user->context()->getPilotId());

        $this->assertEquals(2, $pilot->data->id);
        $this->assertEquals('Bobby Allen', $pilot->data->name);
    }

    public function testCollectionOfPilotsAreReturned()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $pilots = $client->pilots
            ->offset(0)
            ->get();

        $this->assertEquals(10, $pilots->data->count());
    }

    public function testPilotCollectionObjectValues()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $pilots = $client->pilots
            ->offset(0)
            ->get();

        $total = $pilots->data->count;
        $this->assertEquals(10, $total);

        $testAccount1 = $pilots->data[3];
        $this->assertEquals('AdamisFlying', $testAccount1->name);
        $this->assertEquals('531799', $testAccount1->handles->vatsim);

        $this->assertEquals(10, $pilots->meta->cursor->count);
        $this->assertEquals(0, $pilots->meta->cursor->current);
        $this->assertEquals(0, $pilots->meta->cursor->previous);
        $this->assertEquals(11, $pilots->meta->cursor->next);

        $nextCursor = $pilots->meta->cursor->next;

        $pilots = $client->pilots->offset($nextCursor)->get();

        $this->assertEquals(10, $pilots->meta->cursor->count);
        $this->assertEquals(11, $pilots->meta->cursor->current);
        $this->assertEquals(0, $pilots->meta->cursor->previous);
        $this->assertEquals(21, $pilots->meta->cursor->next);

        $testAccount2 = $pilots->data[0];
        $this->assertEquals('Alessandro Papadopoulos', $testAccount2->name);

        $pilots = $client->pilots->offset(7336)->get();
        $this->assertEquals(4, $pilots->meta->cursor->count);
        $this->assertEquals(7336, $pilots->meta->cursor->current);
        $this->assertEquals(7340, $pilots->meta->cursor->next);

        $testAccount3 = $pilots->data[$pilots->data->count() - 1];
        $this->assertEquals('Darrian Dorsey', $testAccount3);


    }

    public function testPilotFlightCollection()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $pilotFlights = $client->pilots
            ->select(2)
            ->offset(1700000)
            ->take(25)
            ->flights();

        $total = $pilotFlights->data->count();
        $this->assertEquals(1700000, $pilotFlights->meta->cursor->current);
        $this->assertEquals(25, $total);
        $this->assertEquals(6, $pilotFlights->meta->cursor->count);

        foreach ($pilotFlights->data as $flight) {
            $this->assertEquals(2, $flight->pilot->id);
        }

    }

    public function testPilotAirlinesCollection()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $pilotAirlines = $client->pilots
            ->select(2)
            ->airlines();

        $total = $pilotAirlines->data->count();

        $this->assertEquals(6, $total);
        $this->assertEquals(6, $pilotAirlines->meta->cursor->count);

        $expectedAirlines = [
            'JSG',
            'CMP',
            'CAA',
            'YON',
            'EZA',
            'BAW',
        ];

        foreach ($pilotAirlines->data as $airline) {
            $this->assertContains($airline->abbreviation, $expectedAirlines);
        }


    }

    public function testPilotStats()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $pilotStats = $client->pilots
            ->select(2)
            ->stats();

        $this->assertEquals(2, $pilotStats->data->id);

        $this->assertEquals(536, $pilotStats->allTime->flights);
        $this->assertEquals(572.7, $pilotStats->allTime->hours);
        $this->assertEquals(215426, $pilotStats->allTime->distance);
        $this->assertEquals(-140, $pilotStats->allTime->averageLandingRate);

        $this->assertEquals(39, $pilotStats->currentMonth->flights);
        $this->assertEquals(56.2, $pilotStats->currentMonth->hours);
        $this->assertEquals(21122, $pilotStats->currentMonth->distance);
        $this->assertEquals(-159, $pilotStats->currentMonth->averageLandingRate);
    }

    public function testPilotFlightsByDepartureIcao()
    {
        $icao = "EGSS";

        $client = new Client("FIXTURE_KEY", new TestConnector());

        $pilotFlights = $client->pilots
            ->select(2)
            ->take(100)
            ->arrivals($icao);

        $this->assertEquals(11, $pilotFlights->meta->cursor->count);

        foreach ($pilotFlights->data as $flight) {
            $this->assertEquals(2, $flight->pilot->id);
            $this->assertEquals($icao, $flight->departure->icao);
        }
    }

    public function testPilotFlightsByArrivalIcao()
    {
        $icao = "LOWS";

        $client = new Client("FIXTURE_KEY", new TestConnector());

        $pilotFlights = $client->pilots
            ->select(2)
            ->take(100)
            ->arrivals($icao);

        $this->assertEquals(11, $pilotFlights->meta->cursor->count);

        foreach ($pilotFlights->data as $flight) {
            $this->assertEquals(2, $flight->pilot->id);
            $this->assertEquals($icao, $flight->arrival->icao);
        }
    }

    public function testPilotRoutes()
    {
        $departure = "EGPH";
        $arrival = "EGSS";

        $client = new Client("FIXTURE_KEY", new TestConnector());

        $pilotFlights = $client->pilots
            ->select(2)
            ->route($departure, $arrival);

        $this->assertEquals(3, $pilotFlights->meta->cursor->count);

        foreach ($pilotFlights->data as $flight) {
            $this->assertEquals(2, $flight->pilot->id);
            $this->assertEquals($departure, $flight->departure->icao);
            $this->assertEquals($arrival, $flight->arrival->icao);
        }
    }

}