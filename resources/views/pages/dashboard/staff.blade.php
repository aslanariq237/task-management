<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="max-w-7xl mx-auto">
        
        <!-- Greeting -->
        <div class="mb-8">
            <h2 class="text-3xl font-semibold text-gray-800">
                Hello, {{ Auth::user()->name ?? 'Sarah Johnson' }} 👋
            </h2>
            <p class="text-gray-600 mt-1">Here's what's happening with your tasks today.</p>
        </div>

        <!-- Today's Tasks -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fas fa-calendar-day text-blue-600"></i>
                    Today's Tasks
                </h3>
                <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:underline text-sm font-medium flex items-center gap-1">
                    Lihat Semua <span class="text-lg leading-none">→</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Task 1 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-800">Update project documentation</p>
                            <p class="text-sm text-gray-500 mt-1">Today, 3:00 PM</p>
                        </div>
                        <span class="px-4 py-1.5 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-2xl">
                            In Progress
                        </span>
                    </div>
                </div>

                <!-- Task 2 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-800">Review UI mockups for client</p>
                            <p class="text-sm text-gray-500 mt-1">Today, 5:00 PM</p>
                        </div>
                        <span class="px-4 py-1.5 text-xs font-medium bg-gray-100 text-gray-600 rounded-2xl">
                            To Do
                        </span>
                    </div>
                </div>

                <!-- Task 3 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-800">Submit weekly progress report</p>
                            <p class="text-sm text-gray-500 mt-1">Today, 8:00 PM</p>
                        </div>
                        <span class="px-4 py-1.5 text-xs font-medium bg-gray-100 text-gray-600 rounded-2xl">
                            To Do
                        </span>
                    </div>
                </div>

                <!-- Task 4 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-800">Fix login page bug</p>
                            <p class="text-sm text-gray-500 mt-1">Today, 4:30 PM</p>
                        </div>
                        <span class="px-4 py-1.5 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-2xl">
                            In Progress
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Overdue Tasks -->
        <div>
            <h3 class="text-lg font-semibold flex items-center gap-2 mb-5 text-red-600">
                <i class="fas fa-exclamation-triangle"></i>
                Overdue Tasks
            </h3>

            <div class="space-y-4">
                @forelse ($overdue as $index => $task)
                    <div class="bg-white border border-red-100 rounded-3xl p-6 hover:shadow-md transition-all">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{$task->name}}
                                </p>
                                <p class="text-red-500 text-sm mt-1">Deadline was: 
                                    {{$task->ended_at->format('M d, Y')}}
                                </p>
                            </div>
                            <span class="px-5 py-2 text-xs font-medium bg-red-100 text-red-700 rounded-2xl">
                                {{$task->status}}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="flex justify-center items-center">
                        <div>                                
                            <p class="font-medium text-slate-400 text-sm">Tidak ada Task</p>
                        </div>                            
                    </div>
                @endforelse                                                
            </div>
        </div>

    </div>
</x-app-layout>