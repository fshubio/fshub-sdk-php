<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\Common;

class Aircraft
{

    /**
     * The aircraft ICAO as recognised by FsHub.
     * @var string
     */
    public string $icao = Common::DEFAULT_STRING_VALUE;

    /**
     * The aircraft official name as recognised by FsHub.
     * @var string
     */
    public ?string $icaoName = Common::DEFAULT_NULL_VALUE;

    /**
     * The aircraft set name (simulator livery label)
     * @var string
     */
    public string $name = Common::DEFAULT_STRING_VALUE;

    /**
     * The aircraft "type" value as set by the simulator (not that useful to be honest!)
     * @var string
     */
    public string $type = Common::DEFAULT_STRING_VALUE;

    /**
     * User configured aircraft/livery specific settings (these are set through the LRM Aircraft Manager screen)
     * @var UserConf
     */
    public UserConf $userConf;


    public function fromArray(array $data)
    {

        $this->icao = $data['icao'] ?? '';
        $this->icaoName = $data['icao_name'] ?? null;
        $this->name = $data['name'];
        $this->type = $data['type'] ?? '';

        $userConfiguration = new UserConf();
        $userConfiguration->tailNumber = $data['user_conf']['tail'];
        $userConfiguration->icao = $data['user_conf']['icao'];
        $this->userConf = $userConfiguration;
    }


}