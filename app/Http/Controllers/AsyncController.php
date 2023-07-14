<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AsyncController extends Controller
{
    public function index(){
        return \Inertia\Inertia::render('async/asyncIndex');
    }
    
    public function get_data(){
        
        $users = [
            [
                'id' => 1,
                'name' => 'User 01',
                'email' => 'user01@company.com',
            ],
            [
                'id' => 2,
                'name' => 'User 02',
                'email' => 'user02@company.com',
            ],
            [
                'id' => 3,
                'name' => 'User 03',
                'email' => 'user03@company.com',
            ],
            [
                'id' => 4,
                'name' => 'User 04',
                'email' => 'user04@company.com',
            ],
            [
                'id' => 5,
                'name' => 'User 05',
                'email' => 'user05@company.com',
            ]
        ];
        
        sleep(10);
        
        $res = [
            'success' => true,
            'users' => $users
        ];
        return response()->json($res, Response::HTTP_OK);
    }
}
