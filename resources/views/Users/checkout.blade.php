@extends('layouts.user')

@section('title', 'User/checkout')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-5">CHECKOUT</h1>

    {{-- ================= CHECKOUT PROGRESS BAR ================= --}}
    <div class="row mb-5 pt-3 ">
        <div class="col-4 text-start">
            <p class="mb-1 fw-bold text-success">01 SHOPPING BAG</p>
            <p class="text-muted small">Manage Your Items List</p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-1 fw-bold text-dark">02 SHIPPING AND CHECKOUT</p>
            <p class="text-muted small">Checkout Your Items List</p>
        </div>
        <div class="col-4 text-end">
            <p class="mb-1 fw-bold text-secondary">03 CONFIRMATION</p>
            <p class="text-muted small">Review And Submit Your Order</p>
        </div>
        <div class="col-12 mt-2">
            <div class="progress rounded-0" style="height: 3px;">
                <div class="progress-bar bg-dark" role="progressbar" style="width: 66.66%;"></div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ================= SHIPPING FORM ================= --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4 rounded-0">
                <div class="card-header bg-white fw-bold h4 border-bottom-0">Shipping Details</div>
                <div class="card-body">
                    <form id="checkoutForm" action="{{ route('checkout.place') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_id" id="payment_id">
                        <input type="hidden" name="payment_method" value="razorpay">

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control rounded-0 @error('first_name') is-invalid @enderror"
                                    id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control rounded-0 @error('last_name') is-invalid @enderror"
                                    id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control rounded-0 @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address') }}" required>
                                @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control rounded-0 @error('city') is-invalid @enderror"
                                    id="city" name="city" value="{{ old('city') }}" required>
                                @error('city')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <select id="state" name="state" class="form-select rounded-0 @error('state') is-invalid @enderror" required>
                                    <option value="">Choose...</option>
                                    <option value="Gujarat" {{ old('state')=='Gujarat' ? 'selected':'' }}>Gujarat</option>
                                    <option value="Maharashtra" {{ old('state')=='Maharashtra' ? 'selected':'' }}>Maharashtra</option>
                                    <option value="Assam" {{ old('state')=='Assam' ? 'selected':'' }}>Assam</option>
                                    <option value="Bihar" {{ old('state')=='Bihar' ? 'selected':'' }}>Bihar</option>
                                    <option value="Goa" {{ old('state')=='Goa' ? 'selected':'' }}>Goa</option>
                                    <option value="Haryana" {{ old('state')=='Haryana' ? 'selected':'' }}>Haryana</option>
                                    <option value="Kerla" {{ old('state')=='Kerla' ? 'selected':'' }}>Kerla</option>
                                    <option value="Sikkim" {{ old('state')=='Sikkim' ? 'selected':'' }}>Sikkim</option>
                                    <option value="Tripura" {{ old('state')=='Tripura' ? 'selected':'' }}>Tripura</option>
                                </select>
                                @error('state')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-2">
                                <label for="zip" class="form-label">Zip</label>
                                <input type="text" class="form-control rounded-0 @error('zip') is-invalid @enderror"
                                    id="zip" name="zip" value="{{ old('zip') }}" required>
                                @error('zip')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Shipping Methods --}}
                        <div class="form-check mb-2 p-3 border">
                            <input class="form-check-input" type="radio" name="shipping_method" id="standard" value="standard"
                                {{ old('shipping_method')=='standard'?'checked':'' }} required>
                            <label class="form-check-label w-100 d-flex justify-content-between" for="standard">
                                <span class="fw-semibold">Standard Shipping (3-7 days)</span>
                                <span class="fw-bold">₹{{ number_format($standardCharge, 2) }}</span>
                            </label>
                        </div>
                        <div class="form-check p-3 border">
                            <input class="form-check-input" type="radio" name="shipping_method" id="express" value="express"
                                {{ old('shipping_method')=='express'?'checked':'' }} required>
                            <label class="form-check-label w-100 d-flex justify-content-between" for="express">
                                <span class="fw-semibold">Express Shipping (1-2 days)</span>
                                <span class="fw-bold">₹{{ number_format($expressCharge, 2) }}</span>
                            </label>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cart') }}" class="btn btn-outline-secondary px-4 py-2 rounded-0">
                                <i class="bi bi-arrow-left me-2"></i> RETURN TO CART
                            </a>
                            <button type="submit" id="payNowBtn" class="btn btn-dark btn-lg px-5 py-2 rounded-0">
    CONTINUE TO PAYMENT
