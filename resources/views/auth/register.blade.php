@extends('layouts.pre-app')

@section('content')
    <section class="py-16 px-4">
        <div class="text-center max-w-2xl mx-auto mb-10"><span class="text-xl text-blue-600">Welcome to Formman!</span>
            <h2 class="text-3xl md:text-5xl mt-2 leading-tight tracking-wide">Let's get you rolling!</h2>
        </div>
        <div class="max-w-xl lg:max-w-5xl mx-auto">
            <form method="POST" action="{{ route('register') }}">
                <div class="text-center mb-8 md:mb-12">
                    <label class="inline-block mb-4 text-xl">
                        <input class="mr-2" type="radio" name="tier" value="free" checked />
                        <span>Free Plan</span>
                    </label>
                    <br class="lg:hidden">
                    <label class="text-xl md:ml-4">
                        <input class="mr-2" type="radio" name="tier" value="paid" />
                        <span>Monthly Unlimited Plan ($10 / mo)</span>
                    </label>
                    <br class="lg:hidden">
                    <label class="text-xl md:ml-4">
                        <input class="mr-2" type="radio" name="tier" value="paid" />
                        <span>Annual Unlimited Plan ($100 / yr)</span>
                    </label>
                </div>
                <div class="p-8 bg-white rounded shadow-xl">
                    <div class="flex flex-wrap content-center -mx-8">
                        <div class="w-full lg:w-1/2 px-8">
                            @error('email')
                                @include('partials/banner-error', [ 'message' => $message ])
                            @enderror
                            @error('password')
                                @include('partials/banner-error', [ 'message' => $message ])
                            @enderror
                            @error('name')
                                @include('partials/banner-error', [ 'message' => $message ])
                            @enderror
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
                            <div class="w-full max-w-sm mx-auto">
                                @csrf
                                <h3 class="text-2xl mb-2 font-heading">Sign Up</h3>
                                <p class="mb-8 text-gray-500 leading-relaxed">It's free!</p>
                                <div class="mb-4">
                                    <input class="appearance-none block w-full py-3 px-4 mb-2 md:mb-0 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="text" placeholder="Name" name="name">
                                </div>
                                <div class="mb-4">
                                    <input class="appearance-none block w-full py-3 px-4 mb-2 md:mb-0 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="text" placeholder="Email" name="email">
                                </div>
                                <div class="mb-4">
                                    <input class="appearance-none block w-full py-3 px-4 mb-2 md:mb-0 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="password" placeholder="Password" name="password" required autocomplete="new-password">
                                </div>
                                <div class="mb-4">
                                    <input class="appearance-none block w-full py-3 px-4 mb-2 md:mb-0 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="password" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="mb-4">
                                    {{-- <div id="credit-card-payment"></div> --}}
                                    {{-- <button type="submit" data-tid="elements_examples.form.donate_button">Pay Now</button> --}}
                                    <div v-if="showCardField">
                                        <credit-card-input />
                                    </div>
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
                                    <span>Data Protection</span>
                                </div>
                                <div class="flex items-center text-xl mb-1">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>Spam Protection</span>
                                </div>
                                <div class="flex items-center text-xl mb-1">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>Webhooks For Your Own Info</span>
                                </div>
                                <div class="flex items-center text-xl mb-1">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>Value-based price (it's 98% free)</span>
                                </div>
                                <div class="flex items-center text-xl">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>Performance</span>
                                </div>
                                <div class="flex items-center text-xl">
                                    <img class="mr-2" src="/marketing/icons/star.svg">
                                    <span>5-Minute Implementation</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection