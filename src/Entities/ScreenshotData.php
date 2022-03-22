<?php

namespace FsHub\Sdk\Entities;

use DateTime;

class ScreenshotData
{
    /**
     * The screenshot ID
     * @var int
     */
    public int $id;

    /**
     * The screenshot name
     * @var string
     */
    public string $name;

    /**
     * The screenshot description (not currently used)
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Screenshot rendition size URLs
     * @var ScreenshotRenditions
     */
    public ScreenshotRenditions $url;

    /**
     * The date and time the screenshot was uploaded to FsHub.
     * @var DateTime
     */
    public DateTime $createdAt;


    public function fromArray(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['desc'];
        $this->createdAt = new DateTime($data['created_at']);

        $renditions = new ScreenshotRenditions();
        $renditions->fullsizeUrl = $data['urls']['fullsize'];
        $renditions->thumbnailUrl = $data['urls']['thumbnail'];
        $this->url = $renditions;
    }
}
