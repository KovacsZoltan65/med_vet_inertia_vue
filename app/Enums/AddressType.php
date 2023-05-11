<?php

namespace App\Enums;

enum AddressType: int
{
    case POST = 1;
    case CENTER = 2;
    case STORE = 3;
    
    public static function toArray() : array
    {
        return [
            [
                'value' => 1,
                'name' => 'POST',
                'label' => 'Post',
            ],
            [
                'value' => 2,
                'name' => 'CENTER',
                'label' => 'Center',
            ],
            [
                'value' => 3,
                'name' => 'STORE',
                'label' => 'Store',
            ]
        ];
    }
    
    public function isPost() : bool { return $this === static::POST; }
    public function isCenter() : bool { return $this === static::CENTER; }
    public function isStore() : bool { return $this === static::STORE; }
    
    public function getLabelText(): string {
        return match($this){
            self::POST => 'Post',
            self::CENTER => 'Center',
            self::STORE => 'Store',
        };
    }
    
    public function getLabelColor() : string{
        return match($this){
            self::PST => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            self::CENTER => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            self::STORE => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
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