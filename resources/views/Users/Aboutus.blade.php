@extends('layouts.user')

@section('title', 'About Us')

@section('content')

<style>
.product-category-card img{
    width:100px;
    height:100px;
    object-fit:cover;
    border-radius:8px;
}
.carousel-item img{
    position: relative;
    z-index: 2;
    pointer-events: auto;
}
.product-category-card img{
    width:100px;
    height:100px;
    object-fit:cover;
    border-radius:8px;
}

.product-category-card{
    transition:.2s ease-in-out;
}
.product-category-card:hover{
    transform:translateY(-5px);
    box-shadow:0 4px 15px rgba(0,0,0,.1);
}

.btn{
    z-index:10 !important;
    position:relative;
}
.product-category-card{
    transition:.2s ease-in-out;
}
.product-category-card:hover{
    transform:translateY(-5px);
    box-shadow:0 4px 15px rgba(0,0,0,.1);
}


/* Change arrow color */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);        /* white → black */
}

/* Background circle (optional) */
.carousel-control-prev,
.carousel-control-next {
    background: rgba(0,0,0,0.4);   /* dark bg */
    width: 45px;
    height: 45px;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

/* Hover effect */
.carousel-control-prev:hover,
.carousel-control-next:hover {
    background: rgba(0,0,0,0.7);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(0);   /* default white */
}


</style>

<div class="container py-5">
{{-- ================= HERO ELECTRONICS SLIDER ================= --}}
{{-- Slider --}}
<div id="electronicsSlider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

        @foreach($products as $key => $product)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="row align-items-center" style="min-height: 85vh; padding: 60px;">

                    <div class="col-md-6">
                        <p class="text-uppercase fw-bold text-secondary">New Arrival</p>
                        <h1 class="display-4 fw-bold">{{ $product->name }}</h1>
                        <p class="mt-3 text-muted">
                            {{ Str::limit(preg_replace('/&nbsp;|&#160;/', ' ', strip_tags($product->description)), 80) }}
                        </p>

                        <a href="{{ route('shop') }}" class="btn btn-dark btn-lg mt-3" style="z-index: 10; position: relative;">
                            Shop Now
                        </a>
                    </div>

                    <div class="col-md-6 text-center">
                        <a href="{{ route('product.show', $product->id) }}" class="nav-link">

                        @if($product->images->count())
                            <img src="{{ asset('uploads/products/'.$product->images->first()->image) }}" 
                                 class="img-fluid" style="max-height:400px; object-fit:cover;">
                        @elseif($product->image)
                            <img src="{{ asset('uploads/products/'.$product->image) }}" 
                                 class="img-fluid" style="max-height:400px; object-fit:cover;">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" 
                                 class="img-fluid" style="max-height:400px; object-fit:cover;">
                        @endif
                    </div>
</a>
                </div>
            </div>
        @endforeach

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#electronicsSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#electronicsSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
{{-- ================= HERO SLIDER END ================= --}}

<hr class="my-5">




{{-- ================= OUR STORY ================= --}}
<h2 class="display-5 fw-bold mb-4">OUR STORY</h2>
<p class="lead text-secondary mb-4">
    Welcome to our E-Commerce platform. We make the latest electronics accessible,
    affordable, and reliable for everyone.
</p>

<p class="text-secondary mb-5">
    We focus on quality, innovation, and customer satisfaction.
    Every product is carefully curated and tested.
</p>

<hr class="my-5">

{{-- ================= PRODUCT CATEGORIES ================= --}}
<h2 class="display-6 fw-bold text-center mb-5">EXPLORE OUR PRODUCTS</h2>

<div class="row row-cols-2 row-cols-md-5 g-4 text-center mb-5">

@php
$categories = [
    ['slug'=>'audio','img'=>'oppo4.png','name'=>'Audio & Airbuds'],
    ['slug'=>'mobile','img'=>'1764328372_laptop.jpg','name'=>'Smartphones'],
    ['slug'=>'laptop','img'=>'hp3.png','name'=>'Laptops'],
    ['slug'=>'gaming','img'=>'oppo3.jpg','name'=>'Gaming'],
    ['slug'=>'home-appliances','img'=>'REFRIGERATOR.jpeg','name'=>'Home Appliances'],
];
@endphp

@foreach($categories as $cat)
<div class="col">
    <a href="{{ route('shop',$cat['slug']) }}" class="text-decoration-none text-dark">
        <div class="bg-light p-3 border rounded-3 product-category-card">
            <img src="{{ asset('uploads/products/'.$cat['img']) }}" class="mb-2">
            <p class="fw-semibold small mb-0">{{ $cat['name'] }}</p>
        </div>
    </a>
</div>
@endforeach

</div>

</div>
@endsection
