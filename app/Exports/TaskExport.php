<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaskExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Task::select('title', 'deskripsi', 'tanggal', 'customer', 'tipe', 'kategori', 'completed_at')->get();
    }

    public function headings(): array
    {
        return ['Judul', 'Deskripsi', 'Tanggal', 'Customer', 'Tipe', 'Kategori', 'Tanggal Selesai'];
    }
}
