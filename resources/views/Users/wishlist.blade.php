@extends('layouts.user')

@section('title','My Wishlist')

@section('content')
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4 fw-bold">My Wishlist</h2>

        @if($wishlists->isEmpty())
            <p class="text-center text-muted">Your wishlist is empty.</p>
        @else
        <div class="row row-cols-1 row-cols-md-3 g-4">

            @foreach($wishlists as $item)
                @php $product = $item->product; @endphp

                <div class="col" id="wishlist-{{ $product->id }}">
                    <div class="card h-100 border-0 shadow-sm">
                <a href="{{ route('product.show', $product->id) }}" class="nav-link">

                        {{-- ✅ PRODUCT IMAGE --}}
                        @if($product && $product->images->count())
                            <img src="{{ asset('uploads/products/'.$product->images->first()->image) }}"
                                 class="card-img-top"
                                 alt="{{ $product->name }}"
                                 style="height:250px; object-fit:cover;">
                        @else
                            <img src="{{ asset('images/no-image.png') }}"
                                 class="card-img-top"
                                 alt="No Image"
                                 style="height:250px; object-fit:cover;">
                        @endif

                        <div class="card-body text-center">
                            <h5 class="card-title text-truncate">
                                {{ $product->name }}
                            </h5>
</a>
                            <p class="fw-bold mb-2">
                                ₹{{ number_format($product->price, 2) }}
                            </p>

                            <a href="{{ route('product.show', $product->id) }}"
                               class="btn btn-sm btn-outline-dark">
                                View Product
                            </a>
                        </div>

                        <div class="card-footer bg-white border-0 text-center">
                            <button type="button"
                                    class="btn btn-sm btn-danger remove-wishlist-btn"
                                    data-id="{{ $product->id }}">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
        @endif
    </div>
</section>
@endsection



@push('scripts')
<script>
document.addEventListener('click', function (e) {

    const btn = e.target.closest('.remove-wishlist-btn');
    if (!btn) return;

    e.preventDefault();

    const productId = btn.dataset.id;

    fetch("{{ route('wishlist.remove', ':id') }}".replace(':id', productId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('wishlist-' + productId).remove();
        }

        if (document.querySelectorAll('.remove-wishlist-btn').length === 0) {
            document.querySelector('.row').innerHTML =
                `<p class="text-center text-muted">Your wishlist is empty.</p>`;
        }
    });
});
</script>
@endpush

