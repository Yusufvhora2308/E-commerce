@extends('layouts.user')

@section('title','Quick View | '.$product->name)

@section('content')

<div class="container py-5">


    <div class="row">
        <div class="col-md-6 text-center">

            {{-- Main Image --}}
           @php
    $mainImage = $product->images->first()->image 
                ?? $product->image 
                ?? 'no-image.png';
@endphp

<img id="mainImage"
     src="{{ asset('uploads/products/'.$mainImage) }}"
     class="img-fluid mb-3"
     style="max-height:400px; object-fit:cover;">


            {{-- Thumbnails --}}
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                @php
                    $allImages = $product->images->pluck('image')->toArray();
                    if($product->image && !in_array($product->image, $allImages)){
                        array_unshift($allImages, $product->image);
                    }
                @endphp

                @foreach($allImages as $img)
                    <img src="{{ asset('uploads/products/'.$img) }}" 
                         class="thumb-image border rounded"
                         style="width:60px; height:60px; object-fit:cover; cursor:pointer;">
                @endforeach
            </div>

        </div>

        <div class="col-md-6">
            <h3>{{ $product->name }}</h3>
            <p class="text-muted">{{ strip_tags($product->description) }}</p>
            <h4>₹{{ number_format($product->price, 2) }}</h4>

     {{-- ACTION BUTTONS --}}
<div class="d-flex align-items-center gap-2 mb-3 mt-5">

    {{-- Back Button --}}
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>

    {{-- STOCK / CART --}}
    @if($product->stock <= 0)

        {{-- OUT OF STOCK --}}
        <button class="btn btn-secondary" disabled>
            <i class="bi bi-x-circle"></i> Out of Stock
        </button>

    @elseif(in_array($product->id, $cartProductIds ?? []))

        {{-- GO TO CART --}}
        <a href="{{ route('cart') }}" class="btn btn-success">
            <i class="bi bi-cart-check"></i> Go to Cart
        </a>

    @else

        {{-- ADD TO CART --}}
        <form id="addToCartForm-{{ $product->id }}"
              action="{{ route('cart.add', $product->id) }}"
              method="POST">
            @csrf
            <button type="button"
                class="btn btn-dark add-to-cart-btn"
                data-id="{{ $product->id }}"
                data-cart-url="{{ route('cart') }}">
                <i class="bi bi-bag-plus"></i> Add to Cart
            </button>
        </form>

    @endif

</div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){

    // Thumbnail click
    document.querySelectorAll('.thumb-image').forEach(function(img){
        img.addEventListener('click', function(){
            document.getElementById('mainImage').src = this.src;
        });
    });

    // Add to cart button
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(){

            const id = btn.dataset.id;
            const cartUrl = btn.dataset.cartUrl;
            const form = document.getElementById('addToCartForm-' + id);
            const data = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': data.get('_token'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: data
            })
            .then(res => res.json())
            .then(res => {
                if(res.success){

                    // Create Go to Cart button
                    const goCartBtn = document.createElement('a');
                    goCartBtn.href = cartUrl;
                    goCartBtn.className = 'btn btn-success';
                    goCartBtn.innerHTML = '<i class="bi bi-cart-check"></i> Go to Cart';

                    btn.parentNode.replaceChild(goCartBtn, btn);
                }
            })
            .catch(err => console.error(err));
        });
    });

});
</script>
@endpush

