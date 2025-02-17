<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'company_name',
        'registration_id',
        'country',
        'email',
        'phone',
        'plan',
        'total_price',
        'payment_status'
    ];
}
