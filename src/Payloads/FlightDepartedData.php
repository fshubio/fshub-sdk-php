<?php

namespace FsHub\Sdk\Payloads;

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
     * @var int
     */
    public readonly int $heading;

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


    public function fromArray(string $json)
    {
        $data = json_decode($json, true);
        $this->id = $data['_data']['id'];

        $this->landingRate = $data['_data']['landing_rate'];
        $this->pitch = $data['_data']['pitch'];
        $this->bank = $data['_data']['bank'];
        $this->speed = $data['_data']['speed_tas'];
        $this->heading = $data['_data']['heading'];
        $this->createdAt = new \DateTime($data['_data']['datetime']);

    }
}