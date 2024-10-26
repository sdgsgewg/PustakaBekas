<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home', [
            'title' => 'Home Page', 
            'books' => Book::latest()->get()
        ]);
    }
}
