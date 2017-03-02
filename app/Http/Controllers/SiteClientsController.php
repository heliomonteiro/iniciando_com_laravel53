<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteClientsController extends Controller
{
    public function create(){
    	return view('site.client');
    }

    public function store(Request $request){
    	return $request->get('value');
    }
}
