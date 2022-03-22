<?php

namespace FsHub\Sdk\Payloads\Entities;

/**
 * @property-read int $oew Aircraft OEW (in KGS)
 */
class Weight
{

    /**
     * Aircraft fuel weight (in KGS)
     * @var int
     */
    public readonly int $fuel;

    /**
     * Aircraft weight (in KGS)
     * @var int
     */
    public readonly int $zfw;

    /**
     * @note Computes the OEW for the aircraft, accessed through __get()
     * @return int
     */
    private function getOperatingEmptyWeight(): int
    {
        return $this->fuel + $this->zfw;
    }

    /**
     * @note Adds computed property support in PHP to match our .NET/C# API so our API is consistent across all languages.
     * @param string $propertyName
     * @return int|void
     */
    public function __get(string $propertyName)
    {
        // Added as a switch statement as we'll probably extend the functionality later to provide more computed properties!
        switch ($propertyName) {
            case "oew":
                return $this->getOperatingEmptyWeight();
        }
    }

    public function fromArray(array $data): Weight
    {
        $this->fuel = $data['fuel'];
        $this->zfw = $data['zfw'];
        return $this;
    }


}