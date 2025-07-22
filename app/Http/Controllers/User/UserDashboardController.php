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
        return view('dashboard', compact('tasks'));
    }

    public function dashboard()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('user.dashboard', compact('tasks'));
    }

   public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|string|in:pending,inprogress,done,cancel',
        ]);

        // Ambil task milik user yang sedang login
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        $task->kategori = $request->kategori;

        if (in_array($request->kategori, ['done', 'cancel'])) {
            $task->completed_at = now();
        } else {
            $task->completed_at = null;
        }

        $task->save();

        return back()->with('success', 'Kategori task berhasil diperbarui.');
    }

}
