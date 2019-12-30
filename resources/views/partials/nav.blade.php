<nav class="flex flex-wrap items-center justify-between p-4">
    <div class="flex flex-shrink-0 mr-6"><a class="text-xl text-indigo-500 font-semibold" href="/home">Formman</a></div>
    <div class="block lg:hidden">
    	<button id="nav-button" class="flex items-center py-2 px-3 text-indigo-500 rounded border border-indigo-500">
    		<svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
    	</button>
    </div>
    <div id="nav-dropdown" class="hidden lg:flex lg:flex-grow lg:items-center w-full lg:w-auto">
        <div class="lg:ml-auto">
        	<a class="block lg:inline-block mt-4 lg:mt-0 mr-10 text-blue-900 hover:text-blue-700" href="/home">Forms</a>
        	{{-- <a class="block lg:inline-block mt-4 lg:mt-0 mr-10 text-blue-900 hover:text-blue-700" href="/profile">Profile</a> --}}
        	<a class="block lg:inline-block mt-4 lg:mt-0 mr-10 text-blue-900 hover:text-blue-700" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        	    {{ __('Logout') }}
        	</a>
        	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        	    @csrf
        	</form>
        </div>
        <div>
			<a class="inline-block py-3 px-6 mt-4 lg:mt-0 leading-none text-white bg-indigo-500 hover:bg-indigo-600 rounded shadow" href="/upgrade">
				Upgrade
			</a>
		</div>
	</div>
</nav>