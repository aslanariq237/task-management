<x-app-layout>
    @section('page-title', 'Report')
    @section('page-link', 'report - index')
    <x-slot name="title">Reports</x-slot>

    <div class="max-w-7xl mx-auto">            
        <!-- Filters -->
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Search -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Cari Tugas</label>
                    <div class="relative">
                        <input type="text" id="search" 
                               placeholder="Cari tugas..." 
                               class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 pl-12 text-sm focus:outline-none">
                        <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                    </div>
                </div>

                <!-- Project Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Project</label>
                    <select id="project-filter" 
                            class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 text-sm focus:outline-none">
                        <option value="">Semua Project</option>
                        <option value="1">Instalasi CCTV</option>
                        <option value="2">PT Mandiri Persero</option>
                        <option value="3">Instalasi Security Access</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select id="status-filter" 
                            class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 text-sm focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="selesai">Selesai</option>
                        <option value="in_progress">In Progress</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Selesai</label>
                    <input type="date" id="date-filter"
                           class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 text-sm focus:outline-none">
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex justify-end gap-3 mt-6">
                <button onclick="resetFilters()" 
                        class="px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-2xl transition">
                    Reset Filter
                </button>
                <button onclick="applyFilters()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium transition">
                    Terapkan Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-500">
                            <th class="py-5 px-6 w-12">#</th>
                            <th class="py-5 px-6">NAMA TUGAS</th>
                            <th class="py-5 px-6">PROJECT</th>
                            <th class="py-5 px-6">DATE COMPLETED</th>
                            <th class="py-5 px-6">ASSIGNED</th>
                            <th class="py-5 px-6">STATUS</th>
                            <th class="py-5 px-6 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm" id="task-table">
                        <!-- Data akan diisi di sini (contoh) -->
                        {{-- @foreach(range(1,6) as $i)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-5 px-6 font-medium text-gray-400">{{$i}}</td>
                            <td class="py-5 px-6 font-medium">Survey Lokasi Gedung Baru</td>
                            <td class="py-5 px-6 text-gray-600">Instalasi CCTV</td>
                            <td class="py-5 px-6 text-gray-600">17 Apr 2026</td>
                            <td class="py-5 px-6 text-gray-700">Udin Saputro</td>
                            <td class="py-5 px-6">
                                <span class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-medium rounded-2xl">Selesai</span>
                            </td>
                            <td class="py-5 px-6 text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <button class="text-yellow-500 hover:text-yellow-600 transition">
                                        <i class="fas fa-edit text-xl"></i>
                                    </button>
                                    <button class="text-green-600 hover:text-green-700 transition">
                                        <i class="fas fa-file-download text-xl"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach --}}
                        @forelse ($tasks as $index => $task)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-5 font-medium text-gray-400">
                                    {{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-5 font-medium">{{ $task->name }}</td>
                                <td class="py-5 text-gray-600">{{ $task->project->name }}</td>
                                <td class="py-5 text-gray-600">{{  $task->ended_at->format('D M y') }}</td>
                                <td class="py-5 text-gray-600">{{  $task->employee->name }}</td>
                                <td class="py-5">
                                    <span class="px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-2xl">
                                        {{
                                            $task->status == 'on_progress' 
                                                ? 'In Progress'
                                                : $task->status

                                        }}
                                    </span>
                                </td>
                                <td class="py-5 px-6 text-center">
                                    <div class="flex items-center justify-center gap-4">
                                        <button class="text-yellow-500 hover:text-yellow-600 transition">
                                            <i class="fas fa-edit text-xl"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-700 transition">
                                            <i class="fas fa-file-download text-xl"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>  
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada data Task.
                                </td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>
            </div>
            @if ($tasks->hasPages())
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    {{ $tasks->links() }}
                </div>
            @endif

            <!-- Pagination -->
            {{-- <div class="flex items-center justify-between px-6 py-5 border-t">
                <p class="text-gray-500 text-sm">Menampilkan 1-6 dari 12 task</p>
                
                <div class="flex gap-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-2xl hover:bg-gray-50">Previous</button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-2xl">1</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-2xl hover:bg-gray-50">2</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-2xl hover:bg-gray-50">Next</button>
                </div>
            </div> --}}
        </div>
    </div>

    <script>
        function resetFilters() {
            document.getElementById('search').value = '';
            document.getElementById('project-filter').value = '';
            document.getElementById('status-filter').value = '';
            document.getElementById('date-filter').value = '';
            alert('Filter telah direset');
        }

        function applyFilters() {
            alert('Filter diterapkan! (Fitur pencarian dinamis bisa ditambahkan dengan JavaScript / Livewire nanti)');
        }
    </script>
</x-app-layout>