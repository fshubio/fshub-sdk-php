<?php

namespace FsHub\Sdk\Payloads;

use FsHub\Sdk\Payloads\Entities\Aircraft;
use FsHub\Sdk\Payloads\Entities\Airline;
use FsHub\Sdk\Payloads\Entities\Airport;
use FsHub\Sdk\Payloads\Entities\FlightPlan;
use FsHub\Sdk\Payloads\Entities\Heading;
use FsHub\Sdk\Payloads\Entities\User;
use FsHub\Sdk\Payloads\Entities\Weight;
use FsHub\Sdk\Payloads\Entities\Wind;
use FsHub\Sdk\Types\LatLng;

class FlightDepartedData
{

    /**
     * The departure ID.
     * @var int
     */
    public readonly int $id;

    /**
     * The pilot entity.
     * @var User
     */
    public readonly User $pilot;

    /**
     * The aircraft entity.
     * @var Aircraft
     */
    public readonly Aircraft $aircraft;

    /**
     * The airline entity.
     * @var Airline|null
     */
    public readonly ?Airline $airline;

    /**
     * The flight plan entity.
     * @var FlightPlan|null
     */
    public readonly ?FlightPlan $plan;

    /**
     * The arrival airport entity.
     * @var Airport|null
     */
    public readonly ?Airport $airport;

    /**
     * The arrival landing rate (in feet per minute)
     * @var int
     */
    public readonly int $landingRate;

    /**
     * The aircraft's pitch angle at take-off.
     * @var int
     */
    public readonly int $pitch;

    /**
     * The aircraft's bank angle at take-off.
     * @var int
     */
    public readonly int $bank;

    /**
     * The aircarft's true airspeed at take-off.
     * @var int
     */
    public readonly int $speed;

    /**
     * The aircraft's heading at take-off.
     * @var Heading
     */
    public readonly Heading $heading;

    /**
     * Wind characteristics at take-off.
     * @var Wind
     */
    public readonly Wind $wind;

    /**
     * Aircraft weight at take-off.
     * @var Weight
     */
    public readonly Weight $weight;

    /**
     * Aircraft GPS at take-off.
     * @var LatLng
     */
    public readonly LatLng $gps;

    /**
     * The date and time of the Departure (take-off)
     * @var \DateTime
     */
    public readonly \DateTime $createdAt;


    public function fromArray(array $data)
    {
        $this->id = $data['id'];

        $this->pilot = (new User())->fromArray($data['user']);
        $this->aircraft = (new Aircraft())->fromArray($data['aircraft']);
        $this->airline = (new Airline())->fromArray($data['airline']);
        $this->plan = isset($data['plan']) ? (new FlightPlan())->fromArray($data['plan']) : null;
        $this->airport = isset($data['airport']) ? (new Airport())->fromArray($data['airport']) : null;

        $this->pitch = $data['pitch'];
        $this->bank = $data['bank'];
        $this->speed = $data['speed_tas'];
        $this->heading = (new Heading())->fromArray($data['heading']);
        $this->wind = (new Wind())->fromArray($data['wind']);
        $this->weight = (new Weight())->fromArray($data['weight']);

        $gps = new LatLng();
        $gps->latitude = $data['gps']['lat'];
        $gps->longitude = $data['gps']['lng'];
        $this->gps = $gps;

        $this->createdAt = new \DateTime($data['datetime']);

    }
}