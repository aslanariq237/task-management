@props([
    'project' => null,
    'employees' => [],
    'route' => null,
    'method' => 'POST'
])

<form 
    action="{{ $route}}"
    {{-- action="{{ route('projects.store') }}"  --}}
    method="POST" 
    class="bg-white rounded-3xl shadow-sm p-8">
    @csrf
    @if($method === 'PUT' || $method === 'PATCH')
        @method('PUT')
    @endif
    
    <div class="flex justify-end gap-4">
        <a href="{{ route('projects.index') }}" 
           class="px-8 py-3 border border-gray-300 rounded-2xl font-medium hover:bg-gray-50 transition">
            Batal
        </a>
        <button 
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium transition"
        >
            {{ $project ? 'Update Project' : 'Simpan Project' }}
        </button>
    </div>

    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-6 h-6 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-sm font-bold">1</div>
            <h2 class="text-xl font-semibold">Informasi Project</h2>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Project <span class="text-red-500">*</span></label>
                <input type="text" name="name" 
                       value="{{ old('name', $project?->name) }}"
                       class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none"
                       placeholder="Masukkan nama project" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Project <span class="text-red-500">*</span></label>
                <textarea 
                    name="description" 
                    rows="4"
                    class="w-full border border-gray-300 focus:border-blue-500 rounded-3xl px-5 py-4 focus:outline-none"
                    placeholder="Jelaskan deskripsi project ini...">{{ old('description', $project?->description) }}
                </textarea>
            </div>                  
        </div>
    </div>        
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-6 h-6 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-sm font-bold">2</div>
            <h2 class="text-xl font-semibold">Timeline Project</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                <input type="date" name="started_at" 
                       value="{{ old('started_at', $project?->started_at?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deadline <span class="text-red-500">*</span></label>
                <input type="date" name="ended_at" 
                       value="{{ old('ended_at', $project?->ended_at?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none" required>
            </div>
        </div>
    </div>    
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-6 h-6 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-sm font-bold">3</div>
            <h2 class="text-xl font-semibold">Lokasi Project (Opsional)</h2>
        </div>
        <input type="text" name="location" 
               value="{{ old('location', $project?->location) }}"
               class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none"
               placeholder="Masukkan lokasi project">
    </div>    
    {{-- <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-6 h-6 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-sm font-bold">4</div>
            <h2 class="text-xl font-semibold">Status Project</h2>
        </div>
        <select name="status" class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none">
            <option value="planned" {{ old('status', $project?->status) == 'planned' ? 'selected' : '' }}>Planned</option>
            <option value="ongoing" {{ old('status', $project?->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
            <option value="completed" {{ old('status', $project?->status) == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ old('status', $project?->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>     --}}
    <div class="mb-10">
        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
        <textarea name="notes" rows="4"
            class="w-full border border-gray-300 focus:border-blue-500 rounded-3xl px-5 py-4 focus:outline-none"
            placeholder="Tambahkan catatan penting terkait project ini...">{{ old('notes', $project?->notes) }}</textarea>
    </div>    
</form>
<script>
    let selectedVendorId = null;

    const vendorSearchInput = document.getElementById('vendor-search');
    const vendorResults = document.getElementById('vendor-results');
    const selectedVendorContainer = document.getElementById('selected-vendor');
    const vendorIdInput = document.getElementById('vendor-id-input');

    const allVendors = @json($vendors);   // pastikan $vendors dikirim dari controller

    vendorSearchInput.addEventListener('input', function() {
        const keyword = this.value.toLowerCase().trim();

        if (keyword.length < 1) {
            vendorResults.classList.add('hidden');
            return;
        }

        const filtered = allVendors.filter(vendor => 
            vendor.name.toLowerCase().includes(keyword) || 
            (vendor.code && vendor.code.toLowerCase().includes(keyword))
        );

        let html = '';

        filtered.forEach(vendor => {
            html += `
                <div onclick="selectVendor(${vendor.id}, '${vendor.name}', '${vendor.code || ''}')" 
                     class="px-5 py-4 hover:bg-gray-100 cursor-pointer flex items-center gap-4 border-b last:border-0">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-semibold text-lg">
                        ${vendor.code ? vendor.code.substring(0,2) : 'V'}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">${vendor.name}</p>
                        ${vendor.code ? `<p class="text-xs text-gray-500">Kode: ${vendor.code}</p>` : ''}
                        ${vendor.email ? `<p class="text-xs text-gray-500">${vendor.email}</p>` : ''}
                    </div>
                </div>
            `;
        });

        vendorResults.innerHTML = html || '<div class="p-6 text-gray-500 text-center">Vendor tidak ditemukan</div>';
        vendorResults.classList.remove('hidden');
    });

    function selectVendor(id, name, code) {
        selectedVendorId = id;
        vendorIdInput.value = id;

        selectedVendorContainer.innerHTML = `
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-semibold">
                    ${code ? code.substring(0,2) : 'V'}
                </div>
                <div class="flex-1">
                    <p class="font-medium">${name}</p>
                    ${code ? `<p class="text-xs text-gray-500">Kode: ${code}</p>` : ''}
                </div>
                <button type="button" onclick="removeSelectedVendor()" 
                        class="text-red-500 hover:text-red-700 text-xl leading-none">×</button>
            </div>
        `;

        vendorSearchInput.value = '';
        vendorResults.classList.add('hidden');
    }

    function removeSelectedVendor() {
        selectedVendorId = null;
        vendorIdInput.value = '';
        selectedVendorContainer.innerHTML = '';
        vendorSearchInput.focus();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#vendor-search')) {
            vendorResults.classList.add('hidden');
        }
    });
</script>

<script>
    let selectedMembers = [];

    const searchInput = document.getElementById('member-search');
    const resultsContainer = document.getElementById('search-results');
    const selectedContainer = document.getElementById('selected-members');
    const membersInput = document.getElementById('members-input');    
    const allEmployees = @json($employees);

    searchInput.addEventListener('input', function() {
        const keyword = this.value.toLowerCase().trim();
        
        if (keyword.length < 1) {
            resultsContainer.classList.add('hidden');
            return;
        }

        const filtered = allEmployees.filter(emp => 
            emp.name.toLowerCase().includes(keyword) && 
            !selectedMembers.includes(emp.id)
        );

        let html = '';
        filtered.forEach(emp => {
            html += `
                <div onclick="addMember(${emp.id}, '${emp.name}')" 
                     class="px-4 py-3 hover:bg-gray-100 cursor-pointer flex items-center gap-3 border-b last:border-0">
                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-medium">
                        ${emp.name.substring(0,1)}
                    </div>
                    <div>
                        <p class="font-medium">${emp.name}</p>
                        <p class="text-xs text-gray-500">Staff</p>
                    </div>
                </div>
            `;
        });

        resultsContainer.innerHTML = html || '<div class="p-4 text-gray-500">Tidak ditemukan</div>';
        resultsContainer.classList.remove('hidden');
    });

    function addMember(id, name) {
        if (selectedMembers.includes(id)) return;

        selectedMembers.push(id);

        const div = document.createElement('div');
        div.className = "bg-blue-50 border border-blue-200 text-blue-700 px-4 py-2 rounded-2xl flex items-center gap-2 text-sm";
        div.innerHTML = `
            ${name}
            <button type="button" onclick="removeMember(${id}, this)" 
                    class="ml-2 text-blue-400 hover:text-red-500">×</button>
        `;
        selectedContainer.appendChild(div);

        updateHiddenInput();
        searchInput.value = '';
        resultsContainer.classList.add('hidden');
    }

    function removeMember(id, element) {
        selectedMembers = selectedMembers.filter(memberId => memberId !== id);
        element.parentElement.remove();
        updateHiddenInput();
    }

    function updateHiddenInput() {
        membersInput.value = selectedMembers.join(',');
    }

    // Close dropdown ketika klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#member-search')) {
            resultsContainer.classList.add('hidden');
        }
    });
</script>