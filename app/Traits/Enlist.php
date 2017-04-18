<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Enlist
{
	public function populate(Request $request)
	{
		if($request->has('relationships'))
        {
            $this->relationships($request);
        }

        if($request->has('where'))
        {
            $this->where($request);
        }

        if($request->has('whereNull'))
        {
            $this->whereNull($request);
        }

        if($request->has('whereNotNull'))
        {
            $this->whereNotNull($request);
        }

        if($request->has('orderBy'))
        {
            $this->orderBy($request);
        }
	}

	public function relationships(Request $request)
	{
		foreach ($request->relationships as $relationship) {
			$this->model->with($relationship);
		}
	}

	public function where(Request $request)
	{
		foreach ($request->where as $where) {
			$this->model->where($where['column'], $where['condition'], $where['value']);
		}	
	}

	public function whereNull(Request $request)
	{
		foreach ($request->whereNull as $column) {
			$this->model->whereNull($column);
		}	
	}

	public function whereNotNull(Request $request)
	{
		foreach ($request->whereNotNull as $column) {
			$this->model->whereNotNull($column);
		}	
	}

	public function orderBy(Request $request)
	{
		foreach ($request->orderBy as $orderBy) {
			$this->model->orderBy($orderBy['column'], $orderBy['order']);
		}	
	}
}