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
            <div class="w-full px-6 mb-8 lg:mb-0">
                <form class="w-full max-w-xl mx-auto" method="POST" action="{{ route('form.update', [ 'form' => $form->id ]) }}">
                    <input name="_method" type="hidden" value="PUT" />
                    @csrf
                    <h3 class="text-2xl mb-2 font-heading">Edit {{ $form->name }} ({{ $form->slug}})</h3>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="text" placeholder="Name of Form (required)" name="name" value="{{ $form->name }}" required />
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="text" placeholder="Email for Form (required)" name="email" value="{{ $form->email }}" required />
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="text" placeholder="Domain Form Lives On (recommended)" name="domain" value="{{ $form->domain }}" />
                    </div>
                    <div class="mb-4">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="text" placeholder="Webhook URL" name="webhook_url" value="{{ $form->webhook_url }}" />
                    </div>
                    @if($user->tier == 'paid')
                        <div class="my-10 border-t border-b">
                            <h3 class="text-2xl mb-2 font-heading">Incoming Webhook</h3>
                            <p class="text-md mb-2">You can post to this endpoint to manually connect forms: {{ config('app.url') . '/hook/' . $form->slug }}</p>
                            <p class="text-md mb-2">Including the following parameter in your call: <pre>"incoming": {{ $form->secret }}</pre></p>
                        </div>
                    @endif
                    <div class="mb-4">
                        <div class="mb-4">
                            <label class="text-gray-500">
                                <input class="mr-2 leading-tight" type="checkbox" name="notify_by_email" value="1" @if($form->notify_by_email) checked @endif />
                                <span class="text-sm">Get Emails When Someone Responds</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="mb-4">
                            <label class="text-gray-500">
                                <input class="mr-2 leading-tight" type="checkbox" name="enabled" value="1" @if($form->enabled) checked @endif />
                                <span class="text-sm">Form Enabled</span>
                                <span class="text-sm">If you disable the form, you will no longer be able to access responses</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="inline-block w-full py-4 px-8 leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow">Let's Go!</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection