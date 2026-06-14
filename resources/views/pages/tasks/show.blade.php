<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    @section('page-title', 'Task Detail')
    @section('page-link', 'Tasks - Detail')
    <x-slot name="title">Detail Tugas</x-slot>

    <div class="max-w-7xl mx-auto">                
        <form action="{{ route('tasks.update', $task) }}" method="POST" enctype="multipart/form-data">
            <div class="flex justify-between gap-4 mb-8">                                
                <div></div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('tasks.index') }}" class="text-gray-500 hover:text-gray-700">
                        Kembali
                    </a>
                    
                    @if($task->status !== 'completed')
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium transition">
                        Simpan Perubahan
                    </button>
                    @endif
                </div> 
            </div>

            <div class="bg-white rounded-3xl shadow-sm p-8">            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">NAMA TUGAS</p>
                        <p class="font-semibold text-xl text-gray-800">{{ $task->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">DEADLINE</p>
                        <p class="font-semibold text-xl text-gray-800">{{ $task->ended_at ? $task->ended_at->format('d F Y') : '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-1">PROJECT</p>
                        <p class="font-medium">{{ $task->project->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">DITUGASKAN KEPADA</p>
                        <p class="font-medium">{{ $task->employee->name ?? '-' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 mb-2">DESKRIPSI TUGAS</p>
                        <p class="text-gray-700 leading-relaxed">{{ $task->description ?? '-' }}</p>
                    </div>
                </div>
                <hr class="my-8">            
                <h3 class="text-lg font-semibold mb-6">Informasi Pengerjaan</h3>                        
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>                        
                        <label class="block text-sm text-gray-600 mb-2">Nama Perusahaan/Client <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="client"
                               placeholder="PT ABC"
                               value="{{ old('client', $task->client) }}"
                               class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Alamat Proyek <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="address"
                               placeholder="jln. ABC"
                               value="{{ old('address', $task->address) }}"
                               class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Task <span class="text-red-500">*</span></label>
                        <select name="status" 
                                class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-4 focus:outline-none">
                            <option value="on_progress" {{ old('status', $task->status) == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="overdue" {{ old('status', $task->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Lokasi Kerja/Area</label>
                        <input type="text" 
                               name="work_location"
                               placeholder="PT. ABC"
                               value="{{ old('work_location', $task->project?->location) }}"
                               class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none" disabled>
                    </div>                    
                </div>
                <div class="mt-6">
                    <label class="block text-sm text-gray-600 mb-2">Pekerjaan yang Dilakukan</label>
                    <textarea name="to_do" rows="4" placeholder="• Konfigurasi kamera ke DVR" class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-3xl px-5 py-4 focus:outline-none"@if($task->status === 'completed') disabled @endif>{{old('to_do',$task->to_do)}}</textarea>
                </div>
                <div class="mt-6">
                    <label class="block text-sm text-gray-600 mb-2">Catatan (optional)</label>
                    <textarea name="notes" rows="3" placeholder="• masukkan catatan disini (optional)" class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-3xl px-5 py-4 focus:outline-none" @if($task->status === 'completed') disabled @endif>{{old('notes',$task->notes)}}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-4">
                    <div>                
                        <label class="block text-sm text-gray-600 mb-2">Mulai Pekerjaan<span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                id="tanggal_mulai"
                                name="started_at"
                                value="{{ old('started_at', $task->started_at ? $task->started_at->format('Y-m-d') : '') }}"
                                class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none pr-12"
                                placeholder="Pilih Tanggal">                            
                        </div>
                    </div>
                    <div>                
                        <label class="block text-sm text-gray-600 mb-2">Selesai Pekerjaan<span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                id="tanggal_mulai"
                                name="ended_at"
                                value="{{ old('ended_at', $task->ended_at ? $task->ended_at->format('Y-m-d') : '') }}"
                                class="w-full bg-gray-50 border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none pr-12"
                                placeholder="Pilih Tanggal">                            
                        </div>
                    </div>                   
                </div>
                <div class="mt-10">
                    <label class="block text-sm text-gray-600 mb-3">Dokumentasi Pekerjaan (Foto)</label>                                    
                        <div class="flex gap-3">
                        @hasanyrole('staff')
                            @if($task->status !== 'completed')
                                <div class="border-2 border-dashed border-gray-300 rounded-3xl pt-8 text-center hover:border-blue-400 transition">
                                    <input 
                                        type="file" 
                                        name="images[]" 
                                        id="image-upload" 
                                        multiple 
                                        accept="image/*" 
                                        class="hidden"
                                        >
                                    <label for="image-upload" class="cursor-pointer">
                                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-600 font-medium">Klik untuk upload foto</p>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG (maksimal 5 foto)</p>
                                    </label>
                                </div>
                            @endif   
                        @endhasanyrole                 
                        @if($task->images && $task->images->count() > 0)
                            <div class="mt-6">
                                <p class="text-sm text-gray-500 mb-3">Foto yang sudah diupload:</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($task->images as $doc)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $doc->image_url) }}" 
                                            class="w-full h-32 object-cover rounded-2xl">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>                    
                </div>                
            </div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#tanggal_mulai", {
                locale: "id",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j F Y",
                allowInput: true
            });
        });
    </script>
</x-app-layout>