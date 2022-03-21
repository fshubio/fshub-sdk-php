<?php

namespace FsHub\Sdk\Contracts;

use FsHub\Sdk\Types\WebhookEvent;
use FsHub\Sdk\Types\WebhookVariant;

interface FsHubWebhookInterface
{
    /**
     * The Webhook Variant.
     * @return WebhookVariant
     */
    public function variant(): WebhookVariant;

    /**
     * The Webhook Event Type.
     * @return WebhookEvent
     */
    public function event(): WebhookEvent;

    /**
     * The Webhook Sent (Server side) Time.
     * @return \DateTime
     */
    public function timeSent(): \DateTime;

    /**
     * The raw JSON Payload.
     * @return string
     */
    public function rawPayload(): string;

}