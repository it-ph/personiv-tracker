<?php

namespace App\Traits;

trait Enlist
{
	use RelationshipsWithConstraints;

	public function populate()
	{
		if(request()->has('relationships'))
        {
            $this->relationships();
        }

        if(request()->has('relationshipsWithConstraints'))
        {
        	$this->populateRelationship();
        }

        if(request()->has('where'))
        {
            $this->where();
        }

				if(request()->has('whereNotIn'))
        {
            $this->whereNotIn();
        }

        if(request()->has('whereNull'))
        {
            $this->whereNull();
        }

        if(request()->has('whereNotNull'))
        {
            $this->whereNotNull();
        }

        if(request()->has('orderBy'))
        {
            $this->orderBy();
        }
	}

	public function relationships()
	{
		foreach (request()->relationships as $relationship) {
			$this->model->with($relationship);
		}
	}

	public function where()
	{
		foreach (request()->where as $where) {
			$this->model->where($where['column'], $where['condition'], $where['value']);
		}
	}

	public function whereNotIn()
	{
		foreach (request()->whereNotIn as $whereNotIn) {
			$this->model->whereNotIn($whereNotIn['column'], $whereNotIn['values']);
		}
	}

	public function whereNull()
	{
		foreach (request()->whereNull as $column) {
			$this->model->whereNull($column);
		}
	}

	public function whereNotNull()
	{
		foreach (request()->whereNotNull as $column) {
			$this->model->whereNotNull($column);
		}
	}

	public function orderBy()
	{
		foreach (request()->orderBy as $orderBy) {
			$this->model->orderBy($orderBy['column'], $orderBy['order']);
		}
	}
}
