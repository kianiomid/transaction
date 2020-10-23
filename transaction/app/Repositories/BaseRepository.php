<?php

namespace App\Repositories;

use App\Http\Controllers\BGenerator\BaseController;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository as PrettusBaseRepository;
use Illuminate\Container\Container as Application;

class BaseRepository extends PrettusBaseRepository
{

    const MODE_TEST_DATA = 'test_data';
    const MODE_PRODUCTION = 'production';

    /**
     * @var array
     */
    public $fieldSearchable = [];

    public $entityManager = null;

    public function __construct(Application $app, $model = null, $entityManager = null)
    {
        $this->model = $model;
        $this->entityManager = $entityManager;

        parent::__construct($app);
    }

    public static function getInstance(Application $app, $modelClass, $entityManager = null)
    {
        $reflect = new \ReflectionClass($modelClass);
        $repository = __NAMESPACE__ . '\\' . $reflect->getShortName() . "Repository";
        return new $repository($app, $modelClass, $entityManager);

    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return get_class($this->model);
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        return $this->model = $model;
    }

    public function findWithoutFail($id, $columns = ['*'])
    {
        try {
            return $this->find($id, $columns);
        } catch (Exception $e) {
            return;
        }
    }

    public function create(array $attributes)
    {
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::create($attributes);
        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attributes);
        $model->save();

        return $this->parserResult($model);
    }

    public function update(array $attributes, $id)
    {
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::update($attributes, $id);
        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attributes);
        $model->save();

        return $this->parserResult($model);
    }

    public function updateRelations($model, $attributes)
    {
        foreach ($attributes as $key => $val) {
            if (isset($model) &&
                method_exists($model, $key) &&
                is_a(@$model->$key(), 'Illuminate\Database\Eloquent\Relations\Relation')
            ) {
                $methodClass = get_class($model->$key($key));
                switch ($methodClass) {
                    case 'Illuminate\Database\Eloquent\Relations\BelongsToMany':
                        $new_values = array_get($attributes, $key, []);
                        if($new_values == null) $new_values = [];
                        if (array_search('', $new_values) !== false) {
                            unset($new_values[array_search('', $new_values)]);
                        }
                        $model->$key()->sync(array_values($new_values));
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\BelongsTo':
                        $model_key = $model->$key()->getQualifiedForeignKey();
                        $new_value = array_get($attributes, $key, null);
                        $new_value = $new_value == '' ? null : $new_value;
                        $model->$model_key = $new_value;
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasOne':
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasOneOrMany':
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasMany':
                        $new_values = array_get($attributes, $key, []);
                        if (array_search('', $new_values) !== false) {
                            unset($new_values[array_search('', $new_values)]);
                        }

                        list($temp, $model_key) = explode('.', $model->$key($key)->getQualifiedForeignKeyName());

                        foreach ($model->$key as $rel) {
                            if (!in_array($rel->id, $new_values)) {
                                $rel->$model_key = null;
                                $rel->save();
                            }
                            unset($new_values[array_search($rel->id, $new_values)]);
                        }

                        if (count($new_values) > 0) {
                            $related = get_class($model->$key()->getRelated());
                            foreach ($new_values as $val) {
                                $rel = $related::find($val);
                                $rel->$model_key = $model->id;
                                $rel->save();
                            }
                        }
                        break;
                    case "Illuminate\Database\Eloquent\Relations\MorphToMany":

                        $new_values = array_get($attributes, $key, []);
                        if($new_values == null) $new_values = [];
                        if (array_search('', $new_values) !== false) {
                            unset($new_values[array_search('', $new_values)]);
                        }

                        $model->$key()->sync($new_values);

                        break;
                }
            }
        }

        return $model;
    }

    public function applyFilter($fields, $filterItems, $filterCriteria)
    {

        foreach ($filterItems as $filterItem) {
            foreach ($filterCriteria as $filterCriterionKey => $filterCriterionValue) {

                $operator = '=';
                if ($fields[$filterItem][BaseController::NS_DB_TYPE] == BaseController::DB_TYPE_INT) {
                    $operator = '=';
                } elseif ($fields[$filterItem][BaseController::NS_DB_TYPE] == BaseController::DB_TYPE_TEXT) {
                    $operator = 'like';
                } elseif ($fields[$filterItem][BaseController::NS_DB_TYPE] == BaseController::DB_TYPE_DATE) {
                    $operator = '=';
                }

                if ($filterItem == $filterCriterionKey) {

                    if (trim($filterCriterionValue) == '') {
                        continue;
                    }

                    if ($operator == 'like') {
                        $filterCriterionValue = '%' . $filterCriterionValue . '%';
                    }

                    if (
                        method_exists($this->model, $filterItem) &&
                        is_a(@$this->model->$filterItem(), 'Illuminate\Database\Eloquent\Relations\Relation')
                    ) {
                        $methodClass = get_class($this->model->$filterItem($filterItem));
                        switch ($methodClass) {
                            case 'Illuminate\Database\Eloquent\Relations\BelongsToMany':
                                $model_key = $this->model->$filterItem()->getRelatedPivotKeyName();
                                $this->model = $this->model->whereHas($filterItem, function ($query) use ($model_key, $operator, $filterCriterionValue) {
                                    $query->where($model_key, $operator, $filterCriterionValue);
                                });
                                break;
                            case 'Illuminate\Database\Eloquent\Relations\BelongsTo':
                                break;
                            case 'Illuminate\Database\Eloquent\Relations\HasOne':
                                break;
                            case 'Illuminate\Database\Eloquent\Relations\HasOneOrMany':
                                break;
                            case 'Illuminate\Database\Eloquent\Relations\HasMany':
                                break;
                        }
                    } else {
                        $this->model = $this->model->where($filterItem, $operator, $filterCriterionValue);
                    }


                }

            }
        }

        return $this;

    }

    /**
     * Retrieve all data of repository, paginated
     *
     *
     * @param null $limit
     * @param array $columns
     * @param string $method
     * @param integer $pageNumber
     *
     * @return mixed
     */
    public function applyPagination($limit = null, $columns = ['*'], $method = "paginate", $pageNumber)
    {
        $this->applyCriteria();
        $this->applyScope();
        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->model->{$method}($limit, $columns, 'page', $pageNumber);
        $results->appends(app('request')->query());

        $this->resetModel();
        return $this->parserResult($results);
    }

    /**
     * @param $table
     * @param string $field
     * @param bool $sort
     * @param int $where
     * @return array
     */
    public function getList($table, $field = '', $sort = true, $where = 1)
    {
        //        DB::connection()->setFetchMode(\PDO::FETCH_ASSOC);
        $sfield = null;
        $res = [];
        if ($sort === true) {
            $field = $field ? $field : substr($table, 1, strlen($table) + 1);
        } elseif (gettype($sort) == 'string') {
            $sfield = $sort;
        }
        $fid = substr("id", 0, strlen($table) + 3);
        $res = DB::table($table)
            ->whereRaw($where)
            ->orderByRaw(($sfield ? $sfield : ($field ? $field : $fid)))
            ->pluck($field, $fid);

        return $res;
    }

}