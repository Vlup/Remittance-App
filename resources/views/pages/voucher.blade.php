@extends('layouts.main')

@section('container')
    <h1>Redeem Your Point for Discount Voucher</h1>

    @if (session()->has('success'))
        <div class="alert alert-success col-md-10 mb-2 p-3" role="alert">{{ session('success') }}</div> 
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger col-md-10 mb-2 p-3" role="alert">{{ session('error') }}</div> 
    @endif

    @if (auth()->user()->email_verified_at == null)
        <div class="alert alert-warning col-md-5 mb-3 p-3" role="alert">
            Please verify your account first before making transactions
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning mt-3 p-2 border">Send verification email</button>
            </form>
        </div> 
    @endif
    <div class="alert alert-success col-md-2 mb-2 p-3" role="alert">Your Point : {{ auth()->user()->point }}</div> 
    
    @forelse ($promos as $promo)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">{{ $promo->name }}</h5>
                <p class="card-text">Redeem cost {{ $promo->price }} points</p>
                <form action="/promos" method="POST" class="position-absolute bottom-0 end-0 translate-middle">
                    @csrf
                    <input type="hidden" name="voucher_id" value="{{ $promo->id }}">
                    <button type="submit" class="btn btn-primary">Redeem</button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-success col-md-5 mb-2 p-3" role="alert">There is no voucher avaiable</div>  
    @endforelse
@endsection