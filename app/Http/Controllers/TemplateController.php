<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        // mengembalikan view resources/views/template/index.blade.php
        return view('template.index');
    }
}
