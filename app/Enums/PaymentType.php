<?php


namespace App\Enums;


 abstract class PaymentType
{
     const PAY_CASH = 1;
     const PAY_BY_DRIVER_WALLET = 2;
     const NOT_PAY= 3;
     const PAY_ON_PICKUP= 4;


     const STATUS_STRING = [
         self::PAY_CASH => 'PAY_CASH',
         self::PAY_BY_DRIVER_WALLET => 'PAY_BY_DRIVER_WALLET',
         self::NOT_PAY => 'NOT_PAY',
         self::PAY_ON_PICKUP => 'PAY_ON_PICKUP',

     ];

}
