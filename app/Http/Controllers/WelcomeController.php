<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];
        
        $activeMenu = 'dashboard';
        
        return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function hello() {
        return 'Hello World';
    }

    public function greeting(){
        return view('blog.hello')
        ->with('name','Dane')
        ->with('occupation','Astronaut');
    }
}
