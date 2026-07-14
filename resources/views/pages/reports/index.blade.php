<x-app-layout>
    @section('page-title', 'Report')
    @section('page-link', 'report - index')
    <x-slot name="title">Reports</x-slot>

    <div class="max-w-7xl mx-auto">
        <form method="GET" action="{{ route('reports.index') }}" class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Cari Tugas</label>
                    <div class="relative">
                        <input type="text"
                               id="search"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari tugas..."
                               class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 pl-12 text-sm focus:outline-none">
                        <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Project</label>
                    <select id="project-filter"
                            name="project_id"
                            class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 text-sm focus:outline-none">
                        <option value="">Semua Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select id="status-filter"
                            name="status"
                            class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 text-sm focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="on_progress" {{ request('status') == 'on_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Selesai</label>
                    <input type="date"
                           id="date-filter"
                           name="date"
                           value="{{ request('date') }}"
                           class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 text-sm focus:outline-none">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('reports.index') }}" class="px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-2xl transition">
                    Reset Filter
                </a>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium transition" type="submit">
                    Terapkan Filter
                </button>
            </div>
        </form>

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
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($tasks as $index => $task)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-5 px-6 font-medium text-gray-400">
                                    {{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-5 px-6 font-medium">{{ $task->name }}</td>
                                <td class="py-5 px-6 text-gray-600">{{ $task->project->name ?? '-' }}</td>
                                <td class="py-5 px-6 text-gray-600">{{ $task->ended_at ? $task->ended_at->format('D M y') : '-' }}</td>
                                <td class="py-5 px-6 text-gray-600">{{ $task->employee->name ?? '-' }}</td>
                                <td class="py-5 px-6">
                                    <span class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-medium rounded-2xl">
                                        {{ $task->status == 'on_progress' ? 'In Progress' : ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td class="py-5 px-6 text-center">
                                    <div class="flex items-center justify-center gap-4">
                                        <a href="{{ route('reports.pdf', $task) }}" class="text-green-600 hover:text-green-700 transition">
                                            <i class="fas fa-file-download text-xl"></i>
                                        </a>
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
        </div>
    </div>
</x-app-layout>
