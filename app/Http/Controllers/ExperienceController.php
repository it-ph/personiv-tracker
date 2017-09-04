<?php

namespace App\Http\Controllers;

use App\Experience;
use App\Http\Requests\StoreExperience;
use Illuminate\Http\Request;
use App\Traits\Enlist;
use DB;

class ExperienceController extends Controller
{
    use Enlist;
    /**
     * Display a listing of the resource with parameters.
     *
     * @return \Illuminate\Http\Response
     */
    public function enlist(Request $request)
    {
      $this->model = Experience::query();

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
    public function store(StoreExperience $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        //
    }
    /*Returns all experiences*/
    public function getExperiences()
    {
      return DB::table('experiences')->get();
    }
}
