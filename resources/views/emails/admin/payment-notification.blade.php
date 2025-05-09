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
        .success { color: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Payment Received</h2>
        </div>
        
        <div class="content">
            <p>A payment has been received for an LEI registration.</p>
            
            <div class="details">
                <h3>Payment Details</h3>
                <table>
                    <tr>
                        <td width="40%"><strong>Reference:</strong></td>
                        <td>LEI-{{ $contact->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Legal Entity Name:</strong></td>
                        <td>{{ $contact->legal_entity_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Amount:</strong></td>
                        <td>€{{ number_format($paymentIntent->amount / 100, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment ID:</strong></td>
                        <td>{{ $paymentIntent->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment Method:</strong></td>
                        <td>{{ ucfirst($paymentIntent->payment_method_types[0] ?? 'card') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td><span class="success">{{ ucfirst($paymentIntent->status) }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{ now()->format('Y-m-d H:i:s') }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="details">
                <h3>Customer Details</h3>
                <table>
                    <tr>
                        <td width="40%"><strong>Name:</strong></td>
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
                        <td><strong>Plan:</strong></td>
                        <td>{{ $contact->selected_plan }}</td>
                    </tr>
                </table>
            </div>
            
            <p>This registration now requires LEI issuance processing.</p>
            <p><a href="{{ route('admin.contacts') }}">Go to Admin Panel</a></p>
        </div>
    </div>
</body>
</html>