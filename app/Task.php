<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Support\TaskReports;

use Carbon\Carbon;
use Excel;

class Task extends Model
{
    use TaskReports;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['ended_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['ended_at'];  

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'revision' => 'boolean',
    ];

    /**
     * Get the user record associated with the task.
     */
    public function user()
    {
    	return $this->belongsTo('App\Task');
    }

    /**
     * Get the account record associated with the task.
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    /**
     * Get the pause records associated with the task.
     */
    public function pauses()
    {
        return $this->hasMany('App\Pause');
    }

    /**
     * Fill the task properties with user request.
     */
    public function populate($request)
    {
        $this->title = $request->title;
        $this->account_id = $request->account_id;
        $this->revision = $request->revision ? $request->revision : false;
        $this->number_of_photos = $request->number_of_photos;
    }

    /**
     * Get pause records associated with the task where paused is unfinished.
     */
    public function loadUnfinishedPauses()
    {
        $this->load(['pauses' => function($query){
            $query->whereNull('ended_at')->orderBy('created_at', 'desc');
        }]);
    }

    /**
     * Calculate the overall time and subtract the idle time.
     */
    public function timeSpent()
    {
        $this->minutesIdle();
        $this->minutesSpent();
    }

    /**
     * Sum of pauses associated with the task.
     */
    protected function minutesIdle()
    {
        $this->load('pauses');

        $this->minutes_idle = $this->pauses()->sum('minutes_spent');
    }

    /**
     * Difference of overall time and time idle while doing the task.
     */
    protected function minutesSpent()
    {
        // Difference in minutes of the time task created and end time.
        $overall = round(Carbon::parse($this->created_at)->diffInSeconds(Carbon::parse($this->ended_at)) / 60, 2);

        $this->minutes_spent = $overall - $this->minutes_idle;
    }

    public function dashboard()
    {
        $this->scope();

        // Check the time range
        if(count(request()->all()))
        {
            $from = Carbon::parse(request()->dateShift . ' ' . request()->timeStart);
            $to = $from->gte(Carbon::parse(request()->dateShift . ' ' . request()->timeEnd)) ? Carbon::parse(request()->dateShift . ' ' . request()->timeEnd)->addDay() : Carbon::parse(request()->dateShift . ' ' . request()->timeEnd);
        }

        else if(isset($this->request->user()->shift_schedule))
        {
            $from = Carbon::parse($this->request->user()->shift_schedule->from);
            $to = $from->gte(Carbon::parse($this->request->user()->shift_schedule->to)) ? Carbon::parse($this->request->user()->shift_schedule->to)->addDay() : Carbon::parse($this->request->user()->shift_schedule->to);
        }

        else{
            $from = Carbon::parse('today');
            $to = Carbon::parse('tomorrow');
        }

        return $this->dashboardData($this->accounts, $from, $to);
    }

    public function toExcel($date_start, $date_end, $time_start, $time_end, $department_id)
    {
        if($department_id)
        {
            $this->scope($department_id);
        }
        else{
            $this->scope();
        }

        $reports = $this->reportData($this->accounts, $date_start, $date_end, $time_start, $time_end);

        // return $reports;

        Excel::create(request()->user()->department->name . ' report from ' . Carbon::parse($date_start)->toFormattedDateString() . ' to ' . Carbon::parse($date_end)->toFormattedDateString() .' Shift: ' . Carbon::parse($time_start)->toTimeString() . ' to ' . Carbon::parse($time_end)->toTimeString(), function($excel) use($reports){
            $reports->each(function($account, $key) use($excel){
                $excel->sheet($this->formatSheet($account->name), function($sheet) use($account){
                    $sheet->loadView('excel.report')->with('account', $account);
                });
            });
        })->download('xls');
    }
}