</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ================= ORDER SUMMARY ================= --}}
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-0 border-0">
                <div class="card-header bg-dark text-white fw-bold h5 rounded-0">Order Summary</div>
                <div class="card-body bg-light">
                    <ul class="list-group list-group-flush">
                        @php $subtotal = 0; @endphp
                        @if($cart && count($cart) > 0)
                            @foreach($cart as $id => $item)
                                @php $subtotal += $item['price'] * $item['quantity']; @endphp
                                <li class="list-group-item bg-light d-flex justify-content-between">
                                    <span class="fw-semibold">{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                                    <span class="text-muted">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item bg-light">Your cart is empty</li>
                        @endif

                        <li class="list-group-item bg-light d-flex justify-content-between pt-3">
                            <span class="fw-semibold">Subtotal</span>
                            <span class="fw-bold" id="summarySubtotal">₹{{ number_format($subtotal, 2) }}</span>
                        </li>
                        <li class="list-group-item bg-light d-flex justify-content-between">
                            <span class="fw-semibold">Shipping Charge</span>
                            <span id="shippingAmount" class="fw-bold">₹0.00</span>
                        </li>
                        <li class="list-group-item bg-light d-flex justify-content-between fw-bold h5 border-top mt-2 pt-2">
                            <span>Total Amount</span>
                            <span id="finalAmount">₹{{ number_format($subtotal,2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
    const shippingAmountEl = document.getElementById('shippingAmount');
    const finalAmountEl = document.getElementById('finalAmount');

    const subtotal = parseFloat(@json($subtotal ?? 0));
    const standardCharge = parseFloat(@json($standardCharge ?? 0));
    const expressCharge = parseFloat(@json($expressCharge ?? 0));

    function updateTotal() {
        let shippingCost = 0;
        const selected = document.querySelector('input[name="shipping_method"]:checked');
        if(selected) {
            shippingCost = selected.value === 'standard' ? standardCharge : expressCharge;
        }
        shippingAmountEl.textContent = '₹' + shippingCost.toFixed(2);
        finalAmountEl.textContent = '₹' + (subtotal + shippingCost).toFixed(2);
    }

    shippingRadios.forEach(radio => {
        radio.addEventListener('change', updateTotal);
    });

    // Initial calculation
    updateTotal();
 document.getElementById('checkoutForm').addEventListener('submit', function (e) {

        // agar payment_id aa chuka hai → normal submit
        if (document.getElementById('payment_id').value !== '') {
            return true;
        }

        // 🔴 FORM VALIDATION CHECK
        if (!this.checkValidity()) {
            e.preventDefault();
            this.reportValidity(); // 🔥 validation show karega
            return false;
        }

        // 🔴 form valid hai → razorpay open
        e.preventDefault();

        let finalAmountText = document.getElementById('finalAmount').innerText;
        let amount = parseFloat(finalAmountText.replace('₹','')) * 100;

        var options = {
            key: "{{ config('services.razorpay.key') }}",
            amount: amount,
            currency: "INR",
            name: "Demo Store",
            description: "Test Order Payment",

         handler: function (response) {
    document.getElementById('payment_id').value = response.razorpay_payment_id;

    let methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = 'payment_method';
    methodInput.value = response.method ?? 'razorpay';
    document.getElementById('checkoutForm').appendChild(methodInput);

    document.getElementById('checkoutForm').submit();
}

        };

        var rzp = new Razorpay(options);
        rzp.open();
    });
});
</script>
@endpush
@endsection
