<header class="bg-white border-b border-gray-200 px-4 lg:px-6 py-4 flex items-center gap-4 shadow-sm sticky top-0 z-20 flex-shrink-0">    
    <button
        onclick="toggleSidebar()"
        class="lg:hidden flex-shrink-0 w-9 h-9 flex items-center justify-center
               rounded-xl text-gray-600 hover:bg-gray-100 transition-colors"
        aria-label="Toggle menu"
    >
        <i class="fas fa-bars text-lg"></i>
    </button>    
    <div class="flex-1 min-w-0">
        <h1 class="text-xl lg:text-2xl font-semibold text-gray-800 truncate">
            @yield('page-title', 'Dashboard')
        </h1>
        <p class="text-gray-400 text-xs lg:text-sm font-semibold truncate">
            @yield('page-link', 'Dashboard')
        </p>
    </div>    
    <div class="flex items-center gap-3 lg:gap-6 flex-shrink-0">
        <button class="relative text-gray-600 hover:text-gray-800">
            <i class="fas fa-bell text-xl"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">3</span>
        </button>

        <div class="flex items-center gap-2 lg:gap-3">
            <div class="text-right hidden lg:block">
                <p class="font-medium text-sm leading-tight">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-gray-500">
                    {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'staff') }}
                </p>
            </div>
            <div class="w-9 h-9 bg-blue-600 text-white rounded-2xl flex items-center justify-center font-bold flex-shrink-0">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
        </div>
    </div>
</header>