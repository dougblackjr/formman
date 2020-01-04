@extends('layouts.app')

@section('content')
<section class="py-8 px-4">
	<div class="flex flex-col">
		<div class="w-full flex flex-col">
			<h2 class="text-5xl text-center mb-2 font-heading font-semibold">Hey there, {{ Auth::user()->name }}</h2>
			<p class="mb-4 text-3xl text-center ">You Did It!</p>
		</div>
		<div class="w-full flex flex-col items-center">
			<img class="max-w-auto md:max-w-sm my-12 mx-auto" src="https://media.giphy.com/media/5tgVJmQBd2vBIm7l6B/giphy.gif" />
			<a class="w-1/3 py-4 px-8 text-xl leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow inline-flex items-center" href="{{ route('home') }}">Get Rocking!</a>
			</a>
		</div>
	</div>
</section>
@endsection
