<x-app-layout>
    @section('page-title', 'Task Detail')
    @section('page-link', 'Tasks - Detail')
    <x-slot name="title">Detail Tugas</x-slot>

    <div class="max-w-5xl mx-auto">                
        <form action="#" method="POST">
            <div class="flex justify-between gap-4 mb-8">                                
                <div class=""></div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('tasks.index') }}" class="text-gray-500 hover:text-gray-700">
                        {{-- <i class="fas fa-arrow-left text-2xl"></i> --}}
                        Kembali
                    </a>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 px-3 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium transition">
                            Simpan Perubahan
                        </button>
                    </div> 
                </div>
            </div>
            <div class="bg-white rounded-3xl shadow-sm p-8">            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">NAMA TUGAS</p>
                        {{-- <p class="font-semibold text-xl text-gray-800">Instalasi Listrik di PLN</p> --}}
                    <p class="font-semibold text-xl text-gray-800">{{ $task->name }}</p>
                    </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">DEADLINE</p>
                    {{-- <p class="font-semibold text-xl text-gray-800">20 April 2026</p> --}}
                    <p class="font-semibold text-xl text-gray-800">{{ $task->ended_at ? $task->ended_at->format('d F Y') : '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">PROJECT</p>
                    <p class="font-medium">{{ $task->project->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">DITUGASKAN KEPADA</p>
                    <p class="font-medium">{{$task->employee->name}} <span class="text-gray-500 text-sm">(Staff)</span></p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 mb-2">DESKRIPSI TUGAS</p>
                    <p class="text-gray-700 leading-relaxed">{{ $task->description ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-8">

            <!-- Informasi Pengerjaan -->
            <h3 class="text-lg font-semibold mb-6">Informasi Pengerjaan</h3>                        
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Nama Perusahaan/Client <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="client_name"
                               value="PT ABC"
                               class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Alamat Proyek <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="project_address"
                               value="PT ABC"
                               class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Jenis Pekerjaan</label>
                        <select name="job_type" class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
                            <option value="Instalasi">Instalasi</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Repair">Repair</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Lokasi Kerja/Area</label>
                        <input type="text" 
                               name="work_location"
                               value="PT ABC"
                               class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
                    </div>
                </div>
                <div class="mt-6">
                    <label class="block text-sm text-gray-600 mb-2">Pekerjaan yang Dilakukan</label>
                    <textarea name="work_done" rows="4"
                        class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-3xl px-5 py-4 focus:outline-none">• Konfigurasi kamera ke DVR
                            • Pemeriksaan Kabel UTP dan Power
                            • Pemasangan 4 Unit Kamera</textarea>
                </div>
                <div class="mt-6">
                    <label class="block text-sm text-gray-600 mb-2">Catatan</label>
                    <textarea name="notes" rows="3"
                        class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-3xl px-5 py-4 focus:outline-none">Semua perangkat berfungsi dengan baik. Menunggu setting remote access dari IT.</textarea>
                </div>                                           
            </div>
        </form>
    </div>
</x-app-layout>