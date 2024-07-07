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

        return view('admin.logs.index', compact('logs', 'countLogs'));
    }

    public function fetchDetail($id)
    {
        $log = Log::findOrFail($id);
        $role = ($log->role == 1)? 'admin' : 'user';
        $data = array(
            'id' => $log->id,
            'name_user' => $log->user->name,
            'user_id' =>$log->user->id_user,
            'action' => $log->action,
            'description' => $log->description,
            'role' => $role,
            'log_time' => $log->log_time,
            'data_old' => $log->data_old,
            'data_new' => $log->data_new,
            'created_at' => $log->created_at,
        );
        // dd($data);

        // return json_decode($data, true);
        return response()->json($data);
    }

    public function checkLogs(Request $request)
    {
        $role = $request->role;

        $rlogs = Log::where('role', $role)->get();

        foreach($rlogs as $rl){
            $data = array(
                'id' => $rl->id,
                'action' => $rl->description,
                'description' => $rl->description,
                'role' => $rlogs,
                'log_time' => $rl->log_time,
                'data_old' => $rl->data_old,
                'data_new' => $rl->data_new,
                'created_at' => $rl->created_at,
            );
        }
        
        // $data = array(
        //     'status' => 'success',
        // );

        return response()->json($data);
    }

    public function fetchByRole( Request $request)
    {
        $role = $request->role;
    }
}
