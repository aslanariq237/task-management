<x-app-layout>
    @section('page-title', 'Employees')
    @section('page-link', 'Employees - index')
    <x-slot name="title">Employee</x-slot>

    <div class="max-w-7xl mx-auto">        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">                                
        </div>
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">                            
                <div class="relative flex-1 max-w-md">
                    <input type="text" 
                           placeholder="Cari Employee..." 
                           class="w-full bg-gray-100 border border-transparent focus:border-gray-300 rounded-2xl py-3 px-5 pl-12 text-sm focus:outline-none">
                    <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                </div>                
                {{-- <div class="flex border-b border-gray-200">
                    <a href="#" class="px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-medium">Semua Tugas</a>
                    <a href="#" class="px-6 py-3 text-gray-500 hover:text-gray-700">Selesai</a>
                </div> --}}
                <div class="md:mt-0">                    
                    <a href="{{ route('employees.create') }}" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-medium flex items-center gap-2 transition">
                        <i class="fas fa-plus"></i>
                        Tambah Employee Baru
                    </a>
                </div>
            </div>            
            <div class="mt-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-sm text-gray-500">
                            <th class="pb-4 w-12">#</th>
                            <th class="pb-4">CODE</th>
                            <th class="pb-4">NAME</th>
                            <th class="pb-4">EMAIL</th>
                            <th class="pb-4">DATE</th>                            
                            <th class="pb-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($employees as $index => $employee)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-5 font-medium text-gray-400">
                                    {{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-5 font-medium">{{ $employee->code }}</td>
                                <td class="py-5 text-gray-600">{{ $employee->name }}</td>
                                <td class="py-5 text-gray-600">{{ $employee->email }}</td>
                                <td class="py-5 text-gray-600">{{  $employee->created_at->format('D M y') }}</td>                                
                                <td class="py-5 text-center">
                                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-5 py-2.5 rounded-2xl inline-flex items-center gap-1">
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
            @if ($employees->hasPages())
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    {{ $employees->links() }}
                </div>
            @endif            
        </div>
    </div>
</x-app-layout>