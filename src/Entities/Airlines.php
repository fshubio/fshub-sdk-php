<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CollectionMeta;

class Airlines implements \Countable
{

    /**
     * List of airline resources.
     * @var Array<AirlineData>
     */
    public array $data;

    /**
     * Collection metadata.
     * @var CollectionMeta
     */
    public CollectionMeta $meta;


    public static function fromJson(string $json): Airlines
    {
        $airlines = new Airlines();
        $data = json_decode($json, true);

        foreach ($data['data'] as $airline) {
            $casted = new AirlineData();
            $casted->fromArray($airline);
            $airlines->data[] = $casted;
        }

        $meta = new CollectionMeta();
        $meta->cursor->count = $data['meta']['cursor']['count'];
        $meta->cursor->previous = $data['meta']['cursor']['prev'];
        $meta->cursor->next = $data['meta']['cursor']['next'];
        $meta->cursor->current = $data['meta']['cursor']['current'];
        $airlines->meta = $meta;

        return $airlines;
    }

    /**
     * Returns the total number of airlines in this collection.
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }
}