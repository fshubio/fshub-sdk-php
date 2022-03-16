<?php

use FsHub\Sdk\Client;
use FsHub\Sdk\Tests\Support\TestConnector;
use PHPUnit\Framework\TestCase;

class AirportTest extends TestCase
{

    public function testAirportQueryValues()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $airport = $client->airports->find('EGSS');

        $this->assertEquals('EGSS', $airport->data->icao);
        $this->assertEquals('STN', $airport->data->iata);
        $this->assertEquals('Stansted', $airport->data->name);
        $this->assertEquals(348, $airport->data->alt);
        $this->assertEquals(-3, $airport->data->magVar);

        $this->assertEquals(51.884998, $airport->data->geo->latitude);
        $this->assertEquals(0.235, $airport->data->geo->longitude);
        $this->assertEquals('51.884998,0.235', (string)$airport->data->geo);
        $this->assertEquals('{"lat":51.884998,"lng":0.235}', $airport->data->geo->toJson());

        $this->assertNull($airport->data->frequencies->clearanceDelivery);
        $this->assertNull($airport->data->frequencies->unicom);
        $this->assertNull($airport->data->frequencies->multicom);
        $this->assertEquals("127.170", $airport->data->frequencies->atis);
        $this->assertEquals("121.720", $airport->data->frequencies->ground);
        $this->assertEquals("123.800", $airport->data->frequencies->tower);
        $this->assertEquals("120.620", $airport->data->frequencies->approach);
        $this->assertEquals("126.950", $airport->data->frequencies->departure);

        $totalRunways = $airport->data->runways->count();
        $this->assertEquals(2, $totalRunways);

        $this->assertEquals("22", $airport->data->runways[1]->name);
        $this->assertEquals("Asphalt", $airport->data->runways[1]->surface);
        $this->assertEquals(9984, $airport->data->runways[1]->length);
        $this->assertEquals(226, $airport->data->runways[1]->heading);

        $this->assertEquals(51.895157, $airport->data->runways[1]->geo->latitude);
        $this->assertEquals(0.250072, $airport->data->runways[1]->geo->longitude);

        $this->assertEquals('ISX', $airport->data->runways[1]->ils->id);
        $this->assertEquals('110.500', $airport->data->runways[1]->ils->frequency);
        $this->assertEquals(226, $airport->data->runways[1]->ils->heading);
        $this->assertEquals(3, $airport->data->runways[1]->ils->slope);

        // Test the AirportInterface implementation (IAirport in our C# SDK)
        $this->assertEquals('EGSS', $airport->getAirportIcao());
    }

    public function testAirportSuccessfulMetarReport()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $airport = $client->airports
            ->find('EGSS');

        $metar = $client->airports
            ->select($airport)
            ->metar();

        $this->assertEquals('EGSS', $metar->data->icao);
        $this->assertEquals('STN', $metar->data->iata);
        $this->assertEquals('EGSS 061220Z AUTO 06015KT 9999 BKN039 OVC045 06/00 Q1030', $metar->data->metar->report);

        $this->assertFalse($metar->data->metar->error);

    }

    public function testAirportNoMetarReport()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $this->expectException(\FsHub\Sdk\Exceptions\NoMetarFoundException::class);
        $metar = $client->airports
            ->select('EGOO')
            ->metar();

    }

    public function testInvalidAirportNoMetarReport()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $this->expectException(\FsHub\Sdk\Exceptions\AirportNotFoundException::class);
        $metar = $client->airports
            ->select('EGDDD')
            ->metar();
    }

    public function testAirportArrivals()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $flights = $client->airports
            ->select('EGSS')
            ->arrivals();

        $this->assertEquals(10, $flights->data->count());

        $this->assertEquals(1, $flights->data[0]->id);
        $this->assertEquals("Carenado A36 Bonanza 60t", $flights->data[0]->aircraft->name);
    }

    public function testAirportDepartures()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $flights = $client->airports
            ->select('EGSS')
            ->departures();

        $this->assertEquals(10, $flights->data->count());

        $this->assertEquals(136708, $flights->data[0]->id);
        $this->assertEquals("F22", $flights->data[0]->aircraft->icao);
        $this->assertEquals("Lockheed Martin F-22 Raptor", $flights->data[0]->aircraft->icaoName);
    }

    public function testAirportDeparturesTo()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $flights = $client->airports
            ->select('EGSS')
            ->offset(800000)
            ->take(25)
            ->departuresTo('LOWS');

        $this->assertEquals(11, $flights->data->count());

        $this->assertEquals(800000,
            $flights->meta->cursor->current); // Our test fixture is taken from cursor position 800000, lets just validate that here!
        $this->assertEquals(11,
            $flights->meta->cursor->count); // Our result (fixture) contains 11 records, lets validate...
        $this->assertEquals(1080601, $flights->data[2]->id);
        $this->assertEquals('Travel Service', $flights->data[2]->airline->name);
        $this->assertEquals('SMW', $flights->data[2]->airline->abbreviation);

        foreach ($flights->data as $flight) {
            $this->assertEquals('EGSS', $flight->departure->icao);
            $this->assertEquals('LOWS', $flight->arrival->icao);
        }
    }

    public function testAirportArrivalsFrom()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());

        $flights = $client->airports
            ->select('EGSS')
            ->offset(1700000)
            ->take(25)
            ->arrivalsFrom('EGPH');

        $this->assertEquals(3, $flights->data->count());

        $this->assertEquals(1700000, $flights->meta->cursor->current);

        foreach ($flights->data as $flight) {
            $this->assertEquals('EGSS', $flight->arrival->icao);
            $this->assertEquals('EGPH', $flight->departure->icao);
        }
    }

}