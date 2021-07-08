@extends('layouts.app')

@section('content')
<div class="mx-auto w-5/12 bg-white rounded-lg border border-logoBlue-light px-8 py-4">
    <div class="w-8/12 mx-auto">
        <h2 class="text-logoBlue-light my-4 text-3xl">Profile Information</h2>
        <form action="">
        @csrf
        <input type="text" placeholder="First Name" name="firstName" class="border  bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input type="text" placeholder="Last Name" name="lastName" class="border bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input type="email" placeholder="E-Mail Address" name="email" class="border bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input type="password" placeholder="Password" name="password" class="border bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input type="password" placeholder="Password Again" name="password_again" class="border bg-gray-100 placeholder-logoBlue-light w-full text-logoBlue-light px-4 py-2 my-2 rounded-full">
        <input type="submit" value="UPDATE" class="bg-logoBlue-base text-white px-6 py-2 rounded-full my-4">
        </form>
    </div>

</div>
@endsection