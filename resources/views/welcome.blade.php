@extends('layouts.pre-app')

@section('content')
<div class="container mx-auto text-center">
   <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 ">
   <div class="col-span-2">
        <h1 class="text-3xl md:text-5xl lg:text-6xl text-white text-center mt-10 mb-6 font-black">Quick spam-free forms for your site!</h1>
        <p class="text-gray-300 text-center">Whether a static or WordPress site, get a custom form on your site with no hassle in under 5-minutes.</p>
     </div>
     <div class="col-span-3 px-4">
         <div class="bg-white w-full rounded-lg shadow-md">
         <h2 class="text-gray-400 uppercase font-bold py-4">Sample Contact Form</h2>
         <div class="py-4 px-6">
         <input type="text" name="" id="" class="rounded p-4  w-full bg-gray-200" placeholder="Message Subject">
         </div>
         <div class="py-4 px-6">
         <textarea name="" id="" cols="30" rows="5" class="w-full rounded p-4 bg-gray-200 resize-none" placeholder="Write message here"></textarea>
         </div>
         <div class="mb-2 pb-10 pt-3">
         <a href="/register" class="bg-logoBlue-base text-white px-4 py-2 font-bold rounded-full">Send Message</a>
         </div>
         </div>
     </div>
   </div>
     

   
     <div>
     <h2 class="text-logoBlue-dark lg:text-white uppercase font-bold text-4xl mt-12">Plans</h2>
     <p class="text-logoBlue-dark lg:text-white lg:text-logoBlue-dark">Unsubscribe at any time! No cancellation charges!</p>
     </div>
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-8">
      <div class="bg-white py-8 rounded shadow-md">
         <h2 class="text-logoBlue-base text-xl">Free</h2>
         <p class="text-logoBlue-light py-2">Costs nothing!</p>
         <ul class="mb-4">
         <li>50 Responses per month</li>
         <li>No spam protection</li>
         </ul>
         <a class="px-4 py-2 bg-logoBlue-dark text-white font-black rounded-full" href="/register">Sign up!</a>
      </div>
      <div  class="bg-white py-8 rounded shadow-md">
         <h2 class="text-logoBlue-base text-xl">Monthly</h2>
         <p class="text-logoBlue-light py-2">$10 / month</p>
         <ul class="mb-4">
         <li>Unlimited Responses</li>
         <li>Strong Spam Protection</li>
         </ul>
         <a class="px-4 py-2 bg-logoBlue-dark text-white font-black rounded-full" href="/register">Sign up!</a>
      </div>
      <div class="bg-white py-8 rounded shadow-md">
         <h2 class="text-logoBlue-base text-xl">Annual</h2>
         <p class="text-logoBlue-light py-2">$100 / year</p>
         <ul class="mb-4">
         <li>Unlimited Responses</li>
         <li>Strong Spam Protection</li>
         </ul>
         <a class="px-4 py-2 bg-logoBlue-dark text-white font-black rounded-full" href="/register">Sign up!</a>
      </div>
     </div>
@endsection
