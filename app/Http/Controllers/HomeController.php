<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Photo;

class HomeController extends Controller
{
    public function index(){
        return Inertia::render("Front/FrontHome",[
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'role'=> auth()->user() ? auth()->user()->getRoleNames()->first() : null
        ]);
    }
}
