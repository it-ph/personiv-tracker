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

	public function whereNullConstraints($relationship, $query)
	{
		foreach ($relationship['whereNull'] as $whereNull) {
			$query->whereNull($whereNull);
		}
	}

	public function orderByConstraints($relationship, $query)
	{
		foreach ($relationship['orderBy'] as $orderBy) {
			$query->orderBy($orderBy['column'], $orderBy['order']);
		}
	}
}
