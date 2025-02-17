<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    <p><strong>First Name:</strong> {{ $contact->first_name }}</p>
    <p><strong>Last Name:</strong> {{ $contact->last_name }}</p>
    <p><strong>Company Name:</strong> {{ $contact->company_name ?? 'N/A' }}</p>
    <p><strong>Country:</strong> {{ $contact->country }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Phone:</strong> {{ $contact->phone }}</p>
    <p><strong>Submitted on:</strong> {{ $contact->created_at->format('Y-m-d H:i') }}</p>
</body>
</html>
