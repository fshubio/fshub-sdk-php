<?php

namespace FsHub\Sdk\Payloads\Entities;

class Aircraft
{
    /**
     * The aircraft ICAO as recognised by FsHub.
     * @var string
     */
    public readonly string $icao;

    /**
     * The aircraft official name as recognised by FsHub.
     * @var string
     */
    public readonly string $icaoName;

    /**
     * The aircraft set name (simulator livery label).
     * @var string
     */
    public readonly string $name;

    /**
     * The aircraft "type" value as set by the simulator (not that useful to be honest!)
     * @var string
     */
    public readonly string $type;

    /**
     * User configured aircraft/livery specific settings (these are set through the LRM Aircraft Manager screen)
     * @var UserConf
     */
    public readonly UserConf $userConf;

    /**
     * @inheritdoc
     */
    public function fromArray(array $data): Aircraft
    {
        $this->icao = $data['icao'];
        $this->icaoName = $data['icao_name'];
        $this->name = $data['name'];
        $this->type = $data['type'];

        $this->userConf = (new UserConf())->fromArray($data['user_conf']);

        return $this;
    }
}
