<?php

namespace App\Enums;

enum UserRole: int {
    
    case ASSOCIATE = 1;
    case ADMINISTRATOR = 2;
    
    // Check if an enum instance (on the user model) is 'Administrator'
    public function isAdministrator() : bool{
        return $this === static::ADMINISTRATOR;
    }
    
    // Check if an enum instance (on the user model) is 'Manager'
    public function isManager() : bool{
        return $this === static::MANAGER;
    }
    
    // Provide additional information that can be consumed by the front-end
    public static function toAray() : array{
        return [
            [
                'id' => static::MANAGER,
                'name' => 'Manager',
                'icon' => 'fa-medal text-sky-500',
                'summary' => 'Lorem ipsum dolor sit amet, consectetur adipising elit, sed do eiusmod tempor',
            ], 
            [
                'id' => static::ADMINISTRATOR,
                'name' => 'Administrator',
                'icon' => 'fa-medal text-purple-500',
                'summary' => 'Lorem ipsum dolor sit amet, consectetur adipising elit, sed do eiusmod tempor',
            ]
        ];
    }
}