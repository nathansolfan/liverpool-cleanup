<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'amount',
        'frequency',
        'payment_method',
        'name',
        'email',
        'stripe_payment_id',
        'status',
    ];

    /**
     * Get the user that made the donation.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
