<?php

namespace FsHub\Sdk\Tests\Support;

use FsHub\Sdk\Connectors\ConnectorResponse;
use FsHub\Sdk\Contracts\FsHubConnectorInterface;

class TestConnector implements FsHubConnectorInterface
{

    private const RQST_CONTENT_TYPE = "application/json";

    public function get(string $resourceIdentifier): ConnectorResponse
    {
        return match ($resourceIdentifier) {
            "user" => $this->User(),
            "pilot/2558" => $this->Pilot(2558),
            "pilot/2" => $this->Pilot(2),
            "pilot?cursor=0&limit=10" => $this->Pilots(0),
            "pilot?cursor=11&limit=10" => $this->Pilots(11),
            "pilot?cursor=7336&limit=10" => $this->Pilots(7336),
            "pilot/2/flight?cursor=1700000&limit=25" => $this->PilotFlights(2),
            "pilot/2/airline?cursor=0&limit=10" => $this->PilotAirlines(2),
            "pilot/2/stats" => $this->PilotStats(2),
            "pilot/2/flight/departure/EGSS?cursor=0&limit=100" => $this->PilotFlightsDeparting(2, "EGSS"),
            "pilot/2/flight/arrival/LOWS?cursor=0&limit=100" => $this->PilotFlightsArriving(2, "LOWS"),
            "pilot/2/flight/departure/EGPH/arrival/EGSS?cursor=0&limit=10" => $this->PilotFlightsByRoute(2, "EGPH",
                "EGSS"),
            "airport/EGSS" => $this->Airport("EGSS"),
            "airport/EGSS/arrival?cursor=0&limit=10" => $this->AirportArrivals("EGSS"),
            "airport/EGSS/departure?cursor=0&limit=10" => $this->AirportDepartures("EGSS"),
            "airport/EGSS/departure/LOWS?cursor=800000&limit=25" => $this->AirportDeparturesTo("EGSS", "LOWS"),
            "airport/EGSS/arrival/EGPH?cursor=1700000&limit=25" => $this->AirportArrivalsFrom("EGSS", "EGPH"),
            "airline/1778" => $this->Airline(1778),
            "airline?cursor=0&limit=10" => $this->Airlines(0),
            "airline?cursor=20&limit=10" => $this->Airlines(20),
            "airline?cursor=52&limit=10" => $this->Airlines(52),
            "airline/2/stats" => $this->AirlineStats(2),
            "airline/1778/pilot?cursor=0&limit=10" => $this->AirlinePilots(1778),
            "airline/1778/arrival/EGSS?cursor=0&limit=10" => $this->AirlineArrivals(1778, "EGSS"),
            "airline/1778/departure/EGPH?cursor=0&limit=10" => $this->AirlineDepartures(1778, "EGPH"),
            "airline/1778/departure/GMMX?cursor=0&limit=10" => $this->AirlineDepartures(1778, "GMMX"),
            "airline/1778/screenshot?cursor=0&limit=10" => $this->AirlineScreenshots(1778),
            "airline/1033/departure/EGSS/arrival/LOWS?cursor=0&limit=10" => $this->AirlineRoutes(1033, "EGSS", "LOWS"),
            "airline/1033/departure/EGSS/arrival/LPPT?cursor=0&limit=10" => $this->AirlineRoutesNoneFound(1033, "EGSS",
                "LPPT"),
            "flight/1798819" => $this->Flight(1798819),
            "flight/1" => $this->Flight(1),
            "flight/9997" => $this->InvalidApiKey(),
            "flight/9998" => $this->RateLimitExceeded(),
            "flight?cursor=1798819&limit=10" => $this->Flights(1798819),
            "flight?cursor=1798829&limit=10" => $this->Flights(1798829),
            "flight?cursor=1798839&limit=10" => $this->Flights(1798839),
            "flight/1802858/screenshot?cursor=0&limit=10" => $this->FlightScreenshots(1802858),
            "airport/EGSS/metar" => $this->Metar("EGSS"),
            "airport/EGOO/metar" => $this->Metar("EGOO"),
            "airport/EGDDD/metar" => $this->Metar("EGDDD"),
            default => throw new \InvalidArgumentException("No test connector handler/request matched!"),
        };
    }

    private function User(): ConnectorResponse
    {

        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/PilotContext.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function Pilot(int $id): ConnectorResponse
    {

        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/Pilot-{$id}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function Pilots(int $page): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/Pilots-Cursor{$page}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function Airport(string $icao): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airports/Airport-{$icao}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirportDepartures(string $icao): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airports/Airport-{$icao}-Departure.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirportArrivals(string $icao): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airports/Airport-{$icao}-Arrival.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirportArrivalsFrom(string $icao, string $arrival): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airports/Airport-{$icao}-ArrivalsFrom-{$arrival}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirportDeparturesTo(string $icao, string $departure): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airports/Airport-{$icao}-DepartingTo-{$departure}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function Airline(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airlines/Airline-{$id}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirlineStats(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airlines/Airline-{$id}-Stats.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function Airlines(int $page): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airlines/Airlines-Cursor{$page}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function Flight(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Flights/Flight-{$id}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function Flights(int $cursor): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Flights/Flights-Cursor{$cursor}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function Metar(string $icao): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airports/Airport-{$icao}-Metar.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirlinePilots(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airlines/Airline-{$id}-Pilot.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirlineDepartures(int $id, string $icao): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airlines/Airline-{$id}-Departure-{$icao}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirlineArrivals(int $id, string $icao): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airlines/Airline-{$id}-Arrivial-{$icao}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirlineScreenshots(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airlines/Airline-{$id}-Screenshots.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirlineRoutes(int $id, string $departure, string $arrival): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Airlines/Airline-{$id}-Depart-{$departure}-Arrive-{$arrival}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function AirlineRoutesNoneFound(int $id, string $departure, string $arrival): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 404;
        $response->body = FixtureReader::Read("Airlines/Airline-{$id}-Depart-{$departure}-Arrive-{$arrival}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function FlightScreenshots(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Flights/Flight-{$id}-Screenshots.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function PilotFlights(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/Pilot-{$id}-Flights.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function PilotAirlines(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/Pilot-{$id}-Airlines.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function PilotStats(int $id): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/Pilot-{$id}-Stats.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function PilotFlightsDeparting(int $id, string $icao): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/Pilot-{$id}-Flights-Departing-{$icao}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function PilotFlightsArriving(int $id, string $icao): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/Pilot-{$id}-Flights-Arriving-{$icao}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function PilotFlightsByRoute(int $id, string $departure, string $arrival): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 200;
        $response->body = FixtureReader::Read("Pilots/Pilot-{$id}-Flights-Departing-{$departure}-Arriving-{$arrival}.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function InvalidApiKey(): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 401;
        $response->body = FixtureReader::Read("General/Invalid-API-Token.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

    private function RateLimitExceeded(): ConnectorResponse
    {
        $response = new ConnectorResponse();
        $response->meta = [
            'X-RateLimit-Limit' => '100',
            'X-RateLimit-Remaining' => '99',
            'Context-Type' => self::RQST_CONTENT_TYPE,
        ];
        $response->status = 429;
        $response->body = FixtureReader::Read("General/Too-Many-Requests.json");

        // Validate and thrown exceptions if there are any...
        $response->validate();

        return $response;
    }

}