<x-app-layout>
    @section('page-title', 'Create Task')
    @section('page-link', 'Task - Create')
    <x-slot name="title">Buat Task Baru</x-slot>

    <div class="max-w-7xl mx-auto">
        
        {{-- <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('tasks.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Informasi Tasks Baru</h1>
                <p class="text-gray-600">Isi detail di bawah ini untuk menyelenggarakan dan menetapkan tasks baru.</p>
            </div>
        </div> --}}

        <form action="{{ route('tasks.store') }}" method="POST" class="bg-white rounded-3xl shadow-sm p-8">
            @csrf
            <div class="flex justify-between">
                <div class=""></div>
                {{-- <div class="flex items-center gap-4 mb-8">                    
                    <div>
                        <h1 class="text-3xl font-semibold text-gray-800">Informasi Tasks Baru</h1>                        
                    </div>
                </div> --}}
                <div class="flex justify-end gap-4">
                    <a href="{{ route('tasks.index') }}" 
                    class="px-8 py-3 border border-gray-300 rounded-2xl font-medium hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium transition">
                        Buat Task
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tasks <span class="text-red-500">*</span></label>
                    <input type="text" name="name" 
                           class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none"
                           placeholder="Masukkan nama tugas" required>
                </div>                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Project <span class="text-red-500">*</span></label>
                    <select name="project_id" class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none" required>
                        <option value="">Pilih Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assigned Staff <span class="text-red-500">*</span></label>
                    <select name="assigned_at" class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none" required>
                        <option value="">Pilih Staff</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="started_at" 
                           class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
                </div>                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                    <input type="date" name="ended_at" 
                           class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Tasks <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5"
                        class="w-full border border-gray-300 focus:border-blue-500 rounded-3xl px-5 py-4 focus:outline-none"
                        placeholder="Jelaskan detail tugas..."></textarea>
                </div>

            </div>                        
        </form>
    </div>
</x-app-layout>