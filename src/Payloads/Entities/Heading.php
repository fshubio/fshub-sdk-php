<?php

namespace FsHub\Sdk\Payloads\Entities;

class Heading
{

    /**
     * Magnetic heading (direction) in cardinal degrees.
     * @var int
     */
    public readonly int $magnetic;

    /**
     * True heading (direction) in cardinal degrees.
     * @var int
     */
    public readonly int $true;

    public function fromArray(array $data): Heading
    {
        $this->magnetic = $data['magnetic'];
        $this->true = $data['true'];
        return $this;
    }
}