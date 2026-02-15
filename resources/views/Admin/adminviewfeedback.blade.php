@extends('layouts.app')

@section('title','View Feedback')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-3">Feedback Details</h2>

    <div class="card shadow p-4">
        <p><strong>Name:</strong> {{ $contact->name }}</p>
        <p><strong>Email:</strong> {{ $contact->email }}</p>
        <p><strong>Subject:</strong> {{ $contact->subject }}</p>
        <p><strong>Message:</strong> {{ $contact->message }}</p>
    </div>

    <a href="{{ route('contact.index') }}" class="btn btn-secondary mt-3">Back</a>

</div>
@endsection
