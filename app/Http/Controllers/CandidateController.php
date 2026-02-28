<?php

namespace App\Http\Controllers;

use App\Models\CandidateApplyFor;
use App\Models\CandidateExperience;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = CandidateProfile::query();

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by education
        if ($request->filled('education')) {
            $query->where('highqualification', $request->education);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // Get unique values for filters
        $genders = CandidateProfile::select('gender')
            ->distinct()
            ->whereNotNull('gender')
            ->pluck('gender');

        $educations = CandidateProfile::select('highqualification')
            ->distinct()
            ->whereNotNull('highqualification')
            ->pluck('highqualification');

        // Pagination
        $perPage = $request->get('per_page', 10);
        $candidates = $query->latest()->paginate($perPage)->withQueryString();

        return view('candidates.index', compact('candidates', 'genders', 'educations'));
    }

    public function show($id)
    {
        $candidate = CandidateProfile::with([
            'educations' => function ($query) {
                $query->orderBy('educationstartdate', 'desc');
            },
            'experiences' => function ($query) {
                $query->orderBy('startdate', 'desc');
            },
            'referees',
            'documents'
        ])->findOrFail($id);

        return view('candidates.show', compact('candidate'));
    }

    public function destroy($id)
    {
        $candidate = CandidateProfile::findOrFail($id);
        $candidate->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidate profile deleted successfully.');
    }

    public function edit($id)
    {
        $candidate = CandidateProfile::findOrFail($id);
        return view('candidates.edit', compact('candidate'));
    }

    public function update(Request $request, $id)
    {
        $candidate = CandidateProfile::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidate_profiles,email,' . $candidate->id,
            'mobile' => 'required|string|max:20',
            // Add other fields and their validation rules as necessary
        ]);

        $candidate->update($validatedData);

        return redirect()->route('candidates.show', $candidate->id)->with('success', 'Candidate profile updated successfully.');
    }

    public function downloadDocument($candidateId, $documentId)
    {
        $candidate = CandidateProfile::findOrFail($candidateId);
        $document = $candidate->documents()->where('id', $documentId)->firstOrFail();

        return response()->download(storage_path('app/' . $document->file_path), $document->original_name);
    }

    public function personalDetails()
    {
        $id = Auth::user()->candidateProfile->id;
        $candidate = CandidateProfile::findOrFail($id);
        return view('candidates.personalDetails.index', compact('candidate'));
    }

    public function createPersonalDetails()
    {
        return view('candidates.personalDetails.create');
    }

    public function storePersonalDetails(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidate_profile,email,' . Auth::user()->candidateProfile->id,
            'mobile' => ['required', 'regex:/^(06|07)\d{8}$/'],
            'secondmobile' => ['nullable', 'regex:/^(06|07)\d{8}$/'],
            'reg_country' => 'required|string|max:255',
            'marital_status' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'id_number' => 'required|string|max:100',
            'passport_number' => 'nullable|string|max:100',
            'gender' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'candidate_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:200', // 200KB max
        ]);

        // Handle photo upload
        if ($request->hasFile('candidate_photo')) {
            $validatedData['candidate_photo'] = $request->file('candidate_photo')->store('candidate_photos', 'public');
        }

        $candidate = new CandidateProfile($validatedData);
        $candidate->user_id = Auth::user()->id;
        $candidate->save();

        return redirect()->route('candidate.personal_details.index')->with('success', 'Personal details added successfully.');
    }

    public function updatePersonalDetails(Request $request, $id)
    {
        $candidate = CandidateProfile::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidate_profile,email,' . $candidate->id,
            'mobile' => ['required', 'regex:/^(06|07)\d{8}$/'],
            'secondmobile' => ['nullable', 'regex:/^(06|07)\d{8}$/'],
            'reg_country' => 'required|string|max:255',
            'marital_status' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'id_number' => 'required|string|max:100',
            'passport_number' => 'nullable|string|max:100',
            'gender' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'candidate_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:200',
        ]);

        // Handle photo upload
        if ($request->hasFile('candidate_photo')) {
            // Delete old photo if exists
            if ($candidate->candidate_photo && Storage::disk('public')->exists($candidate->candidate_photo)) {
                Storage::disk('public')->delete($candidate->candidate_photo);
            }

            $validatedData['candidate_photo'] = $request->file('candidate_photo')->store('candidate_photos', 'public');
        }

        $candidate->update($validatedData);

        return redirect()->route('candidate.personal_details.index')->with('success', 'Personal details updated successfully.');
    }

    public function editPersonalDetails()
    {
        $candidate = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id);
        return view('candidates.personalDetails.create', compact('candidate'));
    }


    public function academicDetails()
    {
        $id = Auth::user()->candidateProfile->id;
        $academicDetails = CandidateProfile::with('educations')->findOrFail($id)
            ->educations;
        return view('candidates.academicDetails.index', compact('academicDetails'));
    }

    public function storeAcademicDetails(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'educationlevel' => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'educationstartdate' => 'required|date',
            'educationenddate' => 'nullable|date|after_or_equal:educationstartdate',
            'score' => 'nullable|string|max:100',
            'certificate_path' => 'required|file|mimes:pdf|max:512', // 500 KB
            // Add other fields and their validation rules as necessary
        ]);

        $candidateId = Auth::user()->candidateProfile->id;
        $candidate = CandidateProfile::findOrFail($candidateId);
        if ($request->hasFile('certificate_path')) {
            $file = $request->file('certificate_path');
            $filePath = $file->store('education_certificates', 'public');
            $validatedData['certificate_path'] = $filePath;
        }

        $candidate->educations()->create($validatedData);

        return redirect()->route('candidate.academic_details.index')->with('success', 'Academic details added successfully.');
    }
    public function editAcademicDetails($id)
    {
        $education = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id)
            ->educations()->where('id', $id)->firstOrFail();
        return view('candidates.academicDetails.index', compact('education'));
    }

    public function updateAcademicDetails(Request $request, $id)
    {
        $education = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id)
            ->educations()->where('rec_id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'educationlevel' => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'educationstartdate' => 'required|date',
            'educationenddate' => 'nullable|date|after_or_equal:educationstartdate',
            'score' => 'nullable|string|max:100',
            'certificate_path' => 'nullable|file|mimes:pdf|max:512', // 500 KB
            // Add other fields and their validation rules as necessary
        ]);

        if ($request->hasFile('certificate_path')) {
            // Delete existing file if present
            if ($education->certificate_path) {
                Storage::disk('public')->delete($education->certificate_path);
            }

            $file = $request->file('certificate_path');
            $filePath = $file->store('education_certificates', 'public');
            $validatedData['certificate_path'] = $filePath;
        }

        $education->update($validatedData);

        return redirect()->route('candidate.academic_details.index')->with('success', 'Academic details updated successfully.');
    }
    public function destroyAcademicDetails($id)
    {
        $education = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id)
            ->educations()->where('rec_id', $id)->firstOrFail();
        $education->delete();

        return redirect()->route('candidate.academic_details.index')->with('success', 'Academic details deleted successfully.');
    }

    public function candidateReferences()
    {
        $id = Auth::user()->candidateProfile->id;
        $referees = CandidateProfile::with('referees')->findOrFail($id)
            ->referees;
        return view('candidates.referees.index', compact('referees'));
    }

    public function storeCandidateReference(Request $request)
    {
        $validatedData = $request->validate([
            'refereename' => 'required|string|max:255',
            'organisation' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'refereeaddress' => 'nullable|string|max:500',
            'refereeemail' => 'nullable|email|max:255',
            // Add other fields and their validation rules as necessary
        ]);

        $candidateId = Auth::user()->candidateProfile->id;
        $candidate = CandidateProfile::findOrFail($candidateId);

        $candidate->referees()->create($validatedData);

        return redirect()->route('candidate.referees.index')->with('success', 'Referee added successfully.');
    }

    public function updateCandidateReference(Request $request, $id)
    {
        $referee = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id)
            ->referees()->where('id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'refereename' => 'required|string|max:255',
            'organisation' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'refereeaddress' => 'nullable|string|max:500',
            'refereeemail' => 'nullable|email|max:255',
            // Add other fields and their validation rules as necessary
        ]);

        $referee->update($validatedData);

        return redirect()->route('candidate.referees.index')->with('success', 'Referee updated successfully.');
    }

    public function destroyCandidateReference($id)
    {
        $referee = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id)
            ->referees()->where('id', $id)->firstOrFail();
        $referee->delete();

        return redirect()->route('candidate.referees.index')->with('success', 'Referee deleted successfully.');
    }

    public function attachments()
    {
        $id = Auth::user()->candidateProfile->id;
        $documents = CandidateProfile::with('documents')->findOrFail($id)
            ->documents;
        return view('candidates.attachments.index', compact('documents'));
    }

    public function storeAttachment(Request $request)
    {
        $validatedData = $request->validate([
            'document_type' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $candidateId = Auth::user()->candidateProfile->id;
        $candidate = CandidateProfile::findOrFail($candidateId);

        $filePath = null;

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filePath = $file->store('candidate_documents', 'public');
        }

        $candidate->documents()->create([
            'document_name' => $validatedData['document_type'],
            'document_file' => $filePath,
        ]);

        return redirect()
            ->route('candidate.attachments.index')
            ->with('success', 'Document uploaded successfully.');
    }

    public function updateAttachment(Request $request, $id)
    {
        $document = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id)
            ->documents()->where('id', $id)->firstOrFail();

        $validatedData = $request->validate([
            'document_name' => 'required|string|max:255',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filePath = $file->store('candidate_documents');

            $validatedData['document_file'] = $filePath;
        }

        $document->update($validatedData);

        return redirect()->route('candidate.attachments.index')->with('success', 'Document updated successfully.');
    }

    public function destroyAttachment($id)
    {
        $document = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id)
            ->documents()->where('id', $id)->firstOrFail();
        $document->delete();

        return redirect()->route('candidate.attachments.index')->with('success', 'Document deleted successfully.');
    }

    public function workExperience()
    {
        $id = Auth::user()->candidateProfile->id;
        $experiences = CandidateProfile::with('experiences')->findOrFail($id)
            ->experiences;
        return view('candidates.workExperience.index', compact('experiences'));
    }
    public function createWorkExperience()
    {
        return view('candidates.workExperience.create');
    }
    public function storeWorkExperience(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'startdate' => 'required|date',
            'enddate' => 'nullable|date|after_or_equal:startdate',
            'months' => 'required|integer|min:1',
        ]);

        $validatedData['user_id'] = Auth::id();
        CandidateExperience::create($validatedData);
        return redirect()->route('candidate.work_experience.index')
            ->with('success', 'Work experience added successfully.');
    }
    public function editWorkExperience($id)
    {
        $experience = CandidateProfile::findOrFail(Auth::user()->candidateProfile->id)
            ->experiences()->where('id', $id)->firstOrFail();
        return view('candidates.workExperience.edit', compact('experience'));
    }

    public function updateWorkExperience(Request $request, $id)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'startdate' => 'required|date',
            'enddate' => 'nullable|date|after_or_equal:startdate',
            'months' => 'required|integer|min:1',
        ]);

        $experience = CandidateExperience::where('exp_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $experience->update($validatedData);

        return redirect()->route('candidate.work_experience.index')
            ->with('success', 'Work experience updated successfully.');
    }
    public function destroyWorkExperience($id)
    {
        $experience = CandidateExperience::where('exp_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $experience->delete();

        return redirect()->route('candidate.work_experience.index')
            ->with('success', 'Work experience deleted successfully.');
    }

    public function vacancies(Request $request)
    {
        $query = Job::where('status', 1);
        $totalJobs = $query->count();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'LIKE', "%{$search}%")
                    ->orWhere('introduction', 'LIKE', "%{$search}%")
                    ->orWhere('responsibilities', 'LIKE', "%{$search}%")
                    ->orWhere('skillset', 'LIKE', "%{$search}%");
            });
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }
        $perPage = $request->input('per_page', 10);
        $vacancies = $query->latest('created_at')->paginate($perPage);
        $vacancies->appends($request->except('page'));
        return view('candidates.vacancies.index', compact('vacancies', 'totalJobs'));
    }

    public function showVacancy($id)
    {
        $id = Hashids::decode($id)[0] ?? null;

        if (!$id) {
            abort(404);
        }
        $vacancy = Job::find($id);
        if (!$vacancy) {
            abort(404);
        }

        return view('candidates.vacancies.show', compact('vacancy'));
    }

    public function applyForVacancy(Request $request, $hashId)
    {
        $request->validate([
            'application_letter' => 'required|file|mimes:pdf|max:1020', // 1MB
            'expected_salary' => 'nullable|numeric|min:0',
            'confirmation' => 'required|accepted'
        ]);

        $id = Hashids::decode($hashId)[0] ?? null;

        if (!$id) {
            abort(404);
        }

        $vacancy = Job::findOrFail($id);

        $existingApplication = CandidateApplyFor::where('job_id', $vacancy->job_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return redirect()->route('candidate.vacancies.show', $hashId)
                ->with('error', 'You have already applied for this position.');
        }

        $file = $request->file('application_letter');
        $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('applications', $fileName, 'public');

        CandidateApplyFor::create([
            'job_id' => $vacancy->job_id,
            'user_id' => Auth::id(),
            'cover_letter' => $filePath,
            'expected_salary' => $request->expected_salary,
            'applied_date' => now(),
        ]);

        $vacancy->increment('applications_count');

        return redirect()->route('candidate.vacancies.show', $hashId)
            ->with('success', 'Application submitted successfully! Good luck!');
    }

    public function myApplications(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $applications = CandidateApplyFor::with('job')
            ->where('user_id', Auth::id())
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('applied_date', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('candidates.vacancies.my_applications', compact('applications'));
    }
}
