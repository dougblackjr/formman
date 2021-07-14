@extends('layouts.app')

@section('content')
@if(session('failed'))
<div class="mx-auto mb-4 w-5/12 bg-red-500 text-white text-center py-4 rounded-full">{{ session('failed') }}</div>
@elseif(session('success'))
<div class="mx-auto mb-4 w-5/12 bg-green-500 text-white text-center py-4 rounded-full">{{ session('success') }}</div>
@endif
<div class="mx-auto w-full lg:w-5/12 bg-white rounded-lg border border-logoBlue-light px-8 py-4">
    <div class="sm:w-11/12 lg:w-8/12 mx-auto">
        <h2 class="text-logoBlue-light my-4 text-3xl">Profile Information</h2>
        <form action="" method="POST">
        @csrf
        <input type="text" value="{{ $name[0] }}" placeholder="First Name" name="firstName" class="border  bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input type="text" value="{{ $name[1] }}" placeholder="Last Name" name="lastName" class="border bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input autocomplete="off" type="email" value="{{ $user->email }}" placeholder="E-Mail Address" name="email" class="border bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input autocomplete="off" type="password" placeholder="Password" name="password" class="border bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input autocomplete="off" type="password" placeholder="Password Again" name="password_again" class="border bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input type="submit" value="UPDATE" class="bg-logoBlue-base text-white px-6 py-2 rounded-full my-4">
        </form>
    </div>

</div>
@endsection