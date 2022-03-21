<?php

namespace FsHub\Sdk\Payloads;

class FlightDeparted
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
     * @var FlightDepartedData
     */
    public readonly FlightDepartedData $data;


    public static function fromJson(string $json): FlightDeparted
    {
        $flight = new FlightDeparted();
        $data = json_decode($json, true);

        $flight->variant = $data['_variant'];
        $flight->sent = $data['_sent'];

        $casted = new FlightDepartedData();
        $casted->fromArray($data['_data']);
        $flight->data = $casted;

        return $flight;
    }
}