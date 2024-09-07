@extends('layouts.app')

@section('content')
<div class="container">
    
    <form method="POST" action="/register" class="w-50 m-auto">
        @csrf

        <h2>add a new user</h2>

        <div class="mb-3">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Name" autocomplete="name" autofocus>

            @error('name')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Email Address" autocomplete="email">

            @error('email')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        @foreach ($roles as $role)
        <div class="form-check">
            <input class="form-check-input" value="{{$role->id}}" type="radio" name="role_id" id="{{$role->name}}" checked>
            <label class="form-check-label" for="{{$role->name}}">
                {{$role->name}}
            </label>
        </div>
        @endforeach
        @error('role_id')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
        @enderror

        <div class="mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="new-password">

            @error('password')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password" autocomplete="new-password">
        </div>

        <div class="mb-0">
            <button type="submit" class="btn btn-success">
                {{ __('Create') }}
            </button>
        </div>
    </form>
</div>
@endsection
