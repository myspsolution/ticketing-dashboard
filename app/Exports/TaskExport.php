<?php

namespace App\Exports;

use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaskExport implements FromCollection, WithHeadings
{
    /** user target opsional (untuk admin) */
    public function __construct(public ?int $targetUserId = null) {}

    public function collection(): Collection
    {
        $user = Auth::user();

        $q = Task::with('user:id,name')
            ->select('id','user_id','title','deskripsi','tanggal','customer','tipe','kategori','completed_at')
            ->orderByDesc('created_at');

        // non-admin: selalu hanya milik dirinya
        if (!$this->isAdmin($user)) {
            $q->where('user_id', $user->id);
        } else {
            // admin: jika diberi target user_id, filterkan; kalau tidak, ambil semua
            if ($this->targetUserId) {
                $q->where('user_id', $this->targetUserId);
            }
        }

        return $q->get()->map(function ($a) {
            return [
                $a->user->name ?? '-',
                $a->title,
                $a->deskripsi,
                $a->tanggal,
                $a->customer,
                $a->tipe,
                $a->kategori,
                $a->completed_at,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama','Judul','Deskripsi','Tanggal','Customer','Tipe','Kategori','Tanggal Selesai'];
    }

    private function isAdmin($user): bool
    {
        // sesuaikan dengan app kamu:
        return method_exists($user, 'hasRole')
            ? $user->hasRole('admin')        // Spatie
            : (($user->role ?? null) === 'admin'); // kolom role sederhana
    }
}
