<?php

use FsHub\Sdk\HookProcessor;
use FsHub\Sdk\Tests\Support\TestWebhookProvider;
use FsHub\Sdk\Types\WebhookEvent;
use FsHub\Sdk\Types\WebhookVariant;
use PHPUnit\Framework\TestCase;

class HookProcessorTestSuite extends TestCase
{

    public function testBasicInstantiation()
    {
        $processor = new HookProcessor(new TestWebhookProvider(
            WebhookVariant::User,
            WebhookEvent::FlightUpdated,
            1645713143,
            "Webhooks/FlightUpdated-1.json"
        ));

        $this->assertEquals(WebhookVariant::User, $processor->variant);
        $this->assertEquals(WebhookEvent::FlightUpdated, $processor->eventType);
        $this->assertEquals("14:32:23", $processor->eventTime->format("H:i:s"));
        $this->assertEquals("Thursday, 24 February 2022", $processor->eventTime->format("l, j F Y"));
    }


    public function testProfileUpdated()
    {

        $webhook = new TestWebhookProvider(
            WebhookVariant::User,
            WebhookEvent::ProfileUpdated,
            1645553446,
            "Webhooks/1645553446_1347.json"
        );

        $processor = new HookProcessor();

        $handled = $processor->process($webhook);

        $this->assertEquals("02/22/2022 18:10:46", $processor->eventTime->format("m/d/Y H:i:s"));
        $this->assertEquals(WebhookEvent::ProfileUpdated, $processor->eventType);
        $this->assertEquals(WebhookVariant::User, $processor->variant);

        $this->expectException(\FsHub\Sdk\Exceptions\IncompatibleHookException::class);
        $this->expectExceptionMessage("Payload request for FlightDeparted is incompatible with the processed ProfileUpdated type.");
        $departure = $handled->flightDeparted();

    }

    public function testProfileUpdatedProperties()
    {

        $processor = new HookProcessor();
        $webhook = new TestWebhookProvider(
            WebhookVariant::User,
            WebhookEvent::ProfileUpdated,
            1645553446,
            "Webhooks/1645553446_1347.json"
        );

        $processor->process($webhook);

        $profileUpdate = $processor->profileUpdated();

        $this->assertEquals(1645553446, $profileUpdate->sent); // Test that the RAW UNIX timestamp is returned.
        $this->assertEquals("User", $profileUpdate->variant); // The RAW event type is returned.

        $this->assertEquals(2, $profileUpdate->data->id);
        $this->assertEquals("Bobby Allen", $profileUpdate->data->name);
        $this->assertEquals("bobbyallen.uk@gmail.com", $profileUpdate->data->email);
        $this->assertEquals("https://fshub.ams3.digitaloceanspaces.com/avatars/u_2_80.png?c=1645553444",
            $profileUpdate->data->profile->avatarUrl);
        $this->assertEquals("Developer of FSHub and the LRM Client. Airbus A320 and GA virtual pilot!",
            $profileUpdate->data->profile->bio);

        $this->assertEquals("EGSS", $profileUpdate->data->locations->base);
        $this->assertEquals("EGSS", $profileUpdate->data->locations->locale);

        $this->assertNull($profileUpdate->data->handles->website);
        $this->assertEquals("@allebb87", $profileUpdate->data->handles->twitter);
        $this->assertNull($profileUpdate->data->handles->facebook);
        $this->assertEquals("1167426", $profileUpdate->data->handles->vatsim);
        $this->assertEquals("458562", $profileUpdate->data->handles->ivao);

        $this->assertEquals("Europe/London", $profileUpdate->data->timezone);
        $this->assertEquals("GB", $profileUpdate->data->country);
    }


}