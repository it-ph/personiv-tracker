<?php

namespace App\Http\Controllers;

use App\Position;
use App\Traits\Enlist;
use Illuminate\Http\Request;

use App\Http\Requests\{StorePosition, UpdatePosition, DetachPosition};

use DB;

class PositionController extends Controller
{
    use Enlist;
    /**
     * Display a listing of the resource with parameters.
     *
     * @return \Illuminate\Http\Response
     */
    public function enlist(Request $request)
    {
        $this->model = Position::query();

        if($request->has('withTrashed'))
        {
          $this->model->withTrashed();
        }

        $this->populate($request);

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
        return Position::all();
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
      DB::transaction(function(){
        $position = new Position;
        $position->checkDuplicate();
        $current = $position->checkExistence();
        $current->syncAccount();
      });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePosition $request, Position $position)
    {
      DB::transaction(function() use($position){
        $position->checkDuplicate();
        $position->detachOldAccount();
        $current = $position->checkExistence();
        $current->syncAccount();
      });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
      $this->authorize('delete', $position);

      $position->delete();
    }

    /**
     * Detach the position relationship from the account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
     public function detach(DetachPosition $request, Position $position)
     {
       $position->accounts()->detach([request()->account_id]);
     }
}
