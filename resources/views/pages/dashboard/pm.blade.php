<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <div class="max-w-7xl mx-auto">        
        <div class="mb-6">
            <h2 class="text-2xl lg:text-3xl font-semibold text-gray-800">
                Hello, {{ Auth::user()->name ?? 'User' }} 👋
            </h2>
            <p class="text-gray-500 text-sm mt-1">Here's what's happening today.</p>
        </div>        
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-6">

            <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0">📁</div>
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 truncate">Total Project</p>
                    <p class="text-2xl font-bold text-gray-800">{{ count($projects) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0">📋</div>
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 truncate">Total Tasks</p>
                    <p class="text-2xl font-bold text-gray-800">{{ count($tasks) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0">✅</div>
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 truncate">Completed</p>
                    <p class="text-2xl font-bold text-gray-800">{{ count($completed) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0">⏳</div>
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 truncate">In Progress</p>
                    <p class="text-2xl font-bold text-gray-800">{{ count($onProgress) }}</p>
                </div>
            </div>            
            <div class="col-span-2 lg:col-span-1 bg-white rounded-2xl p-4 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0">⚠️</div>
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 truncate">Overdue Tasks</p>
                    <p class="text-2xl font-bold text-red-600">{{ count($overdue) }}</p>
                </div>
            </div>
        </div>        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">            
            <div class="lg:col-span-5 bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-base text-gray-800">Task Progress Summary</h3>
                    <select class="bg-gray-100 border-0 rounded-xl px-8 py-1.5 text-xs text-gray-600 focus:outline-none">
                        <option>All Projects</option>
                    </select>
                </div>                
                <div class="flex justify-center my-4">
                    <div class="relative w-48 h-48">
                        <svg class="w-48 h-48 -rotate-90" viewBox="0 0 42 42">
                            <circle cx="21" cy="21" r="15" fill="none" stroke="#e5e7eb" stroke-width="6"/>
                            <circle cx="21" cy="21" r="15" fill="none" stroke="#22c55e" stroke-width="6"
                                    stroke-dasharray="94.2" stroke-dashoffset="0" stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <p class="text-4xl font-bold text-gray-800">{{count($tasks)}}</p>                            
                            <p class="text-xs text-gray-500">Total</p>
                        </div>
                    </div>
                </div>                
                <div class="grid grid-cols-3 gap-2 mt-4 text-xs">
                    <div class="flex flex-col items-center gap-1 bg-green-50 rounded-xl p-2">
                        <div class="w-2.5 h-2.5 bg-green-500 rounded-full"></div>
                        <span class="text-gray-600 text-center">Selesai</span>
                        <span class="font-semibold text-gray-800">{{
                            count($completed)}} (42.9%)</span>
                    </div>
                    <div class="flex flex-col items-center gap-1 bg-blue-50 rounded-xl p-2">
                        <div class="w-2.5 h-2.5 bg-blue-500 rounded-full"></div>
                        <span class="text-gray-600 text-center">In Progress</span>
                        <span class="font-semibold text-gray-800">{{
                            count($onProgress)}} (38.1%)</span>
                    </div>
                    <div class="flex flex-col items-center gap-1 bg-yellow-50 rounded-xl p-2">
                        <div class="w-2.5 h-2.5 bg-yellow-500 rounded-full"></div>
                        <span class="text-gray-600 text-center">To Do</span>
                        <span class="font-semibold text-gray-800">{{
                            count($onProgress)}} (19.0%)</span>
                    </div>
                </div>
            </div>            
            <div class="lg:col-span-4 bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-base text-gray-800">Upcoming Tasks</h3>
                    <a href="{{ route('tasks.index') }}" class="text-blue-600 text-xs hover:underline">View All</a>
                </div>

                <div class="space-y-4">
                    @forelse ($tasks->take(4) as $item)
                        <div class="flex items-start gap-3">                            
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-sm text-gray-800 truncate">{{ $item->name }}</p>
                                <p class="text-gray-400 text-xs mt-0.5">
                                    {{ $item->employee->name }} • {{ $item->started_at->format('d M Y') }}
                                </p>
                            </div>
                            <span class="
                                flex-shrink-0 text-xs px-2.5 py-1 rounded-lg font-medium
                                {{ $item->status === 'on_progress' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $item->status === 'done' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $item->status === 'todo' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            ">
                                {{ $item->status === 'on_progress' ? 'In Progress' : ucfirst($item->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-2xl mb-3">📋</div>
                            <p class="text-sm text-gray-500">Tidak ada task</p>
                        </div>
                    @endforelse
                </div>
            </div>            
            <div class="lg:col-span-3 bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-base text-gray-800">Projects Status</h3>
                    <a href="{{ route('projects.index') }}" class="text-blue-600 text-xs hover:underline">View All</a>
                </div>

                <div class="space-y-3">
                    @forelse ($projects->take(4) as $item)
                        <div class="flex items-center justify-between gap-2">
                            <p class="font-medium text-sm text-gray-800 truncate flex-1">{{ $item->name }}</p>
                            <span class="
                                flex-shrink-0 text-xs px-2.5 py-1 rounded-lg font-medium
                                {{ $item->status === 'on_progress' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $item->status === 'done' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $item->status === 'todo' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ !in_array($item->status, ['on_progress','done','todo']) ? 'bg-gray-100 text-gray-600' : '' }}
                            ">
                                {{ $item->status === 'on_progress' ? 'In Progress' : ucfirst($item->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-2xl mb-3">📁</div>
                            <p class="text-sm text-gray-500">Tidak ada project</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>