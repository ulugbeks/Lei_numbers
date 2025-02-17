@extends('layouts.admin')

@section('title', 'Contacts')

@section('content')
<div class="container mt-4">
    <h1>Contact Requests</h1>

    <!-- Кнопки для экспорта -->
    <div class="mb-3">
        <a href="{{ route('admin.contacts.export.csv') }}" class="btn btn-success">Export to CSV</a>
        <a href="{{ route('admin.contacts.export.xlsx') }}" class="btn btn-primary">Export to XLSX</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Company</th>
                <th>Country</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->first_name }}</td>
                    <td>{{ $contact->last_name }}</td>
                    <td>{{ $contact->company_name ?? 'N/A' }}</td>
                    <td>{{ $contact->country }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
