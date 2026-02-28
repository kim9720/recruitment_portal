<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function index(){
        // $announcements = Announcements::all();
        return view('announcements.index');
    }
}
