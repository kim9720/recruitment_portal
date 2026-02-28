<?php

namespace App\Http\Controllers;

use App\Models\CandidateApplyFor;
use App\Models\Job;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = CandidateApplyFor::with(['user', 'job', 'candidateProfile']);


        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('candidateProfile', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }


        if ($request->filled('date_from')) {
            $query->whereDate('applied_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('applied_date', '<=', $request->date_to);
        }

        $jobs = Job::select('job_id', 'job_title')->get();
        $statuses = ['pending', 'reviewed', 'shortlisted', 'interview', 'rejected', 'accepted'];


        $perPage = $request->get('per_page', 10);
        $applications = $query->latest('applied_date')->paginate($perPage)->withQueryString();

        return view('applications.index', compact('applications', 'jobs', 'statuses'));
    }

    public function show($id)
    {
        $id = Hashids::decode($id)[0] ?? null;

        if (!$id) {
            abort(404);
        }
        $application = CandidateApplyFor::with(['user', 'job', 'candidateProfile.educations', 'candidateProfile.experiences', 'candidateProfile.referees'])
            ->findOrFail($id);
        return view('applications.show', compact('application'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = CandidateApplyFor::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,interview,rejected,accepted',
            'reject_reason' => 'nullable|string|max:200'
        ]);

        $application->update([
            'status' => $request->status,
            'reject_reason' => $request->status === 'rejected'
                ? $request->reject_reason
                : null
        ]);

        $message = match ($request->status) {
            'pending'     => 'Application marked as pending',
            'reviewed'    => 'Application marked as reviewed',
            'shortlisted' => 'Candidate shortlisted successfully',
            'interview'   => 'Candidate moved to interview stage',
            'accepted'    => 'Candidate accepted successfully',
            'rejected'    => 'Candidate rejected successfully',
            default       => 'Status updated successfully',
        };

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
