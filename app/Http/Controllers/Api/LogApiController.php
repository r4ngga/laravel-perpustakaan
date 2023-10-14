<?php

namespace App\Http\Controllers\Api;

use App\Log;
use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LogApiController extends Controller
{
    public function getLogs()
    {
        $logs = Log::orderBy('created_at', 'desc')->get();
        $countlogs = count($logs);

        foreach($logs as $lg){
            $role = ($lg->role == 1)? 'admin' : 'user';
            $log[] = [
                'id' => $lg->id,
                'user_id' => $lg->user_id,
                'name' => $lg->user->name,
                'description' => $lg->description,
                'action' => $lg->action,
                'log_time' => $lg->log_time,
                'role' => $role,
                'data_new' => $lg->data_new,
                'data_old' => $lg->data_old,
                'created_at' => $lg->created_at,
            ];
        }

        if($countlogs > 0){
            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'success',
                'count_logs' => $countlogs,
                'data' => $log,
            );
        }else{
            $data = array(
                'status' => true,
                'code' => 404,
                'message' => 'logs not found',
                'count_logs' => 0,
            );
        }
        // dd($logs);
        return response()->json($data);
    }

    public function fetchGetLogs($id)
    {
        // $log = Log::findOrfail($id);
        $log = Log::where('id', $id)->get();

        $countlog = count($log);

        if($countlog > 0)
        {
            foreach($log as $lg){
                $detail = [
                    'id' => $lg->id,
                    'user_id' => $lg->user_id,
                    'action' => $lg->action,
                    'description' => $lg->description,
                    'role' => $lg->role,
                    'data_old' => $lg->data_old,
                    'data_new' => $lg->data_new,
                    'log_time' => $lg->log_time,
                    'created_at' => $lg->created_at,
                ];
            }

            $data = array(
                'status' => 200,
                'message' => 'success',
                'count_logs' => $countlog,
                'data' => $detail,
            );
        }else{
            $data = array(
                'status' => 404,
                'message' => 'not found',
                'count_logs' => 0
            );
        }

        return response()->json($data);
    }

    public function fetchLogsRole(Request $request)
    {
        $role = $request->role;

        $logs = Log::where('role', $role)->get();

        $countrole = count($logs);

        if($countrole > 0){
            
            foreach($logs as $lg)
            {
                $data = array(
                    'id' => $lg->id,
                    'user_id' => $lg->user_id,
                    'name' => $lg->user->name,
                    'description' => $lg->description,
                    'action' => $lg->action,
                    'log_time' => $lg->log_time,
                    'role' => $role,
                    'data_new' => $lg->data_new,
                    'data_old' => $lg->data_old,
                    'created_at' => $lg->created_at,
                );

                $log = array(
                    'status' => true,
                    'code' => 200,
                    'message' => 'success',
                    'counts' => $countrole,
                    'data' => $data
                );

            }
        }else{
            $log = array(
                'status' => false,
                'code' => 404,
                'message' => 'not found',
                'counts' => 0,
            );
        }

        return response()->json($log);

    }

    public function fetchLogsByAction(Request $request)
    {
        $action = $request->action;

        $logsaction = Log::where('action', $action)->get();

        $countLogsAct = count($logsaction);

        if($countLogsAct > 0){
            foreach($logsaction as $lg ){
                $detail = array(
                    'id' => $lg->id,
                    'user_id' => $lg->user_id,
                    'action' => $lg->action,
                    'description' => $lg->description,
                    'role' => $lg->role,
                    'data_old' => $lg->data_old,
                    'data_new' => $lg->data_new,
                    'log_time' => $lg->log_time,
                    'created_at' => $lg->created_at,
                );
            }

            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'success',
                'counts' => $countLogsAct,
                'data' => $detail,
            );

        }else{
            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'faill',
                'counts' => 0,
            );
        }

        return response()->json([$data]);
    }
}