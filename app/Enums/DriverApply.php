<?php


namespace App\Enums;


 abstract class DriverApply
{
     const NEW_APP = 1;
     const APPROVED_BY_SUPPLIER = 2;
     const APPROVED_BY_PUDO = 3;
     const REJECTED_BY_SUPPLIER = 4;
     const REJECTED_BY_PUDO = 5;

     const STATUS_STRING = [
         self::NEW_APP => 'NEW_APP',
         self::APPROVED_BY_SUPPLIER => 'APPROVED_BY_SUPPLIER',
         self::APPROVED_BY_PUDO => 'APPROVED_BY_PUDO',
         self::REJECTED_BY_SUPPLIER => 'REJECTED_BY_SUPPLIER',
         self::REJECTED_BY_PUDO => 'REJECTED_BY_PUDO',

     ];
}
