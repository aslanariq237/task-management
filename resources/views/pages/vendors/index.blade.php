<x-app-layout>
    <x-slot name="title">Vendors</x-slot>

    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">Vendors</h2>
            
            <div class="mt-4 md:mt-0">
                <a href="{{ route('vendors.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-medium flex items-center gap-2 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Vendor Baru
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative flex-1 max-w-md">
                    <input type="text" 
                           placeholder="Cari vendor..." 
                           class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 pl-12 text-sm focus:outline-none">
                    <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                </div>
            </div>

            <!-- Table -->
            <div class="mt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-500">
                            <th class="pb-4 w-12">#</th>
                            <th class="pb-4">KODE VENDOR</th>
                            <th class="pb-4">NAMA VENDOR</th>
                            <th class="pb-4">EMAIL</th>
                            <th class="pb-4">ALAMAT</th>
                            <th class="pb-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($vendors as $index => $vendor)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-5 font-medium text-gray-400">
                                    {{ ($vendors->currentPage() - 1) * $vendors->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-5 font-medium text-gray-700">{{ $vendor->code }}</td>
                                <td class="py-5 font-medium">{{ $vendor->name }}</td>
                                <td class="py-5 text-gray-600">{{ $vendor->email }}</td>
                                <td class="py-5 text-gray-600 text-sm">{{ $vendor->address ?? '-' }}</td>
                                <td class="py-5 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <!-- Edit -->
                                        <a href="{{ route('vendors.edit', $vendor) }}" 
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2.5 rounded-2xl text-xs transition">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Delete -->
                                        <a href="#" onclick="confirmDelete({{ $vendor->id }})"
                                           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-2xl text-xs transition">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500">
                                    Belum ada data Vendor.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($vendors->hasPages())
                <div class="mt-6">
                    {{ $vendors->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- SweetAlert Delete Script -->
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin hapus vendor ini?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/vendors/${id}`;
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