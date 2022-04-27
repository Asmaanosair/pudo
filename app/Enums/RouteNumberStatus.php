<?php

namespace App\Enums;

 abstract class RouteNumberStatus
{
     const NEW = 1;
     const ACCEPTED = 2;
     const NOT_ACCEPT = 3;
     const COMPLETED = 4;
     const FAILED = 5;
     const ASSIGNED = 6;
     const STATUS_STRING = [
         self::NEW => 'NEW',
         self::ACCEPTED => 'ACCEPTED',
         self::NOT_ACCEPT => 'NOT_ACCEPT',
         self::COMPLETED => 'COMPLETED',
         self::FAILED => 'FAILED',
         self::ASSIGNED => 'ASSIGNED',

     ];
}
