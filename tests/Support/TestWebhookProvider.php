<?php

namespace FsHub\Sdk\Tests\Support;

use DateTime;
use FsHub\Sdk\Contracts\FsHubWebhookInterface;
use FsHub\Sdk\Types\WebhookEvent;
use FsHub\Sdk\Types\WebhookVariant;

class TestWebhookProvider implements FsHubWebhookInterface
{

    private WebhookVariant $variant;
    private WebhookEvent $hookType;
    private int $timestamp;
    private string $fixtureFile;

    public function __construct(
        WebhookVariant $variant,
        WebhookEvent $hookType,
        int $timestamp,
        string $fixtureFilePath
    ) {

        $this->variant = $variant;
        $this->hookType = $hookType;
        $this->timestamp = $timestamp;
        $this->fixtureFile = FixtureReader::Read($fixtureFilePath);
    }

    public function variant(): WebhookVariant
    {
        return $this->variant;
    }

    public function event(): WebhookEvent
    {
        return $this->hookType;
    }

    public function timeSent(): DateTime
    {
        $datetime = new DateTime();
        $datetime->setTimestamp($this->timestamp);
        return $datetime;
    }

    public function rawPayload(): string
    {
        return $this->fixtureFile;
    }
}