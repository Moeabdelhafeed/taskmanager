@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" class="text-center m-auto w-50 shadow-sm rounded-3 border p-5 mt-5" action="{{ route('login') }}">
        @csrf
        <h2 class="mb-4">Login</h2>
        <div class="mb-4">
          <input placeholder="your email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
          @error('email')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
        </div>


        <div class="mb-4">
          <input input id="password" type="password" placeholder="your password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
          @error('password')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
        </div>
        <button type="submit" class="btn btn-primary m-auto w-100">Submit</button>
      </form>
</div>
@endsection
