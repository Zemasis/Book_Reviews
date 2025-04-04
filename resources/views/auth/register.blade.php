@extends('layouts.app')

@section('content')
<div>
    <h1>Sign Up</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="name">Name:</label>
        <input id="name" type="text" name="name" required autofocus>

        <label for="email">Email:</label>
        <input id="email" type="email" name="email" required>

        <label for="password">Password:</label>
        <input id="password" type="password" name="password" required>

        <label for="password_confirmation">Confirm Password:</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button type="submit">Sign Up</button>
        @if($errors->any())
        <ul class="px-4 py-2 bg-red-100">
            @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </form>
</div>
@endsection
