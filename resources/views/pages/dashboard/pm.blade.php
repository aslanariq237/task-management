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
                        <p class="text-sm text-gray-500">Total Project</p>
                        <p class="text-3xl font-bold text-gray-800">
                            {{count($projects)}}
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
                        <p class="text-sm text-gray-500">Total Tasks</p>
                        <p class="text-3xl font-bold text-gray-800">
                            {{count($tasks)}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-2xl flex items-center justify-center text-green-600">
                        ✅
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Completed Tasks</p>
                        <p class="text-3xl font-bold text-gray-800">
                            {{count($completed)}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600">
                        ⏳
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">In Progress</p>
                        <p class="text-3xl font-bold text-gray-800">
                            {{count($onProgress)}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-2xl flex items-center justify-center text-red-600">
                        ⚠️
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Overdue Tasks</p>
                        <p class="text-3xl font-bold text-red-600">
                            {{count($overdue)}}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

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
            
            <div class="lg:col-span-4 bg-white rounded-3xl p-8 shadow-sm">
                <div class="flex justify-between mb-6">
                    <h3 class="font-semibold text-lg">Upcoming Task</h3>
                    <a href="{{ route('tasks.index') }}" class="text-blue-600 text-sm hover:underline">View All</a>
                </div>
                
                <div class="space-y-6 text-sm">
                    @forelse ($tasks->take(4) as $index => $item)
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <p class="font-medium">
                                    {{ $item->name}}
                                </p>
                                <p class="text-gray-500 text-xs">
                                    {{$item->employee->name}} • {{$item->started_at->format('D M y')}}
                                    {{-- Mall Ambarukmo • 22 Mei 2026 --}}
                                </p>
                            </div>
                            <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-xl h-fit">
                                {{ $item->status === 'on_progress' ? 'In Progress' : $item->status}}
                            </span>
                        </div> 
                    @empty
                        <div class="flex justify-center items-center">
                            <div>                                
                                <p class="font-medium text-sm">Tidak ada Task</p>
                            </div>                            
                        </div>
                    @endforelse
                    {{-- <div class="flex gap-4">
                        <div class="flex-1">
                            <p class="font-medium">Instalasi Kamera Area Parkir</p>
                            <p class="text-gray-500 text-xs">Mall Ambarukmo • 22 Mei 2026</p>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-xl h-fit">In Progress</span>
                    </div>                     --}}
                </div>
            </div>

            <!-- Projects Status -->
            <div class="lg:col-span-3 bg-white rounded-3xl p-8 shadow-sm">
                <div class="flex justify-between mb-6">
                    <h3 class="font-semibold text-lg">Projects Status</h3>
                    <a href="{{ route('projects.index') }}" class="text-blue-600 text-sm hover:underline">View All</a>
                </div>
                
                <div class="space-y-5">
                    @forelse ($projects->take(4) as $index => $item)
                        <div class="flex justify-between items-center">
                            <div>                                
                                <p class="font-medium text-sm">{{$item->name}}</p>
                            </div>
                            <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-xl">
                                {{
                                    $item->status
                                }}
                            </span>
                        </div>
                    @empty
                        <div class="flex justify-center items-center">
                            <div>                                
                                <p class="font-medium text-sm">Tidak ada Project</p>
                            </div>                            
                        </div>
                    @endforelse
                    {{-- <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-sm">Instalasi CCTV Kantor ABC</p>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-xl">In Progress</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-sm">Mall Ambarukmo</p>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-xl">In Progress</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-sm">Hotel Grand Sejahtera</p>
                        </div>
                        <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-xl">Selesai</span>
                    </div> --}}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>