<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $joblist = Job::latest()->take(6)->get();
        // dd($joblist);
        return view('welcome', compact('joblist'));
    }
}
