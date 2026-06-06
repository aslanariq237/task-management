@props([
    'employee' => null,
    'route' => null,
    'method' => 'POST',
    'roles' => []           // Kirim semua roles dari controller
])

<form action="{{ $route }}" method="POST" class="bg-white rounded-3xl shadow-sm p-8">
    @csrf
    @if($method === 'PUT' || $method === 'PATCH')
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        <!-- Code -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" 
                   value="{{ old('name', $employee?->name) }}"
                   class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none"
                   placeholder="Nama Karyawan" required>
        </div>

        <!-- Name -->
        <div>            
            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" 
                   value="{{ old('email', $employee?->email) }}"
                   class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none"
                   placeholder="email@perusahaan.com" required>
        </div>        

        <!-- Role -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Role / Jabatan <span class="text-red-500">*</span></label>
            <select name="role" 
                    class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none h-32"
                    required>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" 
                        @if($employee && $employee->hasRole($role->name)) selected @endif>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>            
        </div>

        <!-- Name -->
        <div>            
            <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
            <input type="password" name="password" 
                   value="{{ old('password', '') }}"
                   class="w-full border border-gray-300 focus:border-blue-500 rounded-2xl px-5 py-3 focus:outline-none"
                   placeholder="minimum 8 word" required>
        </div>  

    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-4 mt-10">
        <a href="{{ route('employees.index') }}" 
           class="px-8 py-3 border border-gray-300 rounded-2xl font-medium hover:bg-gray-50 transition">
            Batal
        </a>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium transition">
            {{ $employee ? 'Update Karyawan' : 'Simpan Karyawan' }}
        </button>
    </div>
</form>