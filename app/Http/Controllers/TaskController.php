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

    public function dashboard(Request $request)
    {
        $request->user()->load('subordinates');

        $subordinateIds = $request->user()->subordinates->pluck('id');

        $accounts = \App\Account::where('department_id', $request->user()->department_id)->get();

        foreach ($accounts as $key => $account) {
            $account->employees = \App\User::whereIn('id', $subordinateIds)->with(['tasks' => function($query) use($request){
                $query->whereBetween('ended_at', [Carbon::parse($request->from), Carbon::parse($request->to)]);
            }])->get();

            foreach ($account->employees as $key => $employee) {
                // $employee->new = 
            }

            // $account->employees

            // Task::whereIn('user_id', $subordinateIds)->whereBetween('ended_at', [Carbon::parse($request->from), Carbon::parse($request->to)])->get()->groupBy('user_id')->toArray();
        }

        /*
            {
                accounts: [
                    {
                        employees : [
                            {
                                *details,
                                new: integer,
                                revisions: integer,
                                hours_spent: float,
                            },
                        ],
                    },
                ],
            }
        */

        return $accounts;

        // $collection = collect(['accounts' => $accounts]);

        // return $collection;
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
