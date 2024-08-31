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

    public function update(Request $request){}
}