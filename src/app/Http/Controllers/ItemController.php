<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function index() {
        return view('items.index');
    }

    public function show() {
        return view('items.show');
    }

    public function create() {
        return view('items.create');
    }
}