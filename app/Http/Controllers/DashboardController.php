<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('candidate')) {
            $candidateData = $this->getCandidateDashboardData();
            $latestVacancies = $this->getLatestVacancies();
        }
        return view('dashboard', [
            'candidateData' => $candidateData ?? null,
            'latestVacancies' => $latestVacancies ?? null,
        ]);
    }

    public function getLatestVacancies()
    {
        $vacancies = Job::latest()->take(5)->get();
        return $vacancies;
    }

    public function getCandidateDashboardData()
    {
        $user = Auth::user();
        $candidateProfile = $user->candidateProfile;

        $data = [
            'profileCompletion' => 50,
            'applicationsCount' => 5,
            'interviewsCount' => 7,
            // Add more data as needed
        ];

        return $data;
    }
}
