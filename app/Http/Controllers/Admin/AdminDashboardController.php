<?php

// In AdminDashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get all users and their tasks
       $users = User::where('role', '!=', 'admin')->with('tasks')->get();


        // Get task data for the chart
        $pendingCounts = [];
        $inProgressCounts = [];
        $doneCounts = [];
        $cancelCounts = [];

       foreach ($users as $user) {
            $pendingCounts[] = $user->tasks()->where('kategori', 'pending')->count();
            $inProgressCounts[] = $user->tasks()->where('kategori', 'inprogress')->count();
            $doneCounts[] = $user->tasks()->where('kategori', 'done')->count();
            $cancelCounts[] = $user->tasks()->where('kategori', 'cancel')->count();
        }

    
        // Get tasks for the task table
        $tasks = \App\Models\Task::all(); // Get all tasks from the database

        // Pass all the data to the view
        return view('admin.dashboard', compact('users', 'tasks', 'pendingCounts', 'inProgressCounts', 'doneCounts', 'cancelCounts'));
    }
}


