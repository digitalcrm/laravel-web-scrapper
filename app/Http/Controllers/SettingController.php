<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(string $value = null)
    {
        if ($value == 'vpn') {
            return view('setting.vpn');
        }

        return view('setting.cron');
    }
}
