    @extends('layouts.user')

    @section('title','User/Home')

    @section('content')

    <style>
    .wishlist-btn.active i {
        color: red;
    }

    .wishlist-btn i {
        transition: 0.3s;
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

    {{-- ================= FEATURED PRODUCTS ================= --}}
    <section class="py-5">
        <div class="container">

            <h2 class="text-center mb-4 fw-bold">Featured Products</h2>

            <div class="row row-cols-2 row-cols-md-4 g-4">

                @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-0" >
                            {{-- Main Image --}}
                                <a href="{{ route('product.show', $product->id) }}" class="nav-link">
                            @if($product->images->count())
                                <img src="{{ asset('uploads/products/'.$product->images->first()->image) }}"
                                    class="card-img-top rounded-0"
                                    style="height:280px; width:100%; object-fit: cover; background-color:#f8f8f8;">
                            @elseif($product->image)
                                <img src="{{ asset('uploads/products/'.$product->image) }}"
                                    class="card-img-top rounded-0"
                                    style="height:280px; width:100%; object-fit: cover; background-color:#f8f8f8;">
                            @else
                                <img src="{{ asset('images/no-image.png') }}"
                                    class="card-img-top rounded-0"
                                    style="height:280px; width:100%; object-fit: cover; background-color:#f8f8f8;">
                            @endif
    </a>
                            {{-- Body --}}
                            <div class="card-body">
                                <p class="fw-semibold text-truncate mb-1">{{ $product->name }}</p>
                                <span class="fw-bold">₹{{ number_format($product->price) }}</span>
                            </div>

                          {{-- FOOTER --}}
<div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center gap-2">

    {{-- STOCK / CART BUTTON --}}
    @if($product->stock <= 0)

        {{-- OUT OF STOCK --}}
        <button class="btn btn-secondary btn-sm rounded-0" disabled>
            <i class="bi bi-x-circle"></i> Out of Stock
        </button>

    @elseif(auth()->check() && in_array($product->id, $cartProductIds))

        {{-- GO TO CART --}}
        <a href="{{ route('cart') }}" class="btn btn-success btn-sm rounded-0">
            <i class="bi bi-cart-check"></i> Go to Cart
        </a>

    @else

        {{-- ADD TO CART --}}
      <form id="addToCartForm-{{ $product->id }}"
      action="{{ route('cart.add', $product->id) }}"
      method="POST">

            @csrf
            <button type="button"
                class="btn btn-sm btn-outline-dark rounded-0 add-to-cart-btn"
                data-id="{{ $product->id }}">
                <i class="bi bi-bag-plus"></i>
                <span class="d-none d-lg-inline">ADD TO CART</span>
            </button>
        </form>

    @endif

    {{-- QUICK VIEW --}}
    <a href="{{ route('product.show', $product->id) }}"
       class="small text-muted text-decoration-none">
        QUICK VIEW
    </a>

    {{-- WISHLIST --}}
    <form id="wishlistForm-{{ $product->id }}"
          action="{{ route('wishlist.add', $product->id) }}"
          method="POST"
          class="wishlist-form d-inline">
        @csrf
        <button type="button"
            class="btn btn-sm wishlist-btn
            {{ in_array($product->id, $wishlistIds ?? []) ? 'btn-danger active' : 'btn-outline-danger' }}"
            data-id="{{ $product->id }}">
            <i class="bi {{ in_array($product->id, $wishlistIds ?? []) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
        </button>
    </form>

</div>

                            {{-- Thumbnails --}}
                            @php
                                $allImages = $product->images->pluck('image')->toArray();
                                if($product->image && !in_array($product->image, $allImages)){
                                    array_unshift($allImages, $product->image); // add old image at beginning
                                }
                            @endphp

                            @if(count($allImages) > 1)
                                <div class="d-flex justify-content-center gap-1 mt-2">
                                    @foreach(array_slice($allImages, 0, 4) as $img)
                                        <img src="{{ asset('uploads/products/'.$img) }}" 
                                            width="40" height="40" 
                                            class="rounded border" 
                                            style="object-fit:cover;">
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    @endsection

    {{-- ================= JAVASCRIPT ================= --}}
    @push('scripts')
    <script>
  document.addEventListener('DOMContentLoaded', function () {

    // ================= ADD TO CART =================
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function () {

            const id = btn.dataset.id;
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
                if (res.success) {
                    // replace Add to Cart button with Go to Cart link
                    const goCartBtn = document.createElement('a');
                    goCartBtn.href = "{{ route('cart') }}"; // replace with your cart route if needed
                    goCartBtn.className = 'btn btn-success btn-sm rounded-0';
                    goCartBtn.innerHTML = '<i class="bi bi-cart-check"></i> Go to Cart';
                    btn.parentNode.replaceChild(goCartBtn, btn);
                } else if(res.message) {
                    // optional: show error message
                    alert(res.message);
                }
            })
            .catch(err => {
                console.error('Add to Cart Error:', err);
            });
        });
    });

    // ================= WISHLIST =================
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function () {

            const id = btn.dataset.id;
            const form = document.getElementById('wishlistForm-' + id);
            const data = new FormData(form);
            const icon = btn.querySelector('i');

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

                if (res.status === 'added') {
                    btn.classList.remove('btn-outline-danger');
                    btn.classList.add('btn-danger');
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                }

                if (res.status === 'removed') {
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-outline-danger');
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                }

            });
        });
    });

});

    </script>
    @endpush
