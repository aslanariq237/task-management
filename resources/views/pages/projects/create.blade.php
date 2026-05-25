<x-app-layout>
    @section('page-title', 'Create New Project')
    @section('page-link', 'Project - Create')
    <x-slot name="title">Buat Project Baru</x-slot>

    <div class="max-w-7xl mx-auto">        
        {{-- <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('projects.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Buat Project Baru</h1>
                <p class="text-gray-600">Buat project baru untuk menyelenggarakan pekerjaan tim Anda.</p>
            </div>
        </div> --}}

        @include('pages.projects.form', [
            'project' => null,
            'employees' => $employees,
            'route' => route('projects.store'),
            'method' => 'POST'
        ])

    </div>
</x-app-layout>