@extends('layouts.app')

@section('content')
    <section class="py-16 px-4">
        <div>
        @if(session('failed'))
        <div class="text-center bg-red-500 py-4 rounded-full border-4 border-red-600 text-white mb-6 shadow-lg">{{ session('failed') }}</div>
        @endif
        </div>
        <div class="text-center max-w-2xl mx-auto mb-10"><span class="text-xl text-blue-600">You're Upgrading Formman!</span>
            <h2 class="text-3xl md:text-5xl mt-2 leading-tight tracking-wide">How exciting! You must be hitting a bunch of traffic! Let's get you rolling!</h2>
        </div>
        <div class="max-w-xl lg:max-w-5xl mx-auto">
            <form method="POST" action="{{ route('upgrade.post') }}">
                <div class="p-8 bg-white rounded shadow-xl">
                    <div class="flex flex-wrap content-center -mx-8">
                        <div class="w-full lg:w-1/2 px-8">
                            @error('card_number')
                                @include('partials/banner-error', [ 'message' => $message ])
                            @enderror
                            @error('card_exp')
                                @include('partials/banner-error', [ 'message' => $message ])
                            @enderror
                            @error('card_cvc')
                                @include('partials/banner-error', [ 'message' => $message ])
                            @enderror
                            @error('card_zip')
                                @include('partials/banner-error', [ 'message' => $message ])
                            @enderror
                            @error('payment')
                                @include('partials/banner-error', [ 'message' => $message ])
                            @enderror
                            <div class="w-full max-w-sm mx-auto">
                                @csrf
                                <h3 class="text-2xl mb-2 font-heading">Just Put In Your Card Info, And You're In! $7/mo</h3>
                                <div class="mb-4">
                                    {{-- <div id="credit-card-payment"></div> --}}
                                    {{-- <button type="submit" data-tid="elements_examples.form.donate_button">Pay Now</button> --}}
                                    <credit-card-input />
                                </div>
                                <div class="mb-4">
                                    <input type="hidden" name="card_number" id="card_number" value="" />
                                    <input type="hidden" name="card_exp" id="card_exp" value="" />
                                    <input type="hidden" name="card_cvc" id="card_cvc" value="" />
                                    <input type="hidden" name="card_zip" id="card_zip" value="" />
                                    <button type="submit" class="inline-block w-half py-4 px-8 leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow">Let's Go!</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex lg:w-1/2 px-8 mt-8 lg:mt-0 lg:border-l">
                            <div class="my-auto" id="">
                                <div class="flex items-center text-xl mb-1">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>All Features PLUS</span>
                                </div>
                                <div class="flex items-center text-xl mb-1">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>Unlimited Responses</span>
                                </div>
                                <div class="flex items-center text-xl mb-1">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>File Support</span>
                                </div>
                                <div class="flex items-center text-xl mb-1">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>First Access To New Features!</span>
                                </div>
                                <div class="flex items-center text-xl">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>Unlimited High Fives When We Meet in Public!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection