<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Mail\ContactMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactsExport;

class ContactController extends Controller
{
    /**
     * Отображение заявок в админке
     */
    public function index()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts', compact('contacts'));
    }

    /**
     * Обработка формы: сохранение в базу и отправка email
     */
    public function submit(Request $request)
    {
        // Валидация данных
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'country' => 'required|string|max:2',
            'phone_code' => 'required|string|max:6',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        // Объединяем код страны с телефоном
        $formattedPhone = $request->phone_code . $request->phone;

        // Сохранение заявки в базе
        $contact = Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_name' => $request->company_name,
            'country' => $request->country,
            'email' => $request->email,
            'phone' => $formattedPhone, // Сохраняем телефон с кодом страны
        ]);

        // Отправка email админу
        Mail::to('islanderoc@gmail.com')->send(new ContactMail($contact));

        return redirect()->back()->with('success', 'Your message has been sent!');
    }

    /**
     * Удаление заявки
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('success', 'Contact deleted successfully.');
    }

    /**
     * Экспорт в CSV
     */
    public function exportCsv()
    {
        $contacts = Contact::all();
        $csvFileName = 'contacts_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$csvFileName\""
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['ID', 'First Name', 'Last Name', 'Company', 'Country', 'Email', 'Phone', 'Created At']);

        foreach ($contacts as $contact) {
            fputcsv($handle, [
                $contact->id,
                $contact->first_name,
                $contact->last_name,
                $contact->company_name ?? 'N/A',
                $contact->country,
                $contact->email,
                $contact->phone,
                $contact->created_at->format('Y-m-d H:i:s')
            ]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }

    /**
     * Экспорт в XLSX
     */
    public function exportXlsx()
    {
        return Excel::download(new ContactsExport, 'contacts_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
}
