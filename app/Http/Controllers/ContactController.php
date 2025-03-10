<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    private $planPrices = [
        '1-year' => 75.00,
        '3-years' => 165.00,
        '5-years' => 250.00
    ];

    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view('admin.contacts', compact('contacts'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'country' => 'required',
                'full_name' => 'required',
                'legal_entity_name' => 'required|string|max:255', // добавляем это поле
                'registration_id' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'zip_code' => 'required',
                'selected_plan' => 'required|in:1-year,3-years,5-years',
                'same_address' => 'required|boolean',
                'private_controlled' => 'required|boolean',
                'terms' => 'required|accepted',
                'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
            ]);

            // Преобразование строковых значений в булевы
            $same_address = filter_var($request->input('same_address'), FILTER_VALIDATE_BOOLEAN);
            $private_controlled = filter_var($request->input('private_controlled'), FILTER_VALIDATE_BOOLEAN);

            $contact = Contact::create([
                'country' => $validatedData['country'],
                'full_name' => $validatedData['full_name'],
                'legal_entity_name' => $validatedData['legal_entity_name'], // добавляем это поле
                'registration_id' => $validatedData['registration_id'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'zip_code' => $validatedData['zip_code'],
                'selected_plan' => $validatedData['selected_plan'],
                'amount' => $this->planPrices[$validatedData['selected_plan']] ?? 0,
                'same_address' => $same_address,
                'private_controlled' => $private_controlled,
                'payment_status' => 'pending'
            ]);

            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('documents', 'public');
                $contact->document_path = $documentPath;
                $contact->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Your registration has been submitted successfully!',
                'contact_id' => $contact->id
            ]);

        } catch (\Exception $e) {
            Log::error('Contact creation error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while submitting your registration.',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            return view('admin.contact-details', compact('contact'));
        } catch (\Exception $e) {
            Log::error('Contact show error: ' . $e->getMessage());
            return redirect()->route('admin.contacts')->with('error', 'Contact not found');
        }
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            
            // Удаление файла документа, если он существует
            if ($contact->document_path) {
                Storage::disk('public')->delete($contact->document_path);
            }
            
            $contact->delete();
            
            return redirect()->route('admin.contacts')->with('success', 'Contact deleted successfully');
        } catch (\Exception $e) {
            Log::error('Contact deletion error: ' . $e->getMessage());
            
            return redirect()->route('admin.contacts')->with('error', 'Error deleting contact');
        }
    }

    public function export()
    {
        try {
            $contacts = Contact::all();
            
            $csvData = [];
            $headers = [
                'ID',
                'Country',
                'Full Name',
                'Registration ID',
                'Email',
                'Phone',
                'Address',
                'City',
                'ZIP Code',
                'Selected Plan',
                'Amount',
                'Same Address',
                'Private Controlled',
                'Payment Status',
                'Created At'
            ];
            
            $csvData[] = $headers;
            
            foreach ($contacts as $contact) {
                $csvData[] = [
                    $contact->id,
                    $contact->country,
                    $contact->full_name,
                    $contact->registration_id,
                    $contact->email,
                    $contact->phone,
                    $contact->address,
                    $contact->city,
                    $contact->zip_code,
                    $contact->selected_plan,
                    $contact->amount,
                    $contact->same_address ? 'Yes' : 'No',
                    $contact->private_controlled ? 'Yes' : 'No',
                    $contact->payment_status,
                    $contact->created_at
                ];
            }

            $filename = 'contacts_' . date('Y-m-d_His') . '.csv';
            $handle = fopen($filename, 'w');
            
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            
            fclose($handle);

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=' . $filename,
            ];

            return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Contact export error: ' . $e->getMessage());
            
            return redirect()->route('admin.contacts')->with('error', 'Error exporting contacts');
        }
    }
}