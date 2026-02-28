<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CandidateDocument extends Model
{
    use HasFactory;

    protected $table = "candidate_documents";
    protected $fillable = [
        'document_name',
        'document_file',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDocumentUrlAttribute()
    {
        return $this->document_file
            ? Storage::url($this->document_file)
            : null;
    }
}
