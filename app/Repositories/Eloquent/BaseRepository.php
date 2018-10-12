<?php 

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Contracts\RepositoryCriteriaInterface;
use App\Repositories\Contracts\CriteriaInterface;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements RepositoryInterface, RepositoryCriteriaInterface
{
  private $app;
  protected $model;
  protected $criteria;
  protected $skipCriteria = false;

  public function __construct(App $app, Collection $collection)
  {
    $this->app = $app;
    $this->criteria = $collection;
    $this->resetScope();
    $this->makeModel();
    $this->boot();
  }

  abstract function model();

  public function boot()
  {
    
  }

  public function query()
  {
    $this->applyCriteria();
    if ($this->model instanceof Builder) {
      $results = $this->model;
    } else {
      $results = $this->model->query();
    }
    return $results;
  }

  public function all($columns = ['*'])
  {
    $this->applyCriteria();

    if ($this->model instanceof Builder) {
      $results = $this->model->get($columns);
    } else {
      $results = $this->model->all($columns);
    }

    return $results;
  }

  public function first($columns = ['*'])
  {
    return $this->model->first($columns);
  }

  public function paginate($limit = null, $columns = ['*'])
  {
    $this->applyCriteria();
    $limit = is_null($limit) ? 15 : $limit;
    return $this->model->paginate($limit, $columns);
  }

  public function find($id, $columns = ['*'])
  {
    $this->applyCriteria();
    return $this->model->findOrFail($id, $columns);
  }

  public function findByField($field, $value, $columns = ['*'])
  {
    $this->applyCriteria();
    return $this->model->where($field, '=', $value)->get($columns);
  }

  public function findWhere($where, $columns = ['*'])
  {
    $this->applyCriteria();
    $this->applyConditions($where);
    return $this->model->get($columns);
  }

  public function findWhereIn($field, $values, $columns = ['*'])
  {
    $this->applyCriteria();
    return $this->model->whereIn($field, $values)->get($columns);
  }

  public function findWhereNotIn($field, $values, $columns = ['*'])
  {
    $this->applyCriteria();
    return $this->model->whereNotIn($field, $values)->get($columns);
  }

  public function create($attributes)
  {
    return $this->model->insert($attributes);
  }

  public function update($attributes, $id)
  {
    $model = $this->model->where(['id' => $id]);
    $model->update($attributes);
    return $model;
  }

  public function updateOrCreate($attributes, $values = [])
  {
    return $this->model->updateOrCreate($attributes, $values);
  }

  public function delete($id)
  {
    $model = $this->model->find($id);
    $deleted = $model->delete();
    return $deleted;
  }
  
  public function deleteWhere($where)
  {
    $this->applyConditions($where);
    $deleted = $this->model->delete();
    return $deleted;
  }

  public function orderBy($column, $direction = 'asc')
  {
    $this->model = $this->model->orderBy($column, $direction);
    return $this;
  }

  public function with($relations)
  {
    $this->model = $this->model->with($relations);
    return $this;
  }

  public function has($relation)
  {
    $this->model = $this->model->has($relation);
    return $this;
  }

  public function whereHas($relation, $closure)
  {
    $this->model = $this->model->whereHas($relation, $closure);
    return $this;
  }

  public function count()
  {
    $this->applyCriteria();
    return $this->model->count();
  }

  // Extra repository
  protected function applyConditions($where)
  {
    foreach ($where as $field => $value) {
      if (is_array($value)) {
        list($field, $condition, $val) = $value;
        $this->model = $this->model->where($field, $condition, $val);
      } else {
        $this->model = $this->model->where($field, '=', $value);
      }
    }
  }

  public function makeModel() {
    $model = $this->app->make($this->model());

    if (!$model instanceof Model)
      throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
    
    return $this->model = $model;
  }

  public function resetScope() {
    $this->skipCriteria(false);
    return $this;
  }

  public function skipCriteria($status = true){
    $this->skipCriteria = $status;
    return $this;
  }

  public function getCriteria() {
    return $this->criteria;
  }

  public function getByCriteria(CriteriaInterface $criteria) {
    $this->model = $criteria->apply($this->model, $this);
    $results = $this->model->get();
    return $results;  
  }

  public function pushCriteria($criteria) {
    if (is_string($criteria)) {
      $criteria = new $criteria;
    }
    if (!$criteria instanceof CriteriaInterface) {
      throw new Exception("Class " . get_class($criteria) . " must be an instance of CriteriaInterface");
    }

    $this->criteria->push($criteria);

    return $this;
  }

  public function applyCriteria() {
    if($this->skipCriteria === true)
      return $this;

    foreach($this->getCriteria() as $criteria) {
      if($criteria instanceof CriteriaInterface)
        $this->model = $criteria->apply($this->model, $this);
    }

    return $this;
  }

  public function popCriteria($criteria)
  {
    $this->criteria = $this->criteria->reject(function ($item) use ($criteria) {
      if (is_object($item) && is_string($criteria)) {
        return get_class($item) === $criteria;
      }

      if (is_string($item) && is_object($criteria)) {
        return $item === get_class($criteria);
      }

      return get_class($item) === get_class($criteria);
    });

    return $this;
  }

  public function resetCriteria()
  {
    $this->criteria = new Collection();

    return $this;
  }

}