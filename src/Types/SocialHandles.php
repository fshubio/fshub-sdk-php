<?php

namespace FsHub\Sdk\Types;

class SocialHandles
{

    use CastableEntity;

    /**
     * Facebook Social Handle
     * @var string
     */
    public ?string $facebook = Common::DEFAULT_STRING_VALUE;

    /**
     * Twitter Social Handle
     * @var string
     */
    public ?string $twitter = Common::DEFAULT_STRING_VALUE;

    /**
     * Website address
     * @var string
     */
    public ?string $website = Common::DEFAULT_STRING_VALUE;

    /**
     * VATSIM ID
     * @var string
     */
    public ?string $vatsim = Common::DEFAULT_STRING_VALUE;

    /**
     * IVAO ID
     * @var string
     */
    public ?string $ivao = Common::DEFAULT_STRING_VALUE;
}