<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\portfolioCategory;

class portfolioController extends Controller
{
    public function index(){     
        $portfolioCategory = portfolioCategory::all();
        return view("portfolioIndex", 
            [ 'portfolioCategory' => $portfolioCategory ]
        );
    }    
}
