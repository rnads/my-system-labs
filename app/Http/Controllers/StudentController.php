<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    /**
     * Show students.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        return view('dashboard.students.index');
    }
}
