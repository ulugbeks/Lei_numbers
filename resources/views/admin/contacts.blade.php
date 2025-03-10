@extends('layouts.admin')

@section('title', 'Contacts')

@section('content')
<div class="container mt-4" style="max-width:100%;">
    <h1>Contact Requests</h1>

    <!-- Кнопки для экспорта -->
    <div class="mb-3">
        <a href="{{ route('admin.contacts.export.csv') }}" class="btn btn-success">Export to CSV</a>
        <a href="{{ route('admin.contacts.export.xlsx') }}" class="btn btn-primary">Export to XLSX</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Country</th>
                <th>Full Name</th>
                <th>Company</th>
                <th>Registration ID</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{$contact->id}}</td>
                <td>{{$contact->country}}</td>
                <td>{{$contact->full_name}}</td>
                <td>{{ $contact->legal_entity_name ?: $contact->company_name }}</td>
                <td>{{$contact->registration_id}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->phone}}</td>
                <td>
                    {{$contact->address}}, {{$contact->city}}, {{$contact->zip_code}}
                </td>
                <td>{{$contact->selected_plan}}</td>
                <td>${{number_format($contact->amount, 2)}}</td>
                <td>
                    <span class="badge badge-{{$contact->payment_status == 'paid' ? 'success' : 'warning'}}">
                        {{$contact->payment_status}}
                    </span>
                </td>
                <td>{{$contact->created_at->format('Y-m-d')}}</td>
                <td>
                    <form action="{{route('admin.contact.destroy', $contact->id)}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <a href="{{ route('admin.contact.show', $contact->id) }}" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
