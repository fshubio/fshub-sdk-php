<?php

use FsHub\Sdk\Client;
use FsHub\Sdk\Entities\FlightMaxValues;
use FsHub\Sdk\Entities\UserConf;
use FsHub\Sdk\Exceptions\ContextNotSetException;
use FsHub\Sdk\Exceptions\InvalidApiKeyException;
use FsHub\Sdk\Exceptions\RateLimitExceededException;
use FsHub\Sdk\Tests\Support\TestConnector;
use FsHub\Sdk\Types\Distance;
use FsHub\Sdk\Types\Wind;
use PHPUnit\Framework\TestCase;

class GeneralTest extends TestCase
{

    public function testSelectedContextThrowsExceptionIfNotSet()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $this->expectException(ContextNotSetException::class);
        $this->expectExceptionMessage('No context has been set, use the Select(x) fluent method to set/select a context!');
        $client->airlines->screenshots();
    }

    public function testInvalidApiKeyThrowsCorrectException()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $this->expectException(InvalidApiKeyException::class);
        $this->expectExceptionMessage('The API key specified is not valid, please check and try again.');
        $client->flights->find(9997);
    }

    public function testTooManyApiAttemptsRateLimitShowsCorrectException()
    {
        $client = new Client("FIXTURE_KEY", new TestConnector());
        $this->expectException(RateLimitExceededException::class);
        $this->expectExceptionMessage('You have been rate limited due to the number of API requests you have performed, please wait before trying again.');
        $client->flights->find(9998);

    }


    public function testWeCanCastToAnEntityUsingBaseCastMethod()
    {
        $userConfEntity = UserConf::cast([
            'tail' => 'G-BOBY',
            'icao' => 'A20N',
        ]);
        $this->assertEquals('G-BOBY', $userConfEntity->tailNumber);
        $this->assertEquals('A20N', $userConfEntity->icao);
    }

    public function testCastFlightMaxValues()
    {
        $test = new FlightMaxValues();
        $this->assertEquals(null, $test->altitude);
        $this->assertEquals(null, $test->speed);

        $test = FlightMaxValues::cast([
            'spd' => 198,
            'alt' => 18734,
        ]);
        $this->assertEquals(18734, $test->altitude);
        $this->assertEquals(198, $test->speed);
    }

    public function testThatAFreshEntityHasEmptyValues()
    {
        $userConfEntity = new UserConf();
        $this->assertEquals('', $userConfEntity->tailNumber);
        $this->assertEquals('', $userConfEntity->icao);

        $userConfEntity = UserConf::cast([]);
        $this->assertEquals('', $userConfEntity->tailNumber);
        $this->assertEquals('', $userConfEntity->icao);
    }

    public function testLatLngType()
    {
        $latLngType = new \FsHub\Sdk\Types\LatLng();

        $this->assertEquals(0, $latLngType->latitude);
        $this->assertEquals(0, $latLngType->longitude);

        $latLngType = \FsHub\Sdk\Types\LatLng::cast([
            'lat' => 51.02333,
            'lng' => -2.334,
        ]);
        $this->assertEquals(51.02333, $latLngType->latitude);
        $this->assertEquals(-2.334, $latLngType->longitude);

        $this->assertEquals("51.02333,-2.334", (string)$latLngType);
        $this->assertEquals("{\"lat\":51.02333,\"lng\":-2.334}", $latLngType->toJson());
    }

    public function testDefaultStringValuesPopulated()
    {
        $socials = new \FsHub\Sdk\Types\SocialHandles();

        $this->assertEquals("", $socials->twitter);

        $socials = \FsHub\Sdk\Types\SocialHandles::cast([
            'twitter' => '@allebb87',
            'website' => 'http://example.com',
            'vatsim' => '54321',
            'ivao' => 12345, // Should automatically cast to a string.
        ]);

        $this->assertEmpty($socials->facebook);
        $this->assertEquals("@allebb87", $socials->twitter);
        $this->assertEquals("http://example.com", $socials->website);
        $this->assertEquals("54321", $socials->vatsim);
        $this->assertEquals("12345", $socials->ivao);

        $socials = \FsHub\Sdk\Types\SocialHandles::cast([]);
        $this->assertEquals("", $socials->twitter);

    }

    public function testWindCastMapping()
    {
        $direction = Wind::cast([
            'spd' => 12,
            'dir' => 98,
        ]);

        $this->assertFalse(property_exists($direction, 'spd'));
        $this->assertFalse(property_exists($direction, 'dir'));

        $this->assertEquals(12, $direction->speed);
        $this->assertEquals(98, $direction->direction);
    }

    public function testDistanceCastMapping()
    {
        $distance = Distance::cast([
            'nm' => 1.61987,
            'km' => 3,
        ]);

        $this->assertFalse(property_exists($distance, 'nm'));
        $this->assertFalse(property_exists($distance, 'km'));

        $this->assertEquals(1.61987, $distance->nauticalMiles);
        $this->assertEquals(3, $distance->kilometres);
    }
}