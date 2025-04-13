<?php

namespace App\Repositories;

use Closure;
use App\Exceptions\ExceptionCustom;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Http\Response;
use Illuminate\Support\Collection;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;
    protected $modelClass;

    public function __construct(Application $app, $modelClass)
    {
        $this->app = $app;
        $this->modelClass = $modelClass;
        $this->makeModel();
    }

    /* Validation rules that apply when creating and updating objects */
    abstract public function rules($id): array;

    /*Custom validation messages */
    public function messages(): array
    {
        return [];
    }

    /*Restrictions that apply before update objects*/
    public function authUpdate($model): bool
    {
        // si no es superAdmin, solo puede realizar la operacion en los objetos que ha creado el o su admin
        if (
            auth()->user() &&
            auth()->user()->role_id != 1 &&
            (isset($model->created_user_id) && (auth()->user()->id != $model->created_user_id && auth()->user()->created_user_id != $model->created_user_id))
        ) {
            throw new ExceptionCustom(__('messages.not_access'), Response::HTTP_FORBIDDEN);
        }
        return true;
    }

    /*Restrictions that apply before deleting objects*/
    public function authDestroy($model): bool
    {
        return true;
    }

    public function validExistRelation($element, Collection $list, $nameRelation): bool
    {
        if (($count = $list->count()) > 0) {
            $more = "";
            if ((--$count) > 1) {
                $more .= " y $count $nameRelation más.";
            }
            $message = __('messages.reference_exist') . $list->first() . $more;
            throw new ExceptionCustom(__('messages.element_delete_error', ['name' => $element->__toString()]) . $message, Response::HTTP_FORBIDDEN);
        }
        return true;
    }
    
    public function validatorMake(array $attributes, $id)
    {
        return Validator::make($attributes, $this->rules($id), $this->messages());
    }

    protected function makeModel()
    {
        $modelClass = $this->modelClass;
        $model = $this->app->make($modelClass);

        if (!$model instanceof Model) {
            throw new \Exception("Class {$modelClass} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }
    public function resetModel()
    {
        $this->makeModel();
    }

    public function getModelName()
    {
        $modelClass = $this->modelClass;
        $name = substr($modelClass, strrpos($modelClass, "\\") + 1);
        return strtolower($name);
    }

    public function geTableName()
    {
        $model = $this->makeModel();
        return $model->getTable();
    }


    public function all()
    {
        return  $this->model->all();
    }

    public function findByIdOrFail($id)
    {
        $result = $this->model->find($id);
        if (!$result) {
            $message = __('messages.element_not_found', ['name' => __($this->getModelName()), 'id' => $id]);
            throw new ExceptionCustom($message, Response::HTTP_NOT_FOUND);
        } else
            return $result;
    }
    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findByFieldFirst($fieldName, $fieldValue)
    {
        //$product = Product::with('productAttributeValue')->find($itemId);
        $result = $this->model->where($fieldName, '=', $fieldValue)->first();
        $this->resetModel();
        return $result;
    }

    public function findByField($fieldName, $fieldValue)
    {
        $result = $this->model->where($fieldName, '=', $fieldValue)->get();
        $this->resetModel();
        return $result;
    }

    public function findWhere(array $where)
    {
        $this->applyConditions($where);
        $result = $this->model->get();
        $this->resetModel();
        return $result;
    }

    public function create(array $attributes)
    {
        $model = $this->model->newInstance();
        $model->forceFill($attributes);
        $model->makeVisible($this->model->getHidden());
        $attributes = $model->toArray();
        $validator = $this->validatorMake($attributes, 0);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        } else {
            $model = $this->model->newInstance($attributes);
            if (auth()->check()) {
                $model->created_user_id = auth()->id();
            }
            $model->save();
            return $model;
        }
    }

    public function createList(array $list)
    {
        foreach ($list as $input) {
            $this->create($input);
        }
        return true;
    }

    public function update(array $attributes, $id)
    {
        if (empty($attributes)) {
            throw new ExceptionCustom(__('messages.not_saved'), Response::HTTP_BAD_REQUEST);
        }

        $model = $this->findByIdOrFail($id);
        if ($this->authUpdate($model)) {
            $temp = $this->model->newInstance();
            $temp->setRawAttributes([]);
            $temp->setAppends([]);
            $temp->forceFill($attributes);
            $temp->makeVisible($this->model->getHidden());
            $attributes = $temp->toArray();
            $validator = $this->validatorMake($attributes, $id);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $model->fill($attributes);
            $model->save();
            $this->resetModel();
            return $model;
        } else {
            throw new ExceptionCustom(__('messages.not_access'), Response::HTTP_FORBIDDEN);
        }
    }

    public function available($id, bool $available)
    {
        $model = $this->findByIdOrFail($id);
        if ($this->authUpdate($model)) {
            $model->fill(['state' => $available]);
            $model->save();
            return $model;
        } else {
            throw new ExceptionCustom(__('messages.not_access'), Response::HTTP_FORBIDDEN);
        }
    }

    public function delete($id)
    {
        $model = $this->findByIdOrFail($id);
        $originalModel = clone $model;
        if ($this->authDestroy($model)) {
            $deleted = $model->delete();
            if ($deleted) {
                return $originalModel;
            } else {
                throw new ExceptionCustom(__('messages.element_delete_error', ['name' => $model->__toString()]), Response::HTTP_BAD_REQUEST);
            }
        } else {
            throw new ExceptionCustom(__('messages.not_access'), Response::HTTP_FORBIDDEN);
        }
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    protected $query;
    public function queryPersist()
    {
        if (!$this->query) {
            $this->query = $this->model->query();
        }
        return  $this->query;
    }

    /**
     * Trigger method calls to the model
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->model, $method], $arguments);
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     *
     * @return void
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                //smooth input
                $condition = preg_replace('/\s\s+/', ' ', trim($condition));

                //split to get operator, syntax: "DATE >", "DATE =", "DAY <"
                $operator = explode(' ', $condition);
                if (count($operator) > 1) {
                    $condition = $operator[0];
                    $operator = $operator[1];
                } else $operator = null;
                switch (strtoupper($condition)) {
                    case 'IN':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereIn($field, $val);
                        break;
                    case 'NOTIN':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotIn($field, $val);
                        break;
                    case 'DATE':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereDate($field, $operator, $val);
                        break;
                    case 'DAY':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereDay($field, $operator, $val);
                        break;
                    case 'MONTH':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereMonth($field, $operator, $val);
                        break;
                    case 'YEAR':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereYear($field, $operator, $val);
                        break;
                    case 'EXISTS':
                        if (!($val instanceof Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereExists($val);
                        break;
                    case 'HAS':
                        if (!($val instanceof Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereHas($field, $val);
                        break;
                    case 'HASMORPH':
                        if (!($val instanceof Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereHasMorph($field, $val);
                        break;
                    case 'DOESNTHAVE':
                        if (!($val instanceof Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereDoesntHave($field, $val);
                        break;
                    case 'DOESNTHAVEMORPH':
                        if (!($val instanceof Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereDoesntHaveMorph($field, $val);
                        break;
                    case 'BETWEEN':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereBetween($field, $val);
                        break;
                    case 'BETWEENCOLUMNS':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereBetweenColumns($field, $val);
                        break;
                    case 'NOTBETWEEN':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotBetween($field, $val);
                        break;
                    case 'NOTBETWEENCOLUMNS':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotBetweenColumns($field, $val);
                        break;
                    case 'RAW':
                        $this->model = $this->model->whereRaw($val);
                        break;
                    default:
                        $this->model = $this->model->where($field, $condition, $val);
                }
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }
}
