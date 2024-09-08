<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    function foodBeverage(){
        return view('pos.product')
        ->with('category','Food Beverage');
    }

    function beautyHealth(){
        return view('pos.product')
        ->with('category','Beauty Health');
    }

    function homeCare(){
        return view('pos.product')
        ->with('category','Home Care');
    }

    function babyKid(){
        return view('pos.product')
        ->with('category','Baby Kid');
    }
}
