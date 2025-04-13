<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\CrudController;
use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Role;
use App\Models\Access\Route;
use App\Models\Access\User;
use App\Repositories\LogEventsRepository;


class LogEventsController extends CrudController
{

    protected $models = ['user' => User::class, 'role' => Role::class, 'route' => Route::class, 'menu' => Menu::class, 'permission' => Permission::class];


    public function __construct(LogEventsRepository $repo)
    {
        parent::__construct($repo, 'logs');
        $this->viewIndex = "pages.logs.events";
        $this->viewShow = "pages.logs.event-show";
    }

    public function index()
    {
        $models = ['' => __("All")];
        foreach ($this->models as $model => $class) {
            $models[$model] = __($model);
        }
        $filterModels = ['label' => 'Modelo', 'options' => $models];
        $filterEvents = ['label' => 'Evento', 'options' => ['' => __("All"), 'created' => __('created'), 'updated' => __('updated'), 'deleted' => __('deleted')]];
        $filters = ['model' => $filterModels, 'event' => $filterEvents];
        return view('pages.logs.events', ['filters' => $filters]);
    }


    public function dataTable($query = null)
    {
        $query = $this->repo->queryPersist();
        $filterModel = request()->input('filter_model');
        if (isset($filterModel) && isset($this->models[$filterModel])) {
            $query->where('loggable_type', $this->models[$filterModel]);
        }

        $filterEvent = request()->input('filter_event');
        if (isset($filterEvent)) {
            $query->where('event_name', $filterEvent);
        }

        $filterText = request()->input('filter_text');
        if ($filterText) {
            $this->fieldFilterText = false;
            //$query->where('event_name', 'LIKE', "%$filterText%");
            $query->orWhere('description', 'LIKE', "%$filterText%");
        }

        return parent::dataTable($query);
    }
}
