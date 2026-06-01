<x-app-layout>
    @section('page-title', 'Tasks')
    @section('page-link', 'tasks - index')
    <x-slot name="title">Tasks</x-slot>

    <div class="max-w-7xl mx-auto">        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">                                
        </div>
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">                            
                <div class="relative flex-1 max-w-md">
                    <input type="text" 
                           placeholder="Cari tugas..." 
                           class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 pl-12 text-sm focus:outline-none">
                    <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                </div>                
                @role('manager')
                    <div class="md:mt-0">
                        <a href="{{ route('tasks.form') }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-medium flex items-center gap-2 transition">
                            <i class="fas fa-plus"></i>
                            Tambah Task Baru
                        </a>
                    </div>
                @endrole
            </div>            
            <div class="mt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-500">
                            <th class="pb-4 w-12">#</th>
                            <th class="pb-4">NAMA TUGAS</th>
                            <th class="pb-4">PROJECT</th>
                            <th class="pb-4">DEADLINE</th>
                            <th class="pb-4">STATUS</th>
                            <th class="pb-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($tasks as $index => $task)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-5 font-medium text-gray-400">
                                    {{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-5 font-medium">{{ $task->name }}</td>
                                <td class="py-5 text-gray-600">{{ $task->project->name ?? '-' }}</td>
                                <td class="py-5 text-gray-600">{{ $task->ended_at ? $task->ended_at->format('D M y') : '-' }}</td>
                                <td class="py-5">
                                    @php                                        
                                        $statusClasses = [
                                            'completed'   => 'bg-green-100 text-green-700',
                                            'on_progress' => 'bg-blue-100 text-blue-700',
                                            'overdue'     => 'bg-red-100 text-red-700'
                                        ];                                        
                                        $currentClass = $statusClasses[$task->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp

                                    <span class="px-4 py-1.5 text-xs font-medium rounded-2xl {{ $currentClass }}">
                                        {{
                                            $task->status == 'on_progress' 
                                                ? 'In Progress'
                                                : ucfirst($task->status)
                                        }}
                                    </span>
                                </td>
                                <td class="py-5 text-center">
                                    <div class="flex items-center justify-center gap-3">                                        
                                        @if($task->status == 'completed')
                                            <a href="{{ route('tasks.show', $task) }}" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-5 py-2.5 rounded-2xl inline-flex items-center gap-1">
                                                Detail <span class="text-lg leading-none">→</span>
                                            </a>
                                        @endif                                                                            
                                        @if($task->status != 'completed')
                                            <a href="{{ route('tasks.show', $task) }}" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium px-4 py-2.5 rounded-2xl transition">
                                                <i class="fas fa-edit"></i>
                                            </a>                                                                            
                                            <a href="#" 
                                            onclick="confirmDelete({{ $task->id }})"
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-4 py-2.5 rounded-2xl transition">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>  
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
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
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus task ini?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/tasks/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>
</x-app-layout>
{{-- <x-app-layout>
    @section('page-title', 'Tasks')
    @section('page-link', 'tasks - index')
    <x-slot name="title">Tasks</x-slot>

    <div class="max-w-7xl mx-auto">        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">                                
        </div>
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">                            
                <div class="relative flex-1 max-w-md">
                    <input type="text" 
                           placeholder="Cari tugas..." 
                           class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 pl-12 text-sm focus:outline-none">
                    <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                </div>                
                {{-- <div class="flex border-b border-gray-200">
                    <a href="#" class="px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-medium">Semua Tugas</a>
                    <a href="#" class="px-6 py-3 text-gray-500 hover:text-gray-700">Selesai</a>
                </div>
                <div class="md:mt-0">
                    <a href="{{ route('tasks.form') }}" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-medium flex items-center gap-2 transition">
                        <i class="fas fa-plus"></i>
                        Tambah Task Baru
                    </a>
                </div>
            </div>            
            <div class="mt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-500">
                            <th class="pb-4 w-12">#</th>
                            <th class="pb-4">NAMA TUGAS</th>
                            <th class="pb-4">PROJECT</th>
                            <th class="pb-4">DEADLINE</th>
                            <th class="pb-4">STATUS</th>
                            <th class="pb-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($tasks as $index => $task)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-5 font-medium text-gray-400">
                                    {{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-5 font-medium">{{ $task->name }}</td>
                                <td class="py-5 text-gray-600">{{ $task->project->name }}</td>
                                <td class="py-5 text-gray-600">{{  $task->ended_at->format('D M y') }}</td>
                                <td class="py-5">
                                    <span class="px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-2xl">
                                        {{
                                            $task->status == 'on_progress' 
                                                ? 'In Progress'
                                                : $task->status

                                        }}
                                    </span>
                                </td>
                                <td class="py-5 text-center">
                                    <a href="{{ route('tasks.show', $task) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-5 py-2.5 rounded-2xl inline-flex items-center gap-1">
                                        Detail <span class="text-lg leading-none">→</span>
                                    </a>
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
            {{-- <div class="flex items-center justify-between mt-8 text-sm">
                <p class="text-gray-500">Menampilkan 1-6 dari 12 tugas</p>
                
                <div class="flex gap-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-2xl hover:bg-gray-50">Previous</button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-2xl">1</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-2xl hover:bg-gray-50">2</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-2xl hover:bg-gray-50">Next</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}