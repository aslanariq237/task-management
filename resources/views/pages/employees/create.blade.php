<x-app-layout>
    <x-slot name="title">Tambah Karyawan Baru</x-slot>

    <div class="max-w-4xl mx-auto">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Tambah Karyawan Baru</h1>
                <p class="text-gray-600">Masukkan data karyawan baru.</p>
            </div>
        </div>

        @include('pages.employees.form', [
            'employee' => null,
            'route' => route('employees.store'),
            'method' => 'POST'
        ])

    </div>
</x-app-layout>