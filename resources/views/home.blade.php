@extends('layouts.app')

@section('content')
<section class="py-8 px-4">
	<div class="flex flex-row">
		<div class="w-full lg:w-2/3 px-6 mb-8 lg:mb-0">
			<h2 class="text-lx md:text-2xl lg:text-3xl mb-2 font-heading font-semibold text-logoBlue-light">Welcome, {{ Auth::user()->name }}!</h2>
			<p class="mb-4"><span>Membership: </span> 
			@if($plan == "paid")
			Premium
			@else
			Free
			@endif</p>
		</div>
		<div class="w-full lg:w-1/3 px-6 text-right">
		
			<a class="my-4 w-full text-center py-4 px-8 leading-none text-logoBlue-base bg-white hover:underline rounded-full inline-block items-center" href="{{ route('form.create') }}">Add Form</a>
			<a class="my-4 w-full text-center py-4 px-8 leading-none bg-logoBlue-base text-white hover:underline rounded-full inline-block items-center" href="/upgrade">
				Manage Subscription
			</a>
		</div>
		
	</div>
	@if($plan != 'free')
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap-12 md:gap-6 gap-3">
	@foreach($forms as $form)
	<div class="w-full rounded-lg overflow-hidden shadow-sm bg-white my-8 p-4">
			<div class="px-6 py-4">
			<a class="float-right text-white bg-logoBlue-light px-4 py-2 rounded-full" href="/form/{{$form->id}}">View Form</a>
				<h3 class="font-bold text-xl mb-2 text-gray-600">{{ $form->name }}</h3>
				<img class="w-full my-4" src="{{ asset('images/card-image.jpeg')}}" alt="Card Image">
				<p class="text-gray-500 text-sm">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
				</p>
			</div>
			<div class="px-6  text-white">
				<div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-2">
					<div class="bg-blue-500 text-center rounded-full"><span class="block">0</span> Total</div>
					<div class="bg-red-500 text-center rounded-full"><span class="block">0</span> Today</div>
					<div class="bg-green-500 text-center rounded-full"><span class="block">0</span> Spam</div>
					
				</div>
				<div class="text-sm text-gray-400 my-4">{{ \Carbon\Carbon::parse($form->created_at)->format('F j, Y') }}</div>	
			</div>
			
		</div>
		@endforeach
		
		
	</div>
	@else 
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 lg:gap-12 md:gap-6 gap-3">
	@foreach($forms as $form)
	<div class="w-full rounded-lg overflow-hidden shadow-sm bg-white my-8 p-4 col-span-2">
			<div class="px-6 py-4">
				<a class="float-right text-white bg-logoBlue-light px-4 py-2 rounded-full" href="/form/{{$form->id}}">View Form</a>
				<h3 class="font-bold text-xl mb-2 text-gray-600">{{ $form->name }}</h3>
				<img class="w-full my-4 bg-auto" src="{{ asset('images/card-image.jpeg')}}" alt="Card Image">
				<p class="text-gray-500 text-sm">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
				</p>
			</div>
			<div class="px-6 text-white">
				<div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-2">
					<div class="bg-blue-500 text-center rounded-full"><span class="block">0</span> Total</div>
					<div class="bg-red-500 text-center rounded-full"><span class="block">0</span> Today</div>
					<div class="bg-green-500 text-center rounded-full"><span class="block">0</span> Spam</div>
					
				</div>
				<div class="text-sm text-gray-400 my-4">{{ \Carbon\Carbon::parse($form->created_at)->format('F j, Y') }}</div>	
			</div>
			
		</div>
		<div class="col-span-3 text-white h-full bg-gradient-to-b from-green-400 to-blue-500 px-6 mt-8 rounded-lg">
		<h2 class="uppercase text-4xl mt-6 shadow-sm">Upgrade to Premium</h2>
		<p class="mt-8 mb-12 text-2xl">With premium you can create unlimited forms supporting spam protection, file uploads and much more!</p>
		<a href="upgrade" class="shadow-md bg-logoBlue-base text-white px-10 py-4 rounded-full hover:bg-logoBlue-dark">Subscribe Today!</a>
		</div>
		@endforeach
	</div>
	@endif
</section>
@endsection
