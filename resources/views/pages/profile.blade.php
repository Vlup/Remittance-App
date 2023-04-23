@extends('layouts.main')

@section('container')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container my-5 mx-3">
            @if (session()->has('success'))
                <div class="alert alert-success col-md-10 mb-2 p-3" role="alert">{{ session('success') }}</div> 
            @endif

            <table class="mt-3">
                <tr>
                    <td class="px-1"><h4>Name</h4></td>
                    <td class="px-2"><h4>:</h4></td>
                    <td><h4>{{ auth()->user()->name }}</h4></td>
                <tr>
                    <td class="px-1"><h4>Email</h4></td>
                    <td class="px-2"><h4>:</h4></td>
                    <td><h4>{{ auth()->user()->email }}</h4></td>
                    @if (auth()->user()->email_verified_at == null)
                        <td class="px-3">
                            <form action="{{ route('verification.send') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning p-1 border">Send verification email</button>
                            </form>
                        </td>  
                    @endif
                </tr>
                <tr>
                    <td class="px-1"><h4>Point</h4></td>
                    <td class="px-2"><h4>:</h4></td>
                    <td><h4>{{ auth()->user()->point }}</h4></td>
                </tr>
            </table>
        </div>

        <div class="alert alert-primary col-md-3 mb-3 p-2 text-center" >
            <h4 class="mb-0">Your Voucher</h4>
        </div> 

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @forelse ($user->vouchers as $voucher)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $voucher->name }}</h5>
                            <p class="card-text">Quantity : {{ $voucher->promo->qty }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning col-md-5 mb-2 p-3"> You don't have any voucher</div>  
            @endforelse
        </div>
    </div>
    
@endsection