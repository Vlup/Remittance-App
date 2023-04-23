@extends('layouts.main')

@section('container')
    <h1>Send Your Money To all Country</h1>

    @if (session()->has('error'))
        <div class="alert alert-warning col-md-10 mb-2 p-3" role="alert">{{ session('error') }}</div> 
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success col-md-10 mb-2 p-3" role="alert">{{ session('success') }}</div> 
    @endif

    @if (auth()->user()->email_verified_at == null)
        <div class="alert alert-warning col-md-5 mb-3 p-3" role="alert">
            Verifikasi Akun anda untuk melakukan pengiriman
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning mt-3 p-2 border">Verifikasi email</button>
            </form>
        </div> 
    @endif
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Send Money</h5>
            <form action="/transactions" method="POST">
                @csrf
                <label for="amount">You Send</label>
                <input type="number" class="form-control mb-3" name="amount" id="amount" required>
                <p type="hidden" class="d-none" id="sender_currency">{{ $user->currency }}</p>
                <label for="country">Choose Country Currency</label>
                <select class="form-select mb-3" aria-label="Default select" id="country" name="recipient_currency">
                </select>
                <label for="recipient">Recipient Name</label>
                <input type="text" class="form-control mb-3" name="recipient_name" id="recipient" required>
                <label for="voucher">Choose Your Vouchers</label>
                <select class="form-select mb-3" aria-label="Default select" id="voucher" name="voucher" @disabled(count($user->vouchers) == 0)>
                    @if (count($user->vouchers) == 0) 
                        <option value="-1">You don't have any voucher</option>
                    @else
                        <option value="-1" selected>Select Avaiable Voucher</option>
                        @foreach ($user->vouchers as $voucher)
                            <option value="{{ $voucher->id }}" selected>{{ $voucher->name }}</option>                       
                        @endforeach
                    @endif
                </select>
                <p id="fee_text"></p>
                <input type="hidden" name="transfer_fee" value="{{ 20000 }}" id="transfer_fee">
                <button class="w-100 btn btn-md btn-primary" type="submit" onclick="return confirm('Do you want to send your money?')" @disabled(auth()->user()->email_verified_at == null)>Send Money</button>  
            </form>
        </div>
    </div>
    
    <script>
        const req_url = "https://v6.exchangerate-api.com/v6/b0ac1c255cda5360668a0732/codes";
        const select = document.getElementById("country");
        fetch(req_url, {
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json', 
            }
        })
        .then((response) => response.json())
        .then((datas) => {
            for(let i=0; i<datas.supported_codes.length; i++) {
                let opt = document.createElement("option");
                opt.text = datas.supported_codes[i][1];
                opt.value = datas.supported_codes[i][0];
                select.add(opt);
            }
        })

        const fee = document.getElementById('transfer_fee');
        const curr = document.getElementById('sender_currency');
        const feeTxt = document.getElementById('fee_text');

        const conversion = `https://v6.exchangerate-api.com/v6/b0ac1c255cda5360668a0732/pair/IDR/${curr.innerHTML}/${fee.value}`;
        
        fetch(conversion, {
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json', 
            }
        })
        .then((response) => response.json())
        .then((data) => {
            console.log(data.conversion_result);
            fee.value = data.conversion_result;
            feeTxt.innerHTML = "Transfer fee : " + fee.value + " " + curr.innerHTML;
        })


    </script>
@endsection