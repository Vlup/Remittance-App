@extends('layouts.main')

@section('container')
    <h1>Your transaction history</h1>

    @if (auth()->user()->email_verified_at == null)
        <div class="alert alert-warning col-md-5 mb-3 p-3" role="alert">
            Please verify your account first before making transactions
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning mt-3 p-2 border">Send verification email</button>
            </form>
        </div> 
    @endif

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @forelse ($histories as $history)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recipient Name : {{ $history->recipient_name }}</h5>
                        <p class="card-text mb-0">Your Currency : {{ auth()->user()->currency }}</p>
                        <p class="card-text mb-0">Recipient Currency : {{ $history->recipient_currency }}</p>
                        <p class="card-text mb-0">Amount : {{ $history->amount }} {{ $history->recipient_currency }}</p>
                        <p class="card-text mb-0">Transfer fee : {{ $history->transfer_fee }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning col-md-5 mb-2 p-3">There is no transaction</div>  
        @endforelse
    </div>

@endsection