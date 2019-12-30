@extends('layouts.app')

@section('content')
<section class="py-8 px-4">
	<div class="flex flex-row">
		<div class="w-full lg:w-2/3 px-6 mb-8 lg:mb-0">
			<h2 class="text-3xl mb-2 font-heading font-semibold">Hey there, {{ Auth::user()->name }}</h2>
			<p class="mb-4">You've got quite a bit happening!</p>
		</div>
		<div class="w-full lg:w-1/3 px-6 text-right">
			<a class="w-half py-4 px-8 leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow inline-flex items-center" href="{{ route('form.create') }}">Add Form</a>
			</a>
		</div>
	</div>
    <dashboard />
</section>
@endsection
