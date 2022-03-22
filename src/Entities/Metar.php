<?php

namespace FsHub\Sdk\Entities;

class Metar
{
    public bool $error = false;
    public ?MetarData $data = null;
    public ?string $message = null;

    public static function fromJson(string $json): Metar
    {
        $metar = new Metar();
        $data = json_decode($json, true);

        if (isset($data['error']) && $data['error'] && isset($data['message'])) {
            $metar->error = true;
            $metar->message = $data['message'];
            return $metar;
        }

        $casted = new MetarData();
        $casted->fromArray($data['data']);
        $metar->data = $casted;

        return $metar;
    }
}
