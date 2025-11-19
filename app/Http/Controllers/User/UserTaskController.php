<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class UserTaskController extends Controller
{
    public function create()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('user.form', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal'   => 'required|date',
            'customer'  => 'required|in:WIKA,Viral,Fithub,STI,BSG,BSSB,Garuda Food,BSI,MAOAPA,OrangP,Xentix',
            'tipe'      => 'required|in:standart,custom',
            'kategori'  => 'required|in:pending,inprogress,done,cancel',
        ]);

        $validated['user_id'] = Auth::id();

        // set completed_at saat create bila status done/cancel
        $status = strtolower(trim($validated['kategori']));
        if (in_array($status, ['done', 'cancel'], true)) {
            $validated['completed_at'] = now();
        } // ← ini yang tadi belum ketutup

        Task::create($validated);

        return redirect()->route('dashboard')->with('success', 'Task berhasil disimpan!');
    }

    /**
     * TAMPILKAN FORM EDIT
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();

        // hanya admin atau pemilik task
        if ($user->role !== 'admin' && $task->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses untuk mengedit task ini.');
        }

        return view('user.task_edit', compact('task'));
    }

    /**
     * UPDATE TASK (dipakai baik dari form edit maupun dropdown kategori)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|required|string',
            'tanggal'   => 'sometimes|required|date',
            'customer'  => 'sometimes|required|in:WIKA,Viral,Fithub,STI,BSG,BSSB,Garuda Food,BSI,MAOAPA,OrangP,Xentix',
            'tipe'      => 'sometimes|required|in:standart,custom',
            'kategori'  => 'sometimes|required|in:pending,inprogress,done,cancel',
        ]);

        $task = Task::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin' && $task->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses untuk mengubah task ini.');
        }

        // field dari form edit
        if ($request->filled('title')) {
            $task->title = $request->title;
        }
        if ($request->filled('deskripsi')) {
            $task->deskripsi = $request->deskripsi;
        }
        if ($request->filled('tanggal')) {
            $task->tanggal = $request->tanggal;
        }
        if ($request->filled('customer')) {
            $task->customer = $request->customer;
        }
        if ($request->filled('tipe')) {
            $task->tipe = $request->tipe;
        }

        // kategori bisa dari form edit atau dropdown di dashboard
        if ($request->filled('kategori')) {
            $task->kategori = strtolower($request->kategori);
            $task->completed_at = in_array($task->kategori, ['done', 'cancel'])
                ? now()
                : null;
        }

        $task->save();

        return redirect()->route('dashboard')->with('success', 'Task berhasil diperbarui.');
    }
}
