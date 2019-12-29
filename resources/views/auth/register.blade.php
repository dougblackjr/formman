@extends('layouts.pre-app')

@section('content')
    <section class="py-8 px-4">
        <div class="flex flex-wrap -mx-6">
            <div class="w-full lg:w-full px-6 mb-8 lg:mb-0">
                @error('email')
                    @include('partials/banner-error', [ 'message' => $message ])
                @enderror
                @error('password')
                    @include('partials/banner-error', [ 'message' => $message ])
                @enderror
                @error('name')
                    @include('partials/banner-error', [ 'message' => $message ])
                @enderror
                <form class="w-full max-w-sm mx-auto" method="POST" action="{{ route('register') }}">
                    @csrf
                    <h3 class="text-2xl mb-2 font-heading">Sign Up</h3>
                    <p class="mb-8 text-gray-500 leading-relaxed">It's free!</p>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="text" placeholder="Name" name="name">
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="text" placeholder="Email" name="email">
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="password" placeholder="Password" name="password" required autocomplete="new-password">
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="password" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="inline-block w-half py-4 px-8 leading-none text-white bg-indigo-500 hover:bg-indigo-600 rounded shadow">Sign in</button>
                        @if (Route::has('password.request'))
                            <a class="inline-block w-half py-4 px-8 leading-none text-white bg-indigo-500 hover:bg-indigo-600 rounded shadow" href="{{ route('password.request') }}">Forgot Your Password</a>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection