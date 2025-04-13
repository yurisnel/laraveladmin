<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Session;

class CrudController extends Controller
{
    protected BaseRepository $repo;
    protected $modelObjet;

    protected $fieldOrderFieldDefault = "id";
    protected $fieldOrderDirDefault = "DESC";
    protected $fieldFilterText = "name";
    protected $routeRedirect;
    protected $routeCreate;

    protected $viewIndex;
    protected $viewShow;
    protected $viewCreate;
    protected $viewEdit;

    public function __construct(BaseRepository $repo, $moduleName)
    {
        $this->repo = $repo;
        $this->setModuleName($moduleName);
    }

    protected function setModuleName($moduleName)
    {
        $this->routeRedirect =  $moduleName . ".index";
        $this->routeCreate =  $moduleName . ".create";

        $this->viewIndex = "pages.$moduleName.index";
        $this->viewShow = "pages.$moduleName.show";
        $this->viewCreate = "pages.$moduleName.create";
        $this->viewEdit = "pages.$moduleName.edit";
    }

    public function index()
    {
        return view($this->viewIndex);
    }

    public function show(int $id)
    {
        $item = $this->repo->findByIdOrFail($id);
        return View($this->viewShow, compact('item'));
    }

    public function create()
    {
        return View($this->viewCreate);
    }

    public function edit(int $id)
    {
        $this->modelObjet = $this->repo->findByIdOrFail($id);
        return View($this->viewEdit, ['item' => $this->modelObjet]);
    }

    public function store()
    {
        $this->modelObjet = $this->repo->create(request()->all());
        $title =  __('messages.success');
        $success =  __('messages.element_create_ok', ['name' => $this->modelObjet->__toString()]);

        $isKeep = request()->input('isKeep');
        Session::put('isKeep', $isKeep);
        if ($isKeep) {
            $this->routeRedirect = $this->routeCreate;
        }
        return $this->reponseMixted($title, $success);
    }

    public function update(int $id)
    {
        $this->modelObjet = $this->repo->update(request()->all(), $id);
        $title =  __('messages.success');
        $success =  __('messages.element_update_ok', ['name' => $this->modelObjet->__toString()]);
        return $this->reponseMixted($title, $success);
    }

    public function destroy(int $id)
    {
        $this->modelObjet = $this->repo->delete($id);
        $title =  __('messages.success');
        $success =  __('messages.element_delete_ok', ['name' =>  $this->modelObjet->__toString()]);
        return $this->reponseMixted($title, $success);
    }

    public function enable(int $id)
    {
        $this->modelObjet = $this->repo->available($id, true);
        $title =  __('messages.success');
        $success =  __('messages.element_enabled_ok', ['name' => $this->modelObjet->__toString()]);
        return $this->reponseMixted($title, $success);
    }

    public function disable(int $id)
    {
        $this->modelObjet = $this->repo->available($id, false);
        $title =  __('messages.success');
        $success =  __('messages.element_disabled_ok', ['name' => $this->modelObjet->__toString()]);
        return $this->reponseMixted($title, $success);
    }

    public function reponseMixted($title, $success)
    {
        if (request()->has('ajax')) {
            return response()
                ->json(['title' => $title, 'success' => $success]);
        } else {
            return redirect()->route($this->getRouteRedirect(), $this->getRouteRedirectParams())
                ->with('title', $title)
                ->with('success', $success);
        }
    }

    protected function getRouteRedirect()
    {
        return $this->routeRedirect;
    }

    protected function getRouteRedirectParams()
    {
        return [];
    }

    public function validateForm()
    {
        $inputs = request()->all();
        $validator = $this->repo->validatorMake($inputs, request()->input('id'));
        $result = [];
        if ($validator->fails()) {
            $result['errors'] = $validator->messages();
        }
        return json_encode($result, true);
    }


    public function logs(int $id)
    {
        /*return Redirect::route('logs.events.model.dataTable', [
            'modelName' =>  $this->repo->getModelName(),
            'modelId' => $id
        ]);
        */
        $model = $this->repo->findByIdOrFail($id);
        $this->fieldFilterText = $this->fieldOrderFieldDefault = 'description';
        return self::dataTable($model->logs());
    }

    public function dataTable($query = null)
    {
        if (!$query) {
            $query = $this->repo->queryPersist();
        }

        $filterState = request()->input('filter_state');
        if (isset($filterState)) {
            $query->where($this->repo->geTableName() . '.state', $filterState);
        }

        $filterText = request()->input('filter_text');
        if ($filterText && $this->fieldFilterText) {
            $query->where($this->fieldFilterText, 'LIKE', "%$filterText%");
        }

        // si no es superAdmin, solo puede ver los datos que ha creado el o su admin
        /*$user = auth()->user();
        if ($user->role_id != 1) {
            $query->whereIn('created_user_id', [$user->id, $user->created_user_id]);
        }*/

        $orders = request()->input('order');
        if ($orders && count($orders) > 0 /*&& $orders[0]['column']*/) {
            $order = $orders[0];
            $orderFieldPos = $order['column'];
            $columns = request()->input('columns');
            $orderField = isset($columns[$orderFieldPos]['name']) ? $columns[$orderFieldPos]['name'] : $columns[$orderFieldPos]['data'];
            if ($orderField == 'full_name') {
                $orderField = $this->fieldOrderFieldDefault;
            }
            $orderDir = $order['dir'];
            $query->orderBy($orderField, $orderDir);
        } else {
            $query->orderBy($this->fieldOrderFieldDefault, $this->fieldOrderDirDefault);
        }

        $items = $query->get();
        return datatables()->of($items)->make(true);
    }
}
