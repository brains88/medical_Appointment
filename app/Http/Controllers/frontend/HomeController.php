<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Patient, Doctor};
class HomeController extends Controller
{
    //
        public function index(){
         
            $doctors = Doctor::all();
    
            // Pass the data to the view
            return view('frontend.home', compact('doctors'));
        }
}
