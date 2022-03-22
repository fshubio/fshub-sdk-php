<?php

namespace FsHub\Sdk\Types;

enum WebhookEvent
{
case ProfileUpdated;
case FlightDeparted;
case FlightArrived;
case FlightCompleted;
case FlightUpdated;
    }
