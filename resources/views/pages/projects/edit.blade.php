<x-app-layout>
    @section('page-title', 'Edit Project')
    @section('page-link', 'Project - Edit - '.$project->code)
    <x-slot name="title">Edit Project</x-slot>

    <div class="max-w-7xl mx-auto">    
        {{-- <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('projects.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Edit Project</h1>
                <p class="text-gray-600">{{ $project->name }}</p>
            </div>
        </div> --}}

        @include('pages.projects.form', [
            'project' => $project,
            'employees' => $employees,            
            'route' => route('projects.update', $project),
            'method' => 'PUT'
        ])

    </div>
</x-app-layout>