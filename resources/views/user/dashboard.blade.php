@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold">Dashboard</h2>
        <p class="text-gray-600">Halo, {{ Auth::user()->name }}!</p>
    </div>
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded">
            {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded">
            {{ session('error') }}
    </div>
    @endif

    {{-- FORM TAMBAH TASK --}}
    <div class="grid grid-cols-1 place-items-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-1/2 lg:w-1/3">
            <h3 class="text-lg font-semibold mb-4">Tambah Task Baru</h3>
            <form action="{{ route('task.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block font-medium">Judul:</label>
                    <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block font-medium">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="tanggal" class="block font-medium">Tanggal:</label>
                    <input type="date" name="tanggal" id="tanggal" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label for="customer" class="block font-medium">Customer:</label>
                    <select name="customer" id="customer" class="w-full border rounded px-3 py-2" required>
                        @foreach (['WIKA', 'Viral', 'Fithub', 'STI', 'BSG', 'BSSB', 'Garuda Food', 'BSI', 'MAOAPA', 'OrangP', 'Xentix'] as $customer)
                            <option value="{{ $customer }}">{{ $customer }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="tipe" class="block font-medium">Tipe:</label>
                    <select name="tipe" id="tipe" class="w-full border rounded px-3 py-2" required>
                        <option value="standart">Standard</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="kategori" class="block font-medium">Kategori:</label>
                    <select name="kategori" id="kategori" class="w-full border rounded px-3 py-2" required>
                        <option value="pending">Pending</option>
                        <option value="inprogress">In Progress</option>
                        <option value="done">Done</option>
                        <option value="cancel">Cancel</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    {{-- LIST TASK --}}
    <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto mt-10">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Daftar Task</h3>
            <a href="{{ route('task.export') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200">
                Export ke Excel
            </a>
        </div>

        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Aksi</th>
                    <th class="px-4 py-2">Judul</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Customer</th>
                    <th class="px-4 py-2">Tipe</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Tanggal Selesai</th>
                    <th class="px-4 py-2">Update Terakhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr class="border-b">
                       <td class="px-4 py-2">
                            <div class="flex gap-3 items-center">

                                {{-- ICON EDIT --}}
                                <a href="{{ route('task.edit', $task->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded"
                                    title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 3.487a2.1 2.1 0 113 3L7.5 18.75 3 19.5l.75-4.5L16.862 3.487z"/>
                                        </svg>
                                </a>

                                {{-- ICON DELETE --}}
                               <form action="{{ route('task.destroy', $task->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus task ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.108 1.022.168M4.772 5.79c.34-.06.68-.116 1.022-.168m9.968 0l-.5 12.59A2.25 2.25 0 0112.02 20.25h-.04a2.25 2.25 0 01-2.24-2.02l-.5-12.59m13.5 0H3.75m16.5 0H20.25M3.75 5.79H2.25" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>

                        <td class="px-4 py-2">{{ $task->title }}</td>
                        <td class="px-4 py-2">{{ $task->deskripsi }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($task->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $task->customer }}</td>
                        <td class="px-4 py-2">
                            @php
                                $tipe = strtolower($task->tipe);
                                $bgColor = $tipe === 'standart'
                                    ? 'bg-green-100 text-green-800'
                                    : ($tipe === 'custom'
                                        ? 'bg-blue-100 text-blue-800'
                                        : 'bg-gray-100 text-gray-800');
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $bgColor }}">
                                {{ ucfirst($task->tipe) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('task.update', $task->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="kategori" class="border px-7 py-1 rounded" onchange="this.form.submit()">
                                    <option value="pending"    {{ $task->kategori == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="inprogress" {{ $task->kategori == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="done"       {{ $task->kategori == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="cancel"     {{ $task->kategori == 'cancel' ? 'selected' : '' }}>Cancel</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-2">
                            @if($task->completed_at)
                                {{ \Carbon\Carbon::parse($task->completed_at)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($task->updated_at)
                                {{ \Carbon\Carbon::parse($task->updated_at)->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center text-gray-500">Belum ada task.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
