<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <p>Selamat datang, {{ Auth::user()->name }} (Admin)</p>
            </div>
        </div>
    </div>
</x-app-layout>
