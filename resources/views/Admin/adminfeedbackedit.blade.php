@extends('layouts.app')

@section('title','Feedback Edit')

@section('content')

<div class="container mt-4">
    <h2 class="fw-bold">Edit Feedback</h2>

    <form action="{{ route('contact.update', $contact->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Name</label>
            <input type="text" name="name" value="{{ $contact->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" value="{{ $contact->email }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Subject</label>
            <input type="text" name="subject" value="{{ $contact->subject }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Message</label>
            <textarea name="message" rows="5" class="form-control">{{ $contact->message }}</textarea>
        </div>

        <button class="btn btn-success px-4">Update</button>
        <a href="{{ route('contact.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>
@endsection
