<?php

namespace App\Http\Controllers\ITSM\Pyrus\Helper;

class Helper
{
    //Константы для добавления полей задачи (fields). У каждого поля Pyrus уникальный ID

    //-----Forms-----
    public const CUSTOMER_APPEAL = 829354;

    //-----Places-----
    public const DANAFLEX_ALABUGA = ['item_id' => 81073935];
    public const DANAFLEX_NANO = ['item_id' => 81073933];

    //-----Ticket Sources-----
    public const FROM_EMAIL = ['item_id' => 85279511];
    public const FROM_PHONE = ['item_id' => 85279512];

    //-----Support Groups-----
    public const IT_SUPPORT_LOCAL = ['item_id' => 79788044];
    public const NAVISION_SUP = ['item_id' => 79734620];

    //-----Service catalogs-----
    public const IT_PURCHASES = ['item_id' => 79790260];
    public const CONNECT_VPN = ['item_id' => 152050036];

    //-----Choice status task-----
    public const CHOICE_NEW_TICKET = ['choice_id' => 5];
    public const CHOICE_IN_WORK = ['choice_id' => 2];

    //-----Field Id------
    public const TOPIC_FIELD = 3;
    public const DESCRIPTION_FIELD = 4;
    public const PLACE_FIELD = 41;

    public static function itemToName(int $id): string
    {
        return match ($id){
            81073935 => 'Danaflex Alabuga',
            81073933 => 'Danaflex Nano',
            85279511 => 'Form Email',
            85279512 => 'From Phone',
            79788044 => 'IT Support Local',
            79734620 => 'Navision Sup',
            79790260 => 'IT purchases',
            152050036 => 'Connect VPN',
            5 => 'New Ticket',
            2 => 'In Work',
            default => 'DEFAULT'
        };
    }

    public static function fieldToName(int $id): string
    {
        return match ($id){
            3 => 'topic',
            4 => 'description',
            6 => 'name',
            7 => 'email',
            10 => 'phone',
            19 => 'status',
            27 => 'solution',
            34 => 'support_group',
            37 => 'service_catalog',
            41 => 'place',
            61 => 'ticket_source',
            63 => 'create_date',
            default => 'DEFAULT'
        };
    }
}
