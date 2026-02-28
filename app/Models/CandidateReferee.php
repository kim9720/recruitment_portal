<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateReferee extends Model
{
     use HasFactory;
    protected $table = "candidate_referees";
    protected $fillable = [
        'refereename',
        'organisation',
        'title',
        'telephone',
        'refereeaddress',
        'refereeemail',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
