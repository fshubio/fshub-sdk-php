<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CollectionMeta;

class Flights implements \Countable
{

    /**
     * List of flight resources.
     * @var Array<FlightData>
     */
    public array $data;

    /**
     * Collection metadata.
     * @var CollectionMeta
     */
    public CollectionMeta $meta;


    public static function fromJson(string $json): Flights
    {
        $flights = new Flights();
        $data = json_decode($json, true);

        foreach ($data['data'] as $flight) {
            $casted = new FlightData();
            $casted->fromArray($flight);
            $flights->data[] = $casted;
        }

        $meta = new CollectionMeta();
        $meta->cursor->count = $data['meta']['cursor']['count'];
        $meta->cursor->previous = $data['meta']['cursor']['prev'];
        $meta->cursor->next = $data['meta']['cursor']['next'];
        $meta->cursor->current = $data['meta']['cursor']['current'];
        $flights->meta = $meta;

        return $flights;
    }

    /**
     * Returns the total number of flights in this collection.
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }
}