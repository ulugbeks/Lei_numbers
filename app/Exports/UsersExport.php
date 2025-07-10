<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Username',
            'Email',
            'Full Name',
            'Company',
            'Phone',
            'Country',
            'City',
            'Status',
            'LEI Count',
            'Registration Date'
        ];
    }
    
    public function map($user): array
    {
        return [
            $user->id,
            $user->username,
            $user->email,
            $user->full_name,
            $user->company_name,
            $user->complete_phone,
            $user->country,
            $user->city,
            $user->is_active ?? true ? 'Active' : 'Inactive',
            $user->leiRegistrations()->count(),
            $user->created_at->format('Y-m-d H:i:s')
        ];
    }
}