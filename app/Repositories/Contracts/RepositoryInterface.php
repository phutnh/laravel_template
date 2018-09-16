<?php 

namespace App\Repositories\Contracts;

interface RepositoryInterface {
	
	public function query();
	
	public function all($columns = ['*']);

	public function first($columns = ['*']);

	public function paginate($limit = null, $columns = ['*']);

	public function find($id, $columns = ['*']);

	public function findByField($field, $value, $columns = ['*']);

	public function findWhere($where, $columns = ['*']);

	public function findWhereIn($field, $values, $columns = ['*']);

	public function findWhereNotIn($field, $values, $columns = ['*']);

	public function create($attributes);

	public function update($attributes, $id);

	public function updateOrCreate($attributes, $values = []);

	public function delete($id);

	public function deleteWhere($where);

	public function orderBy($column, $direction = 'asc');

	public function with($relations);

	public function has($relation);

	public function whereHas($relation, $closure);

	public function count();

}