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

		if(request()->has('relationshipCount'))
    {
        $this->relationshipCount();
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

		if(request()->has('whereHas'))
    {
        $this->whereHas();
    }

    if(request()->has('orderBy'))
    {
        $this->orderBy();
    }
	}

	protected function relationships()
	{
		foreach (request()->relationships as $relationship) {
			$this->model->with($relationship);
		}
	}

	protected function relationshipCount()
	{
		foreach (request()->relationshipCount as $relationship) {
			$this->model->withCount($relationship);
		}
	}

	protected function where()
	{
		foreach (request()->where as $where) {
			$this->model->where($where['column'], $where['condition'], $where['value']);
		}
	}

	protected function whereNotIn()
	{
		foreach (request()->whereNotIn as $whereNotIn) {
			$this->model->whereNotIn($whereNotIn['column'], $whereNotIn['values']);
		}
	}

	protected function whereNull()
	{
		foreach (request()->whereNull as $column) {
			$this->model->whereNull($column);
		}
	}

	protected function whereNotNull()
	{
		foreach (request()->whereNotNull as $column) {
			$this->model->whereNotNull($column);
		}
	}

	protected function whereHas()
	{
		foreach (request()->whereHas as $whereHas) {
			$this->model->whereHas($whereHas['relationship'], function($query) use($whereHas){
				foreach ($whereHas['where'] as $where) {
					$query->where($where['column'], $where['condition'], $where['value']);
				}
			});
		}
	}

	protected function orderBy()
	{
		foreach (request()->orderBy as $orderBy) {
			$this->model->orderBy($orderBy['column'], $orderBy['order']);
		}
	}
}
