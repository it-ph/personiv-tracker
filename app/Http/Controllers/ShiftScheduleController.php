<?php

namespace App\Http\Controllers;

use App\ShiftSchedule;
use Illuminate\Http\Request;

use Auth;
use Gate;
use Carbon\Carbon;
use DB;

class ShiftScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ShiftSchedule::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
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
        $this->authorize('create', ShiftSchedule::class);

        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
        ]);

        $shiftSchedule = new ShiftSchedule;

        $shiftSchedule->user_id = $request->user()->id;

        $shiftSchedule->populate($request);

        $shiftSchedule->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShiftSchedule  $shiftSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(ShiftSchedule $shiftSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShiftSchedule  $shiftSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(ShiftSchedule $shiftSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShiftSchedule  $shiftSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShiftSchedule $shiftSchedule)
    {
        $this->authorize($shiftSchedule);

        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
        ]);

        $shiftSchedule->populate($request);

        $shiftSchedule->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShiftSchedule  $shiftSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShiftSchedule $shiftSchedule)
    {
        //
    }
    /*Returns all shift schedules*/
    public function getShiftSchedules()
    {
        return DB::table('shift_schedules')->get();
    }
}
