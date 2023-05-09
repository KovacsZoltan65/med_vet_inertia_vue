<?php

namespace App\Enums;

enum AnimalSex: int {
    
    case FEMALE = 1;
    case MALE = 2;
    
    public static function toArray(){
        return [
            [
                'value' => 1,
                'name' => 'FEMALE',
                'label' => 'Female',
            ],
            [
                'value' => 2,
                'name' => 'MALE',
                'label' => 'Male',
            ]
        ];
    }
    
    public function isFemale() : bool{ return $this === static::FEMALE; }
    public function isMale() : bool{ return $this === static::MALE; }
    
    public function getLabelText(): string {
        return match($this){
            self::FEMALE => 'Female',
            self::MALE => 'Male',
        };
    }
    
    public function getLabelColor() : string{
        return match($this){
            self::FEMALE => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            self::MALE   => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
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