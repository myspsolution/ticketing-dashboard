@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold">Edit Task</h2>
        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block">Kembali ke Dashboard</a>
    </div>

    <div class="grid grid-cols-1 place-items-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-1/2 lg:w-1/3">
            <form action="{{ route('task.update', $task->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="title" class="block font-medium">Judul:</label>
                    <input type="text" name="title" id="title"
                        class="w-full border rounded px-3 py-2"
                        value="{{ old('title', $task->title) }}" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block font-medium">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi"
                            class="w-full border rounded px-3 py-2" rows="3" required>{{ old('deskripsi', $task->deskripsi) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="tanggal" class="block font-medium">Tanggal:</label>
                    <input type="date" name="tanggal" id="tanggal"
                        class="w-full border rounded px-3 py-2"
                        value="{{ old('tanggal', \Carbon\Carbon::parse($task->tanggal)->format('Y-m-d')) }}" required>
                </div>

                <div class="mb-4">
                    <label for="customer" class="block font-medium">Customer:</label>
                    <select name="customer" id="customer" class="w-full border rounded px-3 py-2" required>
                        @foreach (['WIKA', 'Viral', 'Fithub', 'STI', 'BSG', 'BSSB', 'Garuda Food', 'BSI', 'MAOAPA', 'OrangP', 'Xentix'] as $customer)
                            <option value="{{ $customer }}" {{ old('customer', $task->customer) == $customer ? 'selected' : '' }}>
                                {{ $customer }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="tipe" class="block font-medium">Tipe:</label>
                    <select name="tipe" id="tipe" class="w-full border rounded px-3 py-2" required>
                        <option value="standart" {{ old('tipe', $task->tipe) == 'standart' ? 'selected' : '' }}>Standard</option>
                        <option value="custom"   {{ old('tipe', $task->tipe) == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="kategori" class="block font-medium">Kategori:</label>
                    <select name="kategori" id="kategori" class="w-full border rounded px-3 py-2" required>
                        <option value="pending"    {{ old('kategori', $task->kategori) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="inprogress" {{ old('kategori', $task->kategori) == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done"       {{ old('kategori', $task->kategori) == 'done' ? 'selected' : '' }}>Done</option>
                        <option value="cancel"     {{ old('kategori', $task->kategori) == 'cancel' ? 'selected' : '' }}>Cancel</option>
                    </select>
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
