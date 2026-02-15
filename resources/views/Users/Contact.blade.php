@extends('layouts.user')

@section('title', 'Contact')

@section('content')


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="display-5 fw-bold mb-4 text-center">Contact Us</h2>
            <p class="text-center text-secondary mb-5">
                Have questions or feedback? Send us a message and we’ll get back to you shortly.
            </p>


            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="Your Name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="Your Email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Subject --}}
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-semibold">Subject</label>
                            <input type="text" 
                                   name="subject" 
                                   id="subject" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   value="{{ old('subject') }}" 
                                   placeholder="Subject">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">Message</label>
                            <textarea name="message" 
                                      id="message" 
                                      rows="5" 
                                      class="form-control @error('message') is-invalid @enderror" 
                                      placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-dark btn-lg w-100 mt-3">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            {{-- Optional: Contact Info --}}
            <div class="row text-center mt-5">
                <div class="col-md-4 mb-3">
                    <i class="bi bi-geo-alt-fill fs-2 text-dark mb-2"></i>
                    <p class="mb-0">123 Tech Street, City, Country</p>
                </div>
                <div class="col-md-4 mb-3">
                    <i class="bi bi-telephone-fill fs-2 text-dark mb-2"></i>
                    <p class="mb-0">+91 12345 67890</p>
                </div>
                <div class="col-md-4 mb-3">
                    <i class="bi bi-envelope-fill fs-2 text-dark mb-2"></i>
                    <p class="mb-0">support@example.com</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

