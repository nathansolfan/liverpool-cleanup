<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CleanupArea extends Model
{
    protected $fillable = [
        "title",
        "description",
        "latitude",
        "longitude",
        "severity",
        "status",
        "user_id",
    ];

    public $timestamps = true; // Make sure this is true or not specified (true is default)


    /**
     * The user who reported this cleanup area
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
