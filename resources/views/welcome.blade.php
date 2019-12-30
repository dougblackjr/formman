@extends('layouts.pre-app')

@section('content')
<div class="container mx-auto px-4">
    <section class="py-12 px-4">
        <div class="flex flex-wrap items-center text-center lg:text-left -mx-2">
            <div class="lg:w-1/2 px-2 lg:pr-10 mt-10 lg:mt-0 order-1 lg:order-none">
                <h2 class="text-5xl mb-6 leading-tight font-heading">Easy Forms For Your Site!</h2>
                <p class="mb-8 text-gray-500 leading-relaxed">Whether a static site, or Wordpress, or whatever, get a custom form on your site with no hassles in under 5 minutes!</p>
                <div>
                    <a class="inline-block py-4 px-8 mr-6 leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow" href="/register">
                        Sign up
                    </a>
                    <a class="text-blue-700 hover:underline" href="#" id="more-info-button">
                        Learn more
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 px-2"> <img src="/marketing/pictures/certificate.svg" alt=""></div>
        </div>
    </section>
    <section id="more-info" class="bg-cover" style="background-image: url('/marketing/pictures/work.jpg');">
        <div class="pt-32 pb-24 flex relative">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="z-10 w-full px-8 md:px-24 text-center text-white">
                <h2 class="text-4xl mb-2 font-heading">Make it easy to get your information quick!</h2>
                <p class="mb-8">Static sites are amazing! Wordpress is amazing! But getting forms to work can be a pain. Formman makes is uber-easy to get a form moving quick and safe.</p>
                <div class="flex flex-wrap align-center -mx-4">
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6">
                        <img class="mx-auto mb-2" src="/marketing/icons/server.svg" alt="">
                        <h3 class="font-heading">Data Protection</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6">
                        <img class="mx-auto mb-2" src="/marketing/icons/shield.svg" alt="">
                        <h3 class="font-heading">Spam Protection</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6">
                        <img class="mx-auto mb-2" src="/marketing/icons/cloud-tools.svg" alt="">
                        <h3 class="font-heading">Webhooks For Your Own Info</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6">
                        <img class="mx-auto mb-2" src="/marketing/icons/cart.svg" alt="">
                        <h3 class="font-heading">Value-based price (it's 98% free)</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6">
                        <img class="mx-auto mb-2" src="/marketing/icons/badge.svg" alt="">
                        <h3 class="font-heading">Performance</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6">
                        <img class="mx-auto mb-2" src="/marketing/icons/hourglass.svg" alt="">
                        <h3 class="font-heading">5-Minute Implementation</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-12 px-4">
        <div class="flex flex-wrap items-center text-center lg:text-left -mx-2">
            <div class="lg:w-1/2 px-2"><img src="/marketing/pictures/new_ideas.svg" alt=""></div>
            <div class="lg:w-1/2 px-2 lg:pl-16 mt-10 lg:mt-0">
                <h2 class="text-4xl px-4 mb-4 leading-tight font-heading">It's Too Easy To Get Started</h2>
                <div class="p-4 mb-4">
                    <h3 class="text-2xl mb-2 font-heading">1. Sign Up</h3>
                    <p class="text-gray-500 leading-relaxed">Hit that beautiful blue button up top to sign up. No credit card necessary!</p>
                </div>
                <div class="p-4 mb-4 rounded shadow-lg">
                    <h3 class="text-2xl mb-2 font-heading">2. Create a Form</h3>
                    <p class="text-gray-500 leading-relaxed">Add a form in the app, and set up how you want it handled. Get email responses, or set up a webhook to post the data back to your own app.</p>
                </div>
                <div class="p-4 mb-4">
                    <h3 class="text-2xl mb-2 font-heading">3. Install the Form On Your Site!</h3>
                    <p class="text-gray-500 leading-relaxed">Grab the code from Formman, and then add whatever fields you need. Formman is smart enough to grab your fields you send it.</p>
                </div>
                <div class="p-4 mb-4  shadow-lg">
                    <h3 class="text-2xl mb-2 font-heading">4. Wait for delivery!</h3>
                    <p class="text-gray-500 leading-relaxed">You can get notified by email, view responses directly in Formman, post them to your own app, or export them to a fancy schmancy spreadsheet!</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-8 px-4">
        <div class="flex flex-wrap -mx-8 text-center">
            <div class="w-full md:w-1/2 p-8 mb-4 md:mb-0">
                <h3 class="text-5xl font-heading">Free</h3>
                <p class="flex-grow mt-4 mb-6 text-gray-500 leading-relaxed">All features, 50 responses/month</p>
                <a class="inline-block py-4 px-8 leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow" href="/register">Sign Up Now!</a>
            </div>
            <div class="w-full md:w-1/2 p-8 mb-4 md:mb-0 md:border-l">
                <h3 class="text-5xl font-heading">$7 / mo</h3>
                <p class="mt-4 mb-6 text-gray-500 leading-relaxed">All features + file support, <strong>unlimited</strong> responses</p>
                <a class="inline-block py-4 px-8 leading-none text-blue-700 bg-blue-100 hover:bg-blue-200 rounded shadow" href="/register">Sign Up Now!</a>
            </div>
        </div>
    </section>
    <section class="py-12 px-4">
        <h2 class="text-3xl mb-8 text-center font-heading">Contact Us (or just try the app in action)</h2>
        <div class="w-full max-w-2xl mx-auto mb-12">
            <form action="{{ config('formman.contact_form_url') }}" method="POST" accept-charset="utf-8">
                <div class="flex mb-4 -mx-2">
                    <div class="w-1/2 px-2">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="email" placeholder="Email" />
                    </div>
                    <div class="w-1/2 px-2">
                        <input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="name" placeholder="Name" />
                    </div>
                </div>
                <div class="mb-4">
                    <textarea class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" name="message" placeholder="Write something..." rows="5"></textarea>
                </div>
                <div>
                    <button class="inline-block w-full py-4 px-8 leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow">Submit</button>
                </div>
            </form>
        </div>
        <div class="flex flex-col lg:flex-row lg:justify-center -mx-4">
            <div class="px-4"><img class="inline-block w-8 h-8 pr-2" src="/marketing/icons/home.svg" alt=""><span>1725 Slough Avenue, Scranton</span></div>
            <div class="px-4"><img class="inline-block w-8 h-8 pr-2" src="/marketing/icons/mobile.svg" alt=""><span>555-111-555</span></div>
            <div class="px-4"> <img class="inline-block w-8 h-8 pr-2" src="/marketing/icons/message.svg" alt=""><span>scranton@dundermifflin.com</span></div>
        </div>
    </section>
    <footer class="p-4">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="w-full lg:w-auto lg:mr-auto text-center lg:text-left">&copy 2019 Dunder Mifflin</div>
            <div class="flex justify-center items-center mt-4 lg:mt-0"><img class="w-6 h-6" src="/marketing/icons/message.svg" alt=""><img class="w-6 h-6 mx-6" src="/marketing/icons/share.svg" alt=""><img class="w-6 h-6" src="/marketing/icons/star.svg" alt=""></div>
        </div>
    </footer>
</div>
@endsection
