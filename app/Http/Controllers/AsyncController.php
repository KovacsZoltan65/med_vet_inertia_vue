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
        
        return response()->json(['success' => 'OK'], Response::HTTP_OK);
    }
}
