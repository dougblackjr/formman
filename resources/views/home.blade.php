@extends('layouts.app')

@section('content')
<section class="py-8 px-4">
    <h2 class="text-3xl mb-2 font-heading font-semibold">Hey there, {{ Auth::user()->name }}</h2>
    <p class="mb-4">You've got quite a bit happening!</p>
    <div class="flex flex-wrap -mx-4 mb-8">
        <div class="w-full lg:w-1/4 px-4 mb-6 lg:mb-0">
            <div class="h-full">
                <div class="text-center p-4 mb-2 bg-blue-500 text-white rounded">
                    <h3 class="text-3xl leading-tight font-heading font-semibold">448</h3><span class="leading-none">Total Tickets</span></div>
            </div>
        </div>
        <div class="w-full lg:w-1/4 px-4 mb-6 lg:mb-0">
            <div class="h-full">
                <div class="text-center p-4 mb-2 bg-red-500 text-white rounded">
                    <h3 class="text-3xl leading-tight font-heading font-semibold">81</h3><span class="leading-none">Responded</span></div>
            </div>
        </div>
        <div class="w-full lg:w-1/4 px-4 mb-6 lg:mb-0">
            <div class="h-full">
                <div class="text-center p-4 mb-2 bg-green-500 text-white rounded">
                    <h3 class="text-3xl leading-tight font-heading font-semibold">208</h3><span class="leading-none">Resolved</span></div>
            </div>
        </div>
        <div class="w-full lg:w-1/4 px-4 mb-6 lg:mb-0">
            <div class="h-full">
                <div class="text-center p-4 mb-2 bg-gray-800 text-white rounded">
                    <h3 class="text-3xl leading-tight font-heading font-semibold">159</h3><span class="leading-none">Peding</span></div>
            </div>
        </div>
    </div>
    <dashboard />
</section>
@endsection
