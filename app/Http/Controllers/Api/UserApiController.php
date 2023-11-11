<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserApiController extends Controller
{
    public function getAllUsers()
    {
        $users = User::where('role', 2)->ge();
        $countuser = count($users);

        if($countuser > 0)
        {
            foreach($users as $usr) {
                $user = array(
                    'id_user' => $usr->id_user,
                    'name' => $usr->name,
                    'email' => $usr->email,
                    'phone_number' => $usr->phone_number,
                    'address' => $usr->address,
                    'gender' => $usr->gender,
                    'created_at' => $usr->created_at
                );
            }

            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'success get all users data',
                'counts' => $countuser,
                'data' => $user
            );
        }else{
            $data = array(
                'status' => false,
                'code' => 404,
                'message' => 'failed get all users data',
                'counts' => 0,
            );
        }

        return response()->json($data);
    }

    public function fetchByUser($id)
    {
        $user = User::where('id_user', $id)->first();

        $countuser = count($user);

        if($countuser > 0 )
        {
            foreach($user as $usr){
                $data = array(
                    'id_user' => $usr->id_user,
                    'name' => $usr->name,
                    'email' => $usr->email,
                    'phone_number' => $usr->phone_number,
                    'address' => $usr->address,
                    'gender' => $usr->gender,
                    'created_at' => $usr->created_at
                );

                $datauser = array(
                    'status' => true,
                    'code' => 200,
                    'message' => 'success. detail data found',
                    'counts' => $countuser,
                    'data' => $data
                );
            }
        }else{
            $datauser = array(
                'status' => false,
                'code' => 404,
                'message' => 'detail data user not found',
                'counts' => 0,
            );
        }

        return response()->json($datauser);
    }
}