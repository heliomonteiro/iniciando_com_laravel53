<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function create(){
    	return view('client');
    }

    public function store(Request $request){
    	return $request->get('value');
    }
}
