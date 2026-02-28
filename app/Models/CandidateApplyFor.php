<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CandidateApplyFor extends Model
{
    use HasFactory;

    protected $table = 'candidate_applyfor';
    protected $fillable = [
        'cover_letter',
        'expected_salary',
        'job_id',
        'user_id',
        'applied_date',
        'status',
        'reject_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class, 'user_id', 'user_id');
    }

    public function applicationLetterUrl()
    {
        return asset('storage/' . $this->cover_letter);
    }

    public function getHashIdAttribute()
    {
        return Hashids::encode($this->id);
    }
}
