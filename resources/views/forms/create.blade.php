@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                @include('partials/banner-error', [ 'message' => $error ])
            @endforeach
        </div>
    @endif
    <section class="py-8 px-4">
        <div class="flex flex-wrap -mx-6">
            <div class="w-full lg:w-2/3 px-6 mb-8 lg:mb-0">
                <form class="w-full max-w-sm mx-auto" method="POST" action="{{ route('form.store') }}">
                    @csrf
                    <h3 class="text-2xl mb-2 font-heading text-logoBlue">Create Your New Form</h3>
                    <p class="mb-8 text-gray-600 leading-relaxed">They're unlimited!</p>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-100 focus:bg-white border border-gray-200 focus:border-logoBlue-baserounded focus:outline-none" type="text" placeholder="Name of Form (required)" name="name" required />
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-100 focus:bg-white border border-gray-200 focus:border-logoBlue-baserounded focus:outline-none" type="text" placeholder="Email for Form (required)" value="{{ $email }}" name="email" required />
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-100 focus:bg-white border border-gray-200 focus:border-logoBlue-baserounded focus:outline-none" type="text" placeholder="Domain Form Lives On (recommended)" name="domain" />
                    </div>
                    <div class="mb-4">
                        <div class="mb-4">
                            <label class="text-gray-600">
                                <input class="mr-2 leading-tight checked:bg-logoBlue" type="checkbox" name="notify_by_email" value="1" checked />
                                <span class="text-sm">Get Emails When Someone Responds</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="inline-block w-full py-4 px-8 leading-none text-white bg-logoBlue-base hover:bg-logoBlue-dark rounded-full shadow font-semibold">Let's Go!</button>
                    </div>
                </form>
            </div>
            @include('partials/form-explainer')
        </div>
    </section>
@endsection