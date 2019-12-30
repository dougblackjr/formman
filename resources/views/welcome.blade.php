@extends('layouts.pre-app')

@section('content')
<div class="container mx-auto px-4">
    <section class="py-12 px-4">
        <div class="flex flex-wrap items-center text-center lg:text-left -mx-2">
            <div class="lg:w-1/2 px-2 lg:pr-10 mt-10 lg:mt-0 order-1 lg:order-none">
                <h2 class="text-5xl mb-6 leading-tight font-heading">No paper plane can be made without paper</h2>
                <p class="mb-8 text-gray-500 leading-relaxed">Professional, dedicated, local. Dunder Mifflin is on its best patch to change the way you think about paper. That’s us - people who sell limitless paper in the paperless world.</p>
                <div><a class="inline-block py-4 px-8 mr-6 leading-none text-white bg-indigo-500 hover:bg-indigo-600 rounded shadow" href="#">Sign up</a><a class="text-blue-700 hover:underline" href="#">Learn more</a></div>
            </div>
            <div class="lg:w-1/2 px-2"> <img src="/marketing/pictures/certificate.svg" alt=""></div>
        </div>
    </section>
    <section class="bg-cover" style="background-image: url('/marketing/pictures/work.jpg');">
        <div class="pt-32 pb-24 flex relative">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="z-10 w-full px-8 md:px-24 text-center text-white">
                <h2 class="text-4xl mb-2 font-heading">The real business is done on paper.</h2>
                <p class="mb-8">Many beautiful things couldn’t ever appear without paper.</p>
                <div class="flex flex-wrap align-center -mx-4">
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6"><img class="mx-auto mb-2" src="/marketing/icons/shield.svg" alt="">
                        <h3 class="font-heading">High durability</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6"><img class="mx-auto mb-2" src="/marketing/icons/cloud-tools.svg" alt="">
                        <h3 class="font-heading">Versatility</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6"><img class="mx-auto mb-2" src="/marketing/icons/server.svg" alt="">
                        <h3 class="font-heading">Variety</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6"><img class="mx-auto mb-2" src="/marketing/icons/cart.svg" alt="">
                        <h3 class="font-heading">Value-based price</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6"><img class="mx-auto mb-2" src="/marketing/icons/badge.svg" alt="">
                        <h3 class="font-heading">Performance</h3>
                    </div>
                    <div class="w-1/2 lg:w-1/6 px-4 mb-6"><img class="mx-auto mb-2" src="/marketing/icons/hourglass.svg" alt="">
                        <h3 class="font-heading">Long lasting</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-12 px-4">
        <div class="flex flex-wrap items-center text-center lg:text-left -mx-2">
            <div class="lg:w-1/2 px-2"><img src="/marketing/pictures/new_ideas.svg" alt=""></div>
            <div class="lg:w-1/2 px-2 lg:pl-16 mt-10 lg:mt-0">
                <h2 class="text-4xl px-4 mb-4 leading-tight font-heading">How to get Dunder Mifflined?</h2>
                <div class="p-4 mb-4">
                    <h3 class="text-2xl mb-2 font-heading">1. Contact our Sales</h3>
                    <p class="text-gray-500 leading-relaxed">During the phone call we will be able to present you all details of cooperation, pricing and special offers, suited for your company.</p>
                </div>
                <div class="p-4 mb-4 rounded shadow-lg">
                    <h3 class="text-2xl mb-2 font-heading">2. Sign the documents</h3>
                    <p class="text-gray-500 leading-relaxed">We can also talk during business meeting, or visit your office anytime you want! Our employees will provide proper contracts.</p>
                </div>
                <div class="p-4 mb-4">
                    <h3 class="text-2xl mb-2 font-heading">3. Wait for delivery!</h3>
                    <p class="text-gray-500 leading-relaxed">You don’t buy a pig... or shall I say a paper in a poke. The supplies will be delivered to your company every first Monday of the month.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-8 px-4">
        <div class="flex flex-wrap -mx-8 text-center">
            <div class="w-full md:w-1/2 p-8 mb-4 md:mb-0">
                <h3 class="text-5xl font-heading">$9 / mo</h3>
                <p class="flex-grow mt-4 mb-6 text-gray-500 leading-relaxed">Just enough paper for small business. Not enough to waste it on fluffy animals photos. The best quality and economy comes with Dunder Mifflin paper.</p><a class="inline-block py-4 px-8 leading-none text-white bg-indigo-500 hover:bg-indigo-600 rounded shadow"
                    href="#">Contact sales</a></div>
            <div class="w-full md:w-1/2 p-8 mb-4 md:mb-0 md:border-l">
                <h3 class="text-5xl font-heading">$49 / mo</h3>
                <p class="mt-4 mb-6 text-gray-500 leading-relaxed">That’s what we’re talking about! More reams of paper is a really reamful choice. The best combination of quality and economy comes with Dunder Mifflin paper.</p><a class="inline-block py-4 px-8 leading-none text-blue-700 bg-indigo-100 hover:bg-indigo-200 rounded shadow"
                    href="#">Contact sales</a></div>
        </div>
    </section>
    <section class="py-12 px-4">
        <h2 class="text-3xl mb-8 text-center font-heading">Contact the Scranton team</h2>
        <div class="w-full max-w-2xl mx-auto mb-12">
            <form>
                <div class="flex mb-4 -mx-2">
                    <div class="w-1/2 px-2"><input class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="email" placeholder="Email"></div>
                    <div class="w-1/2 px-2"><select class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none"><option>-- Select product --</option><option>Product 1</option><option>Product 2</option><option>Product 3</option></select></div>
                </div>
                <div class="mb-4"><textarea class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" type="password" placeholder="Write something..."
                        rows="5"></textarea></div>
                <div><button class="inline-block w-full py-4 px-8 leading-none text-white bg-indigo-500 hover:bg-indigo-600 rounded shadow">Submit</button></div>
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
