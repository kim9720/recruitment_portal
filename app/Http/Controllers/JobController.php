<?php

namespace App\Http\Controllers;

use App\Models\Job;
// use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function Illuminate\Log\log;

class JobController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = Job::where('status', 1);

        // Search filters
        if ($request->filled('jobfunction')) {
            $query->where('jobfunction', $request->jobfunction);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Optional: Search by job title or keywords
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('job_title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('introduction', 'like', '%' . $request->keyword . '%')
                    ->orWhere('responsibilities', 'like', '%' . $request->keyword . '%')
                    ->orWhere('skills', 'like', '%' . $request->keyword . '%');
            });
        }

        // Get jobs with pagination (10 per page)
        $joblist = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Preserve query parameters in pagination links

        // Get filter counts for UI
        $totalJobs = Job::where('status', 1)->count();
        $filteredJobs = $query->count();

        return view('jobs.index', compact('joblist', 'totalJobs', 'filteredJobs'));
    }

    public function jobList(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Default 10 per page
        $jobs = Job::paginate($perPage);
        return view('jobs.joblist', compact('jobs'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category' => 'required|in:Full Time,Part Time,Freelance,Internship,Temporary',
            'location' => 'required|string|max:100',
            'jobfunction' => 'required|string|max:100',
            'deadline' => 'required|date|after:today',
            'minimumqualification' => 'required|string|max:100',
            'experiencelenght' => 'required|integer|min:0|max:50',
            'jobintro' => 'nullable|string|max:1000',
            'responsibilities' => 'required|string',
            'skillset' => 'required|string',
        ];

        $messages = [
            'title.required' => 'Job title is required.',
            'title.max' => 'Job title must not exceed 255 characters.',
            'category.required' => 'Please select a job category.',
            'category.in' => 'Please select a valid job category.',
            'location.required' => 'Please select a location.',
            'jobfunction.required' => 'Please select a job function.',
            'deadline.required' => 'Application deadline is required.',
            'deadline.after' => 'Application deadline must be a future date.',
            'minimumqualification.required' => 'Please select minimum qualification required.',
            'experiencelenght.required' => 'Please select required experience length.',
            'experiencelenght.integer' => 'Experience length must be a valid number.',
            'experiencelenght.min' => 'Experience length cannot be negative.',
            'experiencelenght.max' => 'Experience length cannot exceed 50 years.',
            'responsibilities.required' => 'Job responsibilities are required.',
            'skillset.required' => 'Required skills and competencies are required.',
        ];

        // If saving draft, adjust rules
        if ($request->has('savedraft')) {
            $rules['responsibilities'] = 'nullable|string';
            $rules['skillset'] = 'nullable|string';
            $rules['deadline'] = 'nullable|date|after:today';
        }

        $validated = $request->validate($rules, $messages);

        try {
            $status = $this->getJobStatus($request);

            $jobData = [
                'job_title' => trim($validated['title']),
                'category' => $validated['category'],
                'location' => $validated['location'],
                'jobfunction' => $validated['jobfunction'],
                'deadline' => $validated['deadline'] ?? null,
                'minimumqualification' => $validated['minimumqualification'],
                'experiencelenght' => (int) $validated['experiencelenght'],
                'introduction' => $validated['jobintro'] ?? null,
                'responsibilities' => $this->cleanHtmlContent($validated['responsibilities'] ?? ''),
                'skillset' => $this->cleanHtmlContent($validated['skillset'] ?? ''),
                'status' => $status,
                // 'created_by' => Auth::id(),
                'countview' => 0,
                // 'applications_count' => 0,
                // 'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $job = Job::create($jobData);

            return $this->getSuccessResponse($request, $job);
        } catch (\Exception $e) {
            Log::error('Job creation failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->except(['_token'])
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while creating the job. Please try again.');
        }
    }


    private function getJobStatus(Request $request): string
    {
        if ($request->has('savepublish')) {
            return 1; // Active
        } elseif ($request->has('savedraft')) {
            return 2; // Draft
        } elseif ($request->has('expired')) {
            return 3; // Expired
        }

        // Default to draft if no specific action
        return 2; // Draft
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        // Check if slug already exists and make it unique
        while (Job::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }


    private function cleanHtmlContent(?string $content): ?string
    {
        if (empty($content)) {
            return null;
        }

        // Remove potentially harmful tags and attributes
        $allowedTags = '<p><br><strong><b><em><i><u><ul><ol><li><h3><h4><h5><h6><a><table><thead><tbody><tr><th><td>';

        $cleanContent = strip_tags($content, $allowedTags);

        // Remove empty paragraphs and normalize whitespace
        $cleanContent = preg_replace('/<p[^>]*>[\s]*<\/p>/', '', $cleanContent);
        $cleanContent = preg_replace('/\s+/', ' ', $cleanContent);

        return trim($cleanContent);
    }

    private function getSuccessResponse(Request $request, Job $job)
    {
        $messages = [
            'savepublish' => 'Job has been successfully created and published!',
            'savedraft' => 'Job has been saved as draft successfully!',
            'expired' => 'Job has been created and marked as expired.',
        ];

        $action = $this->getActionType($request);
        $message = $messages[$action] ?? 'Job has been created successfully!';

        // If it's an AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'job' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'status' => $job->status,
                    'slug' => $job->slug
                ]
            ]);
        }

        // For regular form submission
        return redirect()->route('jobs.list')->with('success', $message);
    }

    private function getActionType(Request $request): string
    {
        if ($request->has('savepublish')) {
            return 'savepublish';
        } elseif ($request->has('savedraft')) {
            return 'savedraft';
        } elseif ($request->has('expired')) {
            return 'expired';
        }

        return 'savedraft';
    }

    public function guestJobShow($id)
    {
        $job = Job::where('status', 1)->findOrFail($id);

        $relatedJobs = Job::where('status', 1)
            ->where('job_id', '!=', $id)
            ->where(function ($query) use ($job) {
                $query->where('category', $job->category)
                    ->orWhere('location', $job->location);
            })
            ->take(3)
            ->get();

        return view('jobs.gest_job_show', compact('job', 'relatedJobs'));
    }

    public function show($id)
    {
        // Increment view count
        $job = Job::findOrFail($id);
        $job->increment('countview');

        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job
     */
    public function edit($id)
    {
        // Check if user can edit this job
        // if ($job->created_by !== Auth::id()) {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified job in storage
     */
    public function update(Request $request, $id)
    {
        // Check if user can update this job
        // if ($job->created_by !== Auth::id()) {
        //     abort(403, 'Unauthorized action.');
        // }

        // Similar validation and update logic as store method
        // Implementation would be similar to store() but for updating
    }

    /**
     * Remove the specified job from storage
     */
    public function destroy($id)
    {
        // dd($id);
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('jobs.list')
            ->with('success', 'Job position has been deleted successfully!');
    }
}
