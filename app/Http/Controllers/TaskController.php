<?php

namespace App\Http\Controllers;

use App\Task;
use App\Traits\Enlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use Enlist;

    /**
     * Mark task as finished.
     *
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->ended_at = Carbon::now();

        $task->save();
    }

    /**
     * Display a listing of the resource with parameters.
     *
     * @return \Illuminate\Http\Response
     */
    public function enlist(Request $request)
    {
        $this->model = Task::query();

        $this->populateRequest($request);

        if($request->first)
        {
            return $this->model->first();        
        }

        if($request->paginate)
        {
            return $this->model->paginate($request->paginate);
        }

        return $this->model->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $task = new Task;

        $task->title = $request->title;
        $task->user_id = $request->user()->id;

        $task->save();

        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
