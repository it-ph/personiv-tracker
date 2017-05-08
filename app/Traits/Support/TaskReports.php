<?php

namespace App\Traits\Support;

use Illuminate\Http\Request;

use App\Account;
use App\User;
use Carbon\Carbon;
use Excel;

trait TaskReports
{
    protected function scope()
    {
        $this->request = request();

        $this->request->user()->load('subordinates', 'shift_schedule');

        $this->subordinateIds = $this->request->user()->subordinates->pluck('id');

        $this->accounts = Account::where('department_id', $this->request->user()->department_id)->get();
    }

    protected function dashboardData($data, $from, $to)
    {
        $data->each(function($account, $key) use($from, $to){
            $account->range = Carbon::parse($from)->toDayDateTimeString() . ' to ' . Carbon::parse($to)->toDayDateTimeString();

            $account->employees = User::whereIn('id', $this->subordinateIds)->with(['tasks' => function($query) use($account, $from, $to){
                $query->where('account_id', $account->id)->whereBetween('ended_at', [Carbon::parse($from), Carbon::parse($to)]);
            }])->get();
           
            $account->employees->each(function($employee, $key){
                $employee->new = $employee->tasks->where('revision', false)->count();
                $employee->revisions = $employee->tasks->where('revision', true)->count();
                $employee->hours_spent = round($employee->tasks->sum('minutes_spent') / 60, 2);
            });

            $account->categories = $account->employees->pluck('name');

            $account->new = $account->employees->map(function($employee, $key){
                return $employee->new;
            });

            $account->revisions = $account->employees->map(function($employee, $key){
                return $employee->revisions;
            });

            $account->hours_spent = $account->employees->map(function($employee, $key){
                return $employee->hours_spent;
            });
        });

        return $data;
    }

    protected function reportData($data, $date_start, $date_end, $time_start, $time_end)
    {
    	$data->each(function($account, $key) use($date_start, $date_end, $time_start, $time_end) {
	        $account->employees = User::whereIn('id', $this->subordinateIds)->get();

	        $account->employees->each(function($employee, $key){
	        	$employee->data = collect([]);
	        });

    		$account->reportDates = collect([]);

    		$timeStart = Carbon::parse($time_start)->toTimeString();
	        $timeEnd = Carbon::parse($time_end)->toTimeString();

	        for ($date = Carbon::parse($date_start); $date->lte(Carbon::parse($date_end)); $date->addDay()) { 

	            $from = Carbon::parse($date->toDateString() . ' ' . $timeStart);

	            $to = $from->gte(Carbon::parse($date->toDateString() . ' ' . $timeEnd)) ? Carbon::parse($date->toDateString() . ' ' . $timeEnd)->addDay() : Carbon::parse($date->toDateString() . ' ' . $timeEnd);

	            $account->reportDates->push($date->toFormattedDateString());

	            $account->employees->load(['tasks' => function($query) use($account, $from, $to){
	            	$query->where('account_id', $account->id)->whereBetween('ended_at', [$from, $to]);
	            }]);

				$account->employees->each(function($employee, $key){
					$new = $employee->tasks->where('revision', false)->count();
	                $revisions = $employee->tasks->where('revision', true)->count();
	                $hours_spent = round($employee->tasks->sum('minutes_spent') / 60, 2);

					$employee->data->push(compact('new', 'revisions', 'hours_spent'));
				});            
	        }
    	});

    	return $data;
    }

    protected function formatSheet($sheet)
    {
    	$sheet = str_replace('/', '-', $sheet);

    	$sheet = stripslashes($sheet);

    	$sheet = substr($sheet, 0, 31);

    	return $sheet;
    }
}