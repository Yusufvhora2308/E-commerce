@extends('layouts.app')

@section('title','Feedback')

@section('content')

<style>
    .feedback-card {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: 0.2s;
    }

    .feedback-card:hover {
        transform: scale(1.01);
    }

    .table thead th {
        background: #212529 !important;
        color: #fff;
        font-size: 14px;
        text-transform: uppercase;
        padding: 12px;
    }

    .page-title {
        font-size: 26px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<div class="container mt-4 d-flex justify-content-center">
    <div class="feedback-card w-100">

        <h2 class="page-title">Feedback / Contact List</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th width="120px">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($contacts as $contact)
                <tr>
                  <td>{{ ($contacts->currentPage() - 1) * $contacts->perPage() + $loop->iteration }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->subject }}</td>
                    <td>{{ Str::limit($contact->message, 50) }}</td>

                    <td class="text-center">
                        <a href="{{ route('feedback.show', $contact->id) }}" 
                           class="btn btn-primary btn-sm">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $contacts->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
