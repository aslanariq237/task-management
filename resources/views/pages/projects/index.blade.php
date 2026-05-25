<x-app-layout>
    @section('page-title', 'Projects')
    @section('page-link', 'projects - index')
    <x-slot name="title">Projects</x-slot>

    <div class="max-w-7xl mx-auto">                
        {{-- <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">                                    
        </div>         --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">                            
                <div class="relative flex-1 max-w-md">
                    <input type="text" 
                           placeholder="Cari Project..." 
                           class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 pl-12 text-sm focus:outline-none">
                    <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('projects.form') }}" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-medium flex items-center gap-2 transition">
                        <i class="fas fa-plus"></i>
                        Buat Project
                    </a>
                </div>
            </div>            
            <div class="mt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-500">
                            <th class="pb-4 w-12">#</th>
                            <th class="pb-4">CODE</th>
                            <th class="pb-4">PROJECT</th>
                            <th class="pb-4">DEADLINE</th>
                            <th class="pb-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm"> 
                        @forelse ($projects as $index => $project)
                            <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition">
                                <td class="py-5 font-medium text-gray-400">
                                    {{ ($projects->currentPage() - 1) * $projects->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-5 font-medium">{{ $project->code ?? '-' }}</td>
                                <td class="py-5 text-gray-600">{{ $project->name ?? '-' }}</td>
                                <td class="py-5 text-gray-600">{{ $project->ended_at->format('d M Y') ?? '-' }}</td>
                                <td class="py-5 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('projects.edit', $project->id)}}" class="text-blue-600 hover:text-blue-700 transition">
                                            <i class="fas fa-edit text-xl"></i>
                                        </a>
                                        <form id="deleteForm" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <!-- Tombol Delete -->
                                        <a href="#" 
                                        onclick="confirmDelete({{ $project->id }})" 
                                        class="text-red-600 hover:text-red-700 transition">
                                            <i class="fas fa-trash text-xl"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada data Project.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>        
            @if ($projects->hasPages())
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    {{ $projects->links() }}
                </div>
            @endif
            {{-- <div class="flex items-center justify-between mt-8 text-sm">
                <p class="text-gray-500">Menampilkan 1-6 dari 12 project</p>
                
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
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data project ini dan semua task di dalamnya akan terhapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                form.action = `/projects/${id}`;   // Laravel resource route otomatis pakai DELETE
                form.submit();

                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });
    }
</script>
</x-app-layout>