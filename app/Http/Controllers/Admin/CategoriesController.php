<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Categories ;
use App\Log;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Categories::all();
        $countCategories = Categories::count();
        return view('admin.categories.index', compact('categories', 'countCategories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();

        $validateData = $request->validate([
            'name' => 'required',
        ]);

        $categories = Categories::store([
            'name' => $request->name,
        ]);

        $last_categories = Categories::find($categories->id);

        //create logs
        $logs = new Log();
        $logs->user_id = $user->id_user;
        $logs->action = 'POST';
        $logs->description = 'add a new categories';
        $logs->role = $user->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($last_categories);
        $logs->save();

        return redirect()->back()->with('notify', 'Data a new category successfully insert !');
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();
        $request->validate([
            'name' => 'required'
        ]);

        $old_data = DB::table('categories')->where('id', $id)->where('deleted_at', null)->first();        

        $categories = DB::table('categories')->where('id', $id)->update([
            'name' => $request->name,
        ]);

        //create logs
        DB::table('logs')->create([
            'user_id' => $user->id_user,
            'action' => 'PUT',
            'description' => 'update a category',
            'role' => $user->role,
            'log_time' => $now,            
            'data_old' => $categories,
            'data_new' => $old_data,

        ]);
        //create logs

        return redirect()->back()->with('notify', 'Data a category successfully change !');
    }

    public function delete($id)
    {
        $user = Auth::user();
        $now = Carbon::now();
        $old_data = DB::table('categories')->where('id', $id)->where('deleted_at', null)->first();

        if(!$old_data)
        {
            return redirect()->back()->with('error', 'Category not found !!');
        }

        $delete_category = Categories::find($id);
        $delete_category->destroy();

        //create logs
        DB::table('categories')->create([
            'user_id' => $user->id_user,
            'action' => `DELETE`,
            'description' => 'delete a category',
            'role' => $user->role,
            'log_time' => $now,
            'data_old' => $old_data,
            'data_new' => '-',
        ]);
        //create logs

        return response()->json([
            'notify' => 'Success delete a category !!'
        ]);
    }
}