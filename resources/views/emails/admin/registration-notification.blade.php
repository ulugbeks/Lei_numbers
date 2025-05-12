<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; }
        .content { padding: 20px; }
        .details { background-color: #f8f9fa; padding: 15px; margin: 20px 0; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; }
        table td, table th { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New LEI Registration</h2>
        </div>
        
        <div class="content">
            <p>A new LEI registration has been submitted.</p>
            
            <div class="details">
                <h3>Registration Details</h3>
                <table>
                    <tr>
                        <td width="40%"><strong>Reference:</strong></td>
                        <td>LEI-{{ $contact->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{ $contact->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Legal Entity Name:</strong></td>
                        <td>{{ $contact->legal_entity_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Registration ID:</strong></td>
                        <td>{{ $contact->registration_id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Plan:</strong></td>
                        <td>{{ $contact->selected_plan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Contact Name:</strong></td>
                        <td>{{ $contact->full_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td>{{ $contact->phone }}</td>
                    </tr>
                    <tr>
                        <td><strong>Country:</strong></td>
                        <td>{{ $contact->country }}</td>
                    </tr>
                    <tr>
                        <td><strong>Address:</strong></td>
                        <td>{{ $contact->address }}, {{ $contact->city }}, {{ $contact->zip_code }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment Status:</strong></td>
                        <td>{{ ucfirst($contact->payment_status) }}</td>
                    </tr>
                </table>
            </div>
            
            <p>You can view this registration in the admin panel:</p>
            <p><a href="{{ route('admin.contacts') }}">Go to Admin Panel</a></p>
        </div>
    </div>
</body>
</html>