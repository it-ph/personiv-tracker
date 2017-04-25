<?php

namespace App\Http\Controllers;

use App\Task;
use App\Pause;
use App\Traits\Enlist;
use Illuminate\Http\Request;

use Carbon\Carbon;
use DB;

class TaskController extends Controller
{
    use Enlist;

    public function download($date_start, $date_end, $time_start, $time_end)
    {
        $task = new Task;

        return $task->toExcel($date_start, $date_end, $time_start, $time_end);
    }

    /**
     * Returns data for dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $task = new Task;

        return $task->dashboard();
    }

    /**
     * Resume a pause record of task.
     *
     * @return \Illuminate\Http\Response
     */
    public function resume(Request $request, Task $task)
    {
        // Check if the user owns the task
        $this->authorize('update', $task);

        DB::transaction(function() use($request, $task){
            $pause = Pause::findOrFail($request->id);

            $pause->resume();

            $task->loadUnfinishedPauses();
        });

        return $task;
    }

    /**
     * Create a pause record for task.
     *
     * @return \Illuminate\Http\Response
     */
    public function pause(Task $task)
    {
        // Check if the user owns the task
        $this->authorize('update', $task);

        DB::transaction(function() use($task){
            $task->pauses()->save(new Pause);

            $task->loadUnfinishedPauses();
        });

        return $task;
    }

    /**
     * Mark task as finished.
     *
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request, Task $task)
    {
        // Check if the user owns the task
        $this->authorize('update', $task);

        DB::transaction(function() use($request, $task){        
            if($request->has('id'))
            {
                $pause = Pause::findOrFail($request->id);

                $pause->resume();
            }

            $task->ended_at = Carbon::now();

            $task->timeSpent();

            $task->save();
        });
    }

    /**
     * Display a listing of the resource with parameters.
     *
     * @return \Illuminate\Http\Response
     */
    public function enlist(Request $request)
    {
        $this->model = Task::query();

        $this->populate($request);

        if($request->has('search'))
        {
            $this->model->where('title', 'like', '%'. $request->search .'%');
        }

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
            'title' => 'required',
        ]);

        $task = new Task;

        $task->populate($request);

        $task->user_id = $request->user()->id;

        $task->save();

        if($task->account_id)
        {
            $task->load('account', 'pauses');
        }

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
        // Check if the user owns the task
        $this->authorize('update', $task);

        $this->validate($request, [
            'title' => 'required',
        ]);

        $task->populate($request);

        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // Check if the user owns the task
        // $this->authorize('delete', $task);

        // $task->delete();
    }
}
