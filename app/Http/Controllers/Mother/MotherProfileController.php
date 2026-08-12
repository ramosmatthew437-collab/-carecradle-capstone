<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;

class MotherProfileController extends Controller
{
    public function index()
    {
        $mother = auth()->user()->mother;

        return view('mother.profile', compact('mother'));
    }
}