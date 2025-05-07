<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Volunteer extends Model
{
    /** @use HasFactory<\Database\Factories\VolunteerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cleanup_areas',
        'status',
        'volunteer_date',
        'hours_committed',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'volunteer_date' => 'date_time',
    ];

    /**
     * Get the user that owns the volunteer sign-up.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cleanupArea(): BelongsTo
    {
        return $this->belongsTo(CleanupArea::class);
    }
}
