<?php

namespace App\Http\Controllers;

class ActivityLogsController extends Controller
{
    public function index()
    {
        return view('users.activity-logs');
    }
}
