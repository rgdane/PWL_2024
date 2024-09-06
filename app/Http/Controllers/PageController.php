<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() {
        return 'Selamat Datang';
    }
    
    public function about() {
        return 'NIM : 2241760113 <br> Nama : Rega Dane Wijayanta';
    }
    
    public function articles($id) {
        return 'Halaman Artikel dengan ID '.$id;
    }
}
