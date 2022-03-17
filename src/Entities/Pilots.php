<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CollectionMeta;

class Pilots implements \Countable
{

    /**
     * List of pilot resources.
     * @var Array<PilotData>
     */
    public array $data;

    /**
     * Collection metadata.
     * @var CollectionMeta
     */
    public CollectionMeta $meta;


    public static function fromJson(string $json): Pilots
    {
        $pilots = new Pilots();
        $data = json_decode($json, true);

        foreach ($data['data'] as $pilot) {
            $casted = new PilotData();
            $casted->fromArray($pilot);
            $pilots->data[] = $casted;
        }

        $meta = new CollectionMeta();
        $meta->cursor->count = $data['meta']['cursor']['count'];
        $meta->cursor->previous = $data['meta']['cursor']['prev'];
        $meta->cursor->next = $data['meta']['cursor']['next'];
        $meta->cursor->current = $data['meta']['cursor']['current'];
        $pilots->meta = $meta;

        return $pilots;
    }

    /**
     * Returns the total number of pilots in this collection.
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }
}