<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CollectionMeta;

class Screenshots implements \Countable
{

    /**
     * List of screenshot resources.
     * @var Array<ScreenshotData>
     */
    public array $data;

    /**
     * Collection metadata.
     * @var CollectionMeta
     */
    public CollectionMeta $meta;


    public static function fromJson(string $json): Screenshots
    {
        $screenshots = new Screenshots();
        $data = json_decode($json, true);

        foreach ($data['data'] as $screenshot) {
            $casted = new ScreenshotData();
            $casted->fromArray($screenshot);
            $screenshots->data[] = $casted;
        }

        $meta = new CollectionMeta();
        $meta->cursor->count = $data['meta']['cursor']['count'];
        $meta->cursor->previous = $data['meta']['cursor']['prev'];
        $meta->cursor->next = $data['meta']['cursor']['next'];
        $meta->cursor->current = $data['meta']['cursor']['current'];
        $screenshots->meta = $meta;

        return $screenshots;
    }

    /**
     * Returns the total number of screenshots in this collection.
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }
}