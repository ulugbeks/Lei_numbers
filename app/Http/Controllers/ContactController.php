<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactsExport;

class ContactController extends Controller
{
    private $planPrices = [
        '1-year' => 75.00,
        '3-years' => 195.00,
        '5-years' => 275.00
    ];

    /**
     * Display a listing of contacts (Admin only)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // This is for admin panel - show all contacts
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view('admin.contacts', compact('contacts'));
    }

    /**
     * Store a newly created contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'country' => 'required',
                'full_name' => 'required',
                'legal_entity_name' => 'required|string|max:255',
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

            // Convert string values to boolean
            $same_address = filter_var($request->input('same_address'), FILTER_VALIDATE_BOOLEAN);
            $private_controlled = filter_var($request->input('private_controlled'), FILTER_VALIDATE_BOOLEAN);

            $contact = Contact::create([
                'country' => $validatedData['country'],
                'full_name' => $validatedData['full_name'],
                'legal_entity_name' => $validatedData['legal_entity_name'],
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
                'payment_status' => 'pending',
                'user_id' => Auth::check() ? Auth::id() : null, // Associate with logged-in user
                'type' => 'contact' // Default type for contact form submissions
            ]);

            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('documents', 'public');
                $contact->document_path = $documentPath;
                $contact->save();
            }

            // Send notification emails (optional)
            try {
                // You can send emails here if needed
            } catch (\Exception $mailException) {
                Log::error('Failed to send contact notification email: ' . $mailException->getMessage());
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
                'debug' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display the specified contact (Admin only)
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
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

    /**
     * Process LEI renewal (kept for backward compatibility)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function renew(Request $request)
    {
        try {
            $lei = $request->input('selected_lei');
            $period = $request->input('renewal_period', 1);
            
            if (empty($lei)) {
                return redirect()->back()->with('error', 'LEI code is required');
            }
            
            // Validate LEI format
            if (!preg_match('/^[A-Z0-9]{20}$/', $lei)) {
                return redirect()->back()->with('error', 'Invalid LEI format');
            }
            
            // Store renewal request in database
            $contact = new Contact();
            $contact->type = 'renewal';
            $contact->lei = $lei;
            $contact->renewal_period = $period;
            $contact->payment_status = 'pending';
            $contact->user_id = Auth::check() ? Auth::id() : null;
            $contact->save();
            
            // Redirect to payment page
            return redirect()->route('payment.show', [
                'id' => $contact->id
            ])->with('success', 'LEI renewal request received');
            
        } catch (\Exception $e) {
            \Log::error('LEI renewal error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during the renewal process');
        }
    }

    /**
     * Remove the specified contact (Admin only)
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            
            // Delete associated document if exists
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

    /**
     * Export contacts to CSV (Admin only)
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        try {
            $contacts = Contact::all();
            
            $csvData = [];
            $headers = [
                'ID',
                'User',
                'Type',
                'Country',
                'Full Name',
                'Legal Entity Name',
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
                    $contact->user ? $contact->user->name : 'Guest',
                    $contact->type,
                    $contact->country,
                    $contact->full_name,
                    $contact->legal_entity_name,
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

    /**
     * Export contacts to CSV format
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCsv()
    {
        return $this->export();
    }

    /**
     * Export contacts to XLSX format
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function exportXlsx()
    {
        try {
            return Excel::download(new ContactsExport, 'contacts_' . date('Y-m-d_His') . '.xlsx');
        } catch (\Exception $e) {
            Log::error('Contact XLSX export error: ' . $e->getMessage());
            
            return redirect()->route('admin.contacts')->with('error', 'Error exporting contacts to Excel format');
        }
    }

    /**
     * Get user's contacts (for authenticated users)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userContacts()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $contacts = Contact::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'contacts' => $contacts
        ]);
    }

    /**
     * Update payment status (Admin only)
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            
            $validatedData = $request->validate([
                'payment_status' => 'required|in:pending,paid,failed,refunded'
            ]);
            
            $contact->payment_status = $validatedData['payment_status'];
            $contact->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Payment status update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating payment status'
            ], 500);
        }
    }
}