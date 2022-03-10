<?php

use FsHub\Sdk\Entites\UserConf;
use PHPUnit\Framework\TestCase;

class GeneralTest extends TestCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testWeCanCastToAnEntityUsingBaseCastMethod()
    {
        $userConfEntity = UserConf::cast([
            'tailNumber' => 'G-BOBY',
            'icao' => 'A20N',
        ]);
        $this->assertEquals('G-BOBY', $userConfEntity->tailNumber);
        $this->assertEquals('A20N', $userConfEntity->icao);

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
        $direction = \FsHub\Sdk\Types\Wind::cast([
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
        $distance = \FsHub\Sdk\Types\Distance::cast([
            'nm' => 1.61987,
            'km' => 3,
        ]);

        $this->assertFalse(property_exists($distance, 'nm'));
        $this->assertFalse(property_exists($distance, 'km'));

        $this->assertEquals(1.61987, $distance->nauticalMiles);
        $this->assertEquals(3, $distance->kilometres);

    }
}