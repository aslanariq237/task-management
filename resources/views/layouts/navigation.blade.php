<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shadow-sm">
    <div class="">
        <h1 class="text-2xl font-semibold text-gray-800">
            @yield('page-title', 'Dashboard')        
        </h1>
        <p class="text-gray-400 text-sm font-semibold">
            @yield('page-link', 'Dashboard')
        </p>
    </div>

    <div class="flex items-center gap-6">
        <button class="relative text-gray-600 hover:text-gray-800">
            <i class="fas fa-bell text-xl"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">3</span>
        </button>

        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="font-medium text-sm">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-gray-500">Staff</p>
            </div>
            <div class="w-9 h-9 bg-blue-600 text-white rounded-2xl flex items-center justify-center font-bold">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
        </div>
    </div>
</header>