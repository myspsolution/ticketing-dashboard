<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            padding: 30px;
        }

        h2 {
            color: #333;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            width: 100%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        th {
            background-color: #e9ecef;
        }

        .inline-form {
            display: inline;
        }

        .centered {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>

    <h2>Tambah Task Baru</h2>
    <form method="POST" action="{{ route('user.task.store') }}">
        @csrf
        <label>Judul:</label>
        <input type="text" name="title" required>

        <label>Deskripsi:</label>
        <textarea name="deskripsi" rows="3" required></textarea>

        <label>Tanggal:</label>
        <input type="date" name="tanggal" required>

        <label>Customer:</label>
        <select name="customer">
            <option value="WIKA">WIKA</option>
            <option value="SP Solution">SP Solution</option>
        </select>

        <label>Tipe:</label>
        <select name="tipe">
            <option value="Standard">Standard</option>
            <option value="Custom">Custom</option>
        </select>

        <label>Kategori:</label>
        <select name="kategori">
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Done">Done</option>
            <option value="Cancel">Cancel</option>
        </select>

        <button type="submit">Simpan</button>
    </form>

    <h2>Daftar Task</h2>
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>
                        <form method="POST" action="{{ route('user.task.update', $task->id) }}" class="inline-form">
                            @csrf
                            @method('PATCH')
                            <select name="kategori" onchange="this.form.submit()">
                                <option value="Pending" {{ $task->kategori === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $task->kategori === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Done" {{ $task->kategori === 'Done' ? 'selected' : '' }}>Done</option>
                                <option value="Cancel" {{ $task->kategori === 'Cancel' ? 'selected' : '' }}>Cancel</option>
                            </select>
                        </form>
                    </td>
                    <td class="centered">
                        {{ in_array($task->kategori, ['Done', 'Cancel']) ? \Carbon\Carbon::parse($task->updated_at)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="centered">Belum ada task.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
