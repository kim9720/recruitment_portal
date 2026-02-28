<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "jobs_to_applay";
    protected $primaryKey = 'job_id';
    public $incrementing = true; // or false if it's not auto-increment
    protected $keyType = 'int';
    protected $fillable = [
        'job_title',
        // 'slug',
        'category',
        'location',
        'jobfunction',
        'deadline',
        'minimumqualification',
        'experiencelenght',
        'introduction',
        'responsibilities',
        'skillset',
        'status',
        'created_by',
        'countview',
        'applications_count',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'deadline' => 'date',
        'is_featured' => 'boolean',
        'experiencelenght' => 'integer',
        'countview' => 'integer',
        'applications_count' => 'integer',
    ];

    /**
     * Get the user that created the job.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the job applications.
     */
    // public function applications(): HasMany
    // {
    //     return $this->hasMany(JobApplication::class);
    // }

    /**
     * Scope a query to only include active jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('application_deadline', '>=', Carbon::today());
    }

    /**
     * Scope a query to only include draft jobs.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include expired jobs.
     */
    public function scopeExpired($query)
    {
        return $query->where(function($query) {
            $query->where('status', 'expired')
                  ->orWhere('application_deadline', '<', Carbon::today());
        });
    }

    /**
     * Scope a query to filter by location.
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by job function.
     */
    public function scopeByFunction($query, $function)
    {
        return $query->where('jobfunction', $function);
    }

    /**
     * Scope a query to search by title or description.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($query) use ($term) {
            $query->where('title', 'LIKE', "%{$term}%")
                  ->orWhere('job_introduction', 'LIKE', "%{$term}%")
                  ->orWhere('responsibilities', 'LIKE', "%{$term}%")
                  ->orWhere('required_skills', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Check if the job is still active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' &&
               $this->application_deadline->isFuture();
    }

    /**
     * Check if the job is expired.
     */
    public function isExpired(): bool
    {
        return $this->status === 'expired' ||
               $this->application_deadline->isPast();
    }

    /**
     * Check if the job is a draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Get formatted experience length.
     */
    public function getFormattedExperienceAttribute(): string
    {
        if ($this->experience_length == 0) {
            return 'Fresh Graduate';
        } elseif ($this->experience_length == 1) {
            return '1 Year';
        } elseif ($this->experience_length >= 10) {
            return '10+ Years';
        } else {
            return $this->experience_length . ' Years';
        }
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'draft' => 'warning',
            'expired' => 'danger',
            'closed' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Get formatted application deadline.
     */
    public function getFormattedDeadlineAttribute(): string
    {
        return $this->application_deadline->format('M j, Y');
    }

    /**
     * Get days remaining until deadline.
     */
    public function getDaysRemainingAttribute(): int
    {
        return max(0, Carbon::today()->diffInDays($this->application_deadline, false));
    }
     public function getHashIdAttribute()
    {
        return Hashids::encode($this->job_id);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-expire jobs past their deadline
        static::updating(function ($job) {
            if ($job->deadline->isPast() && $job->status === 1) {
                $job->status = 3;
            }
        });
    }
}

