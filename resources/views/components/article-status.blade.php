@props(['status'])

{{-- Logika untuk menentukan warna berdasarkan status --}}
@php
    $statusText = ucfirst($status);
    $colorClasses = match ($status) {
        'draft' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
        'pending' => 'bg-blue-100 text-blue-800 border border-blue-300',
        'published' => 'bg-green-100 text-green-800 border border-green-300',
        'archived' => 'bg-gray-100 text-gray-800 border border-gray-300',
        default => 'bg-red-100 text-red-800 border border-red-300',
    };
@endphp

{{-- Tampilan Badge --}}
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $colorClasses }}">
    {{ $statusText }}
</span>
