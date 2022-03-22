<?php

namespace FsHub\Sdk\Payloads;

class FlightCompleted
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
     * @var FlightCompletedData
     */
    public readonly FlightCompletedData $data;


    public static function fromJson(string $json): FlightCompleted
    {

        $flight = new FlightCompleted();
        $data = json_decode($json, true);

        $flight->sent = $data['_sent'];
        $flight->variant = $data['_variant'];

        $casted = new FlightCompletedData();
        $casted->fromArray($data['_data']);
        $flight->data = $casted;

        return $flight;
    }
}
