<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateEducation extends Model
{
    use HasFactory;
    protected $table = 'candidate_education';
    protected $fillable = [
        'user_id',
        'institute',
        'year',
        'score',
        'type',
        'educationlevel',
        'specialization',
        'educationstartdate',
        'educationenddate',
        'certificate_path',
    ];

    protected $primaryKey = 'rec_id';

    public $incrementing = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
