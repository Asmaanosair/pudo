<?php


namespace App\Enums;


abstract class ContractType
{
    const Full_Time = 'full_time';
    const Free_Lance = 'free_lance';
    const Contract_Type=[
        self::Full_Time,
        self::Free_Lance,
    ];
}
