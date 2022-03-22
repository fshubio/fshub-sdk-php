<?php

namespace FsHub\Sdk;

use FsHub\Sdk\Contracts\FsHubWebhookInterface;
use FsHub\Sdk\Exceptions\IncompatibleHookException;
use FsHub\Sdk\Payloads\FlightArrived;
use FsHub\Sdk\Payloads\FlightCompleted;
use FsHub\Sdk\Payloads\FlightDeparted;
use FsHub\Sdk\Payloads\FlightUpdated;
use FsHub\Sdk\Payloads\ProfileUpdated;
use FsHub\Sdk\Types\WebhookEvent;
use FsHub\Sdk\Types\WebhookVariant;

class HookProcessor
{
    /**
     * @var FsHubWebhookInterface
     */
    protected FsHubWebhookInterface $payload;

    /**
     *The processed webhook variant (eg. user, airline).
     * @var WebhookVariant
     */
    public readonly WebhookVariant $variant;

    /**
     * The processed webhook type (eg. profile.updated, flight.completed)
     * @var WebhookEvent
     */
    public readonly WebhookEvent $eventType;

    /**
     * The event timestamp (when this webhook was first generated).
     * @var \DateTime
     */
    public readonly \DateTime $eventTime;

    /**
     * The raw JSON payload.
     * @var string
     */
    public readonly string $rawPayload;

    /**
     * Create a new instance of the webhook processor.
     * @param FsHubWebhookInterface|null $payload Optionally process an inbound payload on instantiation.
     */
    public function __construct(?FsHubWebhookInterface $payload = null)
    {
        if ($payload) {
            $this->process($payload);
        }
    }

    /**
     * Process an inbound payload.
     * @param FsHubWebhookInterface $payload
     * @return HookProcessor
     */
    public function process(FsHubWebhookInterface $payload): HookProcessor
    {
        $this->payload = $payload;

        $this->variant = $this->payload->variant();
        $this->eventType = $this->payload->event();
        $this->eventTime = $this->payload->timeSent();
        $this->rawPayload = $this->payload->rawPayload();

        return $this;
    }

    /**
     * Forces exception handling for incompatible payload requests.
     * @param WebhookEvent $requiredType
     * @return void
     * @throws IncompatibleHookException
     */
    protected function requiresNamedEventType(WebhookEvent $requiredType): void
    {

        if (!isset($this->variant)) {
            throw new IncompatibleHookException("Hook has not yet been processed, did you forget to call process() on a hook first?");
        }

        if ($this->eventType->name !== $requiredType->name) {
            throw new IncompatibleHookException("Payload request for {$requiredType->name} is incompatible with the processed {$this->eventType->name} type.");
        }
    }

    /**
     *  Retrieve data entity for the "profile.updated" event type.
     * @return ProfileUpdated
     * @throws IncompatibleHookException
     */
    public function profileUpdated(): ProfileUpdated
    {
        $this->requiresNamedEventType(WebhookEvent::ProfileUpdated);
        return ProfileUpdated::fromJson($this->rawPayload);
    }

    /**
     * Retrieve data entity for the "flight.departed" event type.
     * @return FlightDeparted
     * @throws IncompatibleHookException
     */
    public function flightDeparted(): FlightDeparted
    {
        $this->requiresNamedEventType(WebhookEvent::FlightDeparted);
        return FlightDeparted::fromJson($this->rawPayload);
    }

    /**
     * Retrieve data entity for the "flight.arrived" event type.
     * @return FlightArrived
     * @throws IncompatibleHookException
     */
    public function flightArrived(): FlightArrived
    {
        $this->requiresNamedEventType(WebhookEvent::FlightArrived);
        return FlightArrived::fromJson($this->rawPayload);
    }

    /**
     * Retrieve data entity for the "flight.completed" event type.
     * @return FlightCompleted
     * @throws IncompatibleHookException
     */
    public function flightCompleted(): FlightCompleted
    {
        $this->requiresNamedEventType(WebhookEvent::FlightCompleted);
        return FlightCompleted::fromJson($this->rawPayload);
    }

    /**
     * Retrieve data entity for the "flight.updated" event type.
     * @return FlightUpdated
     * @throws IncompatibleHookException
     */
    public function flightUpdated(): FlightUpdated
    {
        $this->requiresNamedEventType(WebhookEvent::FlightUpdated);
        return FlightUpdated::fromJson($this->rawPayload);
    }
}
