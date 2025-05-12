<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { font-size: 12px; text-align: center; margin-top: 30px; color: #6c757d; }
        .btn { display: inline-block; background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>LEI Registration Confirmation</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $contact->full_name }},</p>
            
            <p>Thank you for registering for a Legal Entity Identifier (LEI) with us. We've received your application for <strong>{{ $contact->legal_entity_name }}</strong>.</p>
            
            <p>Here's a summary of your registration:</p>
            <ul>
                <li><strong>Legal Entity Name:</strong> {{ $contact->legal_entity_name }}</li>
                <li><strong>Registration ID:</strong> {{ $contact->registration_id }}</li>
                <li><strong>Plan:</strong> {{ $contact->selected_plan }}</li>
                <li><strong>Reference Number:</strong> LEI-{{ $contact->id }}</li>
            </ul>
            
            <p>The next step is to complete the payment process. You can do this by clicking the button below:</p>
            
            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ route('payment.show', ['id' => $contact->id]) }}" class="btn">Complete Payment</a>
            </p>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team at <a href="mailto:support@lei-register.co.uk">support@lei-register.co.uk</a>.</p>
            
            <p>Thank you for choosing our service for your LEI registration.</p>
            
            <p>Best regards,<br>LEI Register Team</p>
        </div>
        
        <div class="footer">
            <p>This email was sent to {{ $contact->email }}. If you didn't request this, please ignore this email.</p>
            <p>&copy; {{ date('Y') }} LEI Register. All rights reserved.</p>
        </div>
    </div>
</body>
</html>