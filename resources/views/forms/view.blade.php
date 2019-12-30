@extends('layouts.app')

@section('content')
<section class="py-8 px-4">
    <div class="flex flex-row">
        <div class="w-full lg:w-2/3 px-6 mb-8 lg:mb-0">
            <h2 class="text-3xl mb-2 font-heading font-semibold">{{ $form->name }}</h2>
        </div>
        <div class="flex flex-row w-full lg:w-1/3 px-6 text-right">
            <a class="w-half py-4 px-8 m-2 text-center leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow inline-flex items-center text-xs cursor-pointer" href="/export/csv/{{ $form->id }}" target="_blank">Export Responses</a>
            </a>
            <a class="w-half py-4 px-8 m-2 text-center leading-none text-white bg-gray-500 hover:bg-gray-600 rounded shadow inline-flex items-center text-xs cursor-pointer" href="#" v-on:click="toggleModal">Install Form</a>
            </a>
            <a class="w-half py-4 px-8 m-2 text-center leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow inline-flex items-center text-xs cursor-pointer" href="{{ route('form.edit', [ 'form' => $form->id ]) }}">Edit Form</a>
            </a>
        </div>
    </div>
    <div class="flex flex-row">
        <div class="w-full px-6 mb-8 lg:mb-0">
            <form-dashboard :form='@json($form)' />
        </div>
    </div>
    <install-form-modal :form='@json($form)' />
</section>
@endsection
