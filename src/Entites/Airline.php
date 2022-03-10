<?php

namespace FsHub\Sdk\Entites;

class Airline
{

    public function __construct(
        public int $id,
        public string $name,
        public string $abbreviation,
        public PilotData $owner,
        public SocialHandles $handes
    ) {

    }


}