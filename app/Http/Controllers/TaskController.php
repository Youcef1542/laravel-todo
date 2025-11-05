<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Affiche la liste des tâches
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    // Ajoute une nouvelle tâche
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        Task::create($data);
        return redirect()->back();
    }

    // Marque une tâche comme terminée / non terminée
    public function update(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        return redirect()->back();
    }

    // Supprime une tâche
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }


public function toggle(Task $task)
{
    $task->completed = !$task->completed;
    $task->save();

    return redirect('/');
 }
}
