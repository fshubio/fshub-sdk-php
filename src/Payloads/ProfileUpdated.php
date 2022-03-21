<?php

namespace FsHub\Sdk\Payloads;

class ProfileUpdated
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
     * @var ProfileUpdatedData
     */
    public readonly ProfileUpdatedData $data;


    public static function fromJson(string $json): ProfileUpdated
    {

        $profile = new ProfileUpdated();
        $data = json_decode($json, true);

        $profile->variant = $data['_variant'];
        $profile->sent = $data['_sent'];

        $casted = new ProfileUpdatedData();
        $casted->fromArray($data['_data']);
        $profile->data = $casted;

        return $profile;
    }
}