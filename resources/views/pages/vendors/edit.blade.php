<x-app-layout>
    <x-slot name="title">Edit Vendor</x-slot>

    <div class="max-w-4xl mx-auto">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('vendors.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Edit Vendor</h1>
                <p class="text-gray-600">{{ $vendor->name }}</p>
            </div>
        </div>

        @include('pages.vendors.form', [
            'vendor' => $vendor,
            'route' => route('vendors.update', $vendor),
            'method' => 'PUT'
        ])

    </div>
</x-app-layout>