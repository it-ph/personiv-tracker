<?php

namespace App\Traits\Support;

use Illuminate\Http\Request;

use App\Account;
use App\User;
use Carbon\Carbon;
use Excel;

trait TaskReports
{
    protected function scope($department_id)
    {
        $this->request = request();

        $this->request->user()->load('subordinates', 'shift_schedule');

        if($this->request->user()->isSuperUser())
        {
            $this->subordinateIds = User::whereNotIn('id', [$this->request->user()->id])->doesntHave('roles')->get()->pluck('id');
        }
        else if($this->request->user()->isDepartmentHead())
        {
            $this->subordinateIds = User::where('department_id', $this->request->user()->department_id)->whereNotIn('id', [$this->request->user()->id])->doesntHave('roles')->get()->pluck('id');
        }
        else{
            $this->subordinateIds = $this->request->user()->subordinates->pluck('id');
        }

        if($department_id)
        {
            $this->accounts = Account::where('department_id', $department_id)->get();
        }

        else if($this->request->user()->isSuperUser())
        {
            $this->accounts = Account::all()    
        }
        else{
            $this->accounts = Account::where('department_id', $this->request->user()->department_id)->get();
        }

    }

    protected function dashboardData($accounts, $from, $to)
    {
        $accounts->each(function($account, $key) use($from, $to){
            $account->range = Carbon::parse($from)->toDayDateTimeString() . ' to ' . Carbon::parse($to)->toDayDateTimeString();

            $account->employees = User::where(function($query) use($account, $from, $to){
                $query->whereIn('id', $this->subordinateIds);
                    
                $query->whereHas('tasks', function($query) use($account, $from, $to){
                    $query->where('account_id', $account->id)->whereBetween('ended_at', [Carbon::parse($from), Carbon::parse($to)]);
                });
            })->with(['tasks' => function($query) use($account, $from, $to){
                $query->where('account_id', $account->id)->whereBetween('ended_at', [Carbon::parse($from), Carbon::parse($to)]);
            }])->get();
           
            $account->employees->each(function($employee, $key){
                $employee->new = $employee->tasks->where('revision', false)->count();
                $employee->number_of_photos_new = $employee->tasks->where('revision', false)->sum('number_of_photos');

                $employee->revisions = $employee->tasks->where('revision', true)->count();
                $employee->number_of_photos_revisions = $employee->tasks->where('revision', true)->sum('number_of_photos');

                $employee->hours_spent = round($employee->tasks->sum('minutes_spent') / 60, 2);
            });

            $account->categories = $account->employees->pluck('name');

            $account->new = $account->employees->map(function($employee, $key){
                return $employee->new;
            });

            $account->number_of_photos_new = $account->employees->map(function($employee, $key){
                return $employee->number_of_photos_new;
            });

            $account->revisions = $account->employees->map(function($employee, $key){
                return $employee->revisions;
            });

            $account->number_of_photos_revisions = $account->employees->map(function($employee, $key){
                return $employee->number_of_photos_revisions;
            });

            $account->hours_spent = $account->employees->map(function($employee, $key){
                return $employee->hours_spent;
            });
        });

        return $accounts;
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
                    $new = 0;
                    $number_of_photos_new  = 0;
                    $revisions  = 0;
                    $number_of_photos_revisions  = 0;
                    $hours_spent  = 0;

                    if(count($employee->tasks))
                    {
                        $new = $employee->tasks->where('revision', false)->count();
    					$number_of_photos_new = $employee->tasks->where('revision', false)->sum('number_of_photos');

                        $revisions = $employee->tasks->where('revision', true)->count();
    	                $number_of_photos_revisions = $employee->tasks->where('revision', true)->sum('number_of_photos');

    	                $hours_spent = round($employee->tasks->sum('minutes_spent') / 60, 2);
                    }

					$employee->data->push(compact('new', 'number_of_photos_new', 'revisions', 'number_of_photos_revisions', 'hours_spent'));
				});            
	        }

            $account->employees->each(function($employee, $key){
                $employee->total_new = $employee->data->sum('new'); 
                $employee->total_number_of_photos_new = $employee->data->sum('number_of_photos_new'); 
                $employee->total_revisions = $employee->data->sum('revisions'); 
                $employee->total_number_of_photos_revisions = $employee->data->sum('number_of_photos_revisions'); 
                $employee->total_hours_spent = $employee->data->sum('hours_spent'); 
            });
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