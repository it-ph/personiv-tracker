<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Enlist
{
	public function populateRequest(Request $request)
	{
		if($request->has('relationships'))
        {
            $this->relationships($request);
        }

        if($request->has('whereClauses'))
        {
            $this->whereClauses($request);
        }

        if($request->has('whereNullClauses'))
        {
            $this->whereNullClauses($request);
        }

        if($request->has('whereNotNullClauses'))
        {
            $this->whereNotNullClauses($request);
        }
	}

	public function relationships(Request $request)
	{
		foreach ($request->relationships as $relationship) {
			$this->model->with($relationship);
		}
	}

	public function whereClauses(Request $request)
	{
		foreach ($request->whereClauses as $where) {
			$this->model->where($where['column'], $where['condition'], $where['value']);
		}	
	}

	public function whereNullClauses(Request $request)
	{
		foreach ($request->whereNullClauses as $column) {
			$this->model->whereNull($column);
		}	
	}

	public function whereNotNullClauses(Request $request)
	{
		foreach ($request->whereNotNullClauses as $column) {
			$this->model->whereNotNull($column);
		}	
	}
}