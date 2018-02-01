<?php

namespace Vl\Basket;

use App\Http\Controllers\Controller;

class BasketController extends Controller{
    
    public function index(){
        $total = 0;
        return view('basket::basket', compact('total'));
    }
    
}

