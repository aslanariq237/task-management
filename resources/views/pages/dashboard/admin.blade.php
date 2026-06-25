<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="max-w-7xl mx-auto">
        
        <!-- Greeting -->
        <div class="mb-8">
            <h2 class="text-3xl font-semibold text-gray-800">
                Hello, {{ Auth::user()->name ?? 'Eric Lee' }} 👋
            </h2>
            <p class="text-gray-600 mt-1">Here's what's happening today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-10">
            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600">
                        📁
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total User</p>
                        <p class="text-3xl font-bold text-gray-800">
                            {{count($user)}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600">
                        📋
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Role</p>
                        <p class="text-3xl font-bold text-gray-800">
                            {{count($roles)}}
                        </p>
                    </div>
                </div>
            </div>                             
        </div>

        {{-- <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Task Progress Summary -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-8 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-semibold text-lg">Task Progress Summary</h3>
                    <select class="bg-gray-100 border-0 rounded-2xl px-4 py-2 text-sm">
                        <option>All Projects</option>
                    </select>
                </div>
                
                <div class="flex justify-center">
                    <div class="relative w-64 h-64">
                        <svg class="w-64 h-64 -rotate-12" viewBox="0 0 42 42">
                            <circle cx="21" cy="21" r="15" fill="none" stroke="#e5e7eb" stroke-width="6"></circle>
                            <circle cx="21" cy="21" r="15" fill="none" stroke="#22c55e" stroke-width="6" 
                                    stroke-dasharray="94.2" stroke-dashoffset="0" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <p class="text-5xl font-bold text-gray-800">42</p>
                            <p class="text-sm text-gray-500">Total</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-8 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span>Selesai</span>
                        <span class="ml-auto font-medium">18 (42.9%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span>In Progress</span>
                        <span class="ml-auto font-medium">16 (38.1%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <span>To Do</span>
                        <span class="ml-auto font-medium">8 (19.0%)</span>
                    </div>
                </div>
            </div>                                  
        </div> --}}
    </div>
</x-app-layout>