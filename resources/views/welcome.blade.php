@extends('layouts.pre-app')

@section('content')
<div class="container mx-auto text-center">
     <div>
        <h1 class="text-6xl text-logoBlue-light text-center mt-10 mb-6 font-black">Quick spam-free forms for your site!</h1>
        <p class="text-gray-500 text-center">Whether a static or WordPress site, get a custom form on your site with no hassle in under 5-minutes.</p>
     </div>

     <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 p-8 bg-gradient-to-r from-logoBlue-bg via-logoBlue-light via-logoBlue-base to-logoBlue-dark rounded-none lg:rounded-r-full text-4xl text-white my-8">
        <div class="my-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-yellow w-1/3 text-yellow-300 lg:text-yellow-100 block mx-auto mb-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
        </svg>
        Key Features
        <p class="text-lg text-gray-100 lg:text-logoBlue-dark my-6">Here are some cool features</p>
        </div>
        <div class="col-span-2">
        <ul class="py-8">
        <li class="my-6">Data Protection</li>
        <li class="my-6">Spam Protection</li>
        <li class="my-6">Webhooks</li>
        <li class="my-6">Quick and easy!</li>
        </ul>
        </div>
     </div>
@endsection
