<?php

namespace App\Traits;

trait RelationshipsWithConstraints
{
	public function populateRelationship()
	{
		foreach (request()->relationshipsWithConstraints as $relationship) {
			$this->model->with([$relationship['relationship'] => function($query) use($relationship){

				if( isset($relationship['whereNull']) )
				{
					$this->whereNullConstraints($relationship, $query);
				}

				if( isset($relationship['orderBy']) )
				{
					$this->orderByConstraints($relationship, $query);
				}
			}]);
		}
	}

	public function populateRelationshipCount()
	{
		foreach (request()->relationshipCountWithConstraints as $relationship) {
			$this->model->withCount([$relationship['relationship'] => function($query) use($relationship){

				if( isset($relationship['where']) )
				{
					$this->whereConstraints($relationship, $query);
				}

				if( isset($relationship['whereNull']) )
				{
					$this->whereNullConstraints($relationship, $query);
				}

				if( isset($relationship['orderBy']) )
				{
					$this->orderByConstraints($relationship, $query);
				}
			}]);
		}
	}

	protected function whereConstraints($relationship, $query)
	{
		foreach ($relationship['where'] as $where) {
			$query->where($where['column'], $where['condition'], $where['value']);
		}
	}

	protected function whereNullConstraints($relationship, $query)
	{
		foreach ($relationship['whereNull'] as $whereNull) {
			$query->whereNull($whereNull);
		}
	}

	protected function orderByConstraints($relationship, $query)
	{
		foreach ($relationship['orderBy'] as $orderBy) {
			$query->orderBy($orderBy['column'], $orderBy['order']);
		}
	}

}
