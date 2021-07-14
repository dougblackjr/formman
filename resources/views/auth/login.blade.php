@extends('layouts.pre-app')

@section('content')
    <section class="py-8 px-4">
        <div class="flex flex-wrap -mx-6">
            <div class="w-full lg:w-1/2 px-6 mb-8 lg:mb-0">
                @error('email')
                    @include('partials/banner-error', [ 'message' => $message ])
                @enderror
                @error('password')
                    @include('partials/banner-error', [ 'message' => $message ])
                @enderror
                <form class="w-full max-w-sm mx-auto" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3 class="text-2xl mb-2 font-heading">Login</h3>
                    <p class="mb-8 text-gray-500 leading-relaxed">Throw in your info here, and let's get rolling!</p>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-logoBlue-light bg-gray-200 focus:bg-white placeholder-logoBlue-light border border-gray-200 focus:border-gray-500 rounded-full focus:outline-none" type="text" placeholder="Email" name="email">
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-logoBlue-light bg-gray-200 focus:bg-white border placeholder-logoBlue-light border-gray-200 focus:border-gray-500 rounded-full focus:outline-none" type="password" placeholder="Password" name="password">
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="inline-block w-half py-4 px-8 leading-none text-white bg-logoBlue-base hover:bg-logoBlue-dark rounded-full shadow">Sign in</button>
                        @if (Route::has('password.request'))
                            <a class="inline-block w-half py-4 px-8 leading-none text-logoBlue-dark " href="{{ route('password.request') }}">Forgot Your Password</a>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="w-full lg:w-1/2 lg:border-l px-6">
                <form class="w-full max-w-sm mx-auto">
                    <h3 class="text-2xl mb-2 font-heading">Sign Up</h3>
                    <p class="mb-8 text-gray-500 leading-relaxed">Get started for free (like, really free) today!</p>
                    <a href="/register" class="inline-block w-full py-4 px-8 leading-none text-white bg-logoBlue-base hover:bg-logoBlue-dark rounded-full shadow">Sign up</a>
                </form>
            </div>
        </div>
    </section>
@endsection
