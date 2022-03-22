<?php

namespace FsHub\Sdk\Payloads;

class FlightArrived
{
    /**
     * The webhook event variant - this is the variation trigger type (eg. User or Airline) action triggered.
     * @var string
     */
    public readonly string $variant;

    /**
     * The UNIX timestamp when the webhook event was generated (on the FsHub platform).
     * @note  This can be used to determine if the webhook request is old or delayed etc.
     * @var int
     */
    public readonly int $sent;

    /**
     * The webhook event payload entity.
     * @var FlightArrivedData
     */
    public readonly FlightArrivedData $data;


    public static function fromJson(string $json): FlightArrived
    {

        $flight = new FlightArrived();
        $data = json_decode($json, true);

        $flight->sent = $data['_sent'];
        $flight->variant = $data['_variant'];

        $casted = new FlightArrivedData();
        $casted->fromArray($data['_data']);
        $flight->data = $casted;

        return $flight;
    }
}
