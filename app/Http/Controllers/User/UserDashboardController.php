<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // ✅ Tambahkan baris ini
use App\Models\Task;

class UserDashboardController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        return view('user.dashboard', compact('tasks'));
    }

    // public function dashboard()
    // {
    //     $tasks = Task::where('user_id', auth()->id())->get();
    //     return view('user.dashboard', compact('tasks'));
    // }

//    public function update(Request $request, $id)
//     {
//         $request->validate([
//             'kategori' => 'required|string|in:pending,inprogress,done,cancel',
//         ]);

//         // Ambil task milik user yang sedang login
//         $task = Task::where('user_id', auth()->id())->findOrFail($id);

//         $task->kategori = $request->kategori;

//         if (in_array($request->kategori, ['done', 'cancel'])) {
//             $task->completed_at = now();
//         } else {
//             $task->completed_at = null;
//         }

//         $task->save();

//         return back()->with('success', 'Kategori task berhasil diperbarui.');
//     }

    public function dashboard()
    {
        $user = Auth::user();

        // Kalau admin, bisa lihat semua task
        if ($user->role === 'admin') {
            $tasks = Task::latest()->get();
        } else {
            // Kalau user biasa, hanya lihat task miliknya
            $tasks = Task::where('user_id', $user->id)->latest()->get();
        }

        return view('user.dashboard', compact('tasks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|string|in:pending,inprogress,done,cancel',
        ]);

        $task = Task::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin' && $task->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses untuk mengubah task ini.');
        }

        $task->kategori = strtolower($request->kategori);
        $task->completed_at = in_array($task->kategori, ['done', 'cancel']) ? now() : null;
        $task->save();

        return back()->with('success', 'Kategori task berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin' && $task->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses untuk menghapus task ini.');
        }

        $task->delete();

        return back()->with('success', 'Task berhasil dihapus.');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();

        // Hanya admin atau pemilik task
        if ($user->role !== 'admin' && $task->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses untuk mengedit task ini.');
        }

        return view('user.task_edit', compact('task'));
    }


}
