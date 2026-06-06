@props([
    'vendor' => null,
    'route' => null,
    'method' => 'POST'
])

<form action="{{ $route }}" method="POST" class="bg-white rounded-3xl shadow-sm p-8">
    @csrf
    @if($method === 'PUT' || $method === 'PATCH')
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Code -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Vendor / Perusahaan <span class="text-red-500">*</span></label>
            <input type="text" name="name" 
                   value="{{ old('name', $vendor?->name) }}"
                   class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none"
                   placeholder="PT. Maju Jaya Abadi" required>
        </div>

        <!-- Name -->
        <div>            
            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" 
                   value="{{ old('email', $vendor?->email) }}"
                   class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none"
                   placeholder="vendor@perusahaan.com" required>
        </div>        

        <!-- Address -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
            <textarea name="address" rows="3"
                class="w-full border border-gray-300 focus:border-blue-500 rounded-3xl px-5 py-4 focus:outline-none"
                placeholder="Jl. Contoh No. 123, Kota, Provinsi">{{ old('address', $vendor?->address) }}</textarea>
        </div>

    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-4 mt-10">
        <a href="{{ route('vendors.index') }}" 
           class="px-8 py-3 border border-gray-300 rounded-2xl font-medium hover:bg-gray-50 transition">
            Batal
        </a>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium transition">
            {{ $vendor ? 'Update Vendor' : 'Simpan Vendor' }}
        </button>
    </div>
</form>