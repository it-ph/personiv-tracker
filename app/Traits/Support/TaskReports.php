<?php

namespace App\Traits\Support;

use Illuminate\Http\Request;

use App\Account;
use App\Task;
use App\User;
use Carbon\Carbon;
use Excel;

trait TaskReports
{
    protected function scope($department_id = null)
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
            $this->accounts = Account::with('positions')->where('department_id', $department_id)->get();
        }

        else if($this->request->user()->isSuperUser())
        {
            $this->accounts = Account::with('positions')->get();
        }
        else{
            $this->accounts = Account::with('positions')->where('department_id', $this->request->user()->department_id)->get();
        }
    }

    protected function dashboardData($accounts, $from, $to)
    {
        $accounts->each(function($account, $key) use($from, $to){
            $account->range = Carbon::parse($from)->toDayDateTimeString() . ' to ' . Carbon::parse($to)->toDayDateTimeString();

            $account->positions->each(function($position, $key) use($account, $from, $to){
              $positionTasksCount = Task::whereBetween('ended_at', [Carbon::parse($from), Carbon::parse($to)])->whereHas('experience', function($query) use($account, $position){
                $query->where('account_id', $account->id)->where('position_id', $position->id);
              })->count();

              if($positionTasksCount)
              {
                $position->employees = User::where(function($query) use($position, $account, $from, $to){
                  $query->whereIn('id', $this->subordinateIds);

                  $query->whereHas('tasks', function($query) use($position, $account, $from, $to){
                    $query->whereBetween('ended_at', [Carbon::parse($from), Carbon::parse($to)])->whereHas('experience', function($query) use($position, $account){
                      $query->where('position_id', $position->id)->where('account_id', $account->id);
                    });
                  });
                })->with(['tasks' => function($query) use($position, $account, $from, $to){
                  $query->whereBetween('ended_at', [Carbon::parse($from), Carbon::parse($to)])->whereHas('experience', function($query) use($position, $account){
                    $query->where('position_id', $position->id)->where('account_id', $account->id);
                  });
                }])->get();

                $position->employees->each(function($employee, $key) use($account, $position, $to){
                  $employee->load(['experiences' => function($query) use($account, $position){
                    $query->where('position_id', $position->id)->where('account_id', $account->id);
                  }]);

                  $monthDiff = Carbon::parse($employee->experiences->first()->date_started)->diffInMonths(Carbon::parse($to));

                  $employee->new = $employee->tasks->where('revision', false)->count();
                  $employee->number_of_photos_new = $employee->tasks->where('revision', false)->sum('number_of_photos');
                  $employee->category = $monthDiff < 3 ? 'Beginner' : ($monthDiff > 3 && $monthDiff < 6 ? 'Moderately Experienced' : 'Experienced');

                  $employee->revisions = $employee->tasks->where('revision', true)->count();
                  $employee->number_of_photos_revisions = $employee->tasks->where('revision', true)->sum('number_of_photos');

                  $employee->hours_spent = round($employee->tasks->sum('minutes_spent') / 60, 2);
                });

                $position->names = $position->employees->pluck('name');

                $position->new = $position->employees->map(function($employee, $key){
                  return $employee->new;
                });

                $position->number_of_photos_new = $position->employees->map(function($employee, $key){
                  return $employee->number_of_photos_new;
                });

                $position->revisions = $position->employees->map(function($employee, $key){
                  return $employee->revisions;
                });

                $position->number_of_photos_revisions = $position->employees->map(function($employee, $key){
                  return $employee->number_of_photos_revisions;
                });

                $position->hours_spent = $position->employees->map(function($employee, $key){
                  return $employee->hours_spent;
                });
              }

            });
        });

        return $accounts;
    }

    protected function reportData($data, $date_start, $date_end, $time_start, $time_end)
    {
      $data->each(function($account, $key) use($date_start, $date_end, $time_start, $time_end) {

        $account->positions->each(function($position) use($account, $date_start, $date_end, $time_start, $time_end){
          $account->reportDates = collect([]);

          $timeStart = Carbon::parse($time_start)->toTimeString();
          $timeEnd = Carbon::parse($time_end)->toTimeString();

          $position->employees = User::where(function($query) use($position, $account, $date_start, $date_end, $timeStart, $timeEnd){
            $query->whereIn('id', $this->subordinateIds);

            $query->whereHas('tasks', function($query) use($position, $account, $date_start, $date_end, $timeStart, $timeEnd){
              $dateStart = Carbon::parse($date_start);
              $dateEnd = Carbon::parse($date_start);

              $from = Carbon::parse($dateStart->toDateString() . ' ' . $timeStart);
              $to = $from->gte(Carbon::parse($dateStart->toDateString() . ' ' . $timeEnd)) ? Carbon::parse($dateStart->toDateString() . ' ' . $timeEnd)->addDay() : Carbon::parse($dateStart->toDateString() . ' ' . $timeEnd);

              $query->whereBetween('ended_at', [$from, $to])->whereHas('experience', function($query) use($position, $account){
                $query->where('position_id', $position->id)->where('account_id', $account->id);
              });
            });
          })->get();

          $position->employees->each(function($employee, $key) use($account, $position){
            $employee->data = collect([]);
            $employee->load(['experiences' => function($query) use($account, $position){
              $query->where('position_id', $position->id)->where('account_id', $account->id);
            }]);
          });

          for ($date = Carbon::parse($date_start); $date->lte(Carbon::parse($date_end)); $date->addDay()) {
            $from = Carbon::parse($date->toDateString() . ' ' . $timeStart);

            $to = $from->gte(Carbon::parse($date->toDateString() . ' ' . $timeEnd)) ? Carbon::parse($date->toDateString() . ' ' . $timeEnd)->addDay() : Carbon::parse($date->toDateString() . ' ' . $timeEnd);

            $account->reportDates->push($date->toFormattedDateString());

            if(count($position->employees))
            {
              $position->employees->load(['tasks' => function($query) use($account, $position, $from, $to){
                $query->whereBetween('ended_at', [$from, $to])->whereHas('experience', function($query) use($position, $account){
                  $query->where('position_id', $position->id)->where('account_id', $account->id);
                });
              }]);

              $position->employees->each(function($employee, $key){
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

                $employee->data->push(compact('category', 'new', 'number_of_photos_new', 'revisions', 'number_of_photos_revisions', 'hours_spent'));
              });
            }
          }

          $position->employees->each(function($employee, $key) use($date_end){
            $monthDiff = Carbon::parse($employee->experiences->first()->date_started)->diffInMonths(Carbon::parse($date_end));
            $employee->category = $monthDiff < 3 ? 'Beginner' : ($monthDiff > 3 && $monthDiff < 6 ? 'Moderately Experienced' : 'Experienced');

            $employee->total_new = $employee->data->sum('new');
            $employee->total_number_of_photos_new = $employee->data->sum('number_of_photos_new');
            $employee->total_revisions = $employee->data->sum('revisions');
            $employee->total_number_of_photos_revisions = $employee->data->sum('number_of_photos_revisions');
            $employee->total_hours_spent = $employee->data->sum('hours_spent');
          });
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
