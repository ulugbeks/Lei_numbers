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
        'company_excerpt_path', 
        'user_id_document_path',
        'type'
    ];

    protected $casts = [
        'same_address' => 'boolean',
        'private_controlled' => 'boolean',
        'amount' => 'decimal:2'
    ];

    // Add accessor methods for file URLs
    public function getCompanyExcerptUrlAttribute()
    {
        return $this->company_excerpt_path ? asset('storage/' . $this->company_excerpt_path) : null;
    }

    public function getUserIdDocumentUrlAttribute()
    {
        return $this->user_id_document_path ? asset('storage/' . $this->user_id_document_path) : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}