<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { font-size: 12px; text-align: center; margin-top: 30px; color: #6c757d; }
        .invoice { background-color: #f8f9fa; padding: 15px; margin: 20px 0; border-radius: 4px; }
        .success { color: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Payment Confirmation</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $contact->full_name }},</p>
            
            <p>Thank you for your payment. We're pleased to confirm that we've received your payment for the LEI registration for <strong>{{ $contact->legal_entity_name }}</strong>.</p>
            
            <div class="invoice">
                <h3>Payment Details</h3>
                <p><strong>Amount:</strong> €{{ number_format($paymentIntent->amount / 100, 2) }}</p>
                <p><strong>Date:</strong> {{ now()->format('Y-m-d') }}</p>
                <p><strong>Payment ID:</strong> {{ $paymentIntent->id }}</p>
                <p><strong>Status:</strong> <span class="success">Paid</span></p>
            </div>
            
            <p>What happens next?</p>
            <ol>
                <li>Our team will now review your application</li>
                <li>Your LEI will be registered with the Global LEI Foundation (GLEIF)</li>
                <li>You will receive your LEI number within 24 hours</li>
                <li>A confirmation email with your LEI details will be sent to you once the process is complete</li>
            </ol>
            
            <p>If you have any questions about your registration or need further assistance, please contact our support team at <a href="mailto:support@lei-register.co.uk">support@lei-register.co.uk</a>.</p>
            
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