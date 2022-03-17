<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Exceptions\AirportNotFoundException;

class MetarData
{

    public string $icao;
    public ?string $iata = null;
    public ?string $name = null;
    public ?MetarReportData $metar;

    public function fromArray(array $data)
    {

        $this->icao = $data['icao'];
        $this->iata = $data['iata'] ?? null;
        $this->name = $data['name'] ?? null;

        $report = new MetarReportData();
        $report->error = $data['metar']['error'];
        $report->report = $data['metar']['report'];
        $this->metar = $report;
    }
}