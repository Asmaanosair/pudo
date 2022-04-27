<?php


namespace App\Enums;


abstract class PaymentMethod
{
    const CASH_ON_DELIVERY = 1;
    const ONLINE_PAYMENT = 2;

    const STATUS_STRING = [
        self::CASH_ON_DELIVERY => 'CASH_ON_DELIVERY',
        self::ONLINE_PAYMENT => 'ONLINE_PAYMENT',
    ];
}
