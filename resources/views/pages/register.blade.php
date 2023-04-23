@extends('layouts.main')

@section('container')

<div class="row justify-content-center">
  <div class="col-lg-6">
    <main class="form-registration">
      <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>
      <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-floating">
          <input type="text" name="name" class="form-control rounded-top @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name') }}" required>
          <label for="name">Name</label>
          @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
          <label for="email">Email address</label>
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="password" name="password" class="form-control rounded-bottom @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
          <label for="password">Password</label>
          @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-floating">
          <select class="form-select" id="country" aria-label="Floating label select" name="currency">
          </select>
          <label for="country">Country Currency</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
      </form>
      <small class="d-block text-center mt-3">Already registered? <a href="/login">Login</a></small>
    </main>
  </div>
</div>

<script>
  const req_url = "https://v6.exchangerate-api.com/v6/b0ac1c255cda5360668a0732/codes";
  const select = document.getElementById("country");
  console.log(select);
  fetch(req_url, {
      headers: {
          'Access-Control-Allow-Origin': '*',
          'Content-Type': 'application/json', 
      }
  })
  .then((response) => response.json())
  .then((datas) => {
      console.log(datas.supported_codes);
      for(let i=0; i<datas.supported_codes.length; i++) {
          let opt = document.createElement("option");
          opt.text = datas.supported_codes[i][1];
          opt.value = datas.supported_codes[i][0];
          select.add(opt);
      }
  })
</script>

@endsection