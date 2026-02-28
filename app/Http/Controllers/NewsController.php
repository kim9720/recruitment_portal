<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        // $news = News::orderBy("created_at","desc")->paginate(10);
          $announcements = [
        [
            'title' => 'System Maintenance',
            'content' => 'Our systems will undergo scheduled maintenance on Sunday at midnight. Expect downtime of about 2 hours.',
            'date' => '2025-09-18',
            'deadline' => null,
            'type' => 'notice'
        ],
        [
            'title' => 'Job Advertisement: Software Developer',
            'content' => 'We are hiring a Software Developer. Submit your application before the deadline.',
            'date' => '2025-09-10',
            'deadline' => '2025-09-30',
            'type' => 'advertisement'
        ],
        [
            'title' => 'Training Program',
            'content' => 'A new employee training program will be held next month. Details will be shared soon.',
            'date' => '2025-09-20',
            'deadline' => null,
            'type' => 'notice'
        ]
    ];
        return view("news.index" , compact("announcements"));
    }
}
