<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'country',
        'full_name',
        'legal_entity_name',
        'registration_id',
        'email',
        'phone',
        'address',
        'city',
        'zip_code',
        'selected_plan',
        'amount',
        'same_address',
        'private_controlled',
        'payment_status',
        'document_path',
        'type'
    ];

    protected $casts = [
        'same_address' => 'boolean',
        'private_controlled' => 'boolean',
        'amount' => 'decimal:2'
    ];
}