@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-xl font-bold">Admin Dashboard</h1>

    <h2 class="mt-6 font-semibold">Grafik Pekerjaan User</h2>
    <canvas id="taskChart" width="400" height="150"></canvas>

     {{-- Tabel DITARUH DI LUAR grid agar tampil di bawah --}}
    <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto mt-10">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar Task</h3>
        <a href="{{ route('task.export') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200">
            Export ke Excel
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto mt-10">
        <h3 class="text-lg font-semibold mb-4">Daftar Task</h3>
        <table class="w-full table-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Judul</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Tipe</th>
                        <th class="px-4 py-2">Kategori</th>
                        <th class="px-4 py-2">Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $task->user->name }}</td> <!-- Tampilkan nama user yang terkait dengan task -->
                            <td class="px-4 py-2">{{ $task->title }}</td>
                            <td class="px-4 py-2">{{ $task->deskripsi }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($task->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ $task->customer }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $tipe = strtolower($task->tipe);
                                    $bgColor = $tipe === 'standart' ? 'bg-green-100 text-green-800' : ($tipe === 'custom' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800');
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $bgColor }}">
                                    {{ ucfirst($task->tipe) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('task.update', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="kategori" class="border px-2 py-1 rounded" onchange="this.form.submit()">
                                        <option value="pending" {{ $task->kategori == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="inprogress" {{ $task->kategori == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="done" {{ $task->kategori == 'done' ? 'selected' : '' }}>Done</option>
                                        <option value="cancel" {{ $task->kategori == 'cancel' ? 'selected' : '' }}>Cancel</option>
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
                            <!-- Menambahkan Nama User -->
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('taskChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($users->pluck('name')) !!},  // Menampilkan nama pengguna sebagai label
            datasets: [
                {
                    label: 'Pending',
                    data: {!! json_encode($pendingCounts) !!},  // Data kategori 'pending'
                    backgroundColor: 'orange',
                    barThickness: 30,
                },
                {
                    label: 'In Progress',
                    data: {!! json_encode($inProgressCounts) !!},  // Data kategori 'inprogress'
                    backgroundColor: 'blue',
                    barThickness: 30,
                },
                {
                    label: 'Done',
                    data: {!! json_encode($doneCounts) !!},  // Data kategori 'done'
                    backgroundColor: 'green',
                    barThickness: 30,
                },
                {
                    label: 'Cancel',
                    data: {!! json_encode($cancelCounts) !!},  // Data kategori 'cancel'
                    backgroundColor: 'red',
                    barThickness: 30,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 3,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1  // Menampilkan langkah setiap 1 nilai pada sumbu Y
                        
                    }
                }
            },
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Status Pekerjaan User' }
            }
        }
    });
</script>
@endsection
