@php
// Check if there was a recent registration
$latestContact = \App\Models\Contact::latest()->first();

// If we have a recent contact, redirect to payment page
if ($latestContact && $latestContact->created_at->isAfter(now()->subMinutes(5))) {
    header('Location: ' . route('payment.show', ['id' => $latestContact->id]));
    exit;
}
@endphp


@extends('layouts.app')

@section('title', 'Form Information')

@section('content')

@include('partials.header')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-info-circle text-info" style="font-size: 64px;"></i>
                    </div>
                    
                    <h1 class="mb-4">Form Submission Information</h1>
                    
                    <p class="mb-4">{{ $message }}</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary me-2">Go to Home Page</a>
                        <a href="{{ route('registration-lei') }}" class="btn btn-outline-primary">Go to Registration Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

@endsection