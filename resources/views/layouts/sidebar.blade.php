<nav class="w-64 bg-white border-r border-gray-200 h-full flex flex-col shadow-sm">    
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                T
            </div>
            <div>
                <span class="text-2xl font-bold text-gray-900">TaskFlow</span>
                <p class="text-xs text-gray-500 -mt-0.5">Work Smarter, Track Better</p>
            </div>
        </div>
    </div>    
    <div class="flex-1 px-4 py-6 overflow-y-auto">
        <p class="px-3 text-xs font-semibold text-gray-500 mb-4">MAIN MENU</p>
        
        <div class="space-y-1">
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <i class="fas fa-home w-5 mr-3"></i> 
                Dashboard
            </x-nav-link>
            @hasanyrole('manager')
                <x-nav-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')">
                    <i class="fas fa-folder w-5 mr-3"></i> Projects
                </x-nav-link>                
            @endhasanyrole            

            @hasanyrole('staff||manager')
                <x-nav-link href="{{ route('tasks.index') }}" :active="request()->routeIs('tasks.*')">
                    <i class="fas fa-tasks w-5 mr-3"></i> 
                    Tasks
                </x-nav-link>
            @endhasanyrole  
            @hasanyrole('manager')            
                <x-nav-link href="{{ route('reports.index') }}" :active="request()->routeIs('reports.*')">
                    <i class="fas fa-folder w-5 mr-3"></i> 
                    Reports
                </x-nav-link>                
            @endhasanyrole             

            @hasanyrole('admin')
                <x-nav-link href="{{ route('employees.index') }}" :active="request()->routeIs('employees.*')">
                    <i class="fas fa-users w-5 mr-3"></i> 
                    Employees
                </x-nav-link>                
            @endhasanyrole
        </div>
    </div>    
    <div class="p-4 border-t border-gray-100 mt-auto">
        <x-nav-link href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="text-red-600 hover:bg-red-50">
            <i class="fas fa-sign-out-alt w-5 mr-3"></i> 
            Log Out
        </x-nav-link>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</nav>