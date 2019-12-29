@extends('layouts.pre-app')

@section('content')
    <section class="py-8 px-4">
        <div class="flex flex-wrap -mx-6">
            <div class="w-full px-6 mb-8 lg:mb-0">
                @if (session('resent'))
                    @include('partials/banner-success', [ 'message' => 'A fresh verification link has been sent to your email address.' ])
                @endif
                <form class="w-full max-w-sm mx-auto" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <h3 class="text-2xl mb-2 font-heading">Let's Verify Your Email!</h3>
                    <p class="mb-8 text-gray-500 leading-relaxed">This helps us keep the app safe.</p>
                    <div class="mb-4">
                        <button type="submit" class="inline-block w-half py-4 px-8 leading-none text-white bg-indigo-500 hover:bg-indigo-600 rounded shadow">Click here to request another</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection