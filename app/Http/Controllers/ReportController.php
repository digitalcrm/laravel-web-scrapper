<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IvanoMatteo\LaravelDeviceTracking\Models\Device;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('report');
    }

    public function stats()
    {
        $devices = Device::latest()->paginate(20);
        return view('stats', compact('devices'));
    }
}
