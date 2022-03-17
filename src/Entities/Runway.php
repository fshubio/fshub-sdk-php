<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\LatLng;

class Runway
{

    /**
     * The runway number/identifier.
     * @var string
     */
    public string $name;

    /**
     * The runway surface typo.
     * @var string
     */
    public string $surface;

    /**
     * The runway length (in feet)
     * @var int
     */
    public int $length;

    /**
     * The runway heading
     * @var int
     */
    public int $heading;

    /**
     * The runway GPS location.
     * @var LatLng
     */
    public LatLng $geo;

    /**
     * ILS details (if applicable)
     * @var Ils
     */
    public Ils $ils;

    public static function fromArray(array $data): Runway
    {

        $runway = new Runway();
        $runway->name = $data['name'];
        $runway->surface = $data['type'];
        $runway->length = $data['length'];
        $runway->heading = $data['hdg'];

        $runway->geo = new LatLng();
        $runway->geo->latitude = $data['geo']['lat'];
        $runway->geo->longitude = $data['geo']['lng'];

        $runway->ils = new Ils();
        $runway->ils->ident = $data['ils']['id'];
        $runway->ils->frequency = $data['ils']['frequency'];
        $runway->ils->heading = $data['ils']['hdg'];
        $runway->ils->slope = $data['ils']['slope'];

        return $runway;
    }
}