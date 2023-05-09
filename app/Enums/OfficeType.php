<?php

namespace App\Enums;

enum OfficeType: int {
    
    case IRODA = 1;
    case RECEPCIO = 2;
    case VARO = 3;
    case KOTOZO = 4;
    case MEGFIGYELO = 5;
    case MUTO = 6;
    
    public static function toArray(){
        return [
            [
                'value' => 1,
                'name' => 'IRODA',
                'label' => 'Iroda',
            ],
            [
                'value' => 2,
                'name' => 'RECEPCIO',
                'label' => 'Recepció',
            ],
            [
                'value' => 3,
                'name' => 'VARO',
                'label' => 'Váró',
            ],
            [
                'value' => 4,
                'name' => 'KOTOZO',
                'label' => 'Kötöző',
            ],
            [
                'value' => 5,
                'name' => 'MEGFIGYELO',
                'label' => 'Megfigyelő',
            ],
            [
                'value' => 6,
                'name' => 'MUTO',
                'label' => 'Műtó',
            ]
        ];
    }
    
    public function isIroda() : bool{ return $this === static::IRODA; }
    public function isRecepcio() : bool{ return $this === static::RECEPCIO; }
    public function isVaro() : bool{ return $this === static::VARO; }
    public function isKotozo() : bool{ return $this === static::KOTOZO; }
    public function isMegfigyelo() : bool{ return $this === static::MEGFIGYELO; }
    public function isMuto() : bool{ return $this === static::MUTO; }
    
    public function getLabelText(): string {
        return match($this){
            self::IRODA => 'Iroda',
            self::RECEPCIO => 'Recepció',
            self::VARO => 'Váró',
            self::KOTOZO => 'Kötöző',
            self::MEGFIGYELO => 'Megfigyelő',
            self::MUTO => 'Műtő',
        };
    }
    
    public function getLabelColor() : string{
        return match($this){
            self::IRODA => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::RECEPCIO => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::VARO => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::KOTOZO => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::MEGFIGYELO => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::MUTO => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
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