<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'selected_plan',
        'amount',
        'payment_status',
        'stripe_session_id'
    ];
}