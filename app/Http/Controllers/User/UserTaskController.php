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
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'customer' => 'required|in:WIKA,Viral,Fithub,STI,BSG,BSSB,Garuda Food,BSI',
            'tipe' => 'required|in:standart,custom',
            'kategori' => 'required|in:pending,inprogress,done,cancel',
        ]);

        $validated['user_id'] = Auth::id();

        Task::create($validated);

        return redirect()->route('dashboard')->with('success', 'Task berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|in:pending,inprogress,done,cancel',
        ]);

        $task = Task::where('user_id', Auth::id())->findOrFail($id); // pastikan hanya task milik user

        $task->kategori = strtolower($request->kategori);

        $task->completed_at = in_array($task->kategori, ['done', 'cancel']) ? now() : null;

        $task->save();

        return redirect()->back()->with('success', 'Task berhasil diperbarui!');
    }
}
