<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Contact::all()->map(function ($contact) {
            return [
                'ID' => $contact->id,
                'First Name' => $contact->first_name,
                'Last Name' => $contact->last_name,
                'Company' => $contact->company_name ?? 'N/A',
                'Country' => $contact->country,
                'Email' => $contact->email,
                'Phone' => $contact->phone,
                'Created At' => $contact->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'First Name', 'Last Name', 'Company', 'Country', 'Email', 'Phone', 'Created At'];
    }
}
