<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'company_name',
        'phone_country_code',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'postal_code',
        'terms_accepted',
        'privacy_accepted',
        'terms_accepted_at',
        'privacy_accepted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'terms_accepted' => 'boolean',
            'privacy_accepted' => 'boolean',
            'terms_accepted_at' => 'datetime',
            'privacy_accepted_at' => 'datetime',
        ];
    }

    /**
     * Get all LEI registrations for the user
     */
    public function leiRegistrations()
    {
        return $this->hasMany(Contact::class, 'user_id');
    }

    /**
     * Get the user's full name
     */
    public function getFullNameAttribute()
    {
        $names = array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->suffix
        ]);
        
        return !empty($names) ? implode(' ', $names) : $this->name;
    }

    /**
     * Get the complete phone number with country code
     */
    public function getCompletePhoneAttribute()
    {
        if ($this->phone_country_code && $this->phone) {
            return $this->phone_country_code . ' ' . $this->phone;
        }
        return $this->phone;
    }

    /**
     * Get the complete address
     */
    public function getCompleteAddressAttribute()
    {
        $address_parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ]);
        
        return implode(', ', $address_parts);
    }

    /**
     * Set the name attribute based on first and last name
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        
        // If first_name and last_name are not set, try to parse from name
        if (empty($this->first_name) && empty($this->last_name) && !empty($value)) {
            $parts = explode(' ', $value);
            if (count($parts) >= 2) {
                $this->attributes['first_name'] = $parts[0];
                $this->attributes['last_name'] = $parts[count($parts) - 1];
                
                // If there are middle parts, combine them as middle name
                if (count($parts) > 2) {
                    $middle_parts = array_slice($parts, 1, -1);
                    $this->attributes['middle_name'] = implode(' ', $middle_parts);
                }
            } else {
                $this->attributes['first_name'] = $value;
            }
        }
    }
}