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
    }

    public function store(Request $request)
    {
        
    }
}