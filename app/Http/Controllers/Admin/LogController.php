<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Book_Borrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::orderBy('created_at', 'desc')->get();
        $countLogs = count($logs);

        return view('logs.index', compact('logs', 'countLogs'));
    }

    public function fetchDetail($id)
    {
        $log = Log::findOrFail($id);

        return json_decode($log, true);
    }
}
