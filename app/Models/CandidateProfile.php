<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $table = "candidate_profile";

    protected $fillable = [
        'user_id',
        'user_slug',
        'login_id',
        'first_name',
        'middle_name',
        'last_name',
        'landline',
        'address',
        'city',
        'email',
        'pin',
        'expectations',
        'resumefile',
        'mobile',
        'secondmobile',
        'applied_for',
        'status',
        'reg_country',
        'gender',
        'highqualification',
        'yearsofexperience',
        'passport_number',
        'id_number',
        'date_of_birth',
        'marital_status',
        'candidate_photo'
    ];

    /**
     * Get the user that owns the candidate profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all referees for the candidate.
     */
    public function referees()
    {
        return $this->hasMany(CandidateReferee::class, 'user_id', 'user_id');
    }

    /**
     * Get all documents for the candidate.
     */
    public function documents()
    {
        return $this->hasMany(CandidateDocument::class, 'user_id', 'user_id');
    }

    /**
     * Get all education records for the candidate.
     */
    public function educations()
    {
        return $this->hasMany(CandidateEducation::class, 'user_id', 'user_id');
    }

    public function educationCertificateLinks()
    {
        return $this->educations()
            ->whereNotNull('certificate_path')->get()->map(function ($education) {
                return [
                    'label' => $education->educationlevel,
                    'url'   => asset('storage/' . $education->certificate_path),
                ];
            });
    }

    /**
     * Get all experience records for the candidate.
     */
    public function experiences()
    {
        return $this->hasMany(CandidateExperience::class, 'user_id', 'user_id')
            ->orderBy('startdate', 'desc');
    }

    /**
     * Get the candidate's latest education record.
     */
    public function latestEducation()
    {
        return $this->hasOne(CandidateEducation::class, 'user_id', 'user_id')->latest();
    }

    /**
     * Get the candidate's latest experience record.
     */
    public function latestExperience()
    {
        return $this->hasOne(CandidateExperience::class, 'user_id', 'user_id')
            ->orderBy('startdate', 'desc');
    }

    /**
     * Get the candidate's current experience (if enddate is null or future).
     */
    public function currentExperience()
    {
        return $this->hasOne(CandidateExperience::class, 'user_id', 'user_id')
            ->whereNull('enddate')
            ->orWhere('enddate', '>=', now())
            ->orderBy('startdate', 'desc');
    }

    /**
     * Get the candidate's CV document.
     */
    public function cvDocument()
    {
        return $this->hasOne(CandidateDocument::class, 'user_id', 'user_id')
            ->where('document_name', 'cv')
            ->latest();
    }

    public function getCvUrlAttribute()
    {
        if ($this->cvDocument) {
            return asset('storage/' . $this->cvDocument->document_file);
        }
        return null;
    }

    public function getNidaUrlAttribute()
    {
        $nidaDoc = $this->documents()->where('document_name', 'National Identification')->latest()->first();
        if ($nidaDoc) {
            return asset('storage/' . $nidaDoc->document_file);
        }
        return null;
    }

    public function getBirthCertificateUrlAttribute()
    {
        $birthCertDoc = $this->documents()->where('document_name', 'Birth Certificate')->latest()->first();
        if ($birthCertDoc) {
            return asset('storage/' . $birthCertDoc->document_file);
        }
        return null;
    }

    /**
     * Scope to filter active candidates.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter by gender.
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope to filter by qualification.
     */
    public function scopeByQualification($query, $qualification)
    {
        return $query->where('highqualification', $qualification);
    }

    /**
     * Get full name attribute.
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name);
    }

    /**
     * Get total years of experience.
     */
    public function getTotalExperienceAttribute()
    {
        // Calculate from experience records (months column)
        $totalMonths = $this->experiences()->sum('months') ?? 0;
        $yearsFromMonths = round($totalMonths / 12, 1);

        // Return calculated years or fallback to yearsofexperience field
        return $yearsFromMonths > 0 ? $yearsFromMonths : ($this->yearsofexperience ?? 0);
    }

    /**
     * Get total months of experience.
     */
    public function getTotalExperienceMonthsAttribute()
    {
        return $this->experiences()->sum('months') ?? 0;
    }

    /**
     * Get formatted experience string (e.g., "5 years 3 months").
     */
    public function getFormattedExperienceAttribute()
    {
        $totalMonths = $this->total_experience_months;

        if ($totalMonths == 0) {
            return 'No experience';
        }

        $years = floor($totalMonths / 12);
        $months = $totalMonths % 12;

        $parts = [];
        if ($years > 0) {
            $parts[] = $years . ' ' . ($years == 1 ? 'year' : 'years');
        }
        if ($months > 0) {
            $parts[] = $months . ' ' . ($months == 1 ? 'month' : 'months');
        }

        return implode(' ', $parts);
    }

    public function getProfilePhotoAttribute()
    {
        if ($this->candidate_photo) {
            return asset('storage/' . $this->candidate_photo);
        }
        return asset('storage/candidate_photos/default_profile.jpg');
    }
}
