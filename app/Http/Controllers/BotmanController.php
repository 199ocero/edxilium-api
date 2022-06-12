<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

class BotmanController extends Controller
{
    public function broadcastMessage(){
        DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

        // config
        $config =
        [
            'facebook' => [
                'token' => env('FB_PAGE_TOKEN'),
                'app_secret' => env('FB_APP_SECRET'),
                'verification'=>env('FB_VERIFY_TOKEN'),
            ]
        ];
        // Create BotMan instance
        $botman = BotManFactory::create($config);
        
        $botman->say("Hello👋! Wazzup",5395711423809806, FacebookDriver::class);

    }
}
