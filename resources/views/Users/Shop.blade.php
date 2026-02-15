@extends('layouts.user')

@section('title','Shop')

@section('content')

<style>
/* Sidebar Card & Carousel Fix */
.carousel-item { position: relative; transition: transform 0.8s ease-in-out; }
.carousel-item * { position: relative; z-index: 5; }
.carousel-item img { pointer-events: none; object-fit: cover; width:100%; height:100%; }
.btn { position: relative; z-index: 10 !important; }
.carousel-control-prev,
.carousel-control-next { z-index: 20 !important; }

.filter-box {
    background: #fff; padding: 18px; border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-bottom: 20px;
}
.filter-title { font-size: 18px; font-weight: 700; margin-bottom: 12px; border-bottom: 2px solid #f1f1f1; padding-bottom: 6px; }
.filter-list a { display: block; padding: 6px 0; color: #444; text-decoration: none; transition: 0.3s; }
.filter-list a:hover, .filter-list a.active { color: #000; font-weight: 600; padding-left: 4px; }

.product-card { border-radius: 15px; overflow: hidden; transition: 0.3s; }
.product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
.product-card img { height: 260px; object-fit: cover; width:100%; }

.sort-box { padding: 12px; background: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.07); }

.carousel-control-prev-icon,
.carousel-control-next-icon { filter: invert(1); }
.carousel-control-prev,
.carousel-control-next { width: 50px; height: 50px; background: rgba(0,0,0,0.4); border-radius: 50%; top: 50%; transform: translateY(-50%); }
.carousel-control-prev-icon,
.carousel-control-next-icon { filter: invert(0); }
</style>

{{-- HERO SLIDER --}}
<div id="electronicsSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">
        @foreach($products as $key => $product)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="container">
                    <div class="row align-items-center" style="min-height: 85vh;">
                        <div class="col-md-6">
                            <p class="text-uppercase fw-bold text-secondary">New Arrival</p>
                            <h1 class="display-4 fw-bold">{{ $product->name }}</h1>
                            <p class="mt-3 text-muted">
                                {{ Str::limit(preg_replace('/&nbsp;|&#160;/', ' ', strip_tags($product->description)), 80) }}
                            </p>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-dark btn-lg mt-3">Shop Now</a>
                        </div>
                        <div class="col-md-6 text-center">
                            @php
                                $sliderImage = $product->images->first()->image ?? $product->image ?? 'no-image.png';
                            @endphp
                            <a href="{{ route('product.show', $product->id) }}">
                                <img src="{{ asset('uploads/products/'.$sliderImage) }}" class="img-fluid" style="max-height:420px; object-fit:contain;">
                            </a>
                        </div>
                    </div>
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

<div class="container-fluid py-4">
    <div class="row mt-4">

        {{-- LEFT SIDEBAR FILTER --}}
        <div class="col-md-3">
            <div class="filter-box">
                <h5 class="filter-title">🔍 Search</h5>
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search products...">
            </div>

            <div class="filter-box">
                <h5 class="filter-title">📂 Categories</h5>
                <ul class="filter-list list-unstyled">
                    @foreach($categories as $cat)
                        <li><a href="?category={{ $cat->id }}" class="{{ request('category') == $cat->id ? 'active' : '' }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="filter-box">
                <h5 class="filter-title">🏷️ Brands</h5>
                <ul class="filter-list list-unstyled">
                    @foreach($brands as $brand)
                        <li><a href="?brand={{ $brand->id }}" class="{{ request('brand') == $brand->id ? 'active' : '' }}">{{ $brand->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="filter-box">
                <h5 class="filter-title">💰 Price Range</h5>
                <form method="GET">
                    <div class="d-flex gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control" placeholder="Min">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control" placeholder="Max">
                    </div>
                    <button class="btn btn-dark btn-sm mt-3 w-100">Apply</button>
                </form>
            </div>
        </div>

        {{-- RIGHT PRODUCTS GRID --}}
        <div class="col-md-9">
            <div class="sort-box mb-3 d-flex justify-content-between">
                <div class="fw-bold">Showing: <span id="product-count">{{ $products->count() }}</span> Products</div>
                <select name="sort" id="sortSelect" class="form-select" style="width:180px">
                    <option value="">Sort By</option>
                    <option value="low_high" {{ request('sort')=='low_high'?'selected':'' }}>Price: Low to High</option>
                    <option value="high_low" {{ request('sort')=='high_low'?'selected':'' }}>Price: High to Low</option>
                </select>
            </div>

            <div class="row g-4" id="product-list">
                @forelse($products as $product)
                <div class="col-md-4" id="product-{{ $product->id }}">
                    <div class="card product-card shadow-sm border-0">

                        <a href="{{ route('product.show', $product->id) }}">
                            @if($product->images->count())
                                <img src="{{ asset('uploads/products/'.$product->images->first()->image) }}" class="card-img-top" style="height:260px; object-fit:cover;">
                            @elseif($product->image)
                                <img src="{{ asset('uploads/products/'.$product->image) }}" class="card-img-top" style="height:260px; object-fit:cover;">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="card-img-top" style="height:260px; object-fit:cover;">
                            @endif
                        </a>

                        <div class="card-body text-center">
                            <p class="text-muted small mb-1">{{ $product->category->name ?? '' }}</p>
                            <h5 class="fw-bold">{{ $product->name }}</h5>
                            <p class="fw-bold text-danger fs-5">₹{{ number_format($product->price,2) }}</p>
                        </div>

                        {{-- FOOTER --}}
                        <div class="card-footer bg-white border-0 pt-0 pb-3">
                            <div class="d-flex justify-content-between align-items-center gap-2">

                                {{-- STOCK / CART BUTTON --}}
                                @if($product->stock <= 0)

                                    <button class="btn btn-secondary btn-sm rounded-0" disabled>
                                        <i class="bi bi-x-circle"></i> Out of Stock
                                    </button>

                                @elseif(auth()->check() && in_array($product->id, $cartProductIds))

                                    <a href="{{ route('cart') }}" class="btn btn-success btn-sm rounded-0">
                                        <i class="bi bi-cart-check"></i> Go to Cart
                                    </a>

                                @else

                                    <form id="addToCartForm-{{ $product->id }}"
                                          action="{{ route('cart.add', $product->id) }}"
                                          method="POST">
                                        @csrf
                                        <button type="button"
                                            class="btn btn-sm btn-outline-dark rounded-0 add-to-cart-btn"
                                            data-id="{{ $product->id }}">
                                            <i class="bi bi-bag-plus"></i> ADD TO CART
                                        </button>
                                    </form>

                                @endif

                                {{-- QUICK VIEW --}}
                                <a href="{{ route('product.show', $product->id) }}"
                                   class="btn btn-light btn-sm rounded-0 fw-semibold text-muted"
                                   style="height:38px; width:100px;">
                                    Quick View
                                </a>

                                {{-- WISHLIST --}}
                                <form id="wishlistForm-{{ $product->id }}"
                                      action="{{ route('wishlist.add', $product->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="button"
                                        class="btn btn-sm wishlist-btn
                                        {{ in_array($product->id,$wishlistIds ?? []) ? 'btn-danger active' : 'btn-outline-danger' }}"
                                        data-id="{{ $product->id }}">
                                        <i class="bi {{ in_array($product->id,$wishlistIds ?? []) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
                @empty
                    <p class="text-center text-muted">No products found</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ---------- ADD TO CART ----------
    document.addEventListener('click', function(e){
        const addBtn = e.target.closest('.add-to-cart-btn');
        if(addBtn){
            const productId = addBtn.dataset.id;
            const form = document.getElementById('addToCartForm-' + productId);
            const data = new FormData(form);

            fetch(form.action, {
                method:'POST',
                headers:{'X-CSRF-TOKEN': data.get('_token'),'X-Requested-With':'XMLHttpRequest'},
                body: data
            })
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    const goCartBtn = document.createElement('a');
                    goCartBtn.href = "{{ route('cart') }}";
                    goCartBtn.className = 'btn btn-success btn-sm rounded-0';
                    goCartBtn.innerHTML = '<i class="bi bi-cart-check"></i> Go to Cart';
                    addBtn.parentNode.replaceChild(goCartBtn, addBtn);
                } else if(res.message){
                    alert(res.message);
                }
            })
            .catch(err => console.error(err));
        }

        // ---------- WISHLIST ----------
        const wishBtn = e.target.closest('.wishlist-btn');
        if(wishBtn){
            const productId = wishBtn.dataset.id;
            const form = document.getElementById('wishlistForm-' + productId);
            const icon = wishBtn.querySelector('i');
            const data = new FormData(form);

            fetch(form.action,{
                method:'POST',
                headers:{'X-CSRF-TOKEN': data.get('_token'),'X-Requested-With':'XMLHttpRequest'},
                body: data
            })
            .then(res=>res.json())
            .then(res=>{
                if(res.status==='added'){
                    wishBtn.classList.add('btn-danger');
                    wishBtn.classList.remove('btn-outline-danger');
                    icon.classList.replace('bi-heart','bi-heart-fill');
                }else if(res.status==='removed'){
                    wishBtn.classList.remove('btn-danger');
                    wishBtn.classList.add('btn-outline-danger');
                    icon.classList.replace('bi-heart-fill','bi-heart');
                }
            });
        }
    });

    // ---------- AJAX SEARCH/FILTER/SORT ----------
    const searchInput = document.getElementById('search');
    let timer = null;
    searchInput.addEventListener('keyup', function(){
        clearTimeout(timer);
        timer = setTimeout(fetchProducts, 400);
    });

    function fetchProducts(){
        let url = "{{ route('shop') }}";
        let params = new URLSearchParams(window.location.search);
        params.set('search', searchInput.value);

        fetch(url+'?'+params.toString(), { headers:{'X-Requested-With':'XMLHttpRequest'} })
        .then(res=>res.text())
        .then(html=>{
            let doc = new DOMParser().parseFromString(html,'text/html');
            document.getElementById('product-list').innerHTML = doc.getElementById('product-list').innerHTML;
        });
    }

    document.querySelectorAll('.filter-list a').forEach(link=>{
        link.addEventListener('click', function(e){
            e.preventDefault();
            fetch(this.href, { headers:{'X-Requested-With':'XMLHttpRequest'} })
            .then(res=>res.text())
            .then(html=>{
                let doc = new DOMParser().parseFromString(html,'text/html');
                document.getElementById('product-list').innerHTML = doc.getElementById('product-list').innerHTML;
                window.history.pushState({}, '', this.href);
            });
        });
    });

    const priceForm = document.querySelector('.filter-box form');
    priceForm.addEventListener('submit', function(e){
        e.preventDefault();
        let params = new URLSearchParams(new FormData(this));
        fetch("{{ route('shop') }}?"+params.toString(), { headers:{'X-Requested-With':'XMLHttpRequest'} })
        .then(res=>res.text())
        .then(html=>{
            let doc = new DOMParser().parseFromString(html,'text/html');
            document.getElementById('product-list').innerHTML = doc.getElementById('product-list').innerHTML;
            window.history.pushState({}, '', "{{ route('shop') }}?"+params.toString());
        });
    });

    const sortSelect = document.getElementById('sortSelect');
    sortSelect.addEventListener('change', function(){
        const sort = this.value;
        const params = new URLSearchParams(window.location.search);
        sort ? params.set('sort', sort) : params.delete('sort');

        fetch("{{ route('shop') }}?"+params.toString(), { headers:{'X-Requested-With':'XMLHttpRequest'} })
        .then(res=>res.text())
        .then(html=>{
            let doc = new DOMParser().parseFromString(html,'text/html');
            document.getElementById('product-list').innerHTML = doc.getElementById('product-list').innerHTML;
            document.getElementById('product-count').innerText = doc.getElementById('product-count')?.innerText || '{{ $products->count() }}';
            window.history.pushState({}, '', "{{ route('shop') }}?"+params.toString());
        });
    });

});
</script>
@endpush
