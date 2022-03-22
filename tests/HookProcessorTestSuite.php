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

    public function testFlightArrived()
    {
        $processor = new HookProcessor();
        $webhook = new TestWebhookProvider(
            WebhookVariant::Airline,
            WebhookEvent::FlightArrived,
            1645612237,
            "Webhooks/1645612237_7124.json"
        );

        $processor->process($webhook);

        $this->assertEquals("02/23/2022 10:30:37", $processor->eventTime->format("m/d/Y H:i:s"));
        $this->assertEquals(WebhookEvent::FlightArrived, $processor->eventType);
        $this->assertEquals(WebhookVariant::Airline, $processor->variant);

        $arrival = $processor->flightArrived();

        $this->assertEquals(1645612237, $arrival->sent); // Test that the RAW UNIX timestamp is returned.
        $this->assertEquals("Airline", $arrival->variant); // The RAW event type is returned.

        $this->assertEquals(2198026, $arrival->data->id);
        $this->assertEquals(2558, $arrival->data->pilot->id);
        $this->assertEquals("thunfischbaum", $arrival->data->pilot->name);
        $this->assertEquals("fshub@thunfischbaum.de", $arrival->data->pilot->email);
        $this->assertEquals("https://fshub.ams3.digitaloceanspaces.com/avatars/u_2558_80.png?c=1645611016",
            $arrival->data->pilot->profile->avatarUrl);
        $this->assertEquals(
            "You might see this Bio Text update from time to time. If so, I'm just testing my Webhook integration. :D\r\nTesting the webhook rn. again.test test test",
            $arrival->data->pilot->profile->bio);

        $this->assertEquals("EDDH", $arrival->data->pilot->location->base);
        $this->assertEquals("EGPD", $arrival->data->pilot->location->locale);

        $this->assertNull($arrival->data->pilot->handles->website);
        $this->assertEquals("twitter.com/thunfischbaum", $arrival->data->pilot->handles->twitter);
        $this->assertNull($arrival->data->pilot->handles->facebook);
        $this->assertNull($arrival->data->pilot->handles->vatsim);
        $this->assertNull($arrival->data->pilot->handles->ivao);

        $this->assertEquals("Europe/Berlin", $arrival->data->pilot->timezone);
        $this->assertEquals("DE", $arrival->data->pilot->country);

        $this->assertEquals("A21N", $arrival->data->aircraft->icao);
        $this->assertEquals("Airbus A321 neo", $arrival->data->aircraft->icaoName);
        $this->assertEquals("ToLissA321_V1p3 easyJet", $arrival->data->aircraft->name);
        $this->assertEquals("ToLissA321_V1p3 easyJet", $arrival->data->aircraft->type);

        $this->assertEquals("", $arrival->data->aircraft->userConf->tailNumber);
        $this->assertEquals("", $arrival->data->aircraft->userConf->icao);

        $this->assertEquals(851, $arrival->data->airline->id);
        $this->assertEquals($arrival->data->pilot, $arrival->data->airline->owner);
        $this->assertEquals("FlyFuwu", $arrival->data->airline->name);
        $this->assertEquals(
            "Welcome to the FlyFuwu Airline. \r\nThis is the place where you pay low and we fly high!\r\nWe take you all around the work in all types of aircraft. \r\nTake your seat, fasten your seatbelt and enjoy the flight!",
            $arrival->data->airline->profile->bio);
        $this->assertEquals(
            "FUW",
            $arrival->data->airline->profile->abbreviation);
        $this->assertEquals("http://flyfuwu.de", $arrival->data->airline->handles->website);
        $this->assertEquals("https://twitter.com/thunfischbaum", $arrival->data->airline->handles->twitter);
        $this->assertNull($arrival->data->airline->handles->facebook);

        $this->assertEquals("EJU723", $arrival->data->plan->callSign);
        $this->assertEquals(340, $arrival->data->plan->cruiseLevel);
        $this->assertEquals("LEPA", $arrival->data->plan->departure);
        $this->assertEquals("EGKK", $arrival->data->plan->arrival);

        $this->assertNotNull($arrival->data->plan);

        $this->assertEquals("LEPA", $arrival->data->airport->icao);
        $this->assertEquals("PMI", $arrival->data->airport->iata);
        $this->assertEquals("Palma De Mallorca", $arrival->data->airport->name);
        $this->assertEquals("Palma De Mallorca", $arrival->data->airport->locale->city);
        $this->assertEquals("Spain", $arrival->data->airport->locale->country);
        $this->assertNull($arrival->data->airport->locale->state);
        $this->assertEquals("39.551674,2.738809", (string)$arrival->data->airport->locale->gps);

        $this->assertEquals(-6, $arrival->data->pitch);
        $this->assertEquals(0, $arrival->data->bank);
        $this->assertEquals(162, $arrival->data->speed);

        $this->assertEquals(0, $arrival->data->wind->speed);
        $this->assertEquals(15, $arrival->data->wind->direction);

        $this->assertEquals(9254, $arrival->data->weight->fuel);
        $this->assertEquals(69382, $arrival->data->weight->zfw);
        $this->assertEquals($arrival->data->weight->fuel + $arrival->data->weight->zfw,
            $arrival->data->weight->oew);

        $this->assertEquals(39.554392, $arrival->data->gps->latitude);
        $this->assertEquals(2.726016, $arrival->data->gps->longitude);
        $this->assertEquals("{\"lat\":39.554392,\"lng\":2.726016}", $arrival->data->gps->toJson());

        $this->assertEquals("02/23/2022 10:30:35", $arrival->data->createdAt->format("m/d/Y H:i:s"));

        $this->assertEquals(2558, $arrival->data->pilot->GetPilotId());
        $this->assertEquals(851, $arrival->data->airline->GetAirlineId());
        $this->assertEquals("LEPA", $arrival->data->airport->GetAirportIcao());

    }


}