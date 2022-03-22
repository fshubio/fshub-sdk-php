<?php

namespace FsHub\Sdk;

use FsHub\Sdk\Contracts\FsHubWebhookInterface;
use FsHub\Sdk\Exceptions\IncompatibleHookException;
use FsHub\Sdk\Payloads\FlightArrived;
use FsHub\Sdk\Payloads\FlightDeparted;
use FsHub\Sdk\Payloads\ProfileUpdated;
use FsHub\Sdk\Types\WebhookEvent;
use FsHub\Sdk\Types\WebhookVariant;

class HookProcessor
{

    /**
     * @var FsHubWebhookInterface
     */
    protected FsHubWebhookInterface $_payload;

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
    public readonly string $payload;

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
        $this->_payload = $payload;

        $this->variant = $this->_payload->variant();
        $this->eventType = $this->_payload->event();
        $this->eventTime = $this->_payload->timeSent();
        $this->payload = $this->_payload->rawPayload();

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
     */
    public function profileUpdated(): ProfileUpdated
    {
        $this->requiresNamedEventType(WebhookEvent::ProfileUpdated);
        return ProfileUpdated::fromJson($this->payload);
    }

    /**
     * Retrieve data entity for the "flight.departed" event type.
     * @return FlightDeparted
     */
    public function flightDeparted(): FlightDeparted
    {
        $this->requiresNamedEventType(WebhookEvent::FlightDeparted);
        return FlightDeparted::fromJson($this->payload);
    }

    /**
     * Retrieve data entity for the "flight.arrived" event type.
     * @return FlightArrived
     */
    public function flightArrived(): FlightArrived
    {
        $this->requiresNamedEventType(WebhookEvent::FlightArrived);
        return FlightArrived::fromJson($this->payload);
    }

    /**
     * Retrieve data entity for the "flight.completed" event type.
     * @return FlightCompleted
     */
    public function flightCompleted(): FlightCompleted
    {
        $this->requiresNamedEventType(WebhookEvent::FlightCompleted);
    }

    /**
     * Retrieve data entity for the "flight.updated" event type.
     * @return FlightUpdated
     */
    public function flightUpdated(): FlightUpdated
    {
        $this->requiresNamedEventType(WebhookEvent::FlightUpdated);
    }


}