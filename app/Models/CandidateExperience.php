<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateExperience extends Model
{
      use HasFactory;

      protected $table = "candidate_experience";

    protected $fillable = [
        'user_id',
        'company_name',
        'role',
        'months',
        'startdate',
        'enddate',
    ];

    protected $primaryKey = 'exp_id';

    public $incrementing = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
