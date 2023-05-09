<?php

namespace App\Enums;

enum HumanType: int {
    
    case ADMIN = 1;
    case USER = 2;
    case ORVOS = 3;
    case ASSZISZTENS = 4;
    case RECEPCIOS = 5;
    case BETEGHORDO = 6;
    
    public static function toArray(){
        return [
            [
                'value' => 1,
                'name' => 'ADMIN',
                'label' => 'Admin',
            ],
            [
                'value' => 2,
                'name' => 'USER',
                'label' => 'User',
            ],
            [
                'value' => 3,
                'name' => 'ORVOS',
                'label' => 'Orvos',
            ],
            [
                'value' => 4,
                'name' => 'ASSZISZTENS',
                'label' => 'Asszisztens',
            ],
            [
                'value' => 5,
                'name' => 'RECEPCIOS',
                'label' => 'Recepciós',
            ],
            [
                'value' => 6,
                'name' => 'BETEGHORDO',
                'label' => 'Beteghordó',
            ]
        ];
    }
    
    public function isAdmin() : bool{ return $this === static::ADMIN; }
    public function isUser() : bool{ return $this === static::USER; }
    public function isOrvos() : bool{ return $this === static::ORVOS; }
    public function isAsszisztens() : bool{ return $this === static::ASSZISZTENS; }
    public function isRecepcios() : bool{ return $this === static::RECEPCIOS; }
    public function isBeteghordo() : bool{ return $this === static::BETEGHORDO; }
    
    public function getLabelText(): string {
        return match($this){
            self::ADMIN => 'Admin',
            self::USER => 'Recepció',
            self::ORVOS => 'Váró',
            self::ASSZISZTENS => 'Kötöző',
            self::RECEPCIOS => 'Megfigyelő',
            self::BETEGHORDO => 'Műtő',
        };
    }
    
    public function getLabelColor() : string{
        return match($this){
            self::ADMIN => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::USER => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::ORVOS => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::ASSZISZTENS => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::RECEPCIOS => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::BETEGHORDO => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        };
    }
    
    public function getLabelHTML() : string{
        
        return sprintf(
            '<span class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded %s">%s</span>', 
            $this->getLabelColor(), 
            $this->getLabelText()
        );
    }
    
}

