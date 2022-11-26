<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::getAllTasks();

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = new Task();

        $task->name = $request->input('name');
        $task->starts_at = $request->input('starts_at');
        $task->description = $request->input('description');

        $task->save();

        return response()->json(['message' => "a tarefa $task->name foi adicionada com sucesso!"]);
    }

    public function edit(EditTaskRequest $request, $id)
    {
        $task = Task::find($id);

        if (isset($task)) {
            $validated = $request->validated();

            foreach($validated as $key=>$value){
                $task[$key] = $value;
            }

            $task->save();

            return response()->json(['message' => "a tarefa $task->name foi editada com sucesso!"]);
        }

        return response()->json(['message' => "A tarefa de id $id não foi encontrada."], 404);
    }

    public function delete($id)
    {
        $task = Task::find($id);

        if (isset($task)) {
            $task->delete();

            return response()->json(['message' => 'tarefa deletada com sucesso!']);
        }

        return response()->json(['message' => "A tarefa de id $id não foi encontrada."], 404);
    }
}
