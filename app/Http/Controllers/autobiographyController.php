<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class autobiographyController extends Controller
{
    function index(){
        return view("autobiographyIndex");
    }
}
