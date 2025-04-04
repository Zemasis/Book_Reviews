@extends('layouts.app')

@section('content')
    <h1 class="my-16 text-center text-4xl font-medium text-slate-600">
      Sign in to your account
    </h1>

    <div class="py-8 px-16">
      <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-8">
          <label for="email"
            class="mb-2 block text-sm font-medium text-slate-900">E-mail</label>
          <input name="email" />
        </div>

        <div class="mb-8">
          <label for="password" class="mb-2 block text-sm font-medium text-slate-900">
            Password
          </label>
          <input name="password" type="password" />
        </div>

        <div class="mb-8 flex justify-between text-sm font-medium">
          <div>
            <div class="flex items-center space-x-2">
              <input type="checkbox" name="remember"
                class="rounded-sm border border-slate-400">
              <label for="remember">Remember me</label>
            </div>
          </div>
          <div>
            <a href="#" class="text-indigo-600 hover:underline">
              Forget password?
            </a>
          </div>
        </div>
        <button class="w-full bg-green-50">Login</button>
        @if($errors->any())
            <ul class="px-4 py-2 bg-red-100">
                @foreach ($errors->all() as $error)
                    <li class="text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
      </form>
@endsection
