<?php


namespace App\Enums;


abstract class AOrderStatus
{
    const NEW_ORDER = 1;
    const ASSIGNED_TO_DRIVER = 2;
    const DRIVER_ACCEPTED = 3;
    const DRIVER_REJECTED = 4;
    const TO_BE_PICKED_UP = 6;
    const PICKED_UP = 7;
    const TO_BE_DELIVERED = 8;
    const DELIVERED = 9;
    const RETURNED = 10;
    const FAILED_TO_RETURN = 5;
    const FAILED_TO_ASSIGN = 53;
    const CANCELED = 11;
    const FAILED = 68;
    const DAMAGED = 54;

    const STATUS_STRING = [
        self::NEW_ORDER => 'NEW_ORDER',
        self::ASSIGNED_TO_DRIVER => 'ASSIGNED_TO_DRIVER',
        self::DRIVER_ACCEPTED => 'DRIVER_ACCEPTED',
        self::DRIVER_REJECTED => 'DRIVER_REJECTED',
        self::TO_BE_PICKED_UP => 'TO_BE_PICKED_UP',
        self::PICKED_UP => 'PICKED_UP',
        self::TO_BE_DELIVERED => 'TO_BE_DELIVERED',
        self::DELIVERED => 'DELIVERED',
        self::RETURNED => 'RETURNED',
        self::FAILED_TO_RETURN => 'FAILED_TO_RETURN',
        self::FAILED_TO_ASSIGN => 'FAILED_TO_ASSIGN',
        self::CANCELED => 'CANCELED',
        self::FAILED => 'FAILED',
        self::DAMAGED => 'DAMAGED',
    ];
}
