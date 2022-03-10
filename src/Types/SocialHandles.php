<?php

namespace FsHub\Sdk\Types;

class SocialHandles
{

    use CastableEntity;

    public string $facebook = Common::DEFAULT_STRING_VALUE;
    public string $twitter = Common::DEFAULT_STRING_VALUE;
    public string $website = Common::DEFAULT_STRING_VALUE;
    public string $vatsim = Common::DEFAULT_STRING_VALUE;
    public string $ivao = Common::DEFAULT_STRING_VALUE;
}