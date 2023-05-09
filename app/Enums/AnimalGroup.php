<?php

namespace App\Enums;

enum AnimalGroup: int{
    case DOG = 1;
    case CAT = 2;
    
    public static function toArray(): array{
        return [
            [
                'value' => 1,
                'name' => 'DOG',
                'label' => 'Dog',
            ],
            [
                'value' => 2,
                'name' => 'CAT',
                'label' => 'Cat',
            ]
        ];
    }
    
    public function isDog() : bool { return $this === static::DOG; }
    public function isCat() : bool { return $this === static::CAT; }
    
    public function getLabelText(): string {
        return match($this){
            self::DOG => 'Dog',
            self::CAT => 'Cat',
        };
    }
    
    public function getLabelColor() : string{
        return match($this){
            self::DOG => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            self::CAT => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        };
    }
    
    public function getLabelHTML() : string{
        return sprintf(
            '<span class="rounded-md px-2 py-1 text-white %s">%s</span>', 
            $this->getLabelColor(), 
            $this->getLabelText()
        );
    }
}